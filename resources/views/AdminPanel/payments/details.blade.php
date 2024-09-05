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
                                <th>{{trans('common.date')}}</th>
                                <th>{{trans('common.time')}}</th>
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

                                <td>
                                    {{ $payment->updated_at->format('Y-m-d') }}
                                </td>


                                <td>

                                    {{ $payment->updated_at->format('H:i:s') }}

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





@stop


