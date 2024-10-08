@extends('backend.master')
@push('styles')
    <style>
        .select2-container--default .select2-selection--single {
            background-color: #fff;
            width: 100%;
            height: 46px;
            line-height: 46px;
            font-size: 13px;
            padding: 3px 20px;
            padding-left: 20px;
            font-weight: 300;
            border-radius: 30px;
            color: var(--base_color);
            border: 1px solid #ECEEF4
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 46px;
            position: absolute;
            top: 1px;
            right: 20px;
            width: 20px;
            color: var(--text-color);
        }

        .select2-dropdown {
            background-color: white;
            border: 1px solid var(--backend-border-color);
            border-radius: 4px;
            box-sizing: border-box;
            display: block;
            position: absolute;
            left: -100000px;
            width: 100%;
            width: 100%;
            background: var(--bg_white);
            overflow: auto !important;
            border-radius: 0px 0px 10px 10px;
            margin-top: 1px;
            z-index: 9999 !important;
            border: 0;
            box-shadow: 0px 10px 20px rgb(108 39 255 / 30%);
            z-index: 1051;
            min-width: 200px;
        }

        .select2-search--dropdown .select2-search__field {
            padding: 4px;
            width: 100%;
            box-sizing: border-box;
            box-sizing: border-box;
            background-color: #fff;
            border: 1px solid rgba(130, 139, 178, 0.3) !important;
            border-radius: 3px;
            box-shadow: none;
            color: #333;
            display: inline-block;
            vertical-align: middle;
            padding: 0px 8px;
            width: 100% !important;
            height: 46px;
            line-height: 46px;
            outline: 0 !important;
        }

        .select2-container {
            width: 100% !important;
            min-width: 90px;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            color: #444;
            line-height: 40px;
        }


        .makeResize.responsiveResize:last-child.col-xl-6 {
            margin-top: 30px;
        }

        #durationBox {
            /*margin-top: 30px;*/
        }

        @media (max-width: 1199px) {
            .responsiveResize2 {
                margin-top: 30px;
            }
        }
    </style>
@endpush
@section('mainContent')
    @php
        $required_type = false;
        if (isModuleActive('Org')) {
            $required_type = true;
        }

            if (@$course->discount_price != null) {
                 $course_price = $course->discount_price;
             } else {
                 $course_price = $course->price;
             }
    @endphp
    @php
        $LanguageList = getLanguageList();
    @endphp

    {!! generateBreadcrumb() !!}
    <section class="admin-visitor-area student-details">
        <div class="container-fluid p-0">
            <div class="row">
                @if ($course->type == 1)
                    <div class="col-lg-12">

                    </div>
                @endif
                <div class="@if ($course->type == 1) col-md-12 @else col-md-12 @endif ">
                    <div class="main-title">
                        <h3 class="">

                            {{ __('courses.Course') }} | <a target="_blank"
                                                            href="{{courseDetailsUrl(@$course->id, @$course->type, @$course->slug)}}">{{ $course->title }}</a>
                        </h3>
                    </div>

                    @if (Session::has('type'))
                        @php
                            $type = Session::get('type');
                        @endphp
                    @elseif (request()->get('type'))
                        @php
                            $type = request()->get('type');
                        @endphp
                    @else
                        @php
                            if ($course->type == 1) {
                                $type = 'courses';
                            } else {
                                $type = 'courseDetails';
                            }
                        @endphp
                    @endif
                    <div class="row pt-0">
                        <ul class="nav nav-tabs no-bottom-border  mt-sm-md-20 mb-10 ms-3" role="tablist">
                            @if ($course->type == 1)
                                <li class="nav-item">
                                    <a class="nav-link @if ($type == 'courses') active @endif"
                                       href="#group_email_sms" role="tab"
                                       data-bs-toggle="tab">{{ __('courses.Course') }}
                                        {{ __('courses.Curriculum') }} </a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link  @if ($type == 'courseDetails') active @endif "
                                       href="#indivitual_email_sms" role="tab"
                                       data-bs-toggle="tab">{{ __('courses.Course') }} {{ __('common.Details') }}</a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link  @if ($type == 'files') active @endif" href="#file_list"
                                       role="tab" data-bs-toggle="tab">{{ __('courses.Exercise') }}
                                        {{ __('common.Files') }}</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link  @if ($type == 'certificate') active @endif" href="#certificate"
                                       role="tab" data-bs-toggle="tab">{{ __('certificate.Certificate') }}</a>
                                </li>
                                @if ($course->drip == 1)
                                    <li class="nav-item">
                                        <a class="nav-link @if ($type == 'drip') active @endif" href="#drip"
                                           role="tab" data-bs-toggle="tab"> {{ __('common.Drip Content') }}</a>
                                    </li>
                                @endif

                                @if (isModuleActive('EarlyBird') && $course_price>0)
                                    <li class="nav-item">
                                        <a class="nav-link @if ($type == 'earlyBirdPrice') active @endif"
                                           href="#earlyBirdPrice"
                                           role="tab" data-bs-toggle="tab"> {{ __('price_plan.Price Plan') }}</a>
                                    </li>
                                @endif
                            @endif

                        </ul>
                    </div>
                    <div class="">
                        <div class="row  mt_0_sm">

                            <!-- Start Sms Details -->
                            <div class="col-lg-12">


                                <!-- Tab panes -->
                                <div class="tab-content">
                                    <input type="hidden" name="selectTab" id="selectTab">

                                    @includeIf('coursesetting::parts_of_course_details._course_details_carriclum_tab')
                                    @includeIf('coursesetting::parts_of_course_details._course_details_tab')
                                    @includeIf('coursesetting::parts_of_course_details._course_details_exercise_file_tab')
                                    @includeIf('coursesetting::parts_of_course_details._course_details_certificate_tab')
                                    @includeIf('coursesetting::parts_of_course_details._course_details_drip_tab')
                                    @includeIf('coursesetting::parts_of_course_details._course_details_early_bird_tab')


                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>




    @if(isModuleActive('Org'))
        <div class="modal fade admin-query" id="orgExistingFileSelect">
            <div class="modal-dialog  modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">{{__('org.Select Material')}}</h4>
                        <button type="button" class="close " data-bs-dismiss="modal">
                            <i class="ti-close "></i>
                        </button>
                    </div>

                    <div class="modal-body">
                        <form action="#" method="POST" enctype="multipart/form-data" id="materialSourceInsertForm">
                            <input type="hidden" id="addCategory" name="category">
                            @csrf
                            <div class="row">
                                <div class="col-xl-12">
                                    <div class="input-effect mt-2 pt-1">
                                        <select class="primary_select AddSelectCateogry"
                                                name="category">
                                            <option
                                                data-display="{{__('common.Select')}} {{__('org.Category')}}"
                                                value="">{{__('common.Select')}} {{__('org.Category')}} </option>
                                            @foreach($categories as $category)
                                                @if($category->parent_id==0)
                                                    @include('backend.categories._single_select_option',['category'=>$category,'level'=>1])
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>


                                    <div class="input-effect mt-2 pt-1">
                                        <select class="primary_select "
                                                name="file"
                                                id="AddSelectFile">
                                            <option
                                                data-display="{{__('common.Select')}} {{__('org.File')}}"
                                                value="">{{__('common.Select')}} {{__('org.File')}} </option>

                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-12 text-center pt_15">


                                <div class="mt-40 d-flex justify-content-between">
                                    <button type="button" class="primary-btn tr-bg"
                                            data-bs-dismiss="modal">{{__('common.Cancel')}}</button>
                                    <button class="primary-btn semi_large2  fix-gr-bg" id="MaterialFileInsert"
                                            type="button"><i
                                            class="ti-check"></i> {{__('common.Add')}}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade admin-query" id="orgNewFileSelect">
            <div class="modal-dialog modal_700px modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">{{__('org.Add New Material')}}</h4>
                        <button type="button" class="close " data-bs-dismiss="modal">
                            <i class="ti-close "></i>
                        </button>
                    </div>

                    <div class="modal-body">
                        <form action="#" method="POST" enctype="multipart/form-data" id="materialSourceAddForm">

                            @csrf
                            <div class="row">
                                <div class="col-xl-12">
                                    <div class="mb-25">
                                        <div class="col-md-12">
                                            <div class="primary_file_uploader">
                                                <input type="file" class="filepond"
                                                       name="file"
                                                       id="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="primary_input mb-25">
                                        <label class="primary_input_label" for="">{{__('org.Category')}} <strong
                                                class="text-danger">*</strong></label>


                                        <select class="primary_select AddSelectCateogry AddNewSelectCateogry"
                                                name="category">
                                            <option
                                                data-display="{{__('common.Select')}} {{__('org.Category')}}"
                                                value="">{{__('common.Select')}} {{__('org.Category')}} </option>
                                            @foreach($categories as $category)
                                                @if($category->parent_id==0)
                                                    @include('backend.categories._single_select_option',['category'=>$category,'level'=>1])
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>

                                </div>
                            </div>

                            <div class="col-lg-12 text-center pt_15">


                                <div class="mt-40 d-flex justify-content-between">
                                    <button type="button" class="primary-btn tr-bg"
                                            data-bs-dismiss="modal">{{__('common.Cancel')}}</button>
                                    <button class="primary-btn semi_large2  fix-gr-bg" id="MaterialFileSave"
                                            type="button"><i
                                            class="ti-check"></i> {{__('common.Add')}}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        @push('scripts')

            <script>


                $(document).on('change click', '.fileType', function (e) {

                    var type = $(this).val();
                    if (type == 1) {
                        $('.AddSelectCateogry').trigger('change');
                        $('#orgExistingFileSelect').modal('show');
                        $('.selectOrgFile').show();
                        $('.defaultHost').addClass('d-none');
                    } else if (type == 2) {
                        $('.selectOrgFile').hide();
                        $('.defaultHost').removeClass('d-none');
                        $('.host_select').trigger('change');
                    } else {
                        $('.selectOrgFile').show();
                        $('#orgNewFileSelect').modal('show');
                        $('.defaultHost').addClass('d-none');
                    }
                });

                $(document).on('change click', '#MaterialFileInsert', function (e) {
                    // e.preventDefault();
                    var category = $('.AddSelectCateogry  option:selected').val();
                    var file = $('#AddSelectFile option:selected').val();
                    if (category == "") {
                        toastr.error('Please select category', 'Error');
                        return false;

                    }

                    if (file == "") {
                        toastr.error('Please select file', 'Error');
                        return false;

                    }
                    var formData = {
                        id: file,
                    };
                    $.ajax({
                        type: "GET",
                        url: "{{route('org.ajaxMaterialSourceGet')}}",
                        data: formData,
                        success: function (data) {
                            console.log(data);
                            $('.FilePath').val(data.link);
                            $('.FileType').val(data.type);
                            $('.scorm_title').val(data.scorm_title);
                            $('.scorm_version').val(data.scorm_version);
                            $('.scorm_identifier').val(data.scorm_identifier);

                            $('#orgExistingFileSelect').modal('hide');
                        }
                    });
                });

                $(document).on('change click', '#MaterialFileSave', function (e) {
                    // e.preventDefault();
                    var category = $('.AddNewSelectCateogry  option:selected').val();

                    if (category == "") {
                        toastr.error('Please select category', 'Error');
                        return false;
                    }


                    $.ajax({
                        type: "POST",
                        url: "{{route('org.ajaxMaterialSourceSave')}}",
                        data: $('#materialSourceAddForm').serialize(),
                        success: function (data) {
                            if (data != "" && data.link != 'undefined' && data.link != '') {
                                $('.FilePath').val(data.link);
                                $('.FileType').val(data.type);
                                $('.scorm_title').val(data.scorm_title);
                                $('.scorm_version').val(data.scorm_version);
                                $('.scorm_identifier').val(data.scorm_identifier);
                                $('#orgNewFileSelect').modal('hide');
                            } else {
                                toastr.error("{{trans('org.File Upload Failed')}}", '{{trans('common.Error')}}');
                                return false;
                            }
                        }
                    });
                });

                $(document).on('change', '.AddSelectCateogry', function (e) {
                    var category = $(".AddSelectCateogry option:selected").val();


                    var url = "{{ route('org.getFilesByCategory') }}";

                    var formData = {
                        category: category,
                    };
                    // get section for student
                    $.ajax({
                        type: "GET",
                        data: formData,
                        dataType: "json",
                        url: url,
                        success: function (data) {
                            $('#AddSelectFile').empty();
                            $('#AddSelectFile').append($('<option>', {
                                value: '',
                                text: 'Select File',
                            }));
                            $.each(data, function (i, item) {
                                $('#AddSelectFile').append($('<option>', {
                                    value: item.id,
                                    text: item.title,
                                }));
                            });
                            $('#AddSelectFile').niceSelect('update');


                        },
                        error: function (data) {
                            console.log("Error:", data);
                            $('#AddSelectFile').niceSelect('update');
                        },
                    });

                });
            </script>
        @endpush
    @endif

    <input type="hidden" id="branchSelectType">
    <input type="hidden" id="branchName">
@endsection



@push('scripts')
    <script src="{{ asset('/') }}/Modules/CourseSetting/Resources/assets/js/course.js"></script>
    <script src="{{ asset('/') }}/Modules/CourseSetting/Resources/assets/js/advance_search.js"></script>



    <script>
        $('.nastable').sortable({
            cursor: "move",
            connectWith: [".nastable"],

            update: function (event, ui) {
                let ids = $(this).sortable('toArray', {
                    attribute: 'data-id'
                });

                if (ids.length > 0) {
                    let data = {
                        '_token': '{{ csrf_token() }}',
                        'ids': ids,
                    }
                    $.get("{{ route('changeChapterPosition') }}", data, function (data) {

                    });
                }
            }
        });

        $('.nastable2').sortable({
            cursor: "move",
            connectWith: ".nastable2",
            update: function (event, ui) {
                let ids = $(this).sortable('toArray', {
                    attribute: 'data-id'
                });
                console.log(ids);
                if (ids.length > 0) {
                    let data = {
                        '_token': '{{ csrf_token() }}',
                        'ids': ids,
                    }
                    $.post("{{ route('changeLessonPosition') }}", data, function (data) {

                    });
                }
                ordering();
            },
            receive: function (event, ui) {
                var chapter_id = event.target.attributes[1].value;
                var lesson = ui.item[0].attributes[1].value;


                let data = {
                    'chapter_id': chapter_id,
                    'lesson_id': lesson,
                    '_token': '{{ csrf_token() }}'
                }
                $.post("{{ route('changeLessonChapter') }}", data, function (data) {

                });
            }
        });

        function ordering() {
            var chepters = $('.nastable2');
            chepters.each(function () {
                var childs = $(this).find(".serial");
                childs.each(function (k, v) {
                    $(this).html(k + 1);
                });
            });
        }
    </script>



    <script>
        @if ($course->type == 2)
        $(".courseBox").hide();
        $(".quizBox").show();
        // $(".makeResize").addClass("col-xl-6");
        // $(".makeResize").removeClass("col-xl-4");
        @endif

        $(".type1").on("click", function () {
            if ($('.type1').is(':checked')) {
                $(".courseBox").show();
                $(".quizBox").hide();
                $(".dripCheck").show();
                $("#quiz_id").val('');
                $(".makeResize").addClass("col-xl-4");
                $(".makeResize").removeClass("col-xl-6");
            }
        });

        $(".type2").on("click", function () {
            if ($('.type2').is(':checked')) {
                $(".courseBox").hide();
                $(".quizBox").show();
                $(".dripCheck").hide();

                $(".makeResize").addClass("col-xl-6");
                $(".makeResize").removeClass("col-xl-4");
            }
        });
        //
        // durationBox


        $(document).ready(function () {

            $('#select_input_type').change(function () {
                console.log('selected');
                if ($(this).val() === '1') {

                    $(".chapter_div").css("display", "block");
                    $(".lesson_div").css("display", "none");
                    $(".quiz_div").css("display", "none");

                } else if ($(this).val() === '2') {

                    $(".chapter_div").css("display", "none");
                    $(".lesson_div").css("display", "none");
                    $(".quiz_div").css("display", "block");

                } else {
                    $(".chapter_div").css("display", "none");
                    $(".lesson_div").css("display", "block");
                    $(".quiz_div").css("display", "none");
                }
            });


            $('#category_id').change(function () {
                let category_id = $('#category_id').find(":selected").val();
                console.log("Host : " + category_id);
                if (category_id === 'Youtube' || category_id === 'URL') {
                    $("#iframeBox").hide();
                    $("#videoUrl").show();
                    $("#vimeoUrl").hide();
                    $("#vimeoVideo").val('');
                    $("#bunnyStreamUrl").hide();
                    $("#youtubeVideo").val('');
                    $("#fileupload").hide();
                    $("#VdoCipherUrl").hide();

                } else if ((category_id === 'Self') || (category_id === 'Zip') || (category_id ===
                    'GoogleDrive') || (category_id === 'PowerPoint') || (category_id === 'Excel') || (
                    category_id === 'Text') || (category_id === 'Word') || (category_id === 'PDF') || (
                    category_id === 'Image') || (category_id === 'AmazonS3') || (category_id ===
                    'SCORM') || (category_id === 'SCORM-AwsS3') || (category_id === 'XAPI') || (
                    category_id === 'XAPI-AwsS3') || (category_id === 'H5P')) {
                    let fileupload = $("#fileupload");

                    if (category_id === 'Self') {

                        // fileupload.find('input').attr('accept', "video/mp4,video/webm");
                    }

                    $("#iframeBox").hide();
                    fileupload.show();
                    $("#videoUrl").hide();
                    $("#vimeoUrl").hide();
                    $("#vimeoVideo").val('');
                    $("#youtubeVideo").val('');
                    $("#VdoCipherUrl").hide();
                    $("#bunnyStreamUrl").hide();
                    $("#media_upload").hide();


                } else if (category_id === 'Vimeo') {
                    $("#iframeBox").hide();
                    $("#videoUrl").hide();
                    $("#vimeoUrl").show();
                    $("#vimeoVideo").val('');
                    $("#youtubeVideo").val('');
                    $("#fileupload").hide();
                    $("#VdoCipherUrl").hide();
                    $("#bunnyStreamUrl").hide();
                    $("#media_upload").hide();

                } else if (category_id === 'VdoCipher') {
                    $("#iframeBox").hide();
                    $("#videoUrl").hide();
                    $("#vimeoUrl").hide();
                    $("#vimeoVideo").val('');
                    $("#youtubeVideo").val('');
                    $("#fileupload").hide();
                    $("#VdoCipherUrl").show();
                    $("#bunnyStreamUrl").hide();
                    $("#media_upload").hide();

                } else if (category_id === 'Iframe') {

                    $("#iframeBox").show();
                    $("#videoUrl").hide();
                    $("#vimeoUrl").hide();
                    $("#vimeoVideo").val('');
                    $("#youtubeVideo").val('');
                    $("#fileupload").hide();
                    $("#VdoCipherUrl").hide();
                    $("#bunnyStreamUrl").hide();
                    $("#media_upload").hide();


                } else if (category_id === 'BunnyStorage') {

                    $("#iframeBox").hide();
                    $("#videoUrl").hide();
                    $("#vimeoUrl").hide();
                    $("#vimeoVideo").val('');
                    $("#youtubeVideo").val('');
                    $("#fileupload").hide();
                    $("#VdoCipherUrl").hide();
                    $("#bunnyStreamUrl").show();
                    $("#media_upload").hide();

                } else if (category_id === 'Storage') {
                    $("#iframeBox").hide();
                    $("#videoUrl").hide();
                    $("#vimeoUrl").hide();
                    $("#vimeoVideo").val('');
                    $("#youtubeVideo").val('');
                    $("#fileupload").hide();
                    $("#VdoCipherUrl").hide();
                    $("#bunnyStreamUrl").hide();
                    $("#media_upload").show();

                } else {
                    $("#iframeBox").hide();
                    $("#videoUrl").hide();
                    $("#vimeoUrl").hide();
                    $("#vimeoVideo").val('');
                    $("#youtubeVideo").val('');
                    $("#fileupload").hide();
                    $("#VdoCipherUrl").hide();
                    $("#bunnyStreamUrl").hide();
                    $("#media_upload").hide();

                }

            });


            $('#category_id1').change(function () {

                let category_id1 = $('#category_id1').find(":selected").val();
                console.log("Host : " + category_id1);
                if (category_id1 === 'Youtube') {
                    $("#videoUrl1").show();
                    $("#vimeoUrl1").hide();
                    $("#vimeoVideo1").val('');
                    $("#youtubeVideo1").val('');
                    $("#fileupload1").hide();
                    $("#bunnyStreamUrl1").hide();

                } else if ((category_id1 === 'Self') || (category_id === 'Document') || (category_id ===
                    'Image') || (category_id1 === 'AmazonS3') || (category_id1 === 'SCORM') || (
                    category_id1 === 'SCORM-AwsS3') || (category_id1 === 'XAPI') || (category_id1 ===
                    'XAPI-AwsS3')) {
                    $("#fileupload1").show();
                    $("#videoUrl1").hide();
                    $("#vimeoUrl1").hide();
                    $("#vimeoVideo1").val('');
                    $("#youtubeVideo1").val('');
                    $("#bunnyStreamUrl1").hide();

                } else if (category_id1 === 'Vimeo') {
                    $("#videoUrl1").hide();
                    $("#vimeoUrl1").show();
                    $("#vimeoVideo1").val('');
                    $("#youtubeVideo1").val('');
                    $("#fileupload1").hide();
                    $("#bunnyStreamUrl1").hide();
                } else if (category_id1 === 'BunnyStorage') {
                    $("#videoUrl1").hide();
                    $("#vimeoUrl1").hide();
                    $("#vimeoVideo1").val('');
                    $("#youtubeVideo1").val('');
                    $("#fileupload1").hide();
                    $("#bunnyStreamUrl1").show();
                } else {
                    $("#videoUrl1").hide();
                    $("#vimeoUrl1").hide();
                    $("#vimeoVideo1").val('');
                    $("#youtubeVideo1").val('');
                    $("#fileupload1").hide();
                    $("#bunnyStreamUrl1").hide();
                }
            });


            @if (empty(@$editLesson))
            $('.category_id').trigger('change');
            @endif
            // $('#category_id1').trigger('change');

        });


        $(document).on('click', '.fileEditFrom', function () {

            let file = $(this).data('item');
            var IdElement = $('.editFileId');
            var NameFileElement = $('.editFileName');
            var PrivacyElement = $('.editFilePrivacy');
            var StatusElement = $('.editFileStatus');
            IdElement.val(file.id);
            NameFileElement.val(file.fileName);
            if (file.lock == "1" || file.lock == true) {
                PrivacyElement.val(1);
            } else {
                PrivacyElement.val(0);
            }
            if (file.status == "1" || file.status == true) {
                StatusElement.val(1);
            } else {
                StatusElement.val(0);
            }

            console.log(PrivacyElement, StatusElement, file)

            PrivacyElement.niceSelect('update');
            StatusElement.niceSelect('update');


        })
    </script>



    <script>
        getVdoCipherList();
        getVdoCipherListForLesson();

        @if(isModuleActive("BunnyStorage"))
        getBunnyListForLesson()

        function getBunnyListForLesson() {
            $('.BunnyVideoLesson').select2({
                ajax: {
                    url: '{{ route('bunny_stream.get_lesson') }}',
                    type: "GET",
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return {
                            search: params.term,
                            page: params.page || 1,
                        }
                    },
                    // processResults: function (response) {
                    //     return {
                    //         results: response,
                    //         pagination: {
                    //             more: true
                    //         }
                    //     };
                    // },
                    cache: true
                }
            });
        }
        @endif


        function getVdoCipherList() {
            $('.vdocipherList').select2({
                ajax: {
                    url: '{{ route('getAllVdocipherData') }}',
                    type: "GET",
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return {
                            search: params.term,
                            page: params.page || 1,
                        }
                    },
                    cache: false
                }
            });
        }

        function getVdoCipherListForLesson() {
            $('.lessonVdocipher').select2({
                ajax: {
                    url: '{{ route('getAllVdocipherData') }}',
                    type: "GET",
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return {
                            search: params.term,
                            page: params.page || 1,
                        }
                    },
                    cache: false
                }
            });
        }


        getVimeoList();
        getVimeoListForLesson();

        function getVimeoList() {
            $('.vimeoList').select2({
                ajax: {
                    url: '{{ route('getAllVimeoData') }}',
                    type: "GET",
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return {
                            search: params.term,
                            page: params.page || 1,
                        }
                    },
                    cache: false
                }
            });
        }

        function getVimeoListForLesson() {
            $('.lessonVimeo').select2({
                ajax: {
                    url: '{{ route('getAllVimeoData') }}',
                    type: "GET",
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return {
                            search: params.term,
                            page: params.page || 1,
                        }
                    },
                    cache: false
                }
            });
        }

        $(document).ready(function () {

            let host = $('#overview_host_section option:selected').val();

            if (host == 'Vimeo') {
                let uri = $(".vimeoListForCourse option:selected").val();
                if (uri != "") {
                    $.ajax({
                        url: "{{ url('admin/course/vimeo/video') }}?uri=" + uri,
                        success: function (data) {
                            $(".vimeoListForCourse option:selected").text(data.name)
                            getVimeoList();
                        },
                        error: function () {
                            console.log('failed')
                        }
                    });
                }
            } else if (host == 'VdoCipher') {
                let id = $(".vdocipherListForCourse option:selected").val();
                if (id != "") {
                    $.ajax({
                        url: "{{ url('admin/course/vdocipher/video') }}/" + id,
                        success: function (data) {
                            $(".vdocipherListForCourse option:selected").text(data.title)
                            getVdoCipherList();
                        },
                        error: function () {
                            console.log('failed')
                        }
                    });
                }
            }


            $('.VdoCipherVideoLesson').each(function (i, obj) {

                let host = $(this).closest('.lesson_div').find('.host_select option:selected').val();
                if (host == 'VdoCipher') {
                    let lessonId = $(this).find('option:selected').val();
                    if (lessonId != "") {
                        $.ajax({
                            url: "{{ url('admin/course/vdocipher/video') }}/" + lessonId,
                            success: function (data) {
                                $(".lessonVdocipher option:selected").text(data.title)
                                getVdoCipherListForLesson();
                            },
                            error: function () {
                                console.log('failed')
                            }
                        });
                    }
                }

            });


            $('.vimeoVideoLesson').each(function (i, obj) {
                let host = $(this).closest('.lesson_div').find('.host_select option:selected').val();
                if (host == 'Vimeo') {
                    var lessonUri = $(this).find('option:selected').val();
                    if (lessonUri != "") {
                        $.ajax({
                            url: "{{ url('admin/course/vimeo/video') }}?uri=" + lessonUri,
                            success: function (data) {
                                $(".lessonVimeo option:selected").text(data.name)
                                getVimeoListForLesson();
                            },
                            error: function () {
                                console.log('failed')
                            }
                        });
                    }
                }
            });


        });
        @if (isset($editLesson))
        var editLesson = $('#category_id_edit_{{ $editLesson->id }}');
        editLesson.trigger('change');

        //   $('.fileType').find()
        var type = $('.fileType:checked').val();
        if (type == 2) {
            $('.fileType:checked').trigger('click');
        }
        @endif


        $('.mode_of_delivery').change(function () {
            let option = $(".mode_of_delivery option:selected").val();

            if (option == 3) {
                $('.quizBox').hide();
            } else {
                if ($('.type2').is(':checked')) {
                    $('.quizBox').show();
                }
            }
        });
        $('.mode_of_delivery').trigger('change');


        $(document).on("click", ".questionSubmitBtn", function (e) {
            e.preventDefault();
            let div = $(this).closest('.questionBoxDiv');
            let count = div.closest('.questionBoxDiv').find('[type=checkbox]:checked').length;
            if (count < 1) {
                toastr.error('{{__('common.At least one correct answer is required')}} ', '{{__('common.Error')}}');
            } else {
                $(this).closest('form').submit();
            }
        });
        $('#iap').change(function () {
            if ($('#iap').is(':checked')) {
                $('#iap_div').removeClass('d-none');
            } else {
                $('#iap_div').addClass('d-none');
            }
        });
        @if(isModuleActive('UpcomingCourse'))
        upcomingCourseDivToggle();

        $(document).on('change', '#is_upcoming_course', function (event) {
            upcomingCourseDivToggle();
        });

        $(document).on('change', '#is_allow_prebooking', function (event) {
            upcomingCourseDivToggle();
        });

        function upcomingCourseDivToggle() {
            if ($('#is_upcoming_course').is(':checked')) {
                $('.upcoming_course_div').removeClass('d-none');
            } else {
                $('.upcoming_course_div').addClass('d-none');
            }
            allowPreBooking();
        }

        function allowPreBooking() {
            if ($('#is_allow_prebooking').is(':checked')) {
                $('.booking_amount_div').removeClass('d-none');
            } else {
                $('.booking_amount_div').addClass('d-none');
            }
        }

        @endif
    </script>
@endpush
