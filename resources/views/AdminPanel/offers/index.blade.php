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
                                <th class="text-center">{{trans('common.offerName')}}</th>
                                <th class="text-center">{{trans('common.code')}}</th>
                                <th class="text-center">{{trans('common.date')}}</th>
                                <th class="text-center">{{trans('common.priceAfterDiscount')}}</th>
                                <th class="text-center">{{trans('common.services')}}</th>
                                <th class="text-center">{{trans('common.actions')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($offers as $offer)
                            <tr id="row_{{$offer->id}}">
                                <td>
                                    {{$offer['name']}}
                                </td>
                                <td>
                                    {{$offer['code']}}
                                </td>
                                <td>
                                    {{trans('common.from')}} <b>{{$offer['start_date']}}</b> {{trans('common.To')}}  <b>{{$offer['end_date']}}</b>
                               </td>
                                <td>
                                    @php $price=0; @endphp
                                    @foreach($offer->services as $service)
                                        @if($service['name'] === 'العلاج الطبيعي المكثف 1' || $service['name'] === 'العلاج الطبيعي المكثف 2')
                                            @php $price+=getSettingValue('sessionPrice1') * $service['sessions_count'] @endphp
                                        @elseif($service['name'] === 'العلاج الوظيفي 1' || $service['name'] === 'العلاج الوظيفي 2')
                                            @php $price+=getSettingValue('sessionPrice2') * $service['sessions_count'] @endphp
                                        @elseif($service['name'] === 'التكامل الحسي 1' || $service['name'] === 'التكامل الحسي 2')
                                            @php $price+=getSettingValue('sessionPrice3') * $service['sessions_count'] @endphp
                                        @elseif($service['name'] === 'التخاطب والنطق 1' || $service['name'] === 'التخاطب والنطق 2')
                                            @php $price+=getSettingValue('sessionPrice4') * $service['sessions_count'] @endphp
                                        @endif
                                    @endforeach
                                    {{$price * (100-$offer['discount_percentage'])/100}} جينها
                                </td>
                              <td>
                            @foreach($offer->services as $service)
                                  <li>{{$service->name}}</li>
                             @endforeach
                              </td>
                                <td class="text-center">
                                    @if(userCan('edit_offers'))
                                    <a href="javascript:;" data-bs-target="#editservice{{$offer->id}}" data-bs-toggle="modal" class="btn btn-icon btn-info" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="{{trans('common.edit')}}">
                                        <i data-feather='edit'></i>
                                    </a>
                                    @endif
                                        @if(userCan('delete_offers'))

                                        <?php $delete = route('admin.offers.delete',['id'=>$offer->id]); ?>
                                    <button type="button" class="btn btn-icon btn-danger" onclick="confirmDelete('{{$delete}}','{{$offer->id}}')">
                                        <i data-feather='trash-2'></i>
                                    </button>
                                        @endif
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

                {{ $offers->links('vendor.pagination.default') }}


            </div>
        </div>
    </div>
    <!-- Bordered table end -->

    @foreach($offers as $offer)

        <div class="modal fade text-md-start" id="editservice{{$offer->id}}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-md modal-dialog-centered modal-edit-user">
                <div class="modal-content">
                    <div class="modal-header bg-transparent">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body pb-5 px-sm-5 pt-50">
                        <div class="text-center mb-2">
                            <h1 class="mb-1">{{trans('common.edit')}}: {{$offer['name']}}</h1>
                        </div>
                        {{Form::open(['url'=>route('admin.offers.update',$offer->id), 'id'=>'editserviceForm'.$offer->id, 'class'=>'row gy-1 pt-75 justify-content-center','required'])}}
                        <div class="col-12 col-md-6">
                            <label class="form-label" for="name">{{trans('common.name')}}</label>
                            {{Form::text('name',$offer->name,['id'=>'name', 'class'=>'form-control','required'])}}
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label" for="code">{{trans('common.code')}}</label>
                            {{Form::text('code',$offer->code,['id'=>'code', 'class'=>'form-control','required'])}}
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label" for="start_date">{{trans('common.start_date')}}</label>
                            {{Form::date('start_date',$offer->start_date,['id'=>'start_date', 'class'=>'form-control','required'])}}
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label" for="end_date">{{trans('common.end_date')}}</label>
                            {{Form::date('end_date',$offer->end_date,['id'=>'end_date', 'class'=>'form-control','required'])}}
                        </div>


                        <div class="col-12 col-md-6">
                            <label class="form-label" for="discount_percentage">{{trans('common.discount_percentage')}}</label>
                            {{Form::number('discount_percentage',$offer->discount_percentage,['id'=>'discount_percentage', 'class'=>'form-control','min' => '0','max' => '100','step' => '1','required'])}}
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label" for="services">{{trans('common.services')}}</label>
                            <div class="form-group">
                                @foreach($services as $service)
                                    <div class="form-check">
                                        {{ Form::checkbox('services[]', $service->id, in_array($service->id, $offer->services->pluck('id')->toArray()), ['class' => 'form-check-input', 'id' => 'service_'.$service->id]) }}
                                        {{ Form::label('service_'.$service->id, $service->name, ['class' => 'form-check-label']) }}
                                    </div>
                                @endforeach
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

    @endforeach

@stop

@section('page_buttons')
    @if(userCan('create_offers'))
    <a href="javascript:;" data-bs-target="#createservice" data-bs-toggle="modal" class="btn btn-primary">
        {{trans('common.CreateNew')}}
    </a>
    @endif

    <div class="modal fade text-md-start" id="createservice" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-md modal-dialog-centered modal-edit-user">
            <div class="modal-content">
                <div class="modal-header bg-transparent">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body pb-5 px-sm-5 pt-50">
                    <div class="text-center mb-2">
                        <h1 class="mb-1">{{trans('common.CreateNew')}}</h1>
                    </div>
                    {{Form::open(['url'=>route('admin.offers.store'), 'id'=>'createserviceForm', 'class'=>'row gy-1 pt-75 justify-content-center','required'])}}
                    <div class="col-12 col-md-6">
                        <label class="form-label" for="name">{{trans('common.name')}}</label>
                        {{Form::text('name','',['id'=>'name', 'class'=>'form-control','required'])}}
                    </div>
                    <div class="col-12 col-md-6">
                        <label class="form-label" for="code">{{trans('common.code')}}</label>
                        {{Form::text('code','',['id'=>'code', 'class'=>'form-control','required'])}}
                    </div>
                    <div class="col-12 col-md-6">
                        <label class="form-label" for="start_date">{{trans('common.start_date')}}</label>
                        {{Form::date('start_date','',['id'=>'start_date', 'class'=>'form-control','required'])}}
                    </div>
                    <div class="col-12 col-md-6">
                        <label class="form-label" for="end_date">{{trans('common.end_date')}}</label>
                        {{Form::date('end_date','',['id'=>'end_date', 'class'=>'form-control','required'])}}
                    </div>


                    <div class="col-12 col-md-6">
                        <label class="form-label" for="discount_percentage">{{trans('common.discount_percentage')}}</label>
                        {{Form::number('discount_percentage','',['id'=>'discount_percentage', 'class'=>'form-control','min' => '0','max' => '100','step' => '1','required'])}}
                    </div>
                    <div class="col-12 col-md-6">
                        <label class="form-label" for="services">{{trans('common.services')}}</label>
                        <div class="form-group">
                            @foreach($services as $service)
                                <div class="form-check">
                                    {{ Form::checkbox('services[]', $service->id, null, ['class' => 'form-check-input', 'id' => 'service_'.$service->id]) }}
                                    {{ Form::label('service_'.$service->id, $service->name, ['class' => 'form-check-label']) }}
                                </div>
                            @endforeach
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
@stop

@section('scripts')
    <script src="{{asset('AdminAssets/app-assets/js/scripts/pages/modal-add-service.js')}}"></script>
@stop
