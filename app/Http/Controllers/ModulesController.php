<?php

namespace App\Http\Controllers;

use App\Models\Module;
use Illuminate\Http\Request;

class ModulesController extends Controller
{

   public function add(Request $request)
   {
       if ($request->filled('type') && $request->filled('content') && $request->filled('value')) {
           Module::create($request->all());
       }
   }

    public function remove(Request $request)
    {
        if ($request->filled('type') && $request->filled('content') && $request->filled('value')) {
            Module::where('type', $request->get('type'))
                ->where('content', $request->get('content'))
                ->where('value', $request->get('value'))
                ->delete();
        }
    }

}