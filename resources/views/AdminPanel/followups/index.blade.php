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
                                <th>#</th>
                                <th>{{trans('common.day')}}</th>
                                <th>{{trans('common.date')}}</th>
                                <th>{{trans('common.client')}}</th>
                                <th>{{trans('common.Arrival time')}}</th>
                                <th>{{trans('common.session start')}}</th>
                                <th>{{trans('common.session end')}}</th>
                                {{-- <th>{{trans('common.service')}}</th> --}}
                                <th>{{trans('common.number of session')}} </th>
                                <th>{{trans('common.doctor')}} </th>
                                <th>{{trans('common.notes')}} </th>
                                <th class="text-center">
                                    {{trans('common.actions')}}
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($followups as $followup)

                            <tr class="text-center">
                                <td>
                                    {{$loop->iteration}}
                                </td>

                                <td>
                                    {{$followup->days}}
                                </td>
                                <td>
                                    {{$followup->date}}
                                </td>
                                <td>
                                    {{$followup->client->Name ?? '-'}}
                                </td>
                                <td >
                                  {{ $followup->arrival_time }}
                                </td>
                                <td>
                                    {{ $followup->session_start }}
                                </td>
                                <td>
                                    {{ $followup->session_end }}
                                </td>
                                {{-- <td>
                                    {{ $followup->service_id }}
                                </td> --}}
                                <td>
                                    {{ $followup->session_number }}
                                </td>
                                <td>
                                    {{ $followup->doctor }}
                                </td>
                                <td>
                                    {{ $followup->note }}
                                </td>

                                <td class="text-nowrap">
                                    <a href="javascript:;" data-bs-target="#editfollowup{{$followup->id}}" data-bs-toggle="modal" class="btn btn-icon btn-info" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="{{trans('common.edit')}}">
                                        <i data-feather='edit'></i>
                                    </a>
                                    <?php $delete = route('admin.followups.delete',['id'=>$followup->id]); ?>
                                    <button type="button" class="btn btn-icon btn-danger" onclick="confirmDelete('{{$delete}}','{{$followup->id}}')">
                                        <i data-feather='trash-2'></i>
                                    </button>
                                </td>
                            </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="p-3 text-center ">
                                        <h2>{{trans('common.nothingToView')}}</h2>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{ $followups->links('vendor.pagination.default') }}


            </div>
        </div>
    </div>
    <!-- Bordered table end -->


@foreach($followups as $followup)

<div class="modal fade text-md-start" id="editfollowup{{$followup->id}}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-user">
        <div class="modal-content">
            <div class="modal-header bg-transparent">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body pb-5 px-sm-5 pt-50">
                <div class="text-center mb-2">
                    <h1 class="mb-1">{{trans('common.edit')}}: {{$followup['name_'.session()->get('Lang')]}}</h1>
                </div>
                {{Form::open(['url'=>route('admin.followups.update',$followup->id), 'id'=>'editfollowupForm'.$followup->id, 'class'=>'row gy-1 pt-75'])}}
                    <div class="row">
                        <div class="col-md-4">
                            <b>{{trans('common.agent')}}: </b>
                            {{$followup->agent->name ?? '-'}}
                        </div>
                        <div class="col-md-4">
                            <b>{{trans('common.time')}}: </b>
                            {{date('H:i:s')}}
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <label class="form-label" for="ClientID">{{trans('common.client')}}</label>
                        {{Form::select('ClientID',clientsList(),$followup->ClientID,['id'=>'ClientID', 'class'=>'form-select'])}}
                    </div>
                    @php


                    $days = [
    'Sunday' => 'الأحد',
    'Monday' => 'الاثنين',
    'Tuesday' => 'الثلاثاء',
    'Wednesday' => 'الأربعاء',
    'Thursday' => 'الخميس',
    'Friday' => 'الجمعة',
    'Saturday' => 'السبت',
];
@endphp
<div class="col-12 col-md-4">
    <label class="form-label" for="days">{{ trans('common.day') }}</label>
    {{ Form::select('days', $days, null, ['id' => 'day', 'class' => 'form-control']) }}
</div>
                    <div class="col-12"></div>
                    <div class="col-12 col-md-4">
                        <label class="form-label" for="date">{{trans('common.date')}}</label>
                        {{Form::date('date', $followup->date,['id'=>'date', 'class'=>'form-control'])}}
                    </div>
                    <div class="col-12 col-md-12">
                        <label class="form-label" for="arrival_time">{{trans('common.arrival time')}}</label>
                        {{Form::time('arrival_time', $followup->arrival_time,['id'=>'arrival_time', 'class'=>'form-control'])}}
                    </div>
                    <div class="col-12 col-md-12">
                        <label class="form-label" for="session_start">{{trans('common.session start')}}</label>
                        {{Form::time('session_start',$followup->session_start,['id'=>'session_start', 'class'=>'form-control','required'])}}
                    </div>
                    <div class="col-12 col-md-12">
                        <label class="form-label" for="session_end">{{trans('common.session end')}}</label>
                        {{Form::time('session_end',$followup->session_end,['id'=>'session_end', 'class'=>'form-control','required'])}}
                    </div>
                    <div class="col-12 col-md-12">
                        <label class="form-label" for="session_number">{{trans('common.session number')}}</label>
                        {{Form::text('session_number',$followup->session_number,['id'=>'session_number', 'class'=>'form-control','required'])}}
                    </div>
                    <div class="col-12 col-md-12">
                        <label class="form-label" for="doctor">{{trans('common.doctor')}}</label>
                        {{Form::text('doctor',$followup->doctor,['id'=>'doctor', 'class'=>'form-control','required'])}}
                    </div>
                    <div class="col-12 col-md-12">
                        <label class="form-label" for="note">{{trans('common.note')}}</label>
                        {{Form::text('note',$followup->note,['id'=>'note', 'class'=>'form-control','required'])}}
                    </div>
                    <div class="col-12 text-center mt-2 pt-50">
                        <button type="submit" class="btn btn-primary me-1"  >{{trans('common.Save changes')}}</button>
                        <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal" aria-label="Close">
                            {{trans('common.Cancel')}}
                        </button>
                    </div>
                {{Form::close()}}
            </div>
        </div>
    </div>
</div>

@endforeach


@stop

@section('page_buttons')
    @if(userCan('followups_create'))
        <a href="javascript:;" data-bs-target="#createFollowUp" data-bs-toggle="modal" class="btn btn-sm btn-primary">
            {{trans('common.CreateNewFollowUp')}}
        </a>
        @include('AdminPanel.followups.create')
    @endif

    <a href="javascript:;" data-bs-target="#searchfollowups" data-bs-toggle="modal" class="btn btn-primary btn-sm">
        {{trans('common.search')}}
    </a>

    <div class="modal fade text-md-start" id="searchfollowups" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-user">
            <div class="modal-content">
                <div class="modal-header bg-transparent">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body pb-5 px-sm-5 pt-50">
                    {{Form::open(['id'=>'searchfollowupsForm', 'class'=>'row gy-1 pt-75', 'method'=>'GET'])}}
                        @if(userCan('followups_view'))
                            <div class="col-12 col-md-3">
                                <label class="form-label" for="branch_id">{{trans('common.branch')}}</label>
                                <?php $branchesList = App\Models\Branches::orderBy('name','asc')->pluck('name','id')->all(); ?>
                                {{Form::select('branch_id',['all'=>'الجميع'] + $branchesList,isset($_GET['branch_id']) ? $_GET['branch_id'] : '',['id'=>'branch_id', 'class'=>'form-select'])}}
                            </div>
                        @endif
                        @if(userCan('followups_view') || userCan('followups_view_branch') || userCan('followups_view_team'))
                            <div class="col-12 col-md-3">
                                <label class="form-label" for="AgentID">{{trans('common.agent')}}</label>
                                {{Form::select('AgentID',['all' => 'الجميع'] + agentsListForSearch(),isset($_GET['AgentID']) ? $_GET['AgentID'] : '',['id'=>'AgentID', 'class'=>'selectpicker','data-live-search'=>'true'])}}
                            </div>
                        @endif
                        <div class="col-12 col-md-3">
                            <label class="form-label" for="status">{{trans('common.status')}}</label>
                            {{Form::select('status',['all'=>'الجميع'] + clientstatusArray(session()->get('Lang')),isset($_GET['status']) ? $_GET['status'] : date('Y'),['id'=>'status', 'class'=>'form-select'])}}
                        </div>
                        <div class="col-12 col-md-3">
                            <label class="form-label" for="class">{{trans('common.class')}}</label>
                            {{Form::select('class',['all'=>'الجميع'] + clientClassArray(),isset($_GET['class']) ? $_GET['class'] : date('Y'),['id'=>'class', 'class'=>'form-select'])}}
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
