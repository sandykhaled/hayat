@extends('AdminPanel.layouts.master')
@section('content')
    <!-- Bordered table start -->
    <div class="row" id="table-bordered">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">{{$title}}</h4>
                </div>
                <div>
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered mb-2">
                        <thead class="text-center">
                        <tr>
                            <th class="text-center">#</th>
                            <th class="text-center">{{trans('common.name_ar')}}</th>
                            <th class="text-center">{{trans('common.name_en')}}</th>
                            <th class="text-center">{{trans('common.description_ar')}}</th>
                            <th class="text-center">{{trans('common.description_en')}}</th>
                            <th class="text-center">{{trans('common.image')}}</th>
                            <th class="text-center">{{trans('common.contact')}}</th>
                            <th class="text-center">{{trans('common.price')}}</th>
                            <th class="text-center">{{trans('common.category')}}</th>
                            <th class="text-center">{{trans('common.actions')}}</th>

                        </tr>
                        </thead>
                        <tbody class="text-center">
                        @forelse($services as $service)
                            <tr id="row_{{$service->id}}">
                                <td>{{$service->id}}</td>
                                <td>
                                    {{$service->name_ar}}
                                </td>
                                <td>
                                    {{$service->name_en}}
                                </td>
                                <td>
                                    {{$service->description_ar}}
                                </td>
                                <td>
                                    {{$service->description_en}}
                                </td>
                                <td>
                                    @if($service->image != '')

                                        <img src="{{ asset('uploads/Webservices/' . $service->image) }}" alt="image" class="img-responsive rounded mt-2" width="50px">
                                    @endif

                                </td>
                                <td>
                                    {{$service->contact}}
                                </td>
                                <td>
                                    {{$service->price}}
                                </td>
                                <td>
                                    @if($service['category'] === 'remote')
                                    {{ trans('common.remote') }}
                                    @elseif($service['category'] === 'inside')
                                    {{ trans('common.inside') }}
                                    @endif
                                </td>

                                <td class="text-center">
                                    @if (userCan('webservice_update'))
                                        <a href="javascript:;" data-bs-target="#editarea{{$service->id}}" data-bs-toggle="modal" class="btn btn-icon btn-info" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="{{trans('common.edit')}}">
                                            <i data-feather='edit'></i>
                                        </a>
                                    @endif
                                    @if (userCan('webservice_delete'))
                                            <?php $delete = route('admin.webservices.delete', ['id' => $service->id]); ?>
                                        <button type="button" class="btn btn-icon btn-danger" onclick="confirmDelete('{{$delete}}','{{$service->id}}')" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="{{trans('common.delete')}}">
                                            <i data-feather='trash-2'></i>
                                        </button>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="p-3 text-center">
                                    <h2>{{trans('common.nothingToView')}}</h2>
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>

                @foreach($services as $service)
                    @include('AdminPanel.webservices.modals', ['service' => $service])
                    @endforeach


                    {{ $services->links('vendor.pagination.default') }}


            </div>
        </div>
    </div>
    <!-- Bordered table end -->
@stop


@section('page_buttons')
    @if(userCan('webservice_create'))
    <a href="javascript:;" data-bs-target="#createarea" data-bs-toggle="modal" class="btn btn-primary">
        {{trans('common.CreateNew')}}
    </a>
    @endif
    <div class="modal fade text-md-start" id="createarea" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-user">
            <div class="modal-content">
                <div class="modal-header bg-transparent">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body pb-5 px-sm-5 pt-50">
                    <div class="text-center mb-2">
                        <h1 class="mb-1">{{trans('common.CreateNew')}}</h1>
                    </div>
                    {{Form::open(['url' => route('admin.webservices.store'), 'id' => 'createareaForm', 'class' => 'row gy-1 pt-75', 'files' => true])}}

                    <div class="col-12 col-md-6">
                        <label class="form-label" for="name_ar">{{trans('common.name_ar')}}</label>
                        {{Form::text('name_ar','', ['id' => 'name_ar', 'class' => 'form-control', 'required'])}}
                    </div>

                    <div class="col-12 col-md-6">
                        <label class="form-label" for="name_en">{{trans('common.name_en')}}</label>
                        {{Form::text('name_en','', ['id' => 'name_en', 'class' => 'form-control', 'required'])}}
                    </div>
                    <div class="col-12 col-md-6">
                        <label class="form-label" for="description_ar">{{trans('common.description_ar')}}</label>
                        {{Form::text('description_ar', '', ['id' => 'description_ar', 'class' => 'form-control', 'required'])}}
                    </div>
                    <div class="col-12 col-md-6">
                        <label class="form-label" for="description_en">{{trans('common.description_en')}}</label>
                        {{Form::text('description_en', '', ['id' => 'description_en', 'class' => 'form-control', 'required'])}}
                    </div>
                    <div class="col-12 col-md-6">
                        <label class="form-label" for="contact">{{trans('common.contact')}}</label>
                        {{Form::text('contact', '', ['id' => 'contact', 'class' => 'form-control', 'required'])}}
                    </div>
                    <div class="col-12 col-md-6">
                        <label class="form-label" for="price">{{trans('common.price')}}</label>
                        {{Form::text('price', '', ['id' => 'price', 'class' => 'form-control', 'required'])}}
                    </div>
                    <div class="col-12 col-md-6">
                        <label class="form-label" for="image">{{ trans('common.image') }}</label>
                        {{ Form::file('image', ['id' => 'image', 'class' => 'form-control']) }}
                    </div>
                    <div class="col-12 col-md-6">
                        <label class="form-label" for="category">{{trans('common.category')}}</label>
                        <label>
                            {{ Form::radio('category', 'remote' , old('category') == 'remote', ['id' => 'remote']) }}
                            {{trans('common.remote')}}
                        </label>
                        <label>
                            {{ Form::radio('category', 'inside', old('category') == 'inside', ['id' => 'inside']) }}
                            {{trans('common.inside')}}
                        </label>
                    </div>
                    <div class="col-12 text-center mt-2 pt-50">
                        <button type="submit" class="btn btn-primary me-1">{{trans('common.Save changes')}}</button>
                        <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal" aria-label="Close">{{trans('common.Cancel')}}</button>
                    </div>
                    {{Form::close()}}
                </div>
            </div>
        </div>
    </div>
@stop
