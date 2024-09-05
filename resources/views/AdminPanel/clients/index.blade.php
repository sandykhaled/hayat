@extends('AdminPanel.layouts.master')
@section('content')


    <!-- Bordered table start -->
    <div class="row" id="table-bordered">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">{{$title}}</h4>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered mb-2">
                        <thead>
                            <tr>
                                <th>{{trans('common.name')}}</th>
                                <th>{{trans('common.code')}}</th>
                                <th>{{trans('common.refferal')}}</th>
                                <th>{{trans('common.services')}}</th>
                                <th>{{trans('common.counts')}}</th>
                                <th>{{trans('common.RemainingSessions')}}</th>
                                <th class="text-center">{{trans('common.actions')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($clients as $client)
                            <tr id="row_{{$client->id}}">
                                <td>
                                    {{$client->Name}}
                                </td>


                                <td>
                                    {{$client->code}}
                                </td>

                                <td>
                                    {{refferalList(session()->get('Lang'))[$client->referral] ?? '-'}}
                                </td>

                                <td>
                                    {{ optional($client->service)->name }}
                                </td>

                                <td>
                                    {{ optional($client->service)->visiting_count}}
                                </td>

                                <td>
                                    {{ $client->remaining_sessions }}
                                 </td>

                                <td class="text-nowrap">
                                    <a href="javascript:;" data-bs-target="#createFollowUp{{$client->id}}" data-bs-toggle="modal" class="btn btn-sm btn-primary mb-1">
                                        {{trans('common.CreateNewFollowUp')}}
                                    </a>
                                    <a href="javascript:;" data-bs-target="#createPayment{{$client->id}}" data-bs-toggle="modal" class="btn btn-sm btn-primary mb-1">
                                        {{trans('common.CreatePayment')}}
                                    </a>
                                    <div class="col-12"></div>
                                    <a href="{{route('admin.followups',['client_id'=>$client->id])}}" class="btn btn-icon btn-success" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="{{trans('common.followups')}}">
                                        <i data-feather='list'></i>
                                    </a>
                                    <a href="javascript:;" data-bs-target="#editclient{{$client->id}}" data-bs-toggle="modal" class="btn btn-icon btn-info" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="{{trans('common.edit')}}">
                                        <i data-feather='edit'></i>
                                    </a>
                                    <?php $delete = route('admin.clients.delete',['id'=>$client->id]); ?>
                                    <button type="button" class="btn btn-icon btn-danger" onclick="confirmDelete('{{$delete}}','{{$client->id}}')">
                                        <i data-feather='trash-2'></i>
                                    </button>
                                    <a href="{{route('admin.payments.details', $client->id)}}" class="btn btn-icon btn-success" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="{{trans('common.payments')}}">
                                        <i data-feather='info'></i>
                                    </a>
                                </td>
                            </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="p-3 text-center ">
                                        <h2>{{trans('common.nothingToView')}}</h2>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{ $clients->links('vendor.pagination.default') }}


            </div>
        </div>
    </div>
    <!-- Bordered table end -->


@foreach($clients as $client)

    <div class="modal fade text-md-start" id="editclient{{$client->id}}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-user">
            <div class="modal-content">
                <div class="modal-header bg-transparent">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body pb-5 px-sm-5 pt-50">
                    <div class="text-center mb-2">
                        <h1 class="mb-1">{{trans('common.edit')}}: {{$client['name_'.session()->get('Lang')]}}</h1>
                    </div>
                    {{Form::open(['url'=>route('admin.clients.update',$client->id), 'id'=>'editclientForm'.$client->id, 'class'=>'row gy-1 pt-75'])}}
                        <div class="col-12 col-md-3">
                            <label class="form-label" for="Name">{{trans('common.name')}}</label>
                            {{Form::text('Name',$client->Name,['id'=>'Name', 'class'=>'form-control','required'])}}
                            @if($errors->has('Name'))
                                <span class="text-danger" role="alert">
                                    <b>{{ $errors->first('Name') }}</b>
                                </span>
                            @endif
                        </div>



                        <div class="col-12 col-md-3">
                            <label class="form-label" for="code">{{trans('common.code')}}</label>
                            {{Form::text('code',$client->code,['id'=>'code', 'class'=>'form-control','required'])}}
                            @if($errors->has('code'))
                                <span class="text-danger" role="alert">
                                    <b>{{ $errors->first('code') }}</b>
                                </span>
                            @endif
                        </div>


                        <div class="col-12 col-md-3">
                            <label class="form-label" for="service_id">{{trans('common.service')}}</label>
                            {{Form::select('service_id', $services->pluck('name', 'id'), old('service_id'), ['id'=>'service_id', 'class'=>'form-control', 'required'])}}
                            @if($errors->has('service_id'))
                                <span class="text-danger" role="alert">
                                    <b>{{ $errors->first('service_id') }}</b>
                                </span>
                            @endif
                        </div>

                        <div class="col-12 col-md-3">
                            <label class="form-label" for="referral">{{trans('common.refferal')}}</label>
                            {{Form::select('referral',refferalList(session()->get('Lang')),$client->referral,['id'=>'referral', 'class'=>'form-control'])}}
                        </div>
                        <div class="col-12 text-center mt-2 pt-50">
                            <button type="submit" class="btn btn-primary me-1">{{trans('common.Save changes')}}</button>
                            <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal" aria-label="Close">
                                {{trans('common.Cancel')}}
                            </button>
                        </div>
                    {{Form::close()}}
                </div>
            </div>
        </div>
    </div>
@foreach ($services as $servicesName)

    @php
       $servicePrices = [
           ['name' => 'العلاج الطبيعي المكثف 1', 'price' => getSettingValue('sessionPrice1')],
           ['name' => 'العلاج الطبيعي المكثف 2', 'price' => getSettingValue('sessionPrice1')],
           ['name' => 'العلاج الوظيفي 1', 'price' => getSettingValue('sessionPrice2')],
           ['name' => 'العلاج الوظيفي 2', 'price' => getSettingValue('sessionPrice2')],
           ['name' => 'التكامل الحسي 1', 'price' => getSettingValue('sessionPrice3')],
           ['name' => 'التكامل الحسي 2', 'price' => getSettingValue('sessionPrice3')],
           ['name' => 'التخاطب والنطق 1', 'price' => getSettingValue('sessionPrice4')],
           ['name' => 'التخاطب والنطق 2', 'price' => getSettingValue('sessionPrice4')],
       ];

       $price = array_filter($servicePrices, function($servicePrice) use ($servicesName) {
           return $servicePrice['name'] === $servicesName['name'];
       })[0]['price'] ?? null;

       // Don't echo the price here
       // ... rest of your PHP code ...

       $fullAmount = null;
       foreach ($servicePrices as $servicePrice) {
           if (isset($servicePrice['name']) && is_string($servicePrice['name'])) {
               if ((string)$servicePrice['name'] === (string)$client->service->name) {
                   $fullAmount = $servicePrice['price'] * $client->service->sessions_count;
                   break;
               }
           }
       }



    @endphp

    @include('AdminPanel.followups.create',['client'=>$client])
    @include('AdminPanel.payments.create', [
        'client' => $client,
        'package' => $client->service->name,
        'session_number' => $client->service->sessions_count,
        'full_amount' => $fullAmount // Pass the full amount to the view
    ])
@endforeach


@endforeach


@stop

@section('page_buttons')
    @if(userCan('clients_create_excel'))
        @include('AdminPanel.clients.createExcel')
    @endif
    @if(userCan('clients_create'))
        @include('AdminPanel.clients.create')
    @endif


    <a href="javascript:;" data-bs-target="#searchClients" data-bs-toggle="modal" class="btn btn-primary btn-sm">
        {{trans('common.search')}}
    </a>

    <div class="modal fade text-md-start" id="searchClients" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-user">
            <div class="modal-content">
                <div class="modal-header bg-transparent">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body pb-5 px-sm-5 pt-50">
                    {{Form::open(['id'=>'searchClientsForm', 'class'=>'row gy-1 pt-75', 'method'=>'GET'])}}
                        @if(userCan('clients_view'))
                            <div class="col-12 col-md-3">
                                <label class="form-label" for="branch_id">{{trans('common.branch')}}</label>
                                <?php $branchesList = App\Models\Branches::orderBy('name','asc')->pluck('name','id')->all(); ?>
                                {{Form::select('branch_id',['all'=>'الجميع'] + $branchesList,isset($_GET['branch_id']) ? $_GET['branch_id'] : '',['id'=>'branch_id', 'class'=>'form-select'])}}
                            </div>
                        @endif
                        @if(userCan('clients_view') || userCan('clients_view_branch') || userCan('clients_view_team'))
                            <div class="col-12 col-md-3">
                                <label class="form-label" for="AgentID">{{trans('common.agent')}}</label>
                                {{Form::select('AgentID',['all' => 'الجميع'] + agentsListForSearch(),isset($_GET['AgentID']) ? $_GET['AgentID'] : '',['id'=>'AgentID', 'class'=>'selectpicker','data-live-search'=>'true'])}}
                            </div>
                        @endif
                        <div class="col-12 col-md-3">
                            <label class="form-label" for="status">{{trans('common.status')}}</label>
                            {{Form::select('status',['all'=>'الجميع'] + clientStatusArray(session()->get('Lang')),isset($_GET['status']) ? $_GET['status'] : '',['id'=>'status', 'class'=>'form-select'])}}
                        </div>
                        <div class="col-12 col-md-3">
                            <label class="form-label" for="class">{{trans('common.class')}}</label>
                            {{Form::select('class',['all'=>'الجميع'] + clientClassArray(),isset($_GET['class']) ? $_GET['class'] : '',['id'=>'class', 'class'=>'form-select'])}}
                        </div>
                        <div class="col-12 col-md-3">
                            <label class="form-label" for="Name">{{trans('common.name')}}</label>
                            {{Form::text('Name', isset($_GET['Name']) ? $_GET['Name'] : '',['id'=>'Name', 'class'=>'form-control'])}}
                        </div>
                        <div class="col-12 col-md-3">
                            <label class="form-label" for="code">{{trans('common.code')}}</label>
                            {{Form::text('code', isset($_GET['code']) ? $_GET['code'] : '',['id'=>'phone', 'class'=>'form-control'])}}
                        </div>
                        <div class="col-12 col-md-3">
                            <label class="form-label" for="cellphone">{{trans('common.mobile')}}</label>
                            {{Form::text('cellphone', isset($_GET['cellphone']) ? $_GET['cellphone'] : '',['id'=>'cellphone', 'class'=>'form-control'])}}
                        </div>
                        <div class="col-12 col-md-3">
                            <label class="form-label" for="whatsapp">{{trans('common.whatsapp')}}</label>
                            {{Form::text('whatsapp', isset($_GET['whatsapp']) ? $_GET['whatsapp'] : '',['id'=>'whatsapp', 'class'=>'form-control'])}}
                        </div>
                        <div class="col-12 text-center mt-2 pt-50">
                            <button type="submit" class="btn btn-primary me-1">{{trans('common.search')}}</button>
                            <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal" aria-label="Close">
                                {{trans('common.Cancel')}}
                            </button>
                        </div>
                    {{Form::close()}}
                </div>
            </div>
        </div>
    </div>
@stop
