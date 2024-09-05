@extends('AdminPanel.layouts.master')

@section('content')

    <!-- Bordered table start -->

    <div class="row d-flex" id="table-bordered">

        <div class="col-12 ">

            <div class="card">

                <div class="card-header">

                    <div class="row">
                        <div class="col-md-8">
                            <h4 class="card-title">{{ $title }}</h4>

                        </div>

                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered mb-2">
                        <thead>
                            <tr>
                                <th class="text-center">{{ trans('common.title_ar') }}</th>
                                <th class="text-center">{{ trans('common.title_en') }}</th>
                                <th class="text-center">{{ trans('common.description_ar') }}</th>
                                <th class="text-center">{{ trans('common.description_en') }}</th>
                                <th class="text-center">{{ trans('common.images') }}</th>
                                <th class="text-center">{{ trans('common.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($blogs as $blog)
                                <tr id="row_{{ $blog->id }}">
                                    <td>{{ $blog->title_ar }}</td>
                                    <td>{{ $blog->title_en }}</td>
                                    <td>{{ $blog->description_ar }}</td>
                                    <td>{{ $blog->description_en }}</td>
                                    <td>
                                        @foreach ($blog->images as $blogImage)
                                            <img src="{{ asset('uploads/blogs/' . $blogImage->image) }}"
                                                class="img-responsive rounded mt-2" width="50px">
                                        @endforeach
                                    </td>
                                    <td class="text-center">
                                        @if (userCan('edit_blogs'))
                                            <a href="javascript:;" data-bs-target="#editservice{{ $blog->id }}"
                                                data-bs-toggle="modal" class="btn btn-icon btn-info">
                                                <i data-feather='edit'></i>
                                            </a>
                                        @endif
                                        @if (userCan('delete_blogs'))
                                            <?php $delete = route('admin.blogs.delete', ['id' => $blog->id]); ?>
                                            <button type="button" class="btn btn-icon btn-danger"
                                                onclick="confirmDelete('{{ $delete }}', '{{ $blog->id }}')">
                                                <i data-feather='trash-2'></i>
                                            </button>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="p-3 text-center">
                                        <h2>{{ trans('common.nothingToView') }}</h2>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{ $blogs->links('vendor.pagination.default') }}
            </div>
        </div>
    </div>
    <!-- Bordered table end -->

    <!-- Create Blog Modal -->
    <div class="modal fade" id="createservice" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-md modal-dialog-centered modal-edit-user">
            <div class="modal-content">
                <div class="modal-header bg-transparent">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body pb-5 px-sm-5 pt-50">
                    <div class="text-center mb-2">
                        <h1 class="mb-1">{{ trans('common.CreateNew') }}</h1>
                    </div>
                    {{ Form::open(['url' => route('admin.blogs.store'), 'id' => 'createserviceForm', 'class' => 'row gy-1 pt-75 justify-content-center', 'method' => 'post', 'files' => true]) }}
                    <div class="col-12 col-md-6">
                        <label class="form-label" for="title_ar">{{ trans('common.title_ar') }}</label>
                        {{ Form::text('title_ar', '', ['id' => 'title_ar', 'class' => 'form-control', 'required']) }}
                    </div>
                    <div class="col-12 col-md-6">
                        <label class="form-label" for="title_en">{{ trans('common.title_en') }}</label>
                        {{ Form::text('title_en', '', ['id' => 'title_en', 'class' => 'form-control', 'required']) }}
                    </div>
                    <div class="col-12 col-md-6">
                        <label class="form-label" for="description_ar">{{ trans('common.description_ar') }}</label>
                        {{ Form::textarea('description_ar', '', ['id' => 'description_ar', 'class' => 'form-control', 'required']) }}
                    </div>
                    <div class="col-12 col-md-6">
                        <label class="form-label" for="description_en">{{ trans('common.description_en') }}</label>
                        {{ Form::textarea('description_en', '', ['id' => 'description_en', 'class' => 'form-control', 'required']) }}
                    </div>
                    <div class="repeatableAddProduct row" id="repeatableAddProduct">
                        <div class="col-12 col-md-6">
                            <label class="form-label" for="images">Upload Images:</label>
                            {{ Form::file('images[]', ['class' => 'form-control', 'multiple' => 'multiple']) }}
                        </div>
                    </div>
                    <button type="button" id="add-input" class="btn btn-primary me-1">Add More Images</button>
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

    <!-- Edit Blog Modal -->
    @foreach ($blogs as $blog)
        <div class="modal fade text-md-start" id="editservice{{ $blog->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-md modal-dialog-centered modal-edit-user">
                <div class="modal-content">
                    <div class="modal-header bg-transparent">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body pb-5 px-sm-5 pt-50">
                        <div class="text-center mb-2">
                            <h1 class="mb-1">{{ trans('common.edit') }}: {{ $blog->title_ar }}</h1>
                        </div>
                        {{ Form::open(['url' => route('admin.blogs.update', $blog->id), 'method' => 'post', 'class' => 'row gy-1 pt-75 justify-content-center', 'files' => true]) }}
                        <div class="col-12 col-md-6">
                            <label class="form-label" for="title_ar">{{ trans('common.title_ar') }}</label>
                            {{ Form::text('title_ar', $blog->title_ar, ['id' => 'title_ar', 'class' => 'form-control', 'required']) }}
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label" for="title_en">{{ trans('common.title_en') }}</label>
                            {{ Form::text('title_en', $blog->title_en, ['id' => 'title_en', 'class' => 'form-control']) }}
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label" for="description_ar">{{ trans('common.description_ar') }}</label>
                            {{ Form::textarea('description_ar', $blog->description_ar, ['id' => 'description_ar', 'class' => 'form-control']) }}
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label" for="description_en">{{ trans('common.description_en') }}</label>
                            {{ Form::text('description_en', $blog->description_en, ['id' => 'description_en', 'class' => 'form-control']) }}
                        </div>
                        <div class="col-12">
                            <label class="form-label">{{ trans('common.current_images') }}</label>
                        </div>
                        <div class="row">
                            @foreach ($blog->images as $blogImage)
                                <div class="col-12 col-md-6 image-item">
                                    <label>
                                        <img src="{{ asset('uploads/blogs/' . $blogImage->image) }}"
                                            class="img-responsive rounded mt-2" width="100px">
                                        <br>
                                        {{ Form::checkbox('remove_images[]', $blogImage->id) }} Remove
                                    </label>
                                </div>
                            @endforeach
                        </div>
                        <div class="repeatableAddProduct row" id="repeatableAddProduct{{ $blog->id }}">
                            <div class="col-12 col-md-6">
                                <label class="form-label" for="images">Upload Images:</label>
                                {{ Form::file('images[]', ['class' => 'form-control', 'multiple' => 'multiple']) }}
                            </div>
                        </div>
                        <button type="button" class="btn btn-primary me-1 add_new_product"
                            data-id="{{ $blog->id }}">Add More Images</button>
                        <div class="col-12 text-center mt-2 pt-50">
                            <button type="submit"
                                class="btn btn-primary me-1">{{ trans('common.Save changes') }}</button>
                            <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal"
                                aria-label="Close">
                                {{ trans('common.Cancel') }}
                            </button>
                        </div>
                        {{ Form::close() }}
                    </div>
                </div>
            </div>
        </div>
    @endforeach

@stop
@section('page_buttons')
    <div>
        @if (userCan('create_offers'))
            <a href="javascript:;" data-bs-target="#createservice" data-bs-toggle="modal" class="btn btn-primary">
                {{ trans('common.CreateNew') }}
            </a>
        @endif
    </div>
@stop
@section('scripts')
    <script type="text/template" id="RepeatAddProductTPL">
        <div class="row more-images">
            <div class="col-12 col-md-6">
                <label class="form-label" for="images">Upload Images:</label>
                <input type="file" class="form-control" name="images[]" />
            </div>
            <div class="col-12 col-md-6">
                <div class="mb-1 mt-1">
                    <span class="delete btn btn-danger btn-sm" style="margin-top:25px;">Delete</span>
                </div>
            </div>
        </div>
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            var max_fields = 5;

            // Handle adding more images for the create form
            $(document).on("click", "#add-input", function(e) {
                e.preventDefault();
                var RepeatOpponentTPL = $("#RepeatAddProductTPL").html();
                var wrapper = $("#repeatableAddProduct");

                if (wrapper.find('.more-images').length < max_fields) {
                    wrapper.append(RepeatOpponentTPL);
                } else {
                    alert('You reached the limit');
                }
            });

            // Handle adding more images for the edit form
            $(document).on("click", ".add_new_product", function(e) {
                e.preventDefault();
                var blogId = $(this).data('id');
                var currentWrapper = $("#repeatableAddProduct" + blogId);
                var RepeatOpponentTPL = $("#RepeatAddProductTPL").html();

                if (currentWrapper.find('.more-images').length < max_fields) {
                    currentWrapper.append(RepeatOpponentTPL);
                } else {
                    alert('You reached the limit');
                }
            });

            // Handle removing images
            $(document).on("click", ".delete", function(e) {
                e.preventDefault();
                $(this).closest('.more-images').remove();
            });
        });
    </script>
@stop
