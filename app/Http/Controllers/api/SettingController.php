<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Settings;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index(Request $request)
    {

       $lang = $request->header('lang');
       if ($lang == '') {
           $resArr = [
               'status' => 'faild',
               'message' => trans('api.pleaseSendLangCode'),
               'data' => []
           ];
           return response()->json($resArr);
       }

        $list = [

            'contact_us' => [
                'phone' => getSettingValue('phone'),
                'email' => getSettingValue('email'),
                'address' => getSettingValue('address'),
            ],
            'FooterText' => [
                'footerText' => getSettingValue('footerText'),
                'footerDescription' => getSettingValue('footerDescription'),
                'footerLogo' => getSettingImageLink('footerLogo'),
            ],
            'social' => [
                'linkedIn' => getSettingValue('linkedIn'),
                'Facebook' => getSettingValue('Facebook'),
                'instagram' => getSettingValue('instagram'),
                'Twitter' => getSettingValue('Twitter'),
                'whatsapp' => getSettingValue('whatsapp'),
            ],
            'servicePage'=>[
                'serviceText' => getSettingValue('serviceText'),
                'serviceDescription' => getSettingValue('serviceDescription'),
                'servicePhoto' => getSettingImageLink('servicePhoto'),
            ],
            'aboutUsPage'=>[
                'aboutUsText' => getSettingValue('aboutUsText'),
                'aboutUsDescription' => getSettingValue('aboutUsDescription'),
                'aboutUsPhoto' => getSettingImageLink('aboutUsPhoto'),
            ],
            'main' => [
                'mainText' => getSettingValue('mainText'),
                'mainDescription' => getSettingValue('mainDescription'),
                'mainPhoto' => getSettingImageLink('mainPhoto'),
                'clientsCount' => getSettingImageLink('clientsCount'),
            ],
            'AboutUsMain' =>[
                'homeAboutUsText'=>getSettingValue('homeAboutUsText'),
                'homeAboutUsDescription'=>getSettingValue('homeAboutUsDescription'),
            ],

        ];

        return $resArr = [
            'status' => 'success',
            'message' => '',
            'data' => $list
        ];



    }

    public function getAboutPageContent()
    {
        $lang = request()->header('lang');
        $array = [];
        for ($i=1; $i <= 3; $i++) {
            if (getSettingValue('aboutus_page_section'.$i.'title_'.$lang) != '') {
                $array[] = [
                    'title' => getSettingValue('aboutus_page_section'.$i.'title_'.$lang),
                    'description' => strip_tags(getSettingValue('aboutus_page_section'.$i.'des_'.$lang))
                ];
            }
        }
        return $array;
    }

    public function getHomePageSections()
    {
        $lang = request()->header('lang');
        $array = [];
        for ($i=1; $i <= 2; $i++) {
            if (getSettingValue('home_page_section'.$i.'title_'.$lang) != '') {
                $array[] = [
                    'image' => getSettingImageLink('home_page_section'.$i.'img'),
                    'title' => getSettingValue('home_page_section'.$i.'title_'.$lang),
                    'description' => strip_tags(getSettingValue('home_page_section'.$i.'des_'.$lang))
                ];
            }
        }
        return $array;
    }
}
