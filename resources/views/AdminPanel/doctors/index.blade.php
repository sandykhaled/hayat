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
                                <th class="text-center">{{trans('common.name')}}</th>
                                <th class="text-center">{{trans('common.jobTitle')}}</th>
                                <th class="text-center">{{trans('common.photo')}}</th>
                                <th class="text-center">{{trans('common.links')}}</th>
                                <th class="text-center">{{trans('common.actions')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($doctors as $doctor)
                            <tr id="row_{{$doctor->id}}">
                                <td>
                                    {{$doctor['name']}}
                                </td>
                                <td>
                                    {{$doctor['jobTitle']}}
                                </td>
                                  <td>
                                  @if($doctor->photo != '')
                                    <img src="{{ asset('uploads/doctors/' . $doctor->photo) }}" alt="image" class="img-responsive rounded mt-2" width="50px">
                                    @endif
                                </td>
                              <td class="text-center align-middle">
                                <a href="{{ $doctor['whatsappLink'] }}" class="whatsapp" target="_blank">
                                    <i class="fa fa-whatsapp" aria-hidden="true"></i>
                                </a>
                                <a href="{{ $doctor['linkedInLink'] }}" class="linkedin" target="_blank" aria-label="LinkedIn">
                                    <i class="fa fa-linkedin" aria-hidden="true"></i>
                                </a>
                                <a href="{{ $doctor['twitterLink'] }}" class="twitter" target="_blank" aria-label="Twitter">
                                    <i class="fa fa-twitter" aria-hidden="true"></i>
                                </a>
                        </td>
                              <td class="text-center">
                                    @if(userCan('edit_services'))

                                    <a href="javascript:;" data-bs-target="#editservice{{$doctor->id}}" data-bs-toggle="modal" class="btn btn-icon btn-info" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="{{trans('common.edit')}}">
                                        <i data-feather='edit'></i>
                                    </a>
                                    @endif
                                    @if(userCan('delete_doctors'))

                                  <?php $delete = route('admin.doctors.delete',['id'=>$doctor->id]); ?>
                                    <button type="button" class="btn btn-icon btn-danger" onclick="confirmDelete('{{$delete}}','{{$doctor->id}}')">
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

                {{ $doctors->links('vendor.pagination.default') }}


            </div>
        </div>
    </div>
    <!-- Bordered table end -->

    @foreach($doctors as $doctor)

        <div class="modal fade text-md-start" id="editservice{{$doctor->id}}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-md modal-dialog-centered modal-edit-user">
                <div class="modal-content">
                    <div class="modal-header bg-transparent">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body pb-5 px-sm-5 pt-50">
                        <div class="text-center mb-2">
                            <h1 class="mb-1">{{trans('common.edit')}}: {{$doctor['name']}}</h1>
                        </div>
                        {{Form::open(['url'=>route('admin.doctors.update',$doctor->id), 'id'=>'editserviceForm'.$doctor->id, 'class'=>'row gy-1 pt-75 justify-content-center','required','files' => true])}}
                        <div class="col-12 col-md-6">
                            <label class="form-label" for="name">{{trans('common.name')}}</label>
                            {{Form::text('name',$doctor->name,['id'=>'name', 'class'=>'form-control','required'])}}
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label" for="jobTitle">{{trans('common.jobTitle')}}</label>
                            {{Form::text('jobTitle',$doctor->jobTitle,['id'=>'jobTitle', 'class'=>'form-control'])}}
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label" for="linkedInLink">{{trans('common.linkedInLink')}}</label>
                            {{Form::text('linkedInLink',$doctor->linkedInLink,['id'=>'linkedInLink', 'class'=>'form-control'])}}
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label" for="twitterLink">{{trans('common.twitterLink')}}</label>
                            {{Form::text('twitterLink',$doctor->twitterLink,['id'=>'twitterLink', 'class'=>'form-control'])}}
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label" for="whatsappLink">{{trans('common.whatsappLink')}}</label>
                            {{Form::text('whatsappLink',$doctor->whatsappLink,['id'=>'whatsappLink', 'class'=>'form-control'])}}
                        </div>
                        <div class="col-12 col-md-6">
                        <label class="form-label" for="photo">{{ trans('common.photo') }}</label>
                        {{ Form::file('photo', ['id' => 'photo', 'class' => 'form-control']) }}
                        @if($doctor->photo != '')
                                    <img src="{{ asset('uploads/doctors/' . $doctor['photo']) }}" alt="photo" class="img-responsive rounded mt-2" width="50px">
                                    @endif
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
                    <h1 class="mb-1">{{ trans('common.CreateNew') }}</h1>
                </div>
                {{ Form::open(['url' => route('admin.doctors.store'), 'id' => 'createserviceForm', 'class' => 'row gy-1 pt-75 justify-content-center', 'method' => 'post', 'files' => true]) }}
                <div class="col-12 col-md-6">
                    <label class="form-label" for="name">{{ trans('common.name') }}</label>
                    {{ Form::text('name', '', ['id' => 'name', 'class' => 'form-control', 'required']) }}
                </div>
                <div class="col-12 col-md-6">
                    <label class="form-label" for="jobTitle">{{ trans('common.jobTitle') }}</label>
                    {{ Form::text('jobTitle', '', ['id' => 'jobTitle', 'class' => 'form-control', 'required']) }}
                </div>
                <div class="col-12 col-md-6">
                    <label class="form-label" for="linkedInLink">{{ trans('common.linkedInLink') }}</label>
                    {{ Form::url('linkedInLink', '', ['id' => 'linkedInLink', 'class' => 'form-control', 'required']) }}
                </div>
                <div class="col-12 col-md-6">
                    <label class="form-label" for="twitterLink">{{ trans('common.twitterLink') }}</label>
                    {{ Form::url('twitterLink', '', ['id' => 'twitterLink', 'class' => 'form-control', 'required']) }}
                </div>
                <div class="col-12 col-md-6">
                    <label class="form-label" for="whatsappLink">{{ trans('common.whatsappLink') }}</label>
                    {{ Form::url('whatsappLink', '', ['id' => 'whatsappLink', 'class' => 'form-control', 'required']) }}
                </div>
                <div class="col-12 col-md-6">
                    <label class="form-label" for="photo">{{ trans('common.photo') }}</label>
                    {{ Form::file('photo', ['id' => 'photo', 'class' => 'form-control']) }}
                </div>
                <div class="col-12 text-center mt-2 pt-50">
                    <button type="submit" class="btn btn-primary me-1">{{ trans('common.Save changes') }}</button>
                    <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal" aria-label="Close">
                        {{ trans('common.Cancel') }}
                    </button>
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
</div>

@stop

@section('scripts')
    <script src="{{asset('AdminAssets/app-assets/js/scripts/pages/modal-add-service.js')}}"></script>
@stop
