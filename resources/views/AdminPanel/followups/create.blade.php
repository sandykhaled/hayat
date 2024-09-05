<div class="modal fade text-md-start" id="createFollowUp{{isset($client) ? $client->id : ''}}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-user">
        <div class="modal-content">
            <div class="modal-header bg-transparent">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body pb-5 px-sm-5 pt-50">
                <div class="text-center mb-2">
                    <h1 class="mb-1">{{trans('common.CreateNewFollowUp')}}</h1>
                </div>
                {{Form::open(['url'=>route('admin.followups.store'), 'id'=>'createFollowUpForm', 'class'=>'row gy-1 pt-75'])}}
                    <div class="row">
                        <div class="col-md-4">
                            <b>{{trans('common.agent')}}: </b>
                            {{auth()->user()->name}}
                        </div>
                        <div class="col-md-4">
                            <b>{{trans('common.date')}}: </b>
                            {{date('Y-m-d')}}
                        </div>
                        <div class="col-md-4">
                            <b>{{trans('common.time')}}: </b>
                            {{date('H:i:s')}}
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <label class="form-label" for="ClientID">{{trans('common.client')}}</label>
                        @if(isset($client))
                            {{$client->Name}}
                            {{Form::hidden('ClientID', $client->id)}}
                        @else
                            {{Form::select('ClientID',clientsList(),isset($theClient) ? $theClient : '',['id'=>'ClientID', 'class'=>'form-select'])}}
                        @endif
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
                    <div class="col-12 col-md-4">
                        <label class="form-label" for="date">{{trans('common.date')}}</label>
                        {{Form::date('date','',['id'=>'date', 'class'=>'form-control'])}}
                    </div>
                    <div class="col-12"></div>
                    <div class="col-12 col-md-12">
                        <label class="form-label" for="arrival_time">{{trans('common.arrival time')}}</label>
                        {{Form::time('arrival_time','',['id'=>'arrival_time', 'class'=>'form-control'])}}
                    </div>
                    <div class="col-12 col-md-12">
                        <label class="form-label" for="session_start">{{trans('common.session start')}}</label>
                        {{Form::time('session_start','',['id'=>'session_start', 'class'=>'form-control','required'])}}
                    </div>
                    <div class="col-12 col-md-12">
                        <label class="form-label" for="session_end">{{trans('common.session end')}}</label>
                        {{Form::time('session_end','',['id'=>'session_end', 'class'=>'form-control','required'])}}
                    </div>
                    <div class="col-12 col-md-12">
                        <label class="form-label" for="session_number">{{trans('common.session number')}}</label>
                        {{Form::text('session_number','',['id'=>'session_number', 'class'=>'form-control','required'])}}
                    </div>
                    <div class="col-12 col-md-12">
                        <label class="form-label" for="doctor">{{trans('common.doctor')}}</label>
                        {{Form::text('doctor','',['id'=>'doctor', 'class'=>'form-control','required'])}}
                    </div>
                    <div class="col-12 col-md-12">
                        <label class="form-label" for="note">{{trans('common.note')}}</label>
                        {{Form::text('note','',['id'=>'note', 'class'=>'form-control','required'])}}
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
