@if($blog)
    <div class="modal fade text-md-start" id="editarea{{$blog->id}}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-user">
            <div class="modal-content">
                <div class="modal-header bg-transparent">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body pb-5 px-sm-5 pt-50">
                    <div class="text-center mb-2">
                        <h1 class="mb-1">{{trans('common.edit')}}</h1>
                    </div>
                    {{Form::open(['url' => route('admin.blogs.update', ['id' => $blog->id]), 'id' => 'editareaForm', 'class' => 'row gy-1 pt-75', 'files' => true])}}
                    <div class="col-12 col-md-6">
                        <label class="form-label" for="title_ar">{{trans('common.title ar')}}</label>
                        {{Form::text('title_ar',$blog->title_ar, ['id' => 'title_ar', 'class' => 'form-control', 'required'])}}
                    </div>

                    <div class="col-12 col-md-6">
                        <label class="form-label" for="title_en">{{trans('common.title en')}}</label>
                        {{Form::text('title_en',$blog->title_en, ['id' => 'title_en', 'class' => 'form-control', 'required'])}}
                    </div>

                    <div class="col-12 col-md-6">
                        <label class="form-label" for="description_ar">{{ trans('common.description ar') }}</label>
                        {{ Form::textarea('description_ar', $blog->description_ar, ['id' => 'description_ar', 'class' => 'form-control', 'rows' => '3']) }}
                    </div>

                    <div class="col-12 col-md-6">
                        <label class="form-label" for="description_en">{{ trans('common.description en') }}</label>
                        {{ Form::textarea('description_en', $blog->description_en, ['id' => 'description_en', 'class' => 'form-control', 'rows' => '3']) }}
                    </div>

                    <div class="col-12 col-md-6">
                        <label class="form-label" for="image">{{ trans('common.image') }}</label>
                        {{ Form::file('image', ['id' => 'image', 'class' => 'form-control']) }}
                        @if($blog->image != '')
                                    <img src="{{ asset('uploads/blogs/' . $blog->image) }}" alt="image" class="img-responsive rounded mt-2" width="50px">
                                    @endif
                    </div>

                    <div class="col-12 text-center mt-2 pt-50">
                        <button  type="submit" class="btn btn-primary me-1">{{trans('common.Save changes')}}</button>
                        <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal" aria-label="Close">{{trans('common.Cancel')}}</button>
                    </div>
                    {{Form::close()}}
                </div>
            </div>
        </div>
    </div>
@else
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
                    {{Form::open(['url' => route('admin.blogs.store'), 'id' => 'createInvoicesForm', 'class' => 'row gy-1 pt-75', 'files' => true])}}

                    <div class="col-12 col-md-6">
                        <label class="form-label" for="title_ar">{{trans('common.title ar')}}</label>
                        {{Form::text('title_ar','', ['id' => 'title_ar', 'class' => 'form-control', 'required'])}}
                    </div>

                    <div class="col-12 col-md-6">
                        <label class="form-label" for="title_en">{{trans('common.title en')}}</label>
                        {{Form::text('title_en','', ['id' => 'title_en', 'class' => 'form-control', 'required'])}}
                    </div>

                    <div class="col-12 col-md-6">
                        <label class="form-label" for="type">{{trans('common.description ar')}}</label>
                        {{Form::textarea('description_ar', '', ['id' => 'description_ar', 'class'=>'form-control editor_ar', 'required'])}}
                    </div>

                    <div class="col-12 col-md-6">
                        <label class="form-label" for="type">{{trans('common.description en')}}</label>
                        {{Form::textarea('description en', '', ['id' => 'description en', 'class'=>'form-control editor_ar', 'required'])}}
                    </div>

                    <div class="col-12 col-md-6">
                        <label class="form-label" for="image">{{ trans('common.photo') }}</label>
                        {{ Form::file('image', ['id' => 'image', 'class' => 'form-control' , 'multiple' => true]) }}
                    </div>
                    <div class="col-12 text-center mt-2 pt-50">
                        <button onclick="this.disabled=true;  document.getElementById('createInvoicesForm').submit()" type="submit" class="btn btn-primary me-1">{{trans('common.Save changes')}}</button>
                        <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal" aria-label="Close">
                            {{trans('common.Cancel')}}
                        </button>
                    </div>
                    {{Form::close()}}
                </div>
            </div>
        </div>
    </div>
@endif
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    function openModal(imageUrl, imageId) {
        $('#modalImage').attr('src', imageUrl);
        $('#deleteImageButton').data('id', imageId);
        $('#imageModal').show();
    }

    function closeModal() {
        $('#imageModal').hide();
    }

    function deleteImage() {
        var imageId = $('#deleteImageButton').data('id');

        $.ajax({
            url: '/delete-image/' + imageId,
            type: 'DELETE',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.success) {
                    $('#modalImage').attr('src', ''); // Clear the image
                    alert('Image deleted successfully');
                    closeModal(); // Close the modal
                } else {
                    alert('Failed to delete image');
                }
            },
            error: function(xhr) {
                alert('An error occurred: ' + xhr.responseText);
            }
        });
    }
</script>
