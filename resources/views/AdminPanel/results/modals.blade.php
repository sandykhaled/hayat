@if($results)
    @foreach ($results as $result)

        <div class="modal fade text-md-start" id="editarea{{$result->id}}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-user">
                <div class="modal-content">
                    <div class="modal-header bg-transparent">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body pb-5 px-sm-5 pt-50">
                        <div class="text-center mb-2">
                            <h1 class="mb-1">{{trans('common.edit')}}</h1>
                        </div>
                        {{Form::open(['url' => route('admin.results.update', ['id' => $result]), 'id' => 'editareaForm', 'class' => 'row gy-1 pt-75', 'files' => true])}}
                        <div class="col-12 col-md-6">
                            <label class="form-label" for="name_ar">{{trans('common.name_ar')}}</label>
                            {{Form::text('name_ar',$result->name_ar, ['id' => 'name_ar', 'class' => 'form-control', 'required'])}}
                        </div>

                        <div class="col-12 col-md-6">
                            <label class="form-label" for="name_en">{{trans('common.name_en')}}</label>
                            {{Form::text('name_en',$result->name_en, ['id' => 'name_en', 'class' => 'form-control', 'required'])}}
                        </div>

                        <div class="col-12 col-md-6">
                            <label class="form-label" for="description_ar">{{trans('common.description_ar')}}</label>
                            {{Form::text('description_ar',$result->description_ar, ['id' => 'description_ar', 'class' => 'form-control', 'required'])}}
                        </div>

                        <div class="col-12 col-md-6">
                            <label class="form-label" for="description_en">{{trans('common.description_en')}}</label>
                            {{Form::text('description_en',$result->description_en, ['id' => 'description_en', 'class' => 'form-control', 'required'])}}
                        </div>

                        <div class="col-12 col-md-6">
                            <label class="form-label" for="start">{{trans('common.start')}}</label>
                            {{Form::date('start',$result->start, ['id' => 'start', 'class' => 'form-control', 'required'])}}
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label" for="end">{{trans('common.end')}}</label>
                            {{Form::date('end',$result->end, ['id' => 'end', 'class' => 'form-control', 'required'])}}
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label" for="video">{{ trans('common.video') }}</label>
                            {{ Form::file('video', ['id' => 'video', 'class' => 'form-control']) }}
                            @if($result->video)
                            <video width="320" height="240" controls>
                                <source src="{{ asset('uploads/results/' . $result->video) }}" type="video/mp4">
                            </video>
                            @endif



                        <div class="col-12 text-center mt-2 pt-50">
                            <button type="submit" class="btn btn-primary me-1">{{trans('common.Save changes')}}</button>
                            <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal" aria-label="Close">{{trans('common.Cancel')}}</button>
                        </div>
                        {{Form::close()}}
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@else
@endif
