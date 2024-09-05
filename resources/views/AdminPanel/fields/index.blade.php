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
                            <th class="text-center">{{trans('common.fieldName')}}</th>
                            <th class="text-center">{{trans('common.details')}}</th>
                            <th class="text-center">{{trans('common.duration')}}</th>
                            <th class="text-center">{{trans('common.actions')}}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($fields as $field)
                            <tr id="row_{{$field->id}}">
                                <td>
                                    {{$field['name']}}
                                </td>
                                <td>
                                    {{$field['details']}}
                                </td>
                                <td>
                                    {{$field['duration']}} دقيقة
                                </td>
                                <td class="text-center">
                                    @if(userCan('edit_fields'))

                                    <a href="javascript:;" data-bs-target="#editmagazine{{$field->id}}" data-bs-toggle="modal" class="btn btn-icon btn-info" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="{{trans('common.edit')}}">
                                        <i data-feather='edit'></i>
                                    </a>
                                    @endif
                                        @if(userCan('delete_fields'))
                                        <?php $delete = route('admin.fields.delete',['id'=>$field->id]); ?>
                                    <button type="button" class="btn btn-icon btn-danger" onclick="confirmDelete('{{$delete}}','{{$field->id}}')">
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

                {{ $fields->links('vendor.pagination.default') }}


            </div>
        </div>
    </div>
    <!-- Bordered table end -->

    @foreach($fields as $field)

        <div class="modal fade text-md-start" id="editmagazine{{$field->id}}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-md modal-dialog-centered modal-edit-user">
                <div class="modal-content">
                    <div class="modal-header bg-transparent">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body pb-5 px-sm-5 pt-50">
                        <div class="text-center mb-2">
                            <h1 class="mb-1">{{trans('common.edit')}}: {{$field['name']}}</h1>
                        </div>
                        {{Form::open(['url'=>route('admin.fields.update',$field->id), 'id'=>'editmagazineForm'.$field->id, 'class'=>'row gy-1 pt-75 justify-content-center'])}}
                        <div class="col-12 col-md-6">
                            <label class="form-label" for="name">{{trans('common.name')}}</label>
                            <select  class="form-select" name="name" id="name">
                                @php
                                    $fieldsName = ['العلاج الطبيعي المكثف 1','العلاج الطبيعي المكثف 2',
                                     'التكامل الحسي 1','التكامل الحسي 2',
                                    'التخاطب والنطق 1','التخاطب والنطق 2',
                                    'العلاج الوظيفي 1','العلاج الوظيفي 2',
                                     ]
                                @endphp
                                @foreach($fieldsName as $fieldName)
                                    <option value="{{ $fieldName }}"
                                        {{ $fieldName === $field->name ? 'selected' : '' }}>
                                        {{ $fieldName }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label" for="duration">{{trans('common.duration')}}</label>
                            {{Form::text('duration',$field->duration,['id'=>'duration', 'class'=>'form-control','required'])}}
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label" for="details">{{trans('common.details')}}</label>
                            {{Form::textarea('details',$field->details,['id'=>'details', 'class'=>'form-control','rows'=>'3','required'])}}
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
    @if(userCan('create_fields'))
    <a href="javascript:;" data-bs-target="#createmagazine" data-bs-toggle="modal" class="btn btn-primary">
        {{trans('common.CreateNew')}}
    </a>
    @endif

    <div class="modal fade text-md-start" id="createmagazine" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-md modal-dialog-centered modal-edit-user">
            <div class="modal-content">
                <div class="modal-header bg-transparent">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body pb-5 px-sm-5 pt-50">
                    <div class="text-center mb-2">
                        <h1 class="mb-1">{{trans('common.CreateNew')}}</h1>
                    </div>
                    {{Form::open(['url'=>route('admin.fields.store'), 'id'=>'createmagazineForm', 'class'=>'row gy-1 pt-75 justify-content-center'])}}
                    <div class="col-12 col-md-6">
                        <label class="form-label" for="name">{{trans('common.name')}}</label>
                        <select  class="form-select" name="name" id="name">
                            @php
                                $fieldsName = ['العلاج الطبيعي المكثف 1','العلاج الطبيعي المكثف 2',
                                                                    'التكامل الحسي 1','التكامل الحسي 2',
                                                                   'التخاطب والنطق 1','التخاطب والنطق 2',
                                                                   'العلاج الوظيفي 1','العلاج الوظيفي 2',
                                                                    ]
                            @endphp
                            @foreach($fieldsName as $fieldName)
                                <option value="{{$fieldName}}">{{ $fieldName }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-12 col-md-6">
                        <label class="form-label" for="duration">{{trans('common.duration')}}</label>
                        {{Form::text('duration','',['id'=>'duration', 'class'=>'form-control','required'])}}
                    </div>
                    <div class="col-12 col-md-6">
                        <label class="form-label" for="details">{{trans('common.details')}}</label>
                        {{Form::textarea('details','',['id'=>'details', 'class'=>'form-control','rows'=>'3','required'])}}
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
    <script src="{{asset('AdminAssets/app-assets/js/scripts/pages/modal-add-magazine.js')}}"></script>
@stop
