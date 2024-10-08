@extends('backend.master')
@section('table')
    {{__('testimonials')}}
@endsection
@section('mainContent')
    {!! generateBreadcrumb() !!}


    <section class="mb-40 student-details">
        <div class="container-fluid p-0">
            <div class="row">

                <div class="col-lg-12">


                    @if (permissionCheck('null'))
                        <form class="form-horizontal" action="{{route('frontend.ContactPageContentUpdate')}}"
                              method="POST"
                              enctype="multipart/form-data">
                            @endif
                            @csrf
                            <div class="white-box student-details header-menu">

                                <div class="col-md-12 ">
                                    <input type="hidden" name="url" id="url" value="{{URL::to('/')}}">
                                    <div class="row mb-30">
                                        <div class="col-md-12">
                                            @php
                                                $LanguageList = getLanguageList();
                                            @endphp
                                            <div class="row pt-0">
                                                @if(isModuleActive('FrontendMultiLang'))
                                                    <ul class="nav nav-tabs no-bottom-border  mt-sm-md-20 mb-10 ms-3"
                                                        role="tablist">
                                                        @foreach ($LanguageList as $key => $language)
                                                            <li class="nav-item">
                                                                <a class="nav-link  @if (auth()->user()->language_code == $language->code) active @endif"
                                                                   href="#element{{$language->code}}"
                                                                   role="tab"
                                                                   data-bs-toggle="tab">{{ $language->native }}  </a>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                @endif
                                            </div>
                                            <div class="tab-content">
                                                @foreach ($LanguageList as $key => $language)
                                                    <div role="tabpanel"
                                                         class="tab-pane fade @if (auth()->user()->language_code == $language->code) show active @endif  "
                                                         id="element{{$language->code}}">
                                                        <div class="row">
                                                            <div class="col-xl-6">
                                                                <div class="primary_input mb-25">
                                                                    <label class="primary_input_label"
                                                                           for="">{{ __('frontendmanage.Contact Page Title') }}
                                                                    </label>
                                                                    <input class="primary_input_field"
                                                                           placeholder="{{ __('frontendmanage.Contact Page Title') }}"
                                                                           type="text"
                                                                           name="contact_page_title[{{$language->code}}]"
                                                                           {{ $errors->has('contact_page_title') ? ' autofocus' : '' }}
                                                                           value="{{isset($page_content)? getRawHomeContents($page_content,'contact_page_title',$language->code)  : ''}}">
                                                                </div>
                                                            </div>

                                                            <div class="col-xl-6">
                                                                <div class="primary_input mb-25">
                                                                    <label class="primary_input_label"
                                                                           for="">{{ __('frontendmanage.Contact Page Sub Title') }}</label>
                                                                    <input class="primary_input_field"
                                                                           placeholder="{{ __('frontendmanage.Contact Page Sub Title') }}"
                                                                           type="text"
                                                                           name="contact_sub_title[{{$language->code}}]"
                                                                           {{ $errors->has('contact_sub_title') ? ' autofocus' : '' }}
                                                                           value="{{isset($page_content)?getRawHomeContents($page_content,'contact_sub_title',$language->code):''}}">
                                                                </div>
                                                            </div>
                                                            @if(currentTheme() == 'edume')
                                                                <div class="col-xl-6">
                                                                    <div class="primary_input mb-25">
                                                                        <label class="primary_input_label"
                                                                               for="">{{ __('frontendmanage.Contact Page Content Title') }}
                                                                        </label>
                                                                        <input class="primary_input_field"
                                                                               placeholder="{{ __('frontendmanage.Contact Page Content Title') }}"
                                                                               type="text"
                                                                               name="contact_page_content_title[{{$language->code}}]"
                                                                               {{ $errors->has('contact_page_content_title') ? ' autofocus' : '' }}
                                                                               value="{{isset($page_content)? getRawHomeContents($page_content,'contact_page_content_title',$language->code) : ''}}">
                                                                    </div>
                                                                </div>

                                                                <div class="col-xl-6">
                                                                    <div class="primary_input mb-25">
                                                                        <label class="primary_input_label"
                                                                               for="">{{ __('frontendmanage.Contact Page Content Details') }}</label>
                                                                        <input class="primary_input_field"
                                                                               placeholder="{{ __('frontendmanage.Contact Page Content Details') }}"
                                                                               type="text"
                                                                               name="contact_page_content_details[{{$language->code}}]"
                                                                               {{ $errors->has('contact_page_content_details') ? ' autofocus' : '' }}
                                                                               value="{{isset($page_content)? getRawHomeContents($page_content,'contact_page_content_details',$language->code) : ''}}">
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>

                                            <div class="row">


                                                @if(currentTheme() == 'infixlmstheme')
                                                    <div class="col-xl-2">
                                                        <div class="primary_input mb-25">
                                                            <img height="70" class="w-100 imagePreview5"
                                                                 src="{{ asset('/'.getRawHomeContents($page_content,'contact_page_banner','en'))}}"
                                                                 alt="">
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-4">
                                                        <div class="primary_input mb-25">
                                                            <label class="primary_input_label"
                                                                   for="">{{ __('frontendmanage.Contact Page Banner') }}
                                                                <small>({{__('common.Recommended Size')}}
                                                                    1920x500)</small>
                                                            </label>
                                                            <div class="primary_file_uploader">
                                                                <input
                                                                    class="primary-input  filePlaceholder {{ @$errors->has('contact_page_banner') ? ' is-invalid' : '' }}"
                                                                    type="text" id=""
                                                                    placeholder="{{__('setting.Browse file')}}"
                                                                    readonly="" {{ $errors->has('contact_page_banner') ? ' autofocus' : '' }}>
                                                                <button class="" type="button">
                                                                    <label class="primary-btn small fix-gr-bg"
                                                                           for="file5">{{ __('common.Browse') }}</label>
                                                                    <input type="file"
                                                                           class="d-none fileUpload imgInput5"
                                                                           name="contact_page_banner" id="file5">
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                                <div class="col-xl-6">

                                                    <div class="mt-5 mb-5">
                                                        <label class="switch_toggle "
                                                               for="show_map">
                                                            <input type="checkbox" class="status_enable_disable"
                                                                   name="show_map"
                                                                   id="show_map"
                                                                   @if (getRawHomeContents($page_content,'show_map','en') == 1) checked
                                                                   @endif value="1">
                                                            <i class="slider round"></i>


                                                        </label>
                                                        {{__('frontendmanage.Show Map')}}

                                                    </div>
                                                </div>
                                                @if(currentTheme() == 'teachery')
                                                    <div class="col-xl-6">

                                                        <div class="mt-5 mb-5">
                                                            <label class="switch_toggle "
                                                                   for="show_contact_page_faq">
                                                                <input type="checkbox" class="status_enable_disable"
                                                                       name="show_contact_page_faq"
                                                                       id="show_contact_page_faq"
                                                                       @if (getRawHomeContents($page_content,'show_contact_page_faq','en') == 1) checked
                                                                       @endif value="1">
                                                                <i class="slider round"></i>


                                                            </label>
                                                            {{__('frontendmanage.Show Contact Page Faq')}}

                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                            @if(currentTheme()=="edume" || currentTheme() == 'teachery')
                                                <div class="row">


                                                    <div class="col-xl-4">

                                                        <div class="row">
                                                            <div class="col-xl-4">
                                                                <div class="primary_input mb-25">
                                                                    <img height="70" class="w-100 imagePreview1"
                                                                         src="{{ asset('/'.getRawHomeContents($page_content,'contact_page_phone','en'))}}"
                                                                         alt="">
                                                                </div>
                                                            </div>
                                                            <div class="col-xl-8">
                                                                <div class="primary_input mb-25">
                                                                    <label class="primary_input_label"
                                                                           for="">{{ __('frontendmanage.Phone Logo') }}
                                                                        <small>({{__('common.Recommended Size')}}
                                                                            60x60)</small>
                                                                    </label>
                                                                    <div class="primary_file_uploader">
                                                                        <input
                                                                            class="primary-input  filePlaceholder {{ @$errors->has('contact_page_phone') ? ' is-invalid' : '' }}"
                                                                            type="text" id=""
                                                                            placeholder="{{__('setting.Browse file')}}"
                                                                            readonly="" {{ $errors->has('contact_page_phone') ? ' autofocus' : '' }}>
                                                                        <button class="" type="button">
                                                                            <label class="primary-btn small fix-gr-bg"
                                                                                   for="file1">{{ __('common.Browse') }}</label>
                                                                            <input type="file"
                                                                                   class="d-none fileUpload imgInput1"
                                                                                   name="contact_page_phone" id="file1">
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>


                                                    <div class="col-xl-4">

                                                        <div class="row">
                                                            <div class="col-xl-4">
                                                                <div class="primary_input mb-25">
                                                                    <img height="70" class="w-100 imagePreview2"
                                                                         src="{{ asset('/'.getRawHomeContents($page_content,'contact_page_email','en'))}}"
                                                                         alt="">
                                                                </div>
                                                            </div>
                                                            <div class="col-xl-8">
                                                                <div class="primary_input mb-25">
                                                                    <label class="primary_input_label"
                                                                           for="">{{ __('frontendmanage.Email Logo') }}
                                                                        <small>({{__('common.Recommended Size')}}
                                                                            60x60)</small>
                                                                    </label>
                                                                    <div class="primary_file_uploader">
                                                                        <input
                                                                            class="primary-input  filePlaceholder {{ @$errors->has('contact_page_email') ? ' is-invalid' : '' }}"
                                                                            type="text" id=""
                                                                            placeholder="{{__('setting.Browse file')}}"
                                                                            readonly="" {{ $errors->has('contact_page_email') ? ' autofocus' : '' }}>
                                                                        <button class="" type="button">
                                                                            <label class="primary-btn small fix-gr-bg"
                                                                                   for="file2">{{ __('common.Browse') }}</label>
                                                                            <input type="file"
                                                                                   class="d-none fileUpload imgInput2"
                                                                                   name="contact_page_email" id="file2">
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>


                                                    <div class="col-xl-4">

                                                        <div class="row">
                                                            <div class="col-xl-4">
                                                                <div class="primary_input mb-25">
                                                                    <img height="70" class="w-100 imagePreview3"
                                                                         src="{{ asset('/'.getRawHomeContents($page_content,'contact_page_address','en'))}}"
                                                                         alt="">
                                                                </div>
                                                            </div>
                                                            <div class="col-xl-8">
                                                                <div class="primary_input mb-25">
                                                                    <label class="primary_input_label"
                                                                           for="">{{ __('frontendmanage.Address Logo') }}
                                                                        <small>({{__('common.Recommended Size')}}
                                                                            60x60)</small>
                                                                    </label>
                                                                    <div class="primary_file_uploader">
                                                                        <input
                                                                            class="primary-input  filePlaceholder {{ @$errors->has('contact_page_address') ? ' is-invalid' : '' }}"
                                                                            type="text" id=""
                                                                            placeholder="{{__('setting.Browse file')}}"
                                                                            readonly="" {{ $errors->has('contact_page_address') ? ' autofocus' : '' }}>
                                                                        <button class="" type="button">
                                                                            <label class="primary-btn small fix-gr-bg"
                                                                                   for="file3">{{ __('common.Browse') }}</label>
                                                                            <input type="file"
                                                                                   class="d-none fileUpload imgInput3"
                                                                                   name="contact_page_address"
                                                                                   id="file3">
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                @php
                                    $tooltip = "";
                                    if(permissionCheck('null')){
                                        $tooltip = "";
                                    }else{
                                        $tooltip = "You have no permission to Update";
                                    }
                                @endphp
                                <div class="row mt-40">
                                    <div class="col-lg-12 text-center">
                                        <button class="primary-btn fix-gr-bg" data-bs-toggle="tooltip"
                                                title="{{$tooltip}}">
                                            <i class="ti-check"></i>
                                            {{__('common.Update')}}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>

                </div>


            </div>
        </div>
    </section>

@endsection
@push('scripts')
    <script>
        function readURL1(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $(".imagePreview1").attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]); // convert to base64 string
            }
        }

        $(".imgInput1").change(function () {
            readURL1(this);
        });

        function readURL2(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $(".imagePreview2").attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]); // convert to base64 string
            }
        }

        $(".imgInput2").change(function () {
            readURL2(this);
        });


        function readURL3(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $(".imagePreview3").attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]); // convert to base64 string
            }
        }

        $(".imgInput3").change(function () {
            readURL3(this);
        });


        function readURL4(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $(".imagePreview4").attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]); // convert to base64 string
            }
        }

        $(".imgInput4").change(function () {
            readURL4(this);
        });


        function readURL5(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $(".imagePreview5").attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]); // convert to base64 string
            }
        }

        $(".imgInput5").change(function () {
            readURL5(this);
        });
        $(".imgInput4").change(function () {
            readURL4(this);
        });


        function readURL6(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $(".imagePreview6").attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]); // convert to base64 string
            }
        }

        $(".imgInput6").change(function () {
            readURL6(this);
        });

        function readURL7(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $(".imagePreview7").attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]); // convert to base64 string
            }
        }

        $(".imgInput7").change(function () {
            readURL7(this);
        });

        function readURL8(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $(".imagePreview8").attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]); // convert to base64 string
            }
        }

        $(".imgInput8").change(function () {
            readURL8(this);
        });


        function readURL9(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $(".imagePreview9").attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]); // convert to base64 string
            }
        }

        $(".imgInput9").change(function () {
            readURL9(this);
        });

        function readURL10(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $(".imagePreview10").attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]); // convert to base64 string
            }
        }

        $(".imgInput10").change(function () {
            readURL10(this);
        });
    </script>
@endpush
