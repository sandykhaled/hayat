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
                            <th class="text-center">{{trans('common.address_ar')}}</th>
                            <th class="text-center">{{trans('common.address_en')}}</th>
                            <th class="text-center">{{trans('common.whatsapp')}}</th>
                            <th class="text-center">{{trans('common.location')}}</th>
                            <th class="text-center">{{trans('common.image')}}</th>
                            <th class="text-center">{{trans('common.actions')}}</th>

                        </tr>
                        </thead>
                        <tbody class="text-center">
                        @forelse($places as $place)
                            <tr id="row_{{$place->id}}">
                                <td>{{$place->id}}</td>
                                <td>
                                    {{$place->name_ar}}
                                </td>
                                <td>
                                    {{$place->name_en}}
                                </td>
                                <td>
                                    {{$place->address_ar}}
                                </td>
                                <td>
                                    {{$place->address_en}}
                                </td>

                                <td>
                                    {{$place->whatsapp}}
                                </td>


                                <td>
                                    {{$place->location_url}}
                                </td>

                                <td>
                                    @if($place->image != '')

                                    <img src="{{ asset('uploads/places/' . $place->image) }}" alt="image" class="img-responsive rounded mt-2" width="50px">
                                @endif

                                </td>


                                    <td class="text-center">
                                        @if (userCan('edit_admin'))
                                            <a href="javascript:;" data-bs-target="#editarea{{$place->id}}" data-bs-toggle="modal" class="btn btn-icon btn-info" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="{{trans('common.edit')}}">
                                                <i data-feather='edit'></i>
                                            </a>
                                        @endif
                                        @if (userCan('delete_admin'))
                                                <?php $delete = route('admin.places.delete', ['id' => $place->id]); ?>
                                            <button type="button" class="btn btn-icon btn-danger" onclick="confirmDelete('{{$delete}}','{{$place->id}}')" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="{{trans('common.delete')}}">
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

                @foreach($places as $place)
                    @include('AdminPanel.places.modals', ['place' => $place])
                    @endforeach


                    {{ $places->links('vendor.pagination.default') }}


            </div>
        </div>
    </div>
    <!-- Bordered table end -->
@stop


@section('page_buttons')
    <a href="javascript:;" data-bs-target="#createarea" data-bs-toggle="modal" class="btn btn-primary">
        {{trans('common.CreateNew')}}
    </a>

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
                    {{Form::open(['url' => route('admin.places.store'), 'id' => 'createareaForm', 'class' => 'row gy-1 pt-75', 'files' => true])}}

                    <div class="col-12 col-md-6">
                        <label class="form-label" for="name_ar">{{trans('common.name_ar')}}</label>
                        {{Form::text('name_ar','', ['id' => 'name_ar', 'class' => 'form-control', 'required'])}}
                    </div>

                    <div class="col-12 col-md-6">
                        <label class="form-label" for="name_en">{{trans('common.name_en')}}</label>
                        {{Form::text('name_en','', ['id' => 'name_en', 'class' => 'form-control', 'required'])}}
                    </div>

                    <div class="col-12 col-md-6">
                        <label class="form-label" for="address_ar">{{trans('common.address_ar')}}</label>
                        {{Form::text('address_ar', '', ['id' => 'address_ar', 'class' => 'form-control', 'required'])}}
                    </div>

                    <div class="col-12 col-md-6">
                        <label class="form-label" for="address_en">{{trans('common.address_en')}}</label>
                        {{Form::text('address_en', '', ['id' => 'address_en', 'class' => 'form-control', 'required'])}}
                    </div>

                    <div class="col-12 col-md-6">
                        <label class="form-label" for="whatsapp">{{trans('common.whatsapp')}}</label>
                        {{Form::text('whatsapp', '', ['id' => 'whatsapp', 'class' => 'form-control', 'required'])}}
                    </div>

                    <div class="col-12 col-md-6">
                        <label class="form-label" for="location_url">{{trans('common.location_url')}}</label>
                        {{Form::text('location_url', '', ['id' => 'location_url', 'class' => 'form-control', 'required'])}}
                    </div>

                    <div class="col-12 col-md-6">
                        <label class="form-label" for="image">{{ trans('common.image') }}</label>
                        {{ Form::file('image', ['id' => 'image', 'class' => 'form-control']) }}
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
