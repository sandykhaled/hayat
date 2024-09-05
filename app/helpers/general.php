<?php

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;
function DayMonthOnly($your_date)
{
    $months = array("Jan" => "يناير",
                     "Feb" => "فبراير",
                     "Mar" => "مارس",
                     "Apr" => "أبريل",
                     "May" => "مايو",
                     "Jun" => "يونيو",
                     "Jul" => "يوليو",
                     "Aug" => "أغسطس",
                     "Sep" => "سبتمبر",
                     "Oct" => "أكتوبر",
                     "Nov" => "نوفمبر",
                     "Dec" => "ديسمبر");
    //$your_date = date('y-m-d'); // The Current Date
    $en_month = date("M", strtotime($your_date));
    foreach ($months as $en => $ar) {
        if ($en == $en_month) { $ar_month = $ar; }
    }

    $find = array ("Sat", "Sun", "Mon", "Tue", "Wed" , "Thu", "Fri");
    $replace = array ("السبت", "الأحد", "الإثنين", "الثلاثاء", "الأربعاء", "الخميس", "الجمعة");
    $ar_day_format = date("D", strtotime($your_date)); // The Current Day
    $ar_day = str_replace($find, $replace, $ar_day_format);

    header('Content-Type: text/html; charset=utf-8');
    $standard = array("0","1","2","3","4","5","6","7","8","9");
    $eastern_arabic_symbols = array("٠","١","٢","٣","٤","٥","٦","٧","٨","٩");
    $current_date = $ar_day.' '.date('d', strtotime($your_date)).' '.$ar_month.' '.date('Y', strtotime($your_date));
    $arabic_date = str_replace($standard , $eastern_arabic_symbols , $current_date);

    return $arabic_date;
}
function arabicMonth($your_date)
{
    $months = array("Jan" => "يناير",
                     "Feb" => "فبراير",
                     "Mar" => "مارس",
                     "Apr" => "أبريل",
                     "May" => "مايو",
                     "Jun" => "يونيو",
                     "Jul" => "يوليو",
                     "Aug" => "أغسطس",
                     "Sep" => "سبتمبر",
                     "Oct" => "أكتوبر",
                     "Nov" => "نوفمبر",
                     "Dec" => "ديسمبر");
    //$your_date = date('y-m-d'); // The Current Date
    $en_month = date("M", strtotime($your_date));
    foreach ($months as $en => $ar) {
        if ($en == $en_month) { $ar_month = $ar; }
    }
    return $ar_month;
}
function getTime($time)
{
    $time = '';
    $time .= date('H:m',strtotime($time));
    $time .= date('a',strtotime($time)) == 'am' ? ' ص ' : 'م';
    return $time;
}

function panelLangMenu()
{
    $list = [];
    $locales = Config::get('app.locales');

    if (Session::get('Lang') != 'ar') {
        $list[] = [
            'flag' => 'ae',
            'text' => trans('common.lang1Name'),
            'lang' => 'ar'
        ];
    } else {
        $selected = [
            'flag' => 'ae',
            'text' => trans('common.lang1Name'),
            'lang' => 'ar'
        ];
    }
    if (Session::get('Lang') != 'en') {
        $list[] = [
            'flag' => 'us',
            'text' => trans('common.lang2Name'),
            'lang' => 'en'
        ];
    } else {
        $selected = [
            'flag' => 'us',
            'text' => trans('common.lang2Name'),
            'lang' => 'en'
        ];
    }
    if (Session::get('Lang') != 'fr') {
        $list[] = [
            'flag' => 'fr',
            'text' => trans('common.lang3Name'),
            'lang' => 'fr'
        ];
    } else {
        $selected = [
            'flag' => 'fr',
            'text' => trans('common.lang3Name'),
            'lang' => 'fr'
        ];
    }

    return [
        'selected' => $selected,
        'list' => $list
    ];
}

function getCssFolder()
{
    return trans('common.cssFile');
}

function getCountriesList($lang,$value)
{
    $list = [];
    $countries = App\Models\Countries::orderBy('name_'.$lang,'asc')->get();
    foreach ($countries as $country) {
        $list[$country[$value]] = $country['name_'.$lang] != '' ? $country['name_'.$lang] : $country['name_en'];
    }
    return $list;
}

function getRolesList($lang,$value,$guard = null)
{
    $list = [];
    if ($guard == null) {
        $roles = App\Models\Role::orderBy('name_'.$lang,'asc')->get();
    } else {
        $roles = App\Models\Role::where('guard',$guard)->orderBy('name_'.$lang,'asc')->get();
    }
    foreach ($roles as $role) {
        $list[$role[$value]] = $role['name_'.$lang] != '' ? $role['name_'.$lang] : $role['name_ar'];
    }
    return $list;
}
function getSectionsList($lang)
{
    $list = [];
    $sections = App\Models\Sections::where('main_section','0')->orderBy('name_'.$lang,'asc')->get();
    foreach ($sections as $section) {
        $list[$section['id']] = $section['name_'.$lang];
        if ($section->subSections != '') {
            foreach ($section->subSections as $key => $value) {
                $list[$value['id']] = ' - '.$value['name_'.$lang];
            }
        }
    }
    return $list;
}

function getSettingValue($key)
{
    $value = '';
    $setting = App\Models\Settings::where('key',$key)->first();
    if ($setting != '') {
        $value = $setting['value'];
    }
    return $value;
}

function getSettingImageLink($key)
{
    $link = '';
    $setting = App\Models\Settings::where('key',$key)->first();
    if ($setting != '') {
        if ($setting['value'] != '') {
            $link = asset('uploads/settings/'.$setting['value']);
        }
    }
    return $link;
}

function getSettingImageValue($key)
{
    $value = '';
    if (getSettingImageLink($key) != '') {
        $value .= '<div class="row"><div class="col-12">';
        $value .= '<span class="avatar mb-2">';
        $value .= '<img class="round" src="'.getSettingImageLink($key).'" alt="avatar" height="90" width="90">';
        $value .= '</span>';
        $value .= '</div>';
        $value .= '<div class="col-12">';
        $value .= '<a href="'.route('admin.settings.deletePhoto',['key'=>$key]).'"';
        $value .= ' class="btn btn-danger btn-sm">'.trans("common.delete").'</a>';
        $value .= '</div></div>';
    }
    return $value;
}

function checkUserForApi($lang, $user_id)
{
    if ($lang == '') {
        $resArr = [
            'status' => 'faild',
            'message' => trans('api.pleaseSendLangCode'),
            'data' => []
        ];
        return response()->json($resArr);
    }
    $user = App\Models\User::find($user_id);
    if ($user == '') {
        return response()->json([
            'status' => 'faild',
            'message' => trans('api.thisUserDoesNotExist'),
            'data' => []
        ]);
    }

    return true;
}

function salesStatistics7Days()
{
    $date = \Carbon\Carbon::today()->subDays(7);
    $date7before = new \Carbon\Carbon($date);
    $date7before = $date7before->subDays(7);
    $ClientsCount = App\Models\User::where('role', '3')->where('created_at', '>=', $date)->count();

    return [
        'ClientsCount' => number_format($ClientsCount),
    ];
}


function safesList()
{
   if (userCan('expenses_view')) {
       $safes = App\Models\SafesBanks::orderBy('Title','asc')->pluck('Title','id')->all();
   } elseif (userCan('expenses_view_branch')) {
       $safes = App\Models\SafesBanks::where('branch_id',auth()->user()->branch_id)->orderBy('Title','asc')->pluck('Title','id')->all();
   }
   return $safes;
}
function citiesList()
{
    $cities = App\Models\Cities::orderBy('name','asc')->pluck('name','id')->all();
    return $cities;
}
function companiesList()
{
    $comapnies = App\Models\ProjectCompanies::orderBy('name','asc')->pluck('name','id')->all();
    return $comapnies;
}
function locationsList()
{
    $locations = App\Models\ProjectLocations::orderBy('name','asc')->pluck('name','id')->all();
    return $locations;
}
function projectsList()
{
    $projects = App\Models\Projects::orderBy('name','asc')->pluck('name','id')->all();
    return ['None' => 'بدون مشروع'] + $projects;
}
function unitsList()
{
    $units = App\Models\Units::orderBy('name','asc')->pluck('name','id')->all();
    return $units;
}
function agentsList()
{
    $agents = App\Models\User::where('status','Active')->orderBy('name','asc')->pluck('name','id')->all();
    return ['None' => 'تابع للشركة'] + $agents;
}
function servicesList()
{
    $services = App\Models\Services::orderBy('name','asc')->pluck('name','id')->all();
    return $services;
}

function agentsListForSearch()
{
    $agents = App\Models\User::where('status','Active')->orderBy('name','asc')->pluck('name','id')->all();
    if (userCan('followups_view_team')) {
        $agents = [auth()->user()->id => auth()->user()->name] + App\Models\User::where('status','Active')
                ->orderBy('name','asc')
                ->pluck('name','id')
                ->all();
    }
    if (userCan('followups_view_branch')) {
        $agents = App\Models\User::where('status','Active')->where('branch_id',auth()->user()->id)
            ->orderBy('name','asc')
            ->pluck('name','id')
            ->all();
    }
    return $agents;
}
function agentsVisitList()
{
    $agents = App\Models\User::where('status','Active')->orderBy('name','asc')->pluck('name','id')->all();
    if (userCan('clients_view_team')) {
        $agents = [auth()->user()->id => auth()->user()->name] + App\Models\User::where('status','Active')
                ->orderBy('name','asc')
                ->pluck('name','id')
                ->all();
    }
    if (userCan('clients_view_branch')) {
        $agents = App\Models\User::where('status','Active')->where('branch_id',auth()->user()->id)
            ->orderBy('name','asc')
            ->pluck('name','id')
            ->all();
    }
    return $agents;
}
function clientsList()
{
    if (userCan('clients_view')) {
        $agents = App\Models\Clients::orderBy('Name','asc')->pluck('Name','id')->all();
    } elseif (userCan('clients_view_branch')) {
        $agents = App\Models\Clients::where('branch_id',auth()->user()->branch_id)->orderBy('Name','asc')->pluck('Name','id')->all();
    } elseif (userCan('clients_view_team')) {
        $teamMembers = [];
        $teamMembers[] = auth()->user()->id;
        $myTeam = App\Models\User::where('status','Active')->get();
        foreach ($myTeam as $myTeamKey => $myTeamV) {
            $teamMembers[] = $myTeamV['id'];
        }
        $agents = App\Models\Clients::whereIn('AgentID',$teamMembers)->orderBy('Name','asc')->pluck('Name','id')->all();
    } else {
        $agents = App\Models\Clients::where('AgentID',auth()->user()->id)->orderBy('Name','asc')->pluck('Name','id')->all();
    }
    return $agents;
}



function clientStatusArray($lang)
{
    $list = [
        'ar' => [
            'FollowUp' => 'عملاء المتابعات',
            'NotInterested' => 'عملاء غير مهتمين',
            'interested' => 'عملاء مهتمين',
            'Request' => 'عملاء بطلبات جديدة',
            'Meeting' => 'عملاء إجتماعات',
            'FollowUpAfterMeeting' => 'عملاء مابعد الإجتماع'
        ],
        'en' => [
            'FollowUp' => 'عملاء المتابعات',
            'NotInterested' => 'عملاء غير مهتمين',
            'interested' => 'عملاء مهتمين',
            'Request' => 'عملاء بطلبات جديدة',
            'Meeting' => 'عملاء إجتماعات',
            'FollowUpAfterMeeting' => 'عملاء مابعد الإجتماع'
        ]
    ];
    return $list[$lang];
}
function clientClassArray()
{
    $list = [
        'A+' => 'A+',
        'A' => 'A',
        'B' => 'B',
        'C' => 'C'
    ];
    return $list;
}

function projectsTypesList($lang)
{
    $list = [
        'ar' => [
            'housing' => 'سكني',
            'commercial' => 'تجاري',
            'Administrative' => 'إداري',
            'all' => 'شامل'
        ],
        'en' => [
            'housing' => 'سكني',
            'commercial' => 'تجاري',
            'Administrative' => 'إداري',
            'all' => 'شامل'
        ]
    ];
    return $list[$lang];
}
function unitsTypesList($lang)
{
    $list = [
        'ar' => [
            'Land' => 'أرض',
            'Floor' => 'شقة',
            'House' => 'منزل',
            'Villa' => 'فيلا',
            'Shop' => 'محل',
            'Studio' => 'ستديو',
            'Shalie' => 'شاليه'
        ],
        'en' => [
            'Land' => 'أرض',
            'Floor' => 'شقة',
            'House' => 'منزل',
            'Villa' => 'فيلا',
            'Shop' => 'محل',
            'Studio' => 'ستديو',
            'Shalie' => 'شاليه'
        ]
    ];
    return $list[$lang];
}

function systemMainSections()
{
    $systemMainSections = [
        'settings' => 'settings',
        'users' => 'users',
        'roles' => 'roles',
        'userAccounts' => 'userAccounts',
        'safes' => 'safes',
        'expensesTypes' => 'expensesTypes',
        'expenses' => 'expenses',
        'revenues' => 'revenues',
        'services' => 'services',
        'offers'=>'offers',
        'fields'=>'fields',
        'clients' => 'clients',
        'followups' => 'followups',
        'reports' => 'reports',
        'homeStats' => 'homeStats',
        'payments'=>'payments',
        'webservices'=>'webservices',
        'results'=>'results'
    ];
    return $systemMainSections;
}
function branchesList()
{
    $branches = App\Models\Branches::orderBy('name','asc')->pluck('name','id')->all();
    return $branches;
}

function getPermissions($role = null)
{

    $roleData = '';
    if ($role != null) {
        $roleData = App\Models\Role::find($role);
    }

    $permissionsArr = [];
    foreach (systemMainSections() as $section) {
        $permissionsArr[$section] = [
            'name' => trans('common.'.$section),
            'permission' => []
        ];
        $settingPermissions = App\Models\permissions::where('group',$section)->get();
        foreach ($settingPermissions as $permission) {
            $hasIt = 0;
            if ($roleData != '') {
                if ($roleData->hasPermission($permission['id']) == 1) {
                    $hasIt = 1;
                }
            }
            $permissionsArr[$section]['permission'][] = [
                'id' => $permission['id'],
                'can' => $permission['can'],
                'name' => $permission['name_'.session()->get('Lang')],
                'hasIt' => $hasIt
            ];
        }
    }
    return $permissionsArr;
}

function monthArray($lang)
{
    $arr = [
        'ar' => [
            '01' => '01 يناير',
            '02' => '02 فبراير',
            '03' => '03 مارس',
            '04' => '04 أبريل',
            '05' => '05 مايو',
            '06' => '06 يونيو',
            '07' => '07 يوليو',
            '08' => '08 أغسطس',
            '09' => '09 سبتمبر',
            '10' => '10 أكتوبر',
            '11' => '11 نوفمبر',
            '12' => '12 ديسمبر',
        ]
    ];
    return $arr[$lang];
}
function yearArray()
{
    $cunrrentYear = date('Y');
    $firstYear = 2020;
    $arr = [];
    for ($i=$cunrrentYear; $i >= $firstYear; $i--) {
        $arr[$i] = $i;
    }
    return $arr;
}
function employeeStatusArray($lang)
{
    $arr = [
        'ar' => [
            'Active' => 'موظف مفعل',
            'Archive' => 'موظف معطل'
        ]
    ];
    return $arr[$lang];
}
function safeTypes($lang)
{
    $list = [
        'ar' => [
            'safe' => 'خزينة نقدية',
            'bank' => 'حساب بنكي',
            'wallet' => 'محفظة إلكترونية'
        ],
        'en' => [
            'safe' => 'Cash Safe',
            'bank' => 'Banck Account',
            'wallet' => 'Electronic Wallet'
        ]
    ];

    return $list[$lang];
}
function expensesTypes($lang)
{
    $list = [
        'ar' => [
            'withdrawal' => 'مسحوبات'
        ],
        'en' => [
            'withdrawal' => 'Withdrawal'
        ]
    ];
    $types = App\Models\ExpensesTypes::orderBy('name','asc')->pluck('name','id')->all();
    return $list[$lang]+$types;
}
function revenuesTypes($lang)
{
    $list = [
        'ar' => [
            'revenues' => 'إيرادات',
            'deposits' => 'إيداعات'
        ],
        'en' => [
            'revenues' => 'إيرادات',
            'deposits' => 'إيداعات'
        ]
    ];
    return $list[$lang];
}

function refferalList($lang)
{
    $list = [
        'ar' => [
            'facebookPage' => 'صفحة فيس بوك',
            'facebookAds' => 'إعلانات فيس بوك',
            'linkedinPage' => 'صفحة لينكد ان',
            'linkedinAds' => 'اعلانات لينكد ان',
            'googleSearch' => 'محرك بحث جوجل',
            'googleAds' => 'اعلانات جوجل',
            'teamReferral' => 'علاقات فريق العمل',
            'managmentReferral' => 'علاقات الإدارة',
            'searching' => 'بحث عشوائي'
        ],
        'en' => [
            'facebookPage' => 'صفحة فيس بوك',
            'facebookAds' => 'إعلانات فيس بوك',
            'linkedinPage' => 'صفحة لينكد ان',
            'linkedinAds' => 'اعلانات لينكد ان',
            'googleSearch' => 'محرك بحث جوجل',
            'googleAds' => 'اعلانات جوجل',
            'teamReferral' => 'علاقات فريق العمل',
            'managmentReferral' => 'علاقات الإدارة',
            'searching' => 'بحث عشوائي'
        ]
    ];
    return $list[$lang];
}

function followUpTypeList($lang)
{
    $list = [
        'ar' => [
            'Mail' => 'بريد إلكتروني',
            'Call' => 'إتصال هاتفي',
            'InVisit' => 'زياره بمقر الشركة',
            'OutVisit' => 'زياره بمقر العميل',
            'UnitVisit' => 'معاينة للوحدة'
        ],
        'en' => [
            'Mail' => 'بريد إلكتروني',
            'Call' => 'إتصال هاتفي',
            'InVisit' => 'زياره بمقر الشركة',
            'OutVisit' => 'زياره بمقر العميل',
            'UnitVisit' => 'معاينة للوحدة'
        ]
    ];
    return $list[$lang];
}
function whoIsContactingList($lang)
{
    $list = [
        'ar' => [
            'Company' => 'ممثل الشركة',
            'Client' => 'العميل'
        ],
        'en' => [
            'Company' => 'ممثل الشركة',
            'Client' => 'العميل'
        ]
    ];
    return $list[$lang];
}

function themeModeClasses()
{
    if (session()->get('theme_mode') == 'light') {
        $arr = [
            'html' => 'semi-dark-layout',
            'navbar' => 'navbar-light',
            'icon' => 'moon',
            'menu' => 'menu-dark'
        ];
    } else {
        $arr = [
            'html' => 'dark-layout',
            'navbar' => 'navbar-dark',
            'icon' => 'sun',
            'menu' => 'menu-dark'
        ];
    }
    return $arr;
}
