@extends('backend.master')
@section('mainContent')
    <style>
        @media (max-width: 991px) {
            .input-effect {
                margin-bottom: 30px;
            }
        }
    </style>
    {{generateBreadcrumb()}}
    <section class="admin-visitor-area up_admin_visitor">
        <div class="container-fluid p-0">
            <div class="row">
                <div class="col-lg-12">
                    <form action="{{ route('zoom.settings.update') }}" method="POST">
                        @csrf
                        <div class="white-box">
                            <div class="row p-0">
                                <div class="col-lg-12">
                                    <h3 class="text-center">{{__('zoom.Setting')}}</h3>
                                    <hr>


                                    <div class="row mb-40 mt-40">
                                        <div class="col-lg-6">
                                            <div class="row">
                                                <div class="col-lg-5 d-flex">
                                                    <p class="text-uppercase fw-500 mb-10">{{__('zoom.Class Join Approval')}}</p>
                                                </div>
                                                <div class="col-lg-7">
                                                    <select
                                                        class="w-100 bb niceSelect form-control {{ @$errors->has('approval_type') ? ' is-invalid' : '' }}"
                                                        name="approval_type">
                                                        <option data-display="{{__('zoom.Select')}} *"
                                                                value="">{{__('zoom.Select')}} *
                                                        </option>
                                                        <option
                                                            value="0" @if(!empty($setting))
                                                            {{ old('approval_type',$setting->approval_type) == 0? 'selected' : ''}}
                                                            @endif>
                                                            {{__('zoom.Automatically')}}
                                                        </option>
                                                        <option
                                                            value="1"@if(!empty($setting))
                                                            {{ old('approval_type',$setting->approval_type) == 1? 'selected' : ''}}
                                                            @endif>
                                                            {{__('zoom.Manually Approve')}}
                                                        </option>
                                                        <option
                                                            value="2" @if(!empty($setting))
                                                            {{ old('approval_type',$setting->approval_type) == 2? 'selected' : ''}}
                                                            @endif>
                                                            {{__('zoom.No Registration Required')}}
                                                        </option>
                                                    </select>
                                                    @if ($errors->has('approval_type'))
                                                        <span class="invalid-feedback invalid-select" role="alert">
                                                                <strong>{{ @$errors->first('approval_type') }}</strong>
                                                            </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="row">
                                                <div class="col-lg-5 d-flex">
                                                    <p class="text-uppercase fw-500 mb-10">{{__('zoom.Host Video')}} </p>
                                                </div>
                                                <div class="col-lg-7">
                                                    <div class="radio-btn-flex">
                                                        <div class="row">
                                                            <div class="col-lg-6 mb-25 p-0">
                                                                <div class="">
                                                                    <label class="primary_checkbox d-flex mr-12"
                                                                           for="host_video_on">
                                                                        <input type="radio" name="host_video"
                                                                               id="host_video_on" value="1"
                                                                               class="common-radio relationButton"@if(!empty($setting))
                                                                            {{ old('host_video',$setting->host_video) == 1 ? 'checked': ''}}
                                                                            @endif>
                                                                        <span
                                                                            class="checkmark me-2"></span> {{__('zoom.Enable')}}
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6 mb-25 p-0">
                                                                <div class="">
                                                                    <label class="primary_checkbox d-flex mr-12"
                                                                           for="host_video">
                                                                        <input type="radio" name="host_video"
                                                                               id="host_video" value="0"
                                                                               class="common-radio relationButton" @if(!empty($setting))
                                                                            {{ old('host_video',$setting->host_video) == '0' ? 'checked': ''}}
                                                                            @endif>
                                                                        <span
                                                                            class="checkmark me-2"></span> {{__('zoom.Disable')}}
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="row mb-40 mt-40">

                                        <div class="col-lg-6">
                                            <div class="row">
                                                <div class="col-lg-5 d-flex">
                                                    <p class="text-uppercase fw-500 mb-10">{{__('zoom.Auto Recording')}}
                                                        ({{__('zoom.For Paid Package')}})</p>
                                                </div>
                                                <div class="col-lg-7">
                                                    <select
                                                        class="w-100 bb niceSelect form-control {{ @$errors->has('auto_recording') ? ' is-invalid' : '' }}"
                                                        name="auto_recording">
                                                        <option data-display="{{__('zoom.Select')}} *"
                                                                value="">{{__('zoom.Select')}} *
                                                        </option>
                                                        <option
                                                            value="none" @if(!empty($setting))
                                                            {{ old('auto_recording',$setting->auto_recording) == 'none'? 'selected' : ''}}
                                                            @endif >
                                                            {{__('zoom.None')}}
                                                        </option>
                                                        <option
                                                            value="local"@if(!empty($setting))
                                                            {{ old('auto_recording',$setting->auto_recording) == 'local'? 'selected' : ''}}
                                                            @endif >
                                                            {{__('zoom.Local')}}
                                                        </option>
                                                        <option
                                                            value="cloud" @if(!empty($setting))
                                                            {{ old('auto_recording',$setting->auto_recording) == 'cloud'? 'selected' : ''}}
                                                            @endif>
                                                            {{__('zoom.Cloud')}}
                                                        </option>
                                                    </select>
                                                    @if ($errors->has('auto_recording'))
                                                        <span class="invalid-feedback invalid-select" role="alert">
                                                            <strong>{{ @$errors->first('auto_recording') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="row">
                                                <div class="col-lg-5 d-flex">
                                                    <p class="text-uppercase fw-500 mb-10">{{__('zoom.Participant video')}} </p>
                                                </div>
                                                <div class="col-lg-7">
                                                    <div class="radio-btn-flex">
                                                        <div class="row">
                                                            <div class="col-lg-6 mb-25 p-0">
                                                                <div class="">
                                                                    <label class="primary_checkbox d-flex mr-12"
                                                                           for="participant_video_on">
                                                                        <input type="radio" name="participant_video"
                                                                               id="participant_video_on" value="1"
                                                                               class="common-radio relationButton" @if(!empty($setting))
                                                                            {{ old('participant_video',$setting->participant_video) == 1? 'checked': ''}}
                                                                            @endif>
                                                                        <span
                                                                            class="checkmark me-2"></span> {{__('zoom.Enable')}}
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6 mb-25 p-0">
                                                                <div class="">
                                                                    <label class="primary_checkbox d-flex mr-12"
                                                                           for="participant_video">
                                                                        <input type="radio" name="participant_video"
                                                                               id="participant_video" value="0"
                                                                               class="common-radio relationButton"@if(!empty($setting))
                                                                            {{ old('participant_video',$setting->participant_video) == 0? 'checked': ''}}
                                                                            @endif>
                                                                        <span
                                                                            class="checkmark me-2"></span> {{__('zoom.Disable')}}
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="row mb-40 mt-40">

                                        <div class="col-lg-6">
                                            <div class="row">
                                                <div class="col-lg-5 d-flex">
                                                    <p class="text-uppercase fw-500 mb-10">
                                                        {{__('zoom.Audio Options')}}</p>
                                                </div>
                                                <div class="col-lg-7">
                                                    <select
                                                        class="w-100 bb niceSelect form-control {{ @$errors->has('audio') ? ' is-invalid' : '' }}"
                                                        name="audio">
                                                        <option data-display="{{__('zoom.Select')}} *"
                                                                value="">{{__('zoom.Select')}}*
                                                        </option>
                                                        <option
                                                            value="both" @if(!empty($setting))
                                                            {{ old('audio',$setting->audio) == 'both' ? 'selected' : ''}}
                                                            @endif >
                                                            {{__('zoom.Both')}}
                                                        </option>
                                                        <option
                                                            value="telephony" @if(!empty($setting))
                                                            {{ old('audio',$setting->audio) == 'telephony'? 'selected' : ''}}
                                                            @endif>
                                                            {{__('zoom.Telephony')}}
                                                        </option>
                                                        <option
                                                            value="voip" @if(!empty($setting))
                                                            {{ old('audio',$setting->audio) == 'voip'? 'selected' : ''}}
                                                            @endif >
                                                            {{__('zoom.Voip')}}
                                                        </option>

                                                    </select>
                                                    @if ($errors->has('audio'))
                                                        <span class="invalid-feedback invalid-select" role="alert">
                                                            <strong>{{ @$errors->first('audio') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="row">
                                                <div class="col-lg-5 d-flex">
                                                    <p class="text-uppercase fw-500 mb-10">{{__('zoom.Join Before Host')}} </p>
                                                </div>
                                                <div class="col-lg-7">
                                                    <div class=" radio-btn-flex">
                                                        <div class="row">
                                                            <div class="col-lg-6 mb-25 p-0">
                                                                <div class="">
                                                                    <label class="primary_checkbox d-flex mr-12"
                                                                           for="join_before_host_on">
                                                                        <input type="radio" name="join_before_host"
                                                                               id="join_before_host_on" value="1"
                                                                               class="common-radio relationButton" @if(!empty($setting))
                                                                            {{ old('join_before_host',$setting->join_before_host) == 1? 'checked': '' }}
                                                                            @endif>
                                                                        <span
                                                                            class="checkmark me-2"></span>{{__('zoom.Enable')}}
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6 mb-25 p-0">
                                                                <div class="">
                                                                    <label class="primary_checkbox d-flex mr-12"
                                                                           for="join_before_host">
                                                                        <input type="radio" name="join_before_host"
                                                                               id="join_before_host" value="0"
                                                                               class="common-radio relationButton" @if(!empty($setting))
                                                                            {{ old('join_before_host',$setting->join_before_host) == 0? 'checked': '' }}
                                                                            @endif>
                                                                        <span
                                                                            class="checkmark me-2"></span> {{__('zoom.Disable')}}
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mb-40 mt-40">
                                        <div class="col-lg-6">
                                            <div class="row">
                                                <div class="col-lg-5 d-flex">
                                                    <p class="text-uppercase fw-500 mb-10">{{__('zoom.Package')}}</p>
                                                </div>
                                                <div class="col-lg-7">
                                                    <select
                                                        class="w-100 bb niceSelect form-control {{ @$errors->has('package_id') ? ' is-invalid' : '' }}"
                                                        name="package_id">
                                                        <option data-display="{{__('zoom.Select Package')}} *"
                                                                value="">{{__('zoom.Select Package')}} *
                                                        </option>
                                                        <option
                                                            value="1" @if(!empty($setting))
                                                            {{ old('package_id',$setting->package_id) == 1 ? 'selected' : ''}}
                                                            @endif >
                                                            {{__('zoom.Basic (Free)')}}
                                                        </option>
                                                        <option
                                                            value="2" @if(!empty($setting))
                                                            {{ old('package_id',$setting->package_id) == 2 ? 'selected' : ''}}
                                                            @endif >
                                                            {{__('zoom.Pro')}}
                                                        </option>
                                                        <option
                                                            value="3"@if(!empty($setting))
                                                            {{ old('package_id',$setting->package_id) == 3 ? 'selected' : ''}}
                                                            @endif >
                                                            {{__('zoom.Business')}}
                                                        </option>
                                                        <option
                                                            value="4" @if(!empty($setting))
                                                            {{ old('package_id',$setting->package_id) == 4 ? 'selected' : ''}}
                                                            @endif >
                                                            {{__('zoom.Enterprise')}}
                                                        </option>
                                                    </select>
                                                    @if ($errors->has('package_id'))
                                                        <span class="invalid-feedback invalid-select" role="alert">
                                                            <strong>{{ @$errors->first('package_id') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="row">
                                                <div class="col-lg-5 d-flex">
                                                    <p class="text-uppercase fw-500 mb-10">{{__('zoom.Waiting Room')}}</p>
                                                </div>
                                                <div class="col-lg-7">
                                                    <div class=" radio-btn-flex">
                                                        <div class="row">
                                                            <div class="col-lg-6 mb-25 p-0">
                                                                <div class="">
                                                                    <label class="primary_checkbox d-flex mr-12"
                                                                           for="waiting_room_on">
                                                                        <input type="radio" name="waiting_room"
                                                                               id="waiting_room_on" value="1"
                                                                               class="common-radio relationButton" @if(!empty($setting))
                                                                            {{ old('waiting_room',$setting->waiting_room) == 1? 'checked': '' }}
                                                                            @endif>
                                                                        <span
                                                                            class="checkmark me-2"></span> {{__('zoom.Enable')}}
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6 mb-25 p-0">
                                                                <div class="">
                                                                    <label class="primary_checkbox d-flex mr-12"
                                                                           for="waiting_room">
                                                                        <input type="radio" name="waiting_room"
                                                                               id="waiting_room" value="0"
                                                                               class="common-radio relationButton" @if(!empty($setting))
                                                                            {{ old('waiting_room',$setting->waiting_room) == 0? 'checked': '' }}
                                                                            @endif>
                                                                        <span
                                                                            class="checkmark me-2"></span> {{__('zoom.Disable')}}
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                    </div>

                                    <div class="row mb-40 mt-40">

                                        <div class="col-lg-6">
                                            <div class="row">
                                                <div class="col-lg-5 d-flex">
                                                    <p class="text-uppercase fw-500 mb-10">
                                                        {{__('zoom.Mute Upon Entry')}} </p>
                                                </div>
                                                <div class="col-lg-7">

                                                    <div class="radio-btn-flex">
                                                        <div class="row">
                                                            <div class="col-lg-6 mb-25 p-0">
                                                                <div class="">
                                                                    <label class="primary_checkbox d-flex mr-12 "
                                                                           for="mute_upon_entr_on">
                                                                        <input type="radio" name="mute_upon_entry"
                                                                               id="mute_upon_entr_on" value="1"
                                                                               class="common-radio relationButton" @if(!empty($setting))
                                                                            {{ old('mute_upon_entry',$setting->mute_upon_entry) == 1? 'checked': ''}}
                                                                            @endif>
                                                                        <span
                                                                            class="checkmark me-2"></span> {{__('zoom.Enable')}}
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6 mb-25 p-0">
                                                                <div class="">
                                                                    <label class="primary_checkbox d-flex mr-12 "
                                                                           for="mute_upon_entry">
                                                                        <input type="radio" name="mute_upon_entry"
                                                                               id="mute_upon_entry" value="0"
                                                                               class="common-radio relationButton" @if(!empty($setting))
                                                                            {{ old('mute_upon_entry',$setting->mute_upon_entry) == 0? 'checked': ''}}
                                                                            @endif>
                                                                        <span
                                                                            class="checkmark me-2"></span> {{__('zoom.Disable')}}
                                                                    </label>
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

                            <div class="row mb-40  ">
                                <div class="col-lg-12 pb_20">
                                    <p>
                                        <i class="fa fa-info-circle"></i> {{__('virtual-class.Zoom')}}  {{__('virtual-class.Server-to-Server OAuth credentials')}}
                                    </p>
                                </div>
                                <div class="col-lg-4">
                                    <div class="input-effect sm2_mb_20 md_mb_20">
                                        <label class="mb-3">{{__('zoom.Account ID')}}<span
                                                class="required_mark">*</span> </label>

                                        <input
                                            class="primary-input-field form-control "
                                            type="text" name="zoom_account_id"
                                            value="@if(!empty($setting)) {{ old('zoom_account_id',$setting->zoom_account_id) }} @endif">
                                        <span class="focus-border"></span>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="input-effect sm2_mb_20 md_mb_20">
                                        <label class="mb-3">{{__('zoom.Client ID') }}<span
                                                class="required_mark">*</span></label>

                                        <input
                                            class="primary-input-field form-control "
                                            type="text" name="zoom_client_id"
                                            value=" @if(!empty($setting)) {{ old('zoom_client_id',$setting->zoom_client_id) }} @endif">
                                        <span class="focus-border"></span>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="input-effect sm2_mb_20 md_mb_20">
                                        <label class="mb-3">{{__('zoom.Client secret') }}<span
                                                class="required_mark">*</span></label>
                                        <input
                                            class="primary-input-field form-control"
                                            type="text" name="zoom_client_secret"
                                            value=" @if(!empty($setting)) {{ old('zoom_client_secret',$setting->zoom_client_secret) }} @endif">
                                        <span class="focus-border"></span>
                                    </div>
                                </div>

                            </div>

                            <div class="row mt-40">
                                <div class="col-lg-12 text-center">
                                    <button type="submit" class="primary-btn fix-gr-bg"
                                            id="_submit_btn_admission">
                                        <i class="ti-check"></i>
                                        {{__('zoom.Update')}}
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
