<a href="javascript:;" data-bs-target="#createClient" data-bs-toggle="modal" class="btn btn-sm btn-primary">
    {{trans('common.CreateNew')}}
</a>

<div class="modal fade text-md-start" id="createClient" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-user">
        <div class="modal-content">
            <div class="modal-header bg-transparent">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body pb-5 px-sm-5 pt-50">
                <div class="text-center mb-2">
                    <h1 class="mb-1">{{trans('common.CreateNew')}}</h1>
                </div>
                {{Form::open(['url'=>route('admin.clients.store'), 'id'=>'createClientForm', 'class'=>'row gy-1 pt-75'])}}


                <div class="col-12 col-md-3">
                        <label class="form-label" for="Name">{{trans('common.name')}}</label>
                        {{Form::text('Name','',['id'=>'Name', 'class'=>'form-control','required'])}}
                        @if($errors->has('Name'))
                            <span class="text-danger" role="alert">
                                <b>{{ $errors->first('Name') }}</b>
                            </span>
                        @endif
                    </div>

                    <div class="col-12 col-md-3">
                        <label class="form-label" for="code">{{trans('common.code')}}</label>
                        {{Form::text('code','',['id'=>'code', 'class'=>'form-control',''])}}
                        @if($errors->has('code'))
                            <span class="text-danger" role="alert">
                                <b>{{ $errors->first('code') }}</b>
                            </span>
                        @endif
                    </div>

                    <div class="col-12 col-md-3">
                        <label class="form-label" for="service_id">{{trans('common.service')}}</label>
                        {{Form::select('service_id', $services->pluck('name', 'id'), null, ['id'=>'service_id', 'class'=>'form-control', 'required'])}}
                        @if($errors->has('service_id'))
                            <span class="text-danger" role="alert">
                                <b>{{ $errors->first('service_id') }}</b>
                            </span>
                        @endif
                    </div>



                    <div class="col-12 col-md-3">
                        <label class="form-label" for="referral">{{trans('common.refferal')}}</label>
                        {{Form::select('referral',refferalList(session()->get('Lang')),'',['id'=>'referral', 'class'=>'form-control'])}}
                    </div>
                    @if(isset($noAgent))
                        {{Form::hidden('UID','0')}}
                    @endif
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
