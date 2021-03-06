<?php

namespace App\Http\Middleware;

use App\Models\Permission;
use Closure;
use Sentinel;

class Acl
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = Sentinel::getUser();

        if (! $user) {
            return redirect()->guest('login');
        }

        if (!$user->isAdmin()) {

            $routeName = $request->route()->getName();
            $permissions = Permission::getKeyRoute($routeName);

            if ($permissions == 'orders' || $permissions == 'transports') {
                $permissions = ['transports', 'orders'];
            }

            if ($permissions && !$user->hasAnyAccess($permissions)) {
                flash()->error('Lỗi', 'Không có quyền truy cập mục này!'.$permissions);
                return redirect()->route('notice');
            }
        }

        return $next($request);
    }
}
