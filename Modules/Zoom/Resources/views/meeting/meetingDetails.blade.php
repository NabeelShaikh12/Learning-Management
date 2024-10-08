@extends('backend.master')
@section('mainContent')
    <style>
        .propertiesname {
            text-transform: uppercase;
            font-weight: bold;
        }
    </style>
    {!! generateBreadcrumb() !!}

    <section class="admin-visitor-area">
        <div class="container-fluid p-0">
            <div class="row">
                <div class="col-md-10">
                    <h3 class="mb-30"> {{__('zoom.Topic')}}</h3>
                </div>
                <div class="col-md-2 pull-right  text-end">

                    <a href="{{ route('zoom.meetings.edit', $localMeetingData->id) }}"
                       class="primary-btn small fix-gr-bg "> <span class="ti-pencil-alt"></span>{{__('zoom.Edit')}} </a>

                </div>
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="QA_section QA_section_heading_custom check_box_table">
                                <div class="QA_table ">
                                    <table id="lms_table" class="table Crm_table_active3">

                                        <tr>
                                            <th>{{__('common.SL')}}</th>
                                            <th>{{__('zoom.Name')}}</th>
                                            <th>{{__('zoom.Status')}}</th>
                                        </tr>
                                        @php $sl = 1 @endphp
                                        <tr>
                                            <td>{{ $sl++ }} </td>
                                            <td class="propertiesname">{{__('zoom.Topic')}}</td>
                                            <td>{{@$localMeetingData->topic}}</td>
                                        </tr>
                                        <tr>
                                            <td>{{ $sl++ }} </td>
                                            <td class="propertiesname">{{__('zoom.Participants')}}</td>
                                            <td> @foreach($localMeetingData->participates as $key=>$participate)
                                                    {{$participate->user->name??''}}
                                                @endforeach
                                            </td>
                                        </tr>
                                        @if($localMeetingData->attached_file)
                                            <tr>
                                                <td>{{ $sl++ }} </td>
                                                <td class="propertiesname">{{__('zoom.Attached File')}}   </td>
                                                <td><a href="{{ asset($localMeetingData->attached_file) }}" download=""><i
                                                            class="fa fa-download me-1"></i> Download</a></td>
                                            </tr>
                                        @endif
                                        <tr>
                                            <td> {{ $sl++ }} </td>
                                            <td class="propertiesname">{{__('zoom.Start Date Time')}}  </td>
                                            <td>{{ $localMeetingData->MeetingDateTime }}</td>
                                        </tr>
                                        <tr>
                                            <td> {{ $sl++ }} </td>
                                            <td class="propertiesname">{{__('zoom.Class')}} </td>
                                            <td>{{ @$localMeetingData->class->title }}</td>
                                        </tr>
                                        <tr>
                                            <td>{{ $sl++ }} </td>
                                            <td class="propertiesname">{{__('zoom.Password')}}</td>
                                            <td>{{@$localMeetingData->password}}</td>
                                        </tr>

                                        <tr>
                                            <td>{{ $sl++ }} </td>
                                            <td class="propertiesname">{{__('zoom.Start/Join')}}  </td>
                                            <td>
                                                @if(@$results['status'] == 'started')
                                                    <a class="primary-btn small bg-success text-white border-0"
                                                       href="{{ route('zoom.meeting.join', $localMeetingData->meeting_id) }}"
                                                       target="_blank">
                                                        @if (Auth::user()->role_id == 1 || Auth::user()->id == $localMeetingData->created_by)
                                                            {{__('zoom.Start')}}
                                                        @else
                                                            {{__('zoom.Join ')}}
                                                        @endif
                                                    </a>
                                                @elseif(@$results['status'] == 'waiting')
                                                    <a href="#"
                                                       class="primary-btn small bg-warning text-white border-0">{{__('zoom.Not Yet Start')}}</a>
                                                @else
                                                    <a href="#"
                                                       class="primary-btn small bg-warning text-white border-0">{{__('zoom.Closed')}}</a>
                                                @endif
                                            </td>
                                        </tr>


                                        <tr>
                                            <td>{{ $sl++ }} </td>
                                            <td class="propertiesname">{{__('zoom.Description')}} </td>
                                            <td> {{ $localMeetingData->description }}  </td>
                                        </tr>


                                        <tr>
                                            <td>{{ $sl++ }} </td>
                                            <td class="propertiesname">   {{__('zoom.Timezone')}} </td>
                                            <td>{{Settings('active_time_zone')}}</td>
                                        </tr>

                                        <tr>
                                            <td>{{ $sl++ }} </td>
                                            <td class="propertiesname"> {{__('zoom.Created At')}}</td>
                                            <td>{{Carbon\Carbon::parse(@$results['created_at'])->format('m-d-Y')}}</td>
                                        </tr>

                                        <tr>
                                            <td>{{ $sl++ }} </td>
                                            <td class="propertiesname"> {{__('zoom.Join Url')}}  </td>
                                            <td><a href="{{@$results['join_url']}}" target="_blank">Click</a></td>
                                        </tr>


                                        <tr>
                                            <td>{{ $sl++ }} </td>
                                            <td class="propertiesname">  {{__('zoom.Host Video')}}</td>
                                            <td>{{@$results['settings']['host_video']==false?'False':'True'}}</td>
                                        </tr>

                                        <tr>
                                            <td>{{ $sl++ }} </td>
                                            <td class="propertiesname">   {{__('zoom.Participant video')}}</td>
                                            <td>{{@$results['settings']['participant_video']==false?'False':'True'}}</td>
                                        </tr>

                                        <tr>
                                            <td>{{ $sl++ }} </td>
                                            <td class="propertiesname">   {{__('zoom.Cn Class')}}</td>
                                            <td>{{@$results['settings']['cn_mettings']==false?'False':'True'}}</td>
                                        </tr>

                                        <tr>
                                            <td>{{ $sl++ }} </td>
                                            <td class="propertiesname">{{__('zoom.In Class')}}  </td>
                                            <td>{{@$results['settings']['in_mettings']==false?'False':'True'}}</td>
                                        </tr>

                                        <tr>
                                            <td>{{ $sl++ }} </td>
                                            <td class="propertiesname">{{__('zoom.Join Before Host')}} </td>
                                            <td>{{@$results['settings']['join_before_host']==false?'False':'True'}}</td>
                                        </tr>

                                        <tr>
                                            <td>{{ $sl++ }} </td>
                                            <td class="propertiesname">{{__('zoom.Mute Upon Entry')}} </td>
                                            <td>{{@$results['settings']['mute_upon_entry']==false?'False':'True'}}</td>
                                        </tr>

                                        <tr>
                                            <td>{{ $sl++ }} </td>
                                            <td class="propertiesname">{{__('zoom.Watermark')}}</td>
                                            <td>{{@$results['settings']['watermark']==false?'False':'True'}}</td>
                                        </tr>

                                        <tr>
                                            <td>{{ $sl++ }} </td>
                                            <td class="propertiesname">{{__('zoom.Use PMI')}}</td>
                                            <td>{{@$results['settings']['use_pmi']==false?'False':'True'}}</td>
                                        </tr>

                                        <tr>
                                            <td>{{ $sl++ }} </td>
                                            <td class="propertiesname"> {{__('zoom.Audio Options')}}</td>
                                            <td>{{@$results['settings']['audio']}}</td>
                                        </tr>
                                        <tr>
                                            <td>{{ $sl++ }} </td>
                                            <td class="propertiesname">{{__('zoom.Auto Recording')}}</td>
                                            <td>{{@$results['settings']['auto_recording']}}</td>
                                        </tr>

                                        <tr>
                                            <td>{{ $sl++ }} </td>
                                            <td class="propertiesname">{{__('zoom.Enforce longin')}} </td>
                                            <td>{{@$results['settings']['enforce_login']==false?'False':'True'}}</td>
                                        </tr>

                                        <tr>
                                            <td>{{ $sl++ }} </td>
                                            <td class="propertiesname">{{__('zoom.Enforce Login Domains')}}   </td>
                                            <td>{{@$results['settings']['enforce_login_domains']==false?'False':'True'}}</td>
                                        </tr>

                                        <tr>
                                            <td>{{ $sl++ }} </td>
                                            <td class="propertiesname">{{__('zoom.Alternative Hosts')}} </td>
                                            <td>{{@$results['settings']['alternative_hosts']==false?'False':'True'}}</td>
                                        </tr>
                                        <tr>
                                            <td>{{ $sl++ }} </td>
                                            <td class="propertiesname">{{__('zoom.Waiting Room')}}</td>
                                            <td>{{@$results['settings']['waiting_room']==false?'False':'True'}}</td>
                                        </tr>
                                        <tr>
                                            <td>{{ $sl++ }} </td>
                                            <td class="propertiesname">{{__('zoom.Class Authentication')}}  </td>
                                            <td>{{@$results['settings']['meeting_authentication']==false?'False':'True'}}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
