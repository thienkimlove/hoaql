<?php

namespace App\Lib;

use App\Models\Customer;
use App\Models\District;
use App\Models\Module;
use App\Models\Payment;
use App\Models\Role;
use App\Models\Rule;
use Carbon\Carbon;
use Log;


class Helpers {

    public static function convertStringToInt($value)
    {
        return intval(str_replace('.', '', $value));
    }

    public static function intToDotString($value) {
        $symbol_thousand = '.';
        $decimal_place = 0;
        $price = number_format($value, $decimal_place, '', $symbol_thousand);
        return $price;
    }

    public static function vn_price($priceFloat, $number=false) {
        $symbol = ($number) ?  '' : 'đ';
        $symbol_thousand = '.';
        $decimal_place = 0;
        $price = number_format($priceFloat, $decimal_place, '', $symbol_thousand);
        return $price.$symbol;
    }

    public static function getDistrictFromAddress($address)
    {
         $districts = District::all();
         $utf8_address = mb_strtolower($address, 'UTF-8');
         foreach ($districts as $district) {
             $utf8_district = mb_strtolower($district->name, 'UTF-8');
             //Log::info($utf8_address.'|'.$utf8_district);
             if (strpos($utf8_address, $utf8_district) !== FALSE) {
                 return $district->id;
             }
         }

         return null;


    }

    public static function getModuleValues($content, $type)
    {
        return Module::where('content', $content)
            ->where('type', $type)
            ->pluck('value')
            ->all();
    }

    public static function getModules($content = 'posts')
    {
        return config('system.modules.'.env('DB_DATABASE').'.'.$content) ?  config('system.modules.'.env('DB_DATABASE').'.'.$content) : [];
    }


    public static function roleList()
    {
       return Role::pluck('name', 'id')->all();
    }

    public static function paymentList()
    {
        return Payment::where('status', true)->pluck('name', 'id')->all();
    }
    public static function ruleList()
    {
        return Rule::where('status', true)->pluck('name', 'id')->all();
    }

    public static function customerList($id = null)
    {
        if ($id) {
            Log::info($id);
            return Customer::where('status', true)->where('id', '!=', $id)->pluck('name', 'id')->all();
        } else {
            return Customer::where('status', true)->pluck('name', 'id')->all();
        }

    }



    public static function inDeepArray($key, $value, $ars)
    {
        $in = false;
        foreach ($ars as $item) {
            if (isset($item[$key]) && $item[$key] == $value) {
                $in = true;
            }
        }
        return $in;
    }

    public static function formatDatetime($datetime)
    {
        return $datetime ? Carbon::parse($datetime)->format('H:i:s d/m/Y') : 'Không có thông tin';
    }

    public static function toNum($value) {
        if (!$value) {
            return 0;
        } else {
            return intval(trim($value));
        }
    }

    public static function appendToLog($message, $log_file)
    {
        @file_put_contents($log_file, $message."\n", FILE_APPEND);
    }

    public static function convertDateToVietnamese( $format, $time = 0 )
    {
        if ( ! $time ) $time = time();

        $lang = array();
        $lang['sun'] = 'CN';
        $lang['mon'] = 'T2';
        $lang['tue'] = 'T3';
        $lang['wed'] = 'T4';
        $lang['thu'] = 'T5';
        $lang['fri'] = 'T6';
        $lang['sat'] = 'T7';
        $lang['sunday'] = 'Chủ nhật';
        $lang['monday'] = 'Thứ hai';
        $lang['tuesday'] = 'Thứ ba';
        $lang['wednesday'] = 'Thứ tư';
        $lang['thursday'] = 'Thứ năm';
        $lang['friday'] = 'Thứ sáu';
        $lang['saturday'] = 'Thứ bảy';
        $lang['january'] = 'Tháng Một';
        $lang['february'] = 'Tháng Hai';
        $lang['march'] = 'Tháng Ba';
        $lang['april'] = 'Tháng Tư';
        $lang['may'] = 'Tháng Năm';
        $lang['june'] = 'Tháng Sáu';
        $lang['july'] = 'Tháng Bảy';
        $lang['august'] = 'Tháng Tám';
        $lang['september'] = 'Tháng Chín';
        $lang['october'] = 'Tháng Mười';
        $lang['november'] = 'Tháng M. Một';
        $lang['december'] = 'Tháng M. Hai';
        $lang['jan'] = 'T01';
        $lang['feb'] = 'T02';
        $lang['mar'] = 'T03';
        $lang['apr'] = 'T04';
        $lang['may2'] = 'T05';
        $lang['jun'] = 'T06';
        $lang['jul'] = 'T07';
        $lang['aug'] = 'T08';
        $lang['sep'] = 'T09';
        $lang['oct'] = 'T10';
        $lang['nov'] = 'T11';
        $lang['dec'] = 'T12';

        $format = str_replace( "r", "D, d M Y H:i:s O", $format );
        $format = str_replace( array( "D", "M" ), array( "[D]", "[M]" ), $format );
        $return = date( $format, $time );

        $replaces = array(
            '/\[Sun\](\W|$)/' => $lang['sun'] . "$1",
            '/\[Mon\](\W|$)/' => $lang['mon'] . "$1",
            '/\[Tue\](\W|$)/' => $lang['tue'] . "$1",
            '/\[Wed\](\W|$)/' => $lang['wed'] . "$1",
            '/\[Thu\](\W|$)/' => $lang['thu'] . "$1",
            '/\[Fri\](\W|$)/' => $lang['fri'] . "$1",
            '/\[Sat\](\W|$)/' => $lang['sat'] . "$1",
            '/\[Jan\](\W|$)/' => $lang['jan'] . "$1",
            '/\[Feb\](\W|$)/' => $lang['feb'] . "$1",
            '/\[Mar\](\W|$)/' => $lang['mar'] . "$1",
            '/\[Apr\](\W|$)/' => $lang['apr'] . "$1",
            '/\[May\](\W|$)/' => $lang['may2'] . "$1",
            '/\[Jun\](\W|$)/' => $lang['jun'] . "$1",
            '/\[Jul\](\W|$)/' => $lang['jul'] . "$1",
            '/\[Aug\](\W|$)/' => $lang['aug'] . "$1",
            '/\[Sep\](\W|$)/' => $lang['sep'] . "$1",
            '/\[Oct\](\W|$)/' => $lang['oct'] . "$1",
            '/\[Nov\](\W|$)/' => $lang['nov'] . "$1",
            '/\[Dec\](\W|$)/' => $lang['dec'] . "$1",
            '/Sunday(\W|$)/' => $lang['sunday'] . "$1",
            '/Monday(\W|$)/' => $lang['monday'] . "$1",
            '/Tuesday(\W|$)/' => $lang['tuesday'] . "$1",
            '/Wednesday(\W|$)/' => $lang['wednesday'] . "$1",
            '/Thursday(\W|$)/' => $lang['thursday'] . "$1",
            '/Friday(\W|$)/' => $lang['friday'] . "$1",
            '/Saturday(\W|$)/' => $lang['saturday'] . "$1",
            '/January(\W|$)/' => $lang['january'] . "$1",
            '/February(\W|$)/' => $lang['february'] . "$1",
            '/March(\W|$)/' => $lang['march'] . "$1",
            '/April(\W|$)/' => $lang['april'] . "$1",
            '/May(\W|$)/' => $lang['may'] . "$1",
            '/June(\W|$)/' => $lang['june'] . "$1",
            '/July(\W|$)/' => $lang['july'] . "$1",
            '/August(\W|$)/' => $lang['august'] . "$1",
            '/September(\W|$)/' => $lang['september'] . "$1",
            '/October(\W|$)/' => $lang['october'] . "$1",
            '/November(\W|$)/' => $lang['november'] . "$1",
            '/December(\W|$)/' => $lang['december'] . "$1" );

        return preg_replace( array_keys( $replaces ), array_values( $replaces ), $return );
    }
    
    public static function convertDate($time)
    {
        return self::convertDateToVietnamese('d/m/Y H:i', $time);
    }

    public static function br2nl($input)
    {
        return preg_replace('/<br\s?\/?>/ius', "\n", str_replace("\n", "", str_replace("\r", "", htmlspecialchars_decode($input))));
    }

    public static function getYoutubeEmbedUrl($code)
    {
        // Extract video url from embed code
        $youtubeVideoId = preg_replace_callback('/<iframe\s+.*?\s+src=(".*?").*?<\/iframe>/', function ($matches) {
            // Remove quotes
            $youtubeUrl = $matches[1];
            $youtubeUrl = trim($youtubeUrl, '"');
            $youtubeUrl = trim($youtubeUrl, "'");
            // Extract id
            preg_match("/^(?:http(?:s)?:\/\/)?(?:www\.)?(?:m\.)?(?:youtu\.be\/|youtube\.com\/(?:(?:watch)?\?(?:.*&)?v(?:i)?=|(?:embed|v|vi|user)\/))([^\?&\"'>]+)/", $youtubeUrl, $videoId);
            return $youtubeVideoId = isset($videoId[1]) ? $videoId[1] : "";
        }, $code);

        return $youtubeVideoId ;
    }

    public static function getYoutubeImage($url)
    {
        preg_match("/^(?:http(?:s)?:\/\/)?(?:www\.)?(?:m\.)?(?:youtu\.be\/|youtube\.com\/(?:(?:watch)?\?(?:.*&)?v(?:i)?=|(?:embed|v|vi|user)\/))([^\?&\"'>]+)/", $url, $videoId);
        $youtubeVideoId = isset($videoId[1]) ? $videoId[1] : "";
        return 'https://img.youtube.com/vi/'.$youtubeVideoId.'/0.jpg';
    }
}
