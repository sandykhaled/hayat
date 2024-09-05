@if($places)
    @foreach ($places as $place)

        <div class="modal fade text-md-start" id="editarea{{$place->id}}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-user">
                <div class="modal-content">
                    <div class="modal-header bg-transparent">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body pb-5 px-sm-5 pt-50">
                        <div class="text-center mb-2">
                            <h1 class="mb-1">{{trans('common.edit')}}</h1>
                        </div>
                        {{Form::open(['url' => route('admin.places.update', ['id' => $place->id]), 'id' => 'editareaForm', 'class' => 'row gy-1 pt-75', 'files' => true])}}
                        <div class="col-12 col-md-6">
                            <label class="form-label" for="name_ar">{{trans('common.name_ar')}}</label>
                            {{Form::text('name_ar',$place->name_ar, ['id' => 'name_ar', 'class' => 'form-control', 'required'])}}
                        </div>

                        <div class="col-12 col-md-6">
                            <label class="form-label" for="name_en">{{trans('common.name_en')}}</label>
                            {{Form::text('name_en',$place->name_en, ['id' => 'name_en', 'class' => 'form-control', 'required'])}}
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label" for="address_ar">{{ trans('common.address_ar') }}</label>
                            {{ Form::textarea('address_ar', $place->address_ar, ['id' => 'address_ar', 'class' => 'form-control', 'rows' => '3']) }}
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label" for="address_en">{{ trans('common.address_en') }}</label>
                            {{ Form::textarea('address_en', $place->address_en, ['id' => 'address_en', 'class' => 'form-control', 'rows' => '3']) }}
                        </div>

                        <div class="col-12 col-md-6">
                            <label class="form-label" for="whatsapp">{{trans('common.whatsapp')}}</label>
                            {{Form::text('whatsapp',$place->whatsapp, ['id' => 'whatsapp', 'class' => 'form-control', 'required'])}}
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label" for="location_url">{{trans('common.location_url')}}</label>
                            {{Form::text('location_url',$place->location_url, ['id' => 'location_url', 'class' => 'form-control', 'required'])}}
                        </div>

                        <div class="col-12 col-md-6">
                            <label class="form-label" for="image">{{ trans('common.image') }}</label>
                            {{ Form::file('image', ['id' => 'image', 'class' => 'form-control']) }}
                            @if($place->image)
                                <img src="{{ asset('uploads/webservices/' . $place->image) }}" alt="image" class="img-responsive rounded mt-2" width="100px">
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
