<?php

namespace App\Http\Controllers;

use App\Lib\Helpers;
use App\Models\Customer;
use App\Models\Rule;
use Illuminate\Http\Request;
use Log;
use Sentinel;
use Exception;
use Socialite;

class BasicController extends Controller
{

    public function notice()
    {
        return view('notice');
    }

    public function redirectToSSO()
    {
        return Socialite::driver('google')->redirect();
    }


    public function handleSSOCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            $user = Sentinel::findByCredentials(['login' => $googleUser->email]);
            if ($user) {
                if ($user->status) {
                    Sentinel::login($user, true);
                    session()->put('google_token', $googleUser->token);
                    flash()->success('Thành công', 'Đăng nhập thành công!');
                    return redirect()->intended('/admin');
                } else {
                    @file_get_contents('https://accounts.google.com/o/oauth2/revoke?token='. $googleUser->token);
                    flash()->error('Lỗi', 'Tài khoản không được kích hoạt!');
                    return redirect()->route('notice');
                }

            } else {
                @file_get_contents('https://accounts.google.com/o/oauth2/revoke?token='. $googleUser->token);
                flash()->error('Lỗi', 'Không có tài khoản tương ứng!');
                return redirect()->route('notice');
            }
        } catch (Exception $e) {
            Log::info($e->getMessage());
            flash()->error('Lỗi', $e->getMessage());
            return redirect('notice');
        }
    }


    public function logout()
    {
        Sentinel::logout();

        @file_get_contents('https://accounts.google.com/o/oauth2/revoke?token='.session()->get('google_token'));
        session()->forget('google_token');

        flash()->success('Thành công', 'Bạn đã đăng xuất');

        return redirect()->route('notice');
    }

    public function index()
    {
        return view('index');
    }

    /**
     * Using for admin ajax if needed
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajax(Request $request)
    {
        if ($request->filled('part')) {
            $part = $request->input('part');
            if ($part == 'fill_customer' && $request->filled('customer_id')) {
                $customer_id = $request->input('customer_id');
                $customer = Customer::find($customer_id);
                if ($customer) {
                    return response()->json($customer->toArray());
                }
            }

            if ($part == 'fill_rule' && $request->filled('rule_id')) {
                $rule_id = $request->input('rule_id');
                $rule = Rule::find($rule_id);
                if ($rule) {
                    $ars = $rule->toArray();
                    $responseArs = [];
                    foreach ($ars as $k => $val) {
                        if (in_array($k, ['salary', 'award', 'price', 'quantity'])) {
                            $responseArs[$k] = Helpers::intToDotString($val);
                        }  else {
                            $responseArs[$k] = $val;
                        }
                    }
                    $responseArs['total'] = Helpers::intToDotString($ars['quantity']*$ars['price']);
                    return response()->json($responseArs);
                }
            }

        }
        return response()->json([]);
    }

}