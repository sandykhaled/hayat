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
                                <th>{{trans('common.name')}}</th>
                                <th>{{trans('common.branch')}}</th>
                                <th class="text-center">{{trans('common.type')}}</th>
                                <th class="text-center">{{trans('common.income')}}</th>
                                <th class="text-center">{{trans('common.outcome')}}</th>
                                <th class="text-center">{{trans('common.balance')}}</th>
                                <th class="text-center">{{trans('common.actions')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($safes as $safe)
                            <tr id="row_{{$safe->id}}">
                                <td>
                                    {{$safe['Title']}}
                                </td>
                                <td>
                                    {{$safe->branch->name ?? '-'}}
                                </td>
                                <td>
                                    {{$safe->TypeText()}}
                                </td>
                                <td class="text-center">
                                    {{$safe->totals()['income']}}
                                </td>
                                <td class="text-center">
                                    {{$safe->totals()['outcome']}}
                                </td>
                                <td class="text-center">
                                    {{$safe->totals()['balance']}}
                                </td>
                                <td class="text-center">
                                    <a href="javascript:;" data-bs-target="#editSafe{{$safe->id}}" data-bs-toggle="modal" class="btn btn-icon btn-info" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="{{trans('common.edit')}}">
                                        <i data-feather='edit'></i>
                                    </a>
                                    <?php $delete = route('admin.safes.delete',['id'=>$safe->id]); ?>
                                    <button type="button" class="btn btn-icon btn-danger" onclick="confirmDelete('{{$delete}}','{{$safe->id}}')">
                                        <i data-feather='trash-2'></i>
                                    </button>
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

                {{ $safes->links('vendor.pagination.default') }}


            </div>
        </div>
    </div>
    <!-- Bordered table end -->

@foreach($safes as $safe)

    <div class="modal fade text-md-start" id="editSafe{{$safe->id}}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-user">
            <div class="modal-content">
                <div class="modal-header bg-transparent">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body pb-5 px-sm-5 pt-50">
                    <div class="text-center mb-2">
                        <h1 class="mb-1">{{trans('common.edit')}}: {{$safe['name_'.session()->get('Lang')]}}</h1>
                    </div>
                    {{Form::open(['url'=>route('admin.safes.update',$safe->id), 'id'=>'editSafeForm'.$safe->id, 'class'=>'row gy-1 pt-75'])}}
                        <div class="col-12 col-md-4">
                            <label class="form-label" for="Title">{{trans('common.name')}}</label>
                            {{Form::text('Title',$safe->Title,['id'=>'Title', 'class'=>'form-control'])}}
                        </div>
                        <div class="col-12 col-md-4">
                            <label class="form-label" for="Type">{{trans('common.type')}}</label>
                            {{Form::select('Type',safeTypes(session()->get('Lang')),$safe->Type,['id'=>'Type', 'class'=>'form-select'])}}
                        </div>
                        <div class="col-12 col-md-4">
                            <label class="form-label" for="branch_id">{{trans('common.branch')}}</label>
                            {{Form::select('branch_id',branchesList(),$safe->branch_id,['id'=>'branch_id', 'class'=>'form-select'])}}
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
    <a href="javascript:;" data-bs-target="#createsafe" data-bs-toggle="modal" class="btn btn-primary">
        {{trans('common.CreateNew')}}
    </a>

    <div class="modal fade text-md-start" id="createsafe" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-user">
            <div class="modal-content">
                <div class="modal-header bg-transparent">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body pb-5 px-sm-5 pt-50">
                    <div class="text-center mb-2">
                        <h1 class="mb-1">{{trans('common.CreateNew')}}</h1>
                    </div>
                    {{Form::open(['url'=>route('admin.safes.store'), 'id'=>'createsafeForm', 'class'=>'row gy-1 pt-75'])}}
                        <div class="col-12 col-md-4">
                            <label class="form-label" for="Title">{{trans('common.name')}}</label>
                            {{Form::text('Title','',['id'=>'Title', 'class'=>'form-control'])}}
                        </div>
                        <div class="col-12 col-md-4">
                            <label class="form-label" for="Type">{{trans('common.type')}}</label>
                            {{Form::select('Type',safeTypes(session()->get('Lang')),'',['id'=>'Type', 'class'=>'form-select'])}}
                        </div>
                        <div class="col-12 col-md-4">
                            <label class="form-label" for="branch_id">{{trans('common.branch')}}</label>
                            {{Form::select('branch_id',branchesList(),'',['id'=>'branch_id', 'class'=>'form-select'])}}
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
<script src="{{asset('AdminAssets/app-assets/js/scripts/pages/modal-add-safe.js')}}"></script>
@stop