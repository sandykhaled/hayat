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
                                <th>{{trans('common.serviceName')}}</th>
                                <th class="text-center">{{trans('common.price')}}</th>
                                <th class="text-center">{{trans('common.sessionsCount')}}</th>
                                <th class="text-center">{{trans('common.sessionDuration')}}</th>
                                <th class="text-center">{{trans('common.visiting_count')}}</th>
                                <th class="text-center">{{trans('common.actions')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($services as $service)
                            <tr id="row_{{$service->id}}">
                                <td>
                                    {{$service['name']}}
                                </td>
                                <td>
                                    @if($service['name'] === 'العلاج الطبيعي المكثف 1' || $service['name'] === 'العلاج الطبيعي المكثف 2')
                                        {{ getSettingValue('sessionPrice1') * $service['sessions_count'] }}
                                    @elseif($service['name'] === 'العلاج الوظيفي 1' || $service['name'] === 'العلاج الوظيفي 2')
                                        {{ getSettingValue('sessionPrice2') * $service['sessions_count'] }}
                                    @elseif($service['name'] === 'التكامل الحسي 1' || $service['name'] === 'التكامل الحسي 2')
                                        {{ getSettingValue('sessionPrice3') * $service['sessions_count'] }}
                                    @elseif($service['name'] === 'التخاطب والنطق 1' || $service['name'] === 'التخاطب والنطق 2')
                                        {{ getSettingValue('sessionPrice4') * $service['sessions_count'] }}
                                    @else
                                        Price not available
                                    @endif
                                </td>
                                <td>
                                    {{$service['sessions_count']}}
                                </td>
                                <td>
                                    @foreach(\App\Models\Field::all() as $field)
                                      @if($field->name === $service->name )
                                          {{$field->duration}} دقيقة
                                      @endif
                                    @endforeach
                                </td>
                                <td>
                                    @if($service['visiting_count'] === 'single')
                                        مرة فقط
                                    @elseif($service['visiting_count'] === 'multiple')
                                        مرتين في اليوم
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if(userCan('edit_services'))

                                    <a href="javascript:;" data-bs-target="#editservice{{$service->id}}" data-bs-toggle="modal" class="btn btn-icon btn-info" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="{{trans('common.edit')}}">
                                        <i data-feather='edit'></i>
                                    </a>
                                    @endif
                                    @if(userCan('delete_services'))

                                    <?php $delete = route('admin.services.delete',['id'=>$service->id]); ?>
                                    <button type="button" class="btn btn-icon btn-danger" onclick="confirmDelete('{{$delete}}','{{$service->id}}')">
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

                {{ $services->links('vendor.pagination.default') }}


            </div>
        </div>
    </div>
    <!-- Bordered table end -->

@foreach($services as $service)

    <div class="modal fade text-md-start" id="editservice{{$service->id}}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-md modal-dialog-centered modal-edit-user">
            <div class="modal-content">
                <div class="modal-header bg-transparent">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body pb-5 px-sm-5 pt-50">
                    <div class="text-center mb-2">
                        <h1 class="mb-1">{{trans('common.edit')}}: {{$service['name']}}</h1>
                    </div>
                    {{Form::open(['url'=>route('admin.services.update',$service->id), 'id'=>'editserviceForm'.$service->id, 'class'=>'row gy-1 pt-75 justify-content-center'])}}
                    <div class="col-12 col-md-6">
                        <label class="form-label" for="booking_repetition">{{trans('common.serviceName')}}</label>
                            <div>
                                @php
                                    $selectedValue = $service->name
                                @endphp
                                <select class="form-select" name="name" id="name">
                                    @foreach($fields as $field)
                                        <option value="{{ $field }}"
                                            {{ old('name', $selectedValue) === $field ? 'selected' : '' }}>
                                            {{ $field }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <label class="form-label" for="booking_repetition">{{trans('common.visiting_count')}}</label>
                        <label>
                            {{ Form::radio('visiting_count', 'single', $service->visiting_count === 'single', ['id' => 'single']) }}
                            {{trans('common.single')}}
                        </label>
                        <label>
                            {{ Form::radio('visiting_count', 'multiple', $service->visiting_count === 'multiple', ['id' => 'multiple']) }}
                            {{trans('common.multiple')}}
                        </label>
                    </div>
                    <div class="col-12 col-md-6">
                        <label class="form-label" for="max_clients">{{trans('common.max_clients')}}</label>
                        {{Form::number('max_clients',$service->max_clients,['id'=>'max_clients', 'class'=>'form-control'])}}
                    </div>
                    <div class="col-12 col-md-6">
                        <label class="form-label" for="sessions_count">{{trans('common.sessionsCount')}}</label>
                        {{Form::text('sessions_count',$service->sessions_count,['id'=>'sessions_count', 'class'=>'form-control'])}}
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
    @if(userCan('create_services'))

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
                    {{Form::open(['url'=>route('admin.services.store'), 'id'=>'createserviceForm', 'class'=>'row gy-1 pt-75 justify-content-center'])}}
                    <div class="col-12 col-md-6">
                        <label class="form-label" for="booking_repetition">{{trans('common.serviceName')}}</label>
                        <select class="form-select" name="name" id="name">
                            @foreach($fields as $field)
                                <option value="{{ $field }}">{{ $field }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-12 col-md-6">
                        <label class="form-label" for="visiting_count">{{trans('common.visiting_count')}}</label>
                        <label>
                            {{ Form::radio('visiting_count', 'single', old('visiting_count') == 'single', ['id' => 'single']) }}
                            {{trans('common.single')}}
                        </label>
                        <label>
                            {{ Form::radio('visiting_count', 'multiple', old('visiting_count') == 'multiple', ['id' => 'multiple']) }}
                            {{trans('common.multiple')}}
                        </label>
                    </div>
                    <div class="col-12 col-md-6">
                        <label class="form-label" for="max_clients">{{trans('common.max_clients')}}</label>
                        {{Form::number('max_clients','',['id'=>'max_clients', 'class'=>'form-control'])}}
                    </div>
                    <div class="col-12 col-md-6">
                        <label class="form-label" for="sessions_count">{{trans('common.sessions_number')}}</label>
                        {{Form::number('sessions_count','',['id'=>'sessions_count', 'class'=>'form-control'])}}
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
