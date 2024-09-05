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
                            <th class="text-center">{{trans('common.start')}}</th>
                            <th class="text-center">{{trans('common.end')}}</th>
                            <th class="text-center">{{trans('common.video')}}</th>
                            <th class="text-center">{{trans('common.actions')}}</th>

                        </tr>
                        </thead>
                        <tbody class="text-center">
                        @forelse($results as $result)
                            <tr id="row_{{$result->id}}">
                                <td>{{$result->id}}</td>
                                <td>
                                    {{$result->name_ar}}
                                </td>
                                <td>
                                    {{$result->name_en}}
                                </td>
                                <td>
                                    {{$result->description_ar}}
                                </td>
                                <td>
                                    {{$result->description_en}}
                                </td>
                                <td>
                                    {{$result->start}}
                                </td>
                                <td>
                                    {{$result->end}}
                                </td>

                                <td>
                                    @if($result->video != '')
                                        <video width="240" height="120" controls>
                                            <source src="{{ asset('uploads/results/' . $result->video) }}" type="video/mp4">
                                        </video>
                                    @endif
                                </td>


                                    <td class="text-center">
                                        @if (userCan('edit_admin'))
                                            <a href="javascript:;" data-bs-target="#editarea{{$result->id}}" data-bs-toggle="modal" class="btn btn-icon btn-info" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="{{trans('common.edit')}}">
                                                <i data-feather='edit'></i>
                                            </a>
                                        @endif
                                        @if (userCan('delete_admin'))
                                                <?php $delete = route('admin.results.delete', ['id' => $result->id]); ?>
                                            <button type="button" class="btn btn-icon btn-danger" onclick="confirmDelete('{{$delete}}','{{$result->id}}')" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="{{trans('common.delete')}}">
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

                @foreach($results as $result)
                    @include('AdminPanel.results.modals', ['result' => $result])
                    @endforeach


                    {{ $results->links('vendor.pagination.default') }}


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
                    {{Form::open(['url' => route('admin.results.store'), 'id' => 'createareaForm', 'class' => 'row gy-1 pt-75', 'files' => true])}}

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
                        {{Form::text('description_ar','', ['id' => 'description_ar', 'class' => 'form-control', 'required'])}}
                    </div>
                    <div class="col-12 col-md-6">
                        <label class="form-label" for="description_en">{{trans('common.description_en')}}</label>
                        {{Form::text('description_en','', ['id' => 'description_en', 'class' => 'form-control', 'required'])}}
                    </div>

                    <div class="col-12 col-md-6">
                        <label class="form-label" for="start">{{trans('common.start')}}</label>
                        {{Form::date('start', '', ['id' => 'start', 'class' => 'form-control', 'required'])}}
                    </div>
                    <div class="col-12 col-md-6">
                        <label class="form-label" for="end">{{trans('common.end')}}</label>
                        {{Form::date('end', '', ['id' => 'end', 'class' => 'form-control', 'required'])}}
                    </div>
                    {{Form::file('video', ['id' => 'video', 'class' => 'form-control', 'required'])}}
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
