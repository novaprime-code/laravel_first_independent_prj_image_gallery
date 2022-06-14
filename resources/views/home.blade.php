@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-11">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between">
                            <div>Images</div>
                            <div>
                                <form class="form-inline">
                                    <select name="" class="form-control" onchange="sortby(this.value)">
                                        <option value="latest" {{-- {{ 
                                            @if (Request::query('sortby ') && Request::query('sortby') == 'latest')
                                                'selected';
                                            @elseif (!Request::query('sortby'))
                                                'selected';
                                            @else
                                                '';
                                            @endif
                                            }} > --}}
                                            {{ Request::query('sortby') && Request::query('sortby') == 'latest' ? 'selected' : '' }}>
                                            Latest</option>
                                        <option value="oldest"
                                            {{ Request::query('sortby') && Request::query('sortby') == 'oldest' ? 'selected' : '' }}>
                                            Oldest</option>
                                    </select>
                                </form>
                            </div>
                        </div>

                    </div>

                    <div class="card-body">
                        {{-- @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif --}}

                        <div class="row">
                            <div class="col-md-3">
                                <p>Filter By Category</p>
                                {{-- backup code startes --}}
                                {{-- <div class="list-group">
                                    <a href="javascript:filter_image('')"
                                        class="list-group-item list-group-item-action {{ !Request::query('category') ? 'active' : '' }}">All</a>
                                    <a href="javascript:filter_image('personal')"
                                        class="list-group-item list-group-item-action {{ Request::query('category') == 'personal' ? 'active' : '' }}">Personal</a>
                                    <a href="javascript:filter_image('Family')"
                                        class="list-group-item list-group-item-action {{ Request::query('category') == 'Family' ? 'active' : '' }}">Family</a>
                                    <a href="javascript:filter_image('Friends')"
                                        class="list-group-item list-group-item-action {{ Request::query('category') == 'Friends' ? 'active' : '' }}">Friends</a>
                                </div> --}}
                                {{-- backup code ends --}}
                                <div class="list-group">
                                    <a href="javascript:filter_image('')"
                                        class="list-group-item list-group-item-action {{ !Request::query('category') ? 'active' : '' }}">All</a>

                                    @foreach (App\Models\Category::all() as $category)
                                        {{-- <option value="{{ $category->category_name }}">
                                            {{ $category->category_name }}</option> --}}
                                        <a href="javascript:filter_image('{{ $category->category_name }}')" 
                                            class="list-group-item list-group-item-action {{ Request::query('category') == $category->category_name?'active' : '' }}">
                                            {{ $category->category_name }}</a>
                                    @endforeach
                                    <a href="javascript:filter_image('personal')"
                                        class="list-group-item list-group-item-action {{ Request::query('category') == 'personal' ? 'active' : '' }}">Personal</a>

                                    <a href="javascript:filter_image('Family')"
                                        class="list-group-item list-group-item-action {{ Request::query('category') == 'Family' ? 'active' : '' }}">Family</a>
                                    <a href="javascript:filter_image('Friends')"
                                        class="list-group-item list-group-item-action {{ Request::query('category') == 'Friends' ? 'active' : '' }}">Friends</a>
                                </div>
                            </div>
                            <div class="col-md-9">
                                @if (session('status'))
                                    {{-- <div class="alert alert-success" role="alert">

                                    </div> --}}
                                    @if (session('status') == 'image deleted')
                                        <div class="alert alert-danger d-flex align-items-center" role="alert">

                                            <div>
                                                {{ session('status') }}
                                            </div>
                                        </div>
                                    @else
                                        <div class="alert alert-success d-flex align-items-center" role="alert">

                                            <div>
                                                {{ session('status') }}
                                            </div>
                                        </div>
                                    @endif
                                @endif
                                <div class="row">
                                    <div class="col-md-12">

                                        @if ($errors->any())
                                            @foreach ($errors->all() as $error)
                                                <div class="alert alert-danger">
                                                    <strong>
                                                        Error!
                                                    </strong>{{ $error }}
                                                </div>
                                            @endforeach
                                        @endif
                                        <button class="btn btn-success mb-2" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapseExample" aria-expanded="false"
                                            aria-controls="collapseExample">
                                            Add Image
                                        </button>
                                        <div id="collapseExample" class="collapse">
                                            <form action="{{ route('image-store') }}" enctype="multipart/form-data"
                                                id="image_upload_form" method="post">
                                                @csrf
                                                <div class="form-group">
                                                    <label for="Image Caption">Image Caption</label>
                                                    <input type="text" name="caption" class="form-control"
                                                        placeholder="Enter Caption" id="imagecaption">
                                                </div>
                                                <div class="form-group">
                                                    <label for="Category">Select Category:</label>
                                                    <select class="form-control" id="category" name="category_name">
                                                        <option value="">Select a Category</option>

                                                        @foreach (App\Models\Category::all() as $category)
                                                            <option value="{{ $category->category_name }}">
                                                                {{ $category->category_name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label">Upload File</label>
                                                    <div class="preview-zone hidden">
                                                        <div class="box box-solid">
                                                            <div class="box-header with-border">
                                                                <div><b>Preview</b></div>
                                                                <div class="box-tools pull-right">
                                                                    <button type="button"
                                                                        class="btn btn-danger btn-xs remove-preview">
                                                                        <i class="fa fa-times"></i> Reset This Form
                                                                    </button>
                                                                </div>
                                                            </div>
                                                            <div class="box-body"></div>
                                                        </div>
                                                    </div>
                                                    <div class="dropzone-wrapper">
                                                        <div class="dropzone-desc">
                                                            <i class="glyphicon glyphicon-download-alt"></i>
                                                            <p>Choose an image file or drag it here.</p>
                                                        </div>
                                                        <input type="file" name="image" class="dropzone">
                                                    </div>
                                                    <div id="image_error">

                                                    </div>
                                                </div>

                                                <div class="row mt-2">
                                                    <div class="col-md-12 ">
                                                        <button type="submit"
                                                            class="btn btn-primary pull-right">Upload</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="col-md-12 mt-2">
                                        <div class="row">
                                            @if (count($images))
                                                @foreach ($images as $image)
                                                    <div class="col-md-3 mb-4 mt-5">
                                                        <a href="{{ asset('userImages/' . $image->image) }}"
                                                            class="fancybox" data-caption="{{ $image->caption }}"
                                                            data-id="{{ $image->id }}"
                                                            data-fancybox="{{ $image->category }}">
                                                            <img src="{{ asset('userImages/thumb/' . $image->image) }} "
                                                                height="100%" width="100%" alt="">
                                                        </a>
                                                        <div class="justify-content-center  d-flex align-items-center mt-2">

                                                            @if (auth()->user()->id == $image->user_id)
                                                                <form action="/image_delete/{{ $image->id }}"
                                                                    method="post" class="inline-form delete  ">
                                                                    @csrf

                                                                    <input type="submit" value="Delete"
                                                                        class="btn btn-danger ">
                                                                </form>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <script>
                                                        $(".delete").on("submit", function(e) {
                                                            return confirm("Are you sure you want to delete this Image?");
                                                        })
                                                    </script>
                                                @endforeach
                                                <div class="col-md-12 mt-5">
                                                    {{ $images->appends(Request::query())->links('pagination::bootstrap-5') }}
                                                </div>
                                            @else
                                                <div class="col-md-12">
                                                    <p>
                                                        No Images Found
                                                    </p>
                                                </div>
                                            @endif


                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script type="text/javascript">
        var query = {};
        @if (Request::query('category'))
            Object.assign(query,{'category': "{{ Request::query('category') }}"});
        @endif
        @if (Request::query('sortby'))
            Object.assign(query,{'sortby': "{{ Request::query('sortby') }}"});
        @endif

        function sortby(value) {
            Object.assign(query, {
                'sortby': value
            });
            window.location.href = "{{ route('home') }}" + '?' + $.param(query);
        }

        function filter_image(value) {
            Object.assign(query, {
                'category': value
            });
            window.location.href = "{{ route('home') }}" + '?' + $.param(query);
        }



        // $.Fancybox.defaults.btnTpl.delete = "<button class='fancybox-button fancybox-delete-button'>Delete</button>";

        // // $.fancybox.default.btnTpl.delete =
        // //     '<button data-fancybox-fb class="fancybox-button fancybox-button--fb" title="Facebook"></button>';

        // $.Fancybox.defaults.buttons = ['delete', 'close', 'share', 'download'];


        function readFile(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    var validImageType = ['image/png', 'image/jpeg', 'image/jpg', 'image/gif', 'image/bmp'];
                    if (!validImageType.includes(input.files[0]['type'])) {
                        var htmlPreview =
                            '<p>Image Preview Not Available</p>' +
                            '<p>' + input.files[0].name + '</p>';

                    } else {
                        var htmlPreview =
                            '<img width="70%" height="300px" src="' + e.target.result + '" />' +
                            '<p>' + input.files[0].name + '</p>';

                    }

                    var wrapperZone = $(input).parent();
                    var previewZone = $(input).parent().parent().find('.preview-zone');
                    var boxZone = $(input).parent().parent().find('.preview-zone').find('.box').find('.box-body');

                    wrapperZone.removeClass('dragover');
                    previewZone.removeClass('hidden');
                    boxZone.empty();
                    boxZone.append(htmlPreview);
                };

                reader.readAsDataURL(input.files[0]);
            }
        }

        function reset(e) {
            e.wrap('<form>').closest('form').get(0).reset();
            e.unwrap();
        }

        $(".dropzone").change(function() {
            readFile(this);
        });

        $('.dropzone-wrapper').on('dragover', function(e) {
            e.preventDefault();
            e.stopPropagation();
            $(this).addClass('dragover');
        });

        $('.dropzone-wrapper').on('dragleave', function(e) {
            e.preventDefault();
            e.stopPropagation();
            $(this).removeClass('dragover');
        });

        $('.remove-preview').on('click', function() {
            var boxZone = $(this).parents('.preview-zone').find('.box-body');
            var previewZone = $(this).parents('.preview-zone');
            var dropzone = $(this).parents('.form-group').find('.dropzone');
            boxZone.empty();
            previewZone.addClass('hidden');
            reset(dropzone);
        });

        $("#image_upload_form").validate({
            rules: {
                caption: {
                    required: true,
                    maxlength: 255,
                },
                category: {
                    required: true,
                },
                image: {
                    required: true,
                    extension: "png|jpeg|jpg|bmp|gif",
                },
            },
            messages: {
                caption: {
                    required: "Please enter an image caption",
                    maxlength: "Max. 255 characters allowed",
                },
                category: {
                    required: "Please select a category",
                },

                image: {
                    required: "Please upload an image",
                    extension: "Only png, jpeg,jpg, bmp, gif image allowed",
                },
            },
            errorPlacement: function(error, element) {
                if (element.attr('name') == "image") {
                    error.insertAfter('#image_error');
                } else {
                    error.insertAfter(element);
                }
            }
        });
    </script>
@endsection
