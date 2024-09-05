@extends('AdminPanel.layouts.master')
@section('content')

    <!-- Bordered table start -->
    <div class="row" id="table-bordered">
        <div class="col-12">
            {{ Form::open(['url' => route('admin.settings.update'), 'files' => true]) }}
            <div class="card">
                <div class="card-body">
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link" id="accounts-tab" data-bs-toggle="tab" href="#accounts" aria-controls="accounts" role="tab" aria-selected="false">
                                <i data-feather="tool"></i> {{ trans('common.accountsSettings') }}
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" id="main-tab" data-bs-toggle="tab" href="#main" aria-controls="main" role="tab" aria-selected="true">
                                <i data-feather="home"></i> {{ trans('common.mainSettings') }}
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="aboutUs-tab" data-bs-toggle="tab" href="#aboutUs" aria-controls="aboutUs" role="tab" aria-selected="false">
                                <i data-feather="tool"></i> {{ trans('common.aboutUsPage') }}
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="footer-tab" data-bs-toggle="tab" href="#footer" aria-controls="footer" role="tab" aria-selected="false">
                                <i data-feather="align-center"></i> {{ trans('common.footerPage') }}
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="servicePage-tab" data-bs-toggle="tab" href="#servicePage" aria-controls="servicePage" role="tab" aria-selected="false">
                                <i data-feather="align-center"></i> {{ trans('common.serviceSetting') }}
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content mt-3">
                        <div class="tab-pane" id="accounts" aria-labelledby="accounts-tab" role="tabpanel">
                            @include('AdminPanel.settings.includes.accounts')
                        </div>
                        <div class="tab-pane active" id="main" aria-labelledby="main-tab" role="tabpanel">
                            @include('AdminPanel.settings.includes.main')
                        </div>
                        <div class="tab-pane" id="aboutUs" aria-labelledby="aboutUs-tab" role="tabpanel">
                            @include('AdminPanel.settings.includes.aboutUs')
                        </div>
                        <div class="tab-pane" id="footer" aria-labelledby="footer-tab" role="tabpanel">
                            @include('AdminPanel.settings.includes.footer')
                        </div>
                        <div class="tab-pane" id="servicePage" aria-labelledby="servicePage-tab" role="tabpanel">
                            @include('AdminPanel.settings.includes.serviceSetting')
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <input type="submit" value="{{ trans('common.Save changes') }}" class="btn btn-primary">
                </div>
            </div>
            {{ Form::close() }}
        </div>
    </div>
    <!-- Bordered table end -->
@stop
