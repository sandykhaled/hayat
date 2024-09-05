<div class="modal fade text-md-start" id="createPayment{{isset($client) ? $client->id : ''}}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-user">
        <div class="modal-content">
            <div class="modal-header bg-transparent">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body pb-5 px-sm-5 pt-50">
                <div class="text-center mb-2">
                    <h1 class="mb-1">{{trans('common.CreatePayment')}}</h1>
                </div>
                {{Form::open(['url'=>route('admin.payments.store'), 'id'=>'createPaymentForm', 'class'=>'row gy-1 pt-75'])}}
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
                        <label class="form-label" for="client_id">{{ trans('common.client') }}</label>
                        @if(isset($client))
                            {{$client->Name}}
                            {{Form::hidden('client_id', $client->id)}}
                        @else
                            {{Form::select('client_id', clientsList(), isset($theClient) ? $theClient : '', ['id'=>'client_id', 'class'=>'form-select'])}}
                        @endif
                    </div>
                    <div class="col-12 col-md-4">
                        <label class="form-label" for="package">{{ trans('common.package') }}</label>
                        @if(isset($package))
                            {{$package}}
                            {{Form::hidden('package', $package)}}
                        @else
                            {{Form::text('package', '', ['id'=>'package', 'class'=>'form-select'])}}
                        @endif
                    </div>
                    <div class="col-12 col-md-4">
                        <label class="form-label" for="session_number">{{ trans('common.session number') }}</label>
                        @if(isset($session_number))
                            {{$session_number}}
                            {{Form::hidden('session_number', $session_number)}}
                        @else
                            {{Form::text('session_number', '', ['id'=>'session_number', 'class'=>'form-select'])}}
                        @endif
                    </div>


                    <div class="col-12 col-md-4">
                        <label class="form-label" for="session_number">{{ trans('common.full amount') }}</label>
                        @if(isset($full_amount))
                            {{$full_amount}}
                            {{Form::hidden('full_amount', $full_amount)}}
                        @else
                            {{Form::text('full_amount', '', ['id'=>'full_amount', 'class'=>'form-select'])}}
                        @endif
                    </div>

                    <div class="col-12 col-md-4">
                        <label class="form-label" for="amount_paid">{{ trans('common.amount paid') }}</label>
                        {{ Form::text('amount_paid', '', ['id' => 'amount_paid', 'class' => 'form-control']) }}
                    </div>
                    <div class="col-12 col-md-4">
                        <label class="form-label" for="remaining_amount">{{ trans('common.remaining amount') }}</label>
                        {{ Form::text('remaining_amount', '', ['id' => 'remaining_amount', 'class' => 'form-control']) }}
                    </div>




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
