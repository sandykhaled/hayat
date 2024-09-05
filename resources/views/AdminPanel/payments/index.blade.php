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
                                <th>{{trans('common.client')}}</th>
                                <th>{{trans('common.package')}}</th>
                                <th>{{trans('common.full amount')}}</th>
                                <th>{{trans('common.amount paid')}}</th>
                                <th>{{trans('common.remaining amount')}}</th>
                                <th>{{trans('common.session number')}}</th>
                                <th> {{trans('common.actions')}} </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($payments as $payment)

                            <tr class="text-center">
                                <td>
                                    {{$payment->id}}
                                </td>
                                <td>
                                    {{$payment->client->Name ?? '-'}}
                                </td>
                                <td>
                                    {{$payment->package}}
                                </td>
                                <td>
                                    {{$payment->full_amount}}
                                </td>
                                <td>
                                    {{$payment->amount_paid}}
                                </td>
                                <td>
                                    {{ $payment->remaining_amount }}
                                </td>
                                <td>
                                    {{ $payment->session_number }}
                                </td>


                                <td class="text-nowrap">
                                    @if(userCan('payments_update'))

                                    <a href="javascript:;" data-bs-target="#editpayment{{$payment->id}}" data-bs-toggle="modal" class="btn btn-icon btn-info" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="{{trans('common.edit')}}">
                                        <i data-feather='edit'></i>
                                    </a>
                                    @endif
                                    @if(userCan('Payments_delete'))

                                    <?php $delete = route('admin.payments.delete',['id'=>$payment->id]); ?>
                                    <button type="button" class="btn btn-icon btn-danger" onclick="confirmDelete('{{$delete}}','{{$payment->id}}')">
                                        <i data-feather='trash-2'></i>
                                    </button>
                                    @endif
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

                {{ $payments->links('vendor.pagination.default') }}


            </div>
        </div>
    </div>
    <!-- Bordered table end -->


@foreach($payments as $payment)

<div class="modal fade text-md-start" id="editpayment{{$payment->id}}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-user">
        <div class="modal-content">
            <div class="modal-header bg-transparent">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body pb-5 px-sm-5 pt-50">
                <div class="text-center mb-2">
                    <h1 class="mb-1">{{trans('common.edit')}}: {{$payment['name_'.session()->get('Lang')]}}</h1>
                </div>
                {{-- payment add to sotre new edit witout remove new edit --}}
                {{Form::open(['url'=>route('admin.payments.store'), 'id'=>'editpaymentForm'.$payment->id, 'class'=>'row gy-1 pt-75'])}}
                    <div class="row">
                        <div class="col-md-4">
                            <b>{{trans('common.agent')}}: </b>
                            {{$payment->agent->name ?? '-'}}
                        </div>
                        <div class="col-md-4">
                            <b>{{trans('common.time')}}: </b>
                            {{date('H:i:s')}}
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <label class="form-label" for="client_id">{{trans('common.client')}}</label>
                        {{Form::select('client_id',clientsList(),$payment->client_id,['id'=>'client_id', 'class'=>'form-select'])}}
                    </div>


                    <div class="col-12"></div>
                    <div class="col-12 col-md-12">
                        <label class="form-label" for="package">{{trans('common.package')}}</label>
                        {{Form::text('package', $payment->package,['id'=>'package', 'class'=>'form-control'])}}
                    </div>
                    <div class="col-12 col-md-12">
                        <label class="form-label" for="full_amount">{{trans('common.fullamount')}}</label>
                        {{Form::text('full_amount',$payment->full_amount,['id'=>'full_amount', 'class'=>'form-control','required'])}}
                    </div>
                    <div class="col-12 col-md-12">
                        <label class="form-label" for="amount_paid">{{trans('common.amount paid')}}</label>
                        {{Form::text('amount_paid',$payment->amount_paid,['id'=>'amount_paid', 'class'=>'form-control','required'])}}
                    </div>
                    <div class="col-12 col-md-12">
                        <label class="form-label" for="remaining_amount">{{trans('common.remaining amount')}}</label>
                        {{Form::text('remaining_amount',$payment->remaining_amount,['id'=>'remaining_amount', 'class'=>'form-control','required'])}}
                    </div>
                    <div class="col-12 col-md-12">
                        <label class="form-label" for="session_number">{{trans('common.session number')}}</label>
                        {{Form::text('session_number',$payment->session_number,['id'=>'session_number', 'class'=>'form-control','required'])}}
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
    @if(userCan('payments_create'))
    <a href="javascript:;" data-bs-target="#createPayment" data-bs-toggle="modal" class="btn btn-sm btn-primary mb-1">
        {{trans('common.CreatePayment')}}
    </a>
        @include('AdminPanel.payments.create')
    @endif



@stop
