<?php
/**
 * User: Hermit
 * Date: 2019/1/15
 * Time: 11:56
 */

namespace biz;


class Util
{

    public static function getQrcodeUrl($qrcode){
        return \CC::app()->request->getHostInfo().\CC::app()->baseUrl.'/qrcode/get.php?url='.urlencode($qrcode);
    }

    public static function getUrlWithHost($url){
        return \CC::app()->request->getHostInfo().\CC::app()->baseUrl.$url;
    }

    public static function echolinkCssJs($css_file_path_arr,$js_file_path_arr){
        $css_js_version = '201901291635';

        $publicUrl = \CC::app()->baseUrl . '/public';
        foreach($css_file_path_arr as $file_path){
            echo '<link rel="stylesheet" href="'.$publicUrl.$file_path.'?t='.$css_js_version.'"/>';
        }
        foreach($js_file_path_arr as $file_path){
            echo '<script type="text/javascript" src="'.$publicUrl.$file_path.'?t='.$css_js_version.'"></script>';
        }
    }

    public static function getPicUrl($pic_url){
        $publicUrl = \CC::app()->baseUrl . '/public';
        return $publicUrl.$pic_url;
    }

}