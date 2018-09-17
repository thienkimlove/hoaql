<?php

namespace App\Http\Controllers;
use App\Models\Setting;


class FrontendController extends Controller
{
    public $logo;

    public function __construct()
    {
        $this->logo = url('/frontend/'.env('DB_DATABASE').'/images/logo.png');
    }

    private function getSetting($key)
    {
        $settings = Setting::pluck('value', 'name')->all();
        return isset($settings[$key]) ? $settings[$key] : '';

    }


    public function index()
    {
        $page = 'index';

        $meta = [];
        $meta['meta_title'] = $this->getSetting('META_INDEX_TITLE');
        $meta['meta_desc'] = $this->getSetting('META_INDEX_DESC');
        $meta['meta_keywords'] = $this->getSetting('META_INDEX_KEYWORDS');
        $meta['meta_image'] = $this->logo;
        $meta['meta_url'] = url('/');
        
        return view('welcome', compact('page'))->with($meta);
    }


}
