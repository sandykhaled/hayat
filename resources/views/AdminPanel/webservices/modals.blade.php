@if($services)
    @foreach ($services as $service)

        <div class="modal fade text-md-start" id="editarea{{$service->id}}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-user">
                <div class="modal-content">
                    <div class="modal-header bg-transparent">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body pb-5 px-sm-5 pt-50">
                        <div class="text-center mb-2">
                            <h1 class="mb-1">{{trans('common.edit')}}</h1>
                        </div>
                        {{Form::open(['url' => route('admin.webservices.update', ['id' => $service->id]), 'id' => 'editareaForm', 'class' => 'row gy-1 pt-75', 'files' => true])}}
                        <div class="col-12 col-md-6">
                            <label class="form-label" for="name_ar">{{trans('common.name_ar')}}</label>
                            {{Form::text('name_ar',$service->name_ar, ['id' => 'name_ar', 'class' => 'form-control', 'required'])}}
                        </div>

                        <div class="col-12 col-md-6">
                            <label class="form-label" for="name_en">{{trans('common.name_en')}}</label>
                            {{Form::text('name_en',$service->name_en, ['id' => 'name_en', 'class' => 'form-control', 'required'])}}
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label" for="description_ar">{{ trans('common.description_ar') }}</label>
                            {{ Form::textarea('description_ar', $service->description_ar, ['id' => 'description_ar', 'class' => 'form-control', 'rows' => '3']) }}
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label" for="description_en">{{ trans('common.description_en') }}</label>
                            {{ Form::textarea('description_en', $service->description_en, ['id' => 'description_en', 'class' => 'form-control', 'rows' => '3']) }}
                        </div>

                        <div class="col-12 col-md-6">
                            <label class="form-label" for="contact">{{trans('common.contact')}}</label>
                            {{Form::text('contact',$service->contact, ['id' => 'contact', 'class' => 'form-control', 'required'])}}
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label" for="price">{{trans('common.price')}}</label>
                            {{Form::text('price',$service->price, ['id' => 'price', 'class' => 'form-control', 'required'])}}
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label" for="booking_repetition">{{ trans('common.booking_repetition') }}</label>
                            <label>
                                {{ Form::radio('category', 'remote', $service->category === 'remote', ['id' => 'remote']) }}
                                {{ trans('common.remote') }}
                            </label>
                            <label>
                                {{ Form::radio('category', 'inside', $service->category === 'inside', ['id' => 'inside']) }}
                                {{ trans('common.inside') }}
                            </label>
                        </div>

                        <div class="col-12 col-md-6">
                            <label class="form-label" for="image">{{ trans('common.image') }}</label>
                            {{ Form::file('image', ['id' => 'image', 'class' => 'form-control']) }}
                            @if($service->image)
                                <img src="{{ asset('uploads/webservices/' . $service->image) }}" alt="image" class="img-responsive rounded mt-2" width="100px">
                            @endif
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
    @endforeach
@else
@endif
