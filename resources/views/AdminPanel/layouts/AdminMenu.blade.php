<!-- BEGIN: Main Menu-->
<div class="main-menu menu-fixed menu-dark menu-accordion menu-shadow" data-scroll-to-active="true">
    <div class="navbar-header">
        <ul class="nav navbar-nav flex-row">
            <img src="{{asset('/AdminAssets/app-assets/images/logo/logo.jpg')}}" height="55" />
            <!-- <li class="nav-item nav-toggle">
                <a class="nav-link modern-nav-toggle pe-0" data-bs-toggle="collapse">
                    <i class="d-block d-xl-none text-primary toggle-icon font-medium-4" data-feather="x"></i>
                    <i class="d-none d-xl-block collapse-toggle-icon font-medium-4  text-primary" data-feather="disc" data-ticon="disc"></i>
                </a>
            </li> -->
        </ul>
    </div>
    <div class="shadow-bottom"></div>
    <div class="main-menu-content">
        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
            <li class="@if(isset($active) && $active == 'panelHome') active @endif nav-item" >
                <a class="d-flex align-items-center" href="{{route('admin.index')}}">
                    <i data-feather="home"></i>
                    <span class="menu-title text-truncate" data-i18n="{{trans('common.PanelHome')}}">
                        {{trans('common.PanelHome')}}
                    </span>
                </a>
            </li>
            <li class="nav-item @if(isset($active) && $active == 'setting') active @endif">
                <a class="d-flex align-items-center" href="{{route('admin.settings.general')}}">
                    <i data-feather='settings'></i>
                    <span class="menu-title text-truncate" data-i18n="{{trans('common.setting')}}">
                        {{trans('common.setting')}}
                    </span>
                </a>
            </li>

            @if(userCan('view_services'))

            <li class=" nav-item">
                <a class="d-flex align-items-center" href="#">
                    <i data-feather="shield"></i>
                    <span class="menu-title text-truncate" data-i18n="{{trans('common.servicesAndOffers')}}">
                        {{trans('common.servicesAndOffers')}}
                    </span>
                </a>
                <ul class="menu-content">

                    <li class="nav-item @if(isset($active) && $active == 'fields') active @endif">
                        <a class="d-flex align-items-center" href="{{route('admin.fields.index')}}">
                            <i data-feather="circle"></i>
                            <span class="menu-title text-truncate" data-i18n="{{trans('common.fields')}}">
                {{trans('common.fields')}}
            </span>
                        </a>
                    </li>
                        <li class="nav-item @if(isset($active) && $active == 'services') active @endif">
                            <a class="d-flex align-items-center" href="{{route('admin.services.index')}}">
                                <i data-feather='settings'></i>
                                <span class="menu-title text-truncate" data-i18n="{{trans('common.services')}}">
                        {{trans('common.services')}}
                    </span>
                            </a>
                        </li>
                            <li class="nav-item @if(isset($active) && $active == 'offers') active @endif">
                                <a class="d-flex align-items-center" href="{{route('admin.offers.index')}}">
                                    <i data-feather='zap'></i>
                                    <span class="menu-title text-truncate" data-i18n="{{trans('common.offers')}}">
                        {{trans('common.offers')}}

                    </span>
                                </a>
                            </li>



                </ul>
            </li>
            @endif

                       <li class=" nav-item">
                <a class="d-flex align-items-center" href="#">
                    <i data-feather="shield"></i>
                    <span class="menu-title text-truncate" data-i18n="{{trans('common.UsersManagment')}}">
                        {{trans('common.UsersManagment')}}
                    </span>
                </a>
                <ul class="menu-content">
                    <li @if(isset($active) && $active == 'adminUsers') class="active" @endif>
                        <a class="d-flex align-items-center" href="{{route('admin.adminUsers')}}">
                            <i data-feather="circle"></i>
                            <span class="menu-item text-truncate" data-i18n="{{trans('common.AdminUsers')}}">
                                {{trans('common.users')}}
                            </span>
                        </a>
                    </li>
                    <li @if(isset($active) && $active == 'roles') class="active" @endif>
                        <a class="d-flex align-items-center" href="{{route('admin.roles')}}">
                            <i data-feather="circle"></i>
                            <span class="menu-item text-truncate" data-i18n="{{trans('common.Roles')}}">
                                {{trans('common.Roles')}}
                            </span>
                        </a>
                    </li>
                </ul>
            </li>
            @if(env('APP_HR') == 1)
                <li class=" nav-item">
                    <a class="d-flex align-items-center" href="#">
                        <i data-feather='file-text'></i>
                        <span class="menu-title text-truncate" data-i18n="{{trans('common.HrDep')}}">
                            {{trans('common.HrDep')}}
                        </span>
                    </a>
                    <ul class="menu-content">
                        <li @if(isset($active) && $active == 'salaries') class="active" @endif>
                            <a class="d-flex align-items-center" href="{{route('admin.salaries')}}">
                                <i data-feather="circle"></i>
                                <span class="menu-item text-truncate" data-i18n="{{trans('common.salaries')}}">
                                    {{trans('common.salaries')}}
                                </span>
                            </a>
                        </li>
                        <li @if(isset($active) && $active == 'attendance') class="active" @endif>
                            <a class="d-flex align-items-center" href="{{route('admin.attendance')}}">
                                <i data-feather="circle"></i>
                                <span class="menu-item text-truncate" data-i18n="{{trans('common.attendance')}}">
                                    {{trans('common.attendance')}}
                                </span>
                            </a>
                        </li>
                    </ul>
                </li>
            @endif

                <li class=" nav-item">
                    <a class="d-flex align-items-center" href="#">
                        <i data-feather='archive'></i>
                        <span class="menu-title text-truncate" data-i18n="{{trans('common.accounts')}}">
                            {{trans('common.accounts')}}
                        </span>
                    </a>
                    <ul class="menu-content">
                        <li @if(isset($active) && $active == 'expenses') class="active" @endif>
                            <a class="d-flex align-items-center" href="{{route('admin.expenses')}}">
                                <i data-feather="circle"></i>
                                <span class="menu-item text-truncate" data-i18n="{{trans('common.expenses')}}">
                                    {{trans('common.expenses')}}
                                </span>
                            </a>
                        </li>
                        <li @if(isset($active) && $active == 'revenues') class="active" @endif>
                            <a class="d-flex align-items-center" href="{{route('admin.revenues')}}">
                                <i data-feather="circle"></i>
                                <span class="menu-item text-truncate" data-i18n="{{trans('common.revenues')}}">
                                    {{trans('common.revenues')}}
                                </span>
                            </a>
                        </li>
                    </ul>
                </li>

            @if(env('APP_SERVICES') == 1)
                <li class="nav-item @if(isset($active) && $active == 'services') active @endif">
                    <a class="d-flex align-items-center" href="{{route('admin.services.index')}}">
                        <i data-feather='airplay'></i>
                        <span class="menu-title text-truncate" data-i18n="{{trans('common.services')}}">
                            {{trans('common.services')}}
                        </span>
                    </a>
                </li>
            @endif
            @if(env('APP_REALESTATES') == 1)
                <li class=" nav-item">
                    <a class="d-flex align-items-center" href="#">
                        <i data-feather='briefcase'></i>
                        <span class="menu-title text-truncate" data-i18n="{{trans('common.projects&units')}}">
                            {{trans('common.projects&units')}}
                        </span>
                    </a>
                    <ul class="menu-content">
                        <li @if(isset($active) && $active == 'governorates') class="active" @endif>
                            <a class="d-flex align-items-center" href="{{route('admin.governorates')}}">
                                <i data-feather="circle"></i>
                                <span class="menu-item text-truncate" data-i18n="{{trans('common.governorates')}}">
                                    {{trans('common.governorates')}}
                                </span>
                            </a>
                        </li>
                        <li @if(isset($active) && $active == 'locations') class="active" @endif>
                            <a class="d-flex align-items-center" href="{{route('admin.locations')}}">
                                <i data-feather="circle"></i>
                                <span class="menu-item text-truncate" data-i18n="{{trans('common.locations')}}">
                                    {{trans('common.locations')}}
                                </span>
                            </a>
                        </li>
                        <li @if(isset($active) && $active == 'companies') class="active" @endif>
                            <a class="d-flex align-items-center" href="{{route('admin.companies')}}">
                                <i data-feather="circle"></i>
                                <span class="menu-item text-truncate" data-i18n="{{trans('common.companies')}}">
                                    {{trans('common.companies')}}
                                </span>
                            </a>
                        </li>
                        <li @if(isset($active) && $active == 'projects') class="active" @endif>
                            <a class="d-flex align-items-center" href="{{route('admin.projects')}}">
                                <i data-feather="circle"></i>
                                <span class="menu-item text-truncate" data-i18n="{{trans('common.projects')}}">
                                    {{trans('common.projects')}}
                                </span>
                            </a>
                        </li>



                        <li @if(isset($active) && $active == 'units') class="active" @endif>
                            <a class="d-flex align-items-center" href="{{route('admin.units')}}">
                                <i data-feather="circle"></i>
                                <span class="menu-item text-truncate" data-i18n="{{trans('common.units')}}">
                                    {{trans('common.units')}}
                                </span>
                            </a>
                        </li>
                    </ul>
                </li>
            @endif
            <li class=" nav-item">
                <a class="d-flex align-items-center" href="#">
                    <i data-feather='users'></i>
                    <span class="menu-title text-truncate" data-i18n="{{trans('common.clients')}}">
                        {{trans('common.clients&FollowUps')}}
                    </span>
                </a>
                <ul class="menu-content">
                    <li @if(isset($active) && $active == 'clients') class="active" @endif>
                        <a class="d-flex align-items-center" href="{{route('admin.clients')}}">
                            <i data-feather='circle'></i>
                            <span class="menu-item text-truncate" data-i18n="{{trans('common.clients')}}">
                                {{trans('common.clients')}}
                            </span>
                        </a>
                    </li>
                    <li @if(isset($active) && $active == 'followups') class="active" @endif>
                        <a class="d-flex align-items-center" href="{{route('admin.followups')}}">
                            <i data-feather='circle'></i>
                            <span class="menu-item text-truncate" data-i18n="{{trans('common.followups')}}">
                                {{trans('common.followups')}}
                            </span>
                        </a>
                    </li>
                    <li @if(isset($active) && $active == 'nextFollowups') class="active" @endif>
                        <a class="d-flex align-items-center" href="{{route('admin.nextFollowups')}}">
                            <i data-feather='circle'></i>
                            <span class="menu-item text-truncate" data-i18n="{{trans('common.nextFollowups')}}">
                                {{trans('common.nextFollowups')}}
                            </span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item @if(isset($active) && $active == 'payments') active @endif">
                <a class="d-flex align-items-center" href="{{route('admin.payments')}}">
                    <i data-feather='dollar-sign'></i>
                    <span class="menu-title text-truncate" data-i18n="{{trans('common.payments')}}">
                        {{trans('common.payments')}}
                    </span>
                </a>
            </li>
            <li class="nav-item @if(isset($active) && $active == 'places') active @endif">
                <a class="d-flex align-items-center" href="{{route('admin.places')}}">
                    <i data-feather='map'></i>
                    <span class="menu-title text-truncate" data-i18n="{{trans('common.places')}}">
                        {{trans('common.places')}}
                    </span>
                </a>
            </li>
            <li class="nav-item @if(isset($active) && $active == 'doctors') active @endif">
                <a class="d-flex align-items-center" href="{{route('admin.doctors')}}">
                    <i data-feather='map'></i>
                    <span class="menu-title text-truncate" data-i18n="{{trans('common.doctors')}}">
                        {{trans('common.doctors')}}
                    </span>
                </a>
            </li>

            <li class="nav-item @if(isset($active) && $active == 'blogs') active @endif">
                <a class="d-flex align-items-center" href="{{route('admin.blogs')}}">
                    <i data-feather='columns'></i>
                    <span class="menu-title text-truncate" data-i18n="{{trans('common.blogs')}}">
                    {{trans('common.blogs')}}
                </span>
                </a>
            </li>

            <li @if(isset($active) && $active == 'webservices') class="active" @endif>
                <a class="d-flex align-items-center" href="{{route('admin.webservices')}}">
                    <i data-feather="server"></i>
                    <span class="menu-item text-truncate" data-i18n="{{trans('common.webservices')}}">
                        {{trans('common.webservices')}}
                    </span>
                </a>
            </li>

            <li @if(isset($active) && $active == 'results') class="active" @endif>
                <a class="d-flex align-items-center" href="{{route('admin.results')}}">
                    <i data-feather="info"></i>
                    <span class="menu-item text-truncate" data-i18n="{{trans('common.results')}}">
                        {{trans('common.results')}}
                    </span>
                </a>
            </li>

            <li class="nav-item @if(isset($active) && $active == 'contactUs') active @endif">
                <a class="d-flex align-items-center" href="{{route('admin.contactus')}}">
                    <i data-feather='mail'></i>
                    <span class="menu-title text-truncate" data-i18n="{{trans('common.contactUs')}}">
                        {{trans('common.contactUs')}}
                    </span>
                </a>
            </li>

            <li class="nav-item @if(isset($active) && $active == 'branches') active @endif">
                <a class="d-flex align-items-center" href="{{route('admin.branches.index')}}">
                    <i data-feather='git-branch'></i>
                    <span class="menu-title text-truncate" data-i18n="{{trans('common.branches')}}">
                        {{__('common.branches')}}
                    </span>
                </a>
            </li>

            <li class=" nav-item">
                <a class="d-flex align-items-center" href="#">
                    <i data-feather='layers'></i>
                    <span class="menu-title text-truncate" data-i18n="{{trans('common.reports')}}">
                        {{trans('common.reports')}}
                    </span>
                </a>
                <ul class="menu-content">
                    </li>
                    {{-- <li @if(isset($active) && $active == 'userFollowUpsReport') class="active" @endif>
                        <a class="d-flex align-items-center" href="{{route('admin.userFollowUpsReport')}}">
                            <i data-feather='circle'></i>
                            <span class="menu-item text-truncate" data-i18n="{{trans('common.userFollowUpsReport')}}">
                                {{trans('common.userFollowUpsReport')}}
                            </span>
                        </a>
                    </li>
                    <li @if(isset($active) && $active == 'teamFollowUpsReport') class="active" @endif>
                        <a class="d-flex align-items-center" href="{{route('admin.teamFollowUpsReport')}}">
                            <i data-feather='circle'></i>
                            <span class="menu-item text-truncate" data-i18n="{{trans('common.teamFollowUpsReport')}}">
                                {{trans('common.teamFollowUpsReport')}}
                            </span>
                        </a>
                    </li>
                    <li @if(isset($active) && $active == 'branchFollowUpsReport') class="active" @endif>
                        <a class="d-flex align-items-center" href="{{route('admin.branchFollowUpsReport')}}">
                            <i data-feather='circle'></i>
                            <span class="menu-item text-truncate" data-i18n="{{trans('common.branchFollowUpsReport')}}">
                                {{trans('common.branchFollowUpsReport')}}
                            </span>
                        </a>
                    </li> --}}
                    <li @if(isset($active) && $active == 'accountsReport') class="active" @endif>
                        <a class="d-flex align-items-center" href="{{route('admin.accountsReport')}}">
                            <i data-feather='circle'></i>
                            <span class="menu-item text-truncate" data-i18n="{{trans('common.accountsReport')}}">
                                {{trans('common.accountsReport')}}
                            </span>
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</div>
<!-- END: Main Menu-->
