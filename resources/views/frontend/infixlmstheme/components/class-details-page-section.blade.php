<div>
    @php
        function secondsToTime($seconds) {
         $dtF = new \DateTime('@0');
         $dtT = new \DateTime("@$seconds");
         return $dtF->diff($dtT)->format('%a days, %h hours, %i minutes');
     }

             function secondsToHour($seconds) {
              $dtF = new \DateTime('@0');
              $dtT = new \DateTime("@$seconds");
           return $dtF->diff($dtT)->format('%h : %i Hour(s)');

          }

    if (Auth::check() &&  $isEnrolled){
        $allow=true;
    }else{
        $allow=false;
    }
        if (@$course->discount_price!=null) {
        $course_price=@$course->discount_price;
    } else {
        $course_price=@$course->price;
    }
        $showWaitList =false;
        $alreadyWaitListRequest =false;
        if(isModuleActive('WaitList') && $course->waiting_list_status == 1 && auth()->check()){
           $count = $course->waitList->where('user_id',auth()->id())->count();
            if ($count==0){
                $showWaitList=true;
            }else{
                $alreadyWaitListRequest =true;
            }
        }
    @endphp

    <input type="hidden" name="start_time" class="class_start_time"
           value="{{isset($course->nextMeeting->start_time)?$course->nextMeeting->start_time:''}}">
    <!-- course_details::start  -->
    <div class="course__details">
        <div class="container">
            <div class="row justify-content-center ">
                <div class="col-xl-10">
                    <div class="course__details_title">
                        <div class="single__details">
                            <div class="thumb"
                                 style="background-image: url('{{getProfileImage(@$course->user->image,$course->user->name)}}')">
                            </div>
                            <div class="details_content">
                                <span>{{__('frontend.Instructor Name')}}</span>
                                <a href="{{route('instructorDetails',[$course->user->id,$course->user->name])}}">
                                    <h4 class="f_w_700">{{@$course->user->name}}</h4>
                                </a>
                            </div>
                        </div>
                        <div class="single__details">
                            <div class="details_content">
                                <span>{{__('frontend.Category')}}</span>
                                <h4 class="f_w_700">{{@$course->class->category->name}}</h4>
                            </div>
                        </div>
                        <div class="single__details">
                            <div class="details_content">
                                <span>{{__('frontend.Reviews')}}</span>


                                <div class="rating_star">
                                    <div class="stars">
                                        @php
                                            $main_stars=@$course->user->totalRating()['rating'];

                                            $stars=intval(@$course->user->totalRating()['rating']);

                                        @endphp
                                        @for ($i = 0; $i <  $stars; $i++)
                                            <i class="fas fa-star"></i>
                                        @endfor
                                        @if ($main_stars>$stars)
                                            <i class="fas fa-star-half"></i>
                                        @endif
                                        @if($main_stars==0)
                                            @for ($i = 0; $i <  5; $i++)
                                                <i class="far fa-star"></i>
                                            @endfor
                                        @endif
                                    </div>
                                    <p>{{@$course->user->totalRating()['rating']}}
                                        ({{@$course->user->totalRating()['total']}} {{__('frontend.rating')}})</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="video_screen theme__overlay mb_60">
                        <div class="video_play text-center">

                            @if (Auth::check())
                                @if ($isEnrolled)

                                    @if(@$course->class->host=="Zoom")
                                        @if(@$course->nextMeeting->currentStatus=="started")
                                            <a target="_blank"
                                               href="{{route('classStart', [$course->slug,'Zoom',$course->nextMeeting->id])}}"
                                               class="theme_btn d-block text-center height_50 mb_10">
                                                {{__('common.Watch Now')}}
                                            </a>
                                        @elseif (@$course->nextMeeting->currentStatus== 'waiting')
                                            <span
                                                class="theme_btn d-block text-center height_50 mb_10">
                                                {{__('frontend.Waiting')}}
                                           </span>
                                        @else
                                            @if($isWaiting)
                                                <span
                                                    class="theme_line_btn d-block text-center height_50 mb_10">
                                                    {{__('frontend.Waiting')}}
                                                </span>
                                            @else
                                                @if($certificateCanDownload)
                                                    <a href="{{route('getCertificate',[$course->id,$course->title])}}"
                                                       class="theme_btn certificate_btn mt-5">
                                                        {{__('frontend.Get Certificate')}}
                                                    </a>
                                                @else
                                                    <span
                                                        class="theme_line_btn d-block text-center height_50 mb_10">
                                                {{__('frontend.Closed')}}
                                            </span>
                                                @endif
                                            @endif

                                        @endif
                                    @endif
                                    @if(@$course->class->host=="BBB")
                                        @php
                                            $hasClass=false;
                                        @endphp
                                        @foreach($course->class->bbbMeetings as $key=>$meeting)
                                            @if(!$hasClass)
                                                @if(@$meeting->isRunning())
                                                    <a target="_blank"
                                                       href="{{route('classStart', [$course->slug,'BBB',$meeting->id])}}"
                                                       class="theme_btn d-block text-center height_50 mb_10">
                                                        {{__('common.Watch Now')}}
                                                    </a>
                                                    @php
                                                        $hasClass=true;
                                                    @endphp
                                                @endif
                                            @endif
                                        @endforeach
                                        @if(!$hasClass)
                                            @if($isWaiting)
                                                <span
                                                    class="theme_line_btn d-block text-center height_50 mb_10">
                                                    {{__('frontend.Waiting')}}
                                                </span>
                                            @else
                                                <span
                                                    class="theme_line_btn d-block text-center height_50 mb_10">
                                                {{__('frontend.Closed')}}
                                            </span>
                                            @endif
                                        @endif
                                    @endif
                                    @if(@$course->class->host=="Jitsi")
                                        @if($course->nextMeeting)
                                            @php
                                                $start = \Illuminate\Support\Carbon::parse($course->nextMeeting->date . ' ' .$course->nextMeeting->time);
                                                 $nowDate = \Illuminate\Support\Carbon::now();
                                                 $not_start = $start->gt($nowDate);

                                                 $end =$start->addMinutes($course->nextMeeting->duration);
                                                 $not_end =$end->gt($nowDate);
                                            @endphp
                                            @if(!$not_start && $not_end)
                                                <a target="_blank"
                                                   href="{{route('classStart', [$course->slug,'Jitsi',$course->nextMeeting->id])}}"
                                                   class="theme_btn d-block text-center height_50 mb_10">
                                                    {{__('common.Watch Now')}}
                                                </a>

                                            @else
                                                @if($isWaiting)
                                                    <span
                                                        class="theme_line_btn d-block text-center height_50 mb_10">
                                                    {{__('frontend.Waiting')}}
                                                </span>
                                                @else
                                                    <span
                                                        class="theme_line_btn d-block text-center height_50 mb_10">
                                                {{__('frontend.Closed')}}
                                            </span>
                                                @endif
                                            @endif
                                        @endif
                                    @endif

                                    @if(@$course->class->host=="Custom")
                                        @if($course->nextMeeting)
                                            @php
                                                $start = \Illuminate\Support\Carbon::parse($course->nextMeeting->date . ' ' .$course->nextMeeting->time);
                                                 $nowDate = \Illuminate\Support\Carbon::now();
                                                 $not_start = $start->gt($nowDate);

                                                 $end =$start->addMinutes($course->nextMeeting->duration);
                                                 $not_end =$end->gt($nowDate);
                                            @endphp
                                            @if(!$not_start && $not_end)
                                                <a target="_blank"
                                                   href="{{route('classStart', [$course->slug,'Custom',$course->nextMeeting->id])}}"
                                                   class="theme_btn d-block text-center height_50 mb_10">
                                                    {{__('common.Watch Now')}}
                                                </a>

                                            @else
                                                @if($isWaiting)
                                                    <span
                                                        class="theme_line_btn d-block text-center height_50 mb_10">
                                                    {{__('frontend.Waiting')}}
                                                </span>
                                                @else
                                                    <span
                                                        class="theme_line_btn d-block text-center height_50 mb_10">
                                                {{__('frontend.Closed')}}
                                            </span>
                                                @endif
                                            @endif
                                        @endif
                                    @endif
                                    @if(@$course->class->host=="InAppLiveClass")
                                        @if($course->nextMeeting)
                                            @php
                                                $start = \Illuminate\Support\Carbon::parse($course->nextMeeting->date . ' ' .$course->nextMeeting->time);
                                                 $nowDate = \Illuminate\Support\Carbon::now();
                                                 $not_start = $start->gt($nowDate);

                                                 $end =$start->addMinutes($course->nextMeeting->duration);
                                                 $not_end =$end->gt($nowDate);
                                            @endphp
                                            @if(!$not_start && $not_end)
                                                <a target="_blank"
                                                   href="{{route('classStart', [$course->slug,'InAppLiveClass',$course->nextMeeting->id])}}"
                                                   class="theme_btn d-block text-center height_50 mb_10">
                                                    {{__('common.Watch Now')}}
                                                </a>

                                            @else
                                                @if($isWaiting)
                                                    <span
                                                        class="theme_line_btn d-block text-center height_50 mb_10">
                                                    {{__('frontend.Waiting')}}
                                                </span>
                                                @else
                                                    <span
                                                        class="theme_line_btn d-block text-center height_50 mb_10">
                                                {{__('frontend.Closed')}}
                                            </span>
                                                @endif
                                            @endif
                                        @endif
                                    @endif
                                    @if(@$course->class->host=="GoogleMeet")

                                        @if(@$course->nextMeeting->currentStatus=="started")
                                            <a target="_blank"
                                               href="{{route('classStart', [$course->slug,'GoogleMeet',$course->nextMeeting->id])}}"
                                               class="theme_btn d-block text-center height_50 mb_10">
                                                {{__('common.Watch Now')}}
                                            </a>
                                        @elseif (@$course->nextMeeting->currentStatus== 'waiting')
                                            <span
                                                class="theme_btn d-block text-center height_50 mb_10">
                                                {{__('frontend.Waiting')}}
                                           </span>
                                        @else
                                            @if($isWaiting)
                                                <span
                                                    class="theme_line_btn d-block text-center height_50 mb_10">
                                                    {{__('frontend.Waiting')}}
                                                </span>
                                            @else
                                                @if($certificateCanDownload)
                                                    <a href="{{route('getCertificate',[$course->id,$course->title])}}"
                                                       class="theme_btn certificate_btn mt-5">
                                                        {{__('frontend.Get Certificate')}}
                                                    </a>
                                                @else
                                                    <span
                                                        class="theme_line_btn d-block text-center height_50 mb_10">
                                                {{__('frontend.Closed')}}
                                            </span>
                                                @endif
                                            @endif

                                        @endif
                                    @endif

                                @else
                                    @if(!onlySubscription())
                                        @if($isFree)
                                            @if($is_cart == 1)
                                                <a href="javascript:void(0)"
                                                   class="theme_btn d-block text-center height_50 mb_10">{{__('common.Added To Cart')}}</a>
                                            @else
                                                <a href="{{route('addToCart',[@$course->id])}}"
                                                   class="theme_btn d-block text-center height_50 mb_10">{{__('common.Add To Cart')}}</a>
                                            @endif
                                        @else
                                            <a href=" {{route('addToCart',[@$course->id])}} "
                                               class="theme_btn d-block text-center height_50 mb_10">{{__('common.Add To Cart')}}</a>
                                            <a href="{{route('buyNow',[@$course->id])}}"
                                               class="theme_line_btn d-block text-center height_50 mb_20">{{__('common.Buy Now')}}</a>
                                        @endif
                                    @endif
                                @endif

                            @else
                                @if(!onlySubscription())
                                    @if($isFree)
                                        <a href=" {{route('addToCart',[@$course->id])}} "
                                           class="theme_btn d-block text-center height_50 mb_10">{{__('common.Add To Cart')}}</a>
                                    @else
                                        <a href=" {{route('addToCart',[@$course->id])}} "
                                           class="theme_btn d-block text-center height_50 mb_10">{{__('common.Add To Cart')}}</a>
                                        <a href="{{route('buyNow',[@$course->id])}}"
                                           class="theme_line_btn d-block text-center height_50 mb_20">{{__('common.Buy Now')}}</a>
                                    @endif
                                @endif
                            @endif

                        </div>
                    </div>
                    <div class="row">
                        <div class="{{onlySubscription()?"col-xl-12 col-lg-12":"col-xl-8 col-lg-8"}}">
                            <div class="course_tabs text-center">
                                <ul class="w-100 nav lms_tabmenu justify-content-between  mb_55" id="myTab"
                                    role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="Overview-tab" data-bs-toggle="tab"
                                           href="#Overview"
                                           role="tab" aria-controls="Overview"
                                           aria-selected="true">{{__('frontend.Overview')}}</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="Curriculum-tab" data-bs-toggle="tab" href="#Curriculum"
                                           role="tab" aria-controls="Curriculum"
                                           aria-selected="false">{{__('frontend.Course Schedule')}}</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="Instructor-tab" data-bs-toggle="tab" href="#Instructor"
                                           role="tab" aria-controls="Instructor"
                                           aria-selected="false">{{__('frontend.Instructor')}}</a>
                                    </li>
                                    @if(Settings('hide_review_section')!='1')
                                        <li class="nav-item">
                                            <a class="nav-link" id="Reviews-tab" data-bs-toggle="tab" href="#Reviews"
                                               role="tab" aria-controls="Instructor"
                                               aria-selected="false">{{__('frontend.Reviews')}}</a>
                                        </li>
                                    @endif
                                    @if(Settings('hide_qa_section')!='1')
                                        <li class="nav-item">
                                            <a class="nav-link" id="QA-tab" data-bs-toggle="tab" href="#QASection"
                                               role="tab" aria-controls="Instructor"
                                               aria-selected="false">{{__('frontend.QA')}}</a>
                                        </li>
                                    @endif
                                </ul>
                            </div>
                            <div class="tab-content lms_tab_content" id="myTabContent">
                                <div class="tab-pane fade show active " id="Overview" role="tabpanel"
                                     aria-labelledby="Overview-tab">
                                    <!-- content  -->
                                    @if(isModuleActive('Installment') && $course_price > 0)
                                        @includeIf(theme('partials._installment_plan_details'), ['course' => $course,'position'=>'top_of_page'])
                                    @endif
                                    <div class="course_overview_description">
                                        <div class="row mb_40">
                                            <div class="col-12">
                                                <div class="description_grid">

                                                    <div class="single_description_grid">
                                                        <h5> {{__('common.Start Date & Time')}}</h5>
                                                        <p>
                                                            {{ showDate($course->class->start_date)}}  {{__('common.At')}}
                                                            {{date('h:i A', strtotime($course->class->time))}}
                                                        </p>
                                                    </div>
                                                    <div class="single_description_grid">
                                                        <h5> {{__('common.End Date & Time')}}</h5>
                                                        <p>{{showDate($course->class->end_date)}} {{__('common.At')}}
                                                            @php
                                                                $duration =$course->class->duration??0;

                                                            @endphp
                                                            {{date('h:i A', strtotime("+".$duration." minutes", strtotime($course->class->time)))}}
                                                        </p>
                                                    </div>

                                                    <div class="single_description_grid">
                                                        <h5> {{__('common.Duration')}}</h5>
                                                        @php

                                                            $days =1;
                                                            if ($course->class->host=="Zoom"){
                                                                $days=count($course->class->zoomMeetings);
                                                            }elseif($course->class->host=="BBB"){
                                                                $days=count($course->class->bbbMeetings);
                                                            }elseif ($course->class->host=="Jitsi"){
                                                                $days=count($course->class->jitsiMeetings);
                                                            }elseif ($course->class->host=="InAppLiveClass"){
                                                                $days=count($course->class->inAppMeetings);
                                                            }elseif ($course->class->host=="Custom"){
                                                                $days=count($course->class->customMeetings);
                                                            }

                                                                $str = ($course->class->duration?? 0)*$days;
                                                                $duration =preg_replace('/[^0-9]/', '', $str);

                                                        @endphp
                                                        <p class="nowrap">{{MinuteFormat($duration)}}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="single_overview">
                                            <h4 class="font_22 f_w_700 mb_20">{{__('frontend.Course Description')}}</h4>
                                            <div class="theme_border"></div>
                                            <div class="">
                                                {!! $course->about !!}
                                            </div>
                                            <p class="mb_20">

                                            </p>
                                            @if(isModuleActive('Installment') && $course_price > 0)
                                                @includeIf(theme('partials._installment_plan_details'), ['course' => $course,'position'=>'bottom_of_page'])
                                            @endif
                                            @if(!Settings('hide_social_share_btn') =='1')
                                                <div class="social_btns">
                                                    <a target="_blank"
                                                       href="https://www.facebook.com/sharer/sharer.php?u={{URL::current()}}"
                                                       class="social_btn fb_bg"> <i class="fab fa-facebook-f"></i>
                                                        {{__('frontend.Facebook')}}</a>
                                                    <a target="_blank"
                                                       href="https://twitter.com/intent/tweet?text={{$course->title}}&amp;url={{URL::current()}}"
                                                       class="social_btn Twitter_bg"> <i
                                                            class="fab fa-twitter"></i> {{__('frontend.Twitter')}}</a>
                                                    <a target="_blank"
                                                       href="https://pinterest.com/pin/create/link/?url={{URL::current()}}&amp;description={{$course->title}}"
                                                       class="social_btn Pinterest_bg"> <i
                                                            class="fab fa-pinterest-p"></i> {{__('frontend.Pinterest')}}
                                                    </a>
                                                    <a target="_blank"
                                                       href="https://www.linkedin.com/shareArticle?mini=true&amp;url={{URL::current()}}&amp;title={{$course->title}}&amp;summary={{$course->title}}"
                                                       class="social_btn Linkedin_bg"> <i
                                                            class="fab fa-linkedin-in"></i> {{__('frontend.Linkedin')}}
                                                    </a>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <!--/ content  -->
                                </div>
                                <div class="tab-pane fade " id="Curriculum" role="tabpanel"
                                     aria-labelledby="Curriculum-tab">
                                    <!-- content  -->
                                    <h4 class="font_22 f_w_700 mb_20">{{__('frontend.Course Schedule')}}</h4>

                                    <div class="single_description mb_25">


                                        @if($course->class->host=="BBB")
                                            @foreach($course->class->bbbMeetings as $key=>$meeting)
                                                <div class="row justify-content-between text-center p-3 m-2"
                                                     style="border:1px solid #E1E2E6">
                                                    <div class="{{$allow?'col-sm-3':'col-sm-4'}} margin_auto "
                                                         style="border-right: 1px solid #E1E2E6;">
                                                        <span>
                                                      {{__('common.Start Date')}}
                                                    </span>

                                                        <h6 class="mb-0">{{date('d M Y',$meeting->datetime)}}  </h6>
                                                    </div>
                                                    <div class="{{$allow?'col-sm-3':'col-sm-4'}} margin_auto"
                                                         style="border-right: 1px solid #E1E2E6;">
                                                         <span>
                                                       {{__('common.Time')}} <br>
                                                             ({{__('common.Start')}} - {{__('common.End')}})
                                                    </span>
                                                        <h6 class="mb-0">{{date('g:i A',$meeting->datetime)}}
                                                            - @if($meeting->duration==0)
                                                                N/A
                                                            @else
                                                                {{date('g:i A',$meeting->datetime+($meeting->duration*60))}}
                                                            @endif</h6>

                                                    </div>
                                                    <div class="{{$allow?'col-sm-3':'col-sm-4'}} margin_auto"
                                                         style="{{$allow?'border-right: 1px solid #E1E2E6;':''}}">
                                                        <span>
                                                       {{__('common.Duration')}}
                                                    </span>
                                                        @php

                                                            $str = $meeting->duration?? 0;
                                                            $duration =preg_replace('/[^0-9]/', '', $str);

                                                        @endphp
                                                        <h6 class="mb-0 nowrap">{{MinuteFormat($duration)}}</h6>
                                                    </div>


                                                    @if (Auth::check() &&  $isEnrolled)

                                                        <div class="col-sm-3 margin_auto">

                                                            @if(@$meeting->isRunning())
                                                                <a target="_blank"
                                                                   href="{{route('classStart', [$course->slug,'BBB',$meeting->id])}}"
                                                                   class="theme_btn small_btn2 d-block text-center height_50   p-3 ">
                                                                    {{__('common.Watch Now')}}
                                                                </a>

                                                            @else

                                                                @php
                                                                    $last_time = Illuminate\Support\Carbon::parse($meeting->date. ' ' . $meeting->time);
                                                                   $nowDate = Illuminate\Support\Carbon::now();
                                                                   $isWaiting = $last_time->gt($nowDate);

                                                                @endphp
                                                                @if($isWaiting)
                                                                    <span
                                                                        class="theme_btn small_btn2 d-block text-center height_50   p-3 ">
                                                                    {{__('frontend.Waiting')}}
                                                                </span>
                                                                @else
                                                                    <span
                                                                        class="theme_btn small_btn2 d-block text-center height_50   p-3 ">
                                                                    {{__('frontend.Closed')}}
                                                                </span>
                                                                @endif

                                                            @endif
                                                        </div>
                                                    @endif


                                                </div>
                                            @endforeach

                                        @elseif($course->class->host=="Jitsi")

                                            @foreach($course->class->jitsiMeetings as $key=>$meeting)
                                                <div class="row justify-content-between text-center p-3 m-2"
                                                     style="border:1px solid #E1E2E6">
                                                    <div class="{{$allow?'col-sm-3':'col-sm-4'}} margin_auto"
                                                         style="border-right: 1px solid #E1E2E6;">
                                                        <span>
                                                        {{__('common.Start Date')}}
                                                    </span>

                                                        <h6 class="mb-0">{{date('d M Y',$meeting->datetime)}}  </h6>
                                                    </div>
                                                    <div class="{{$allow?'col-sm-3':'col-sm-4'}} margin_auto"
                                                         style="border-right: 1px solid #E1E2E6;">
                                                         <span>
                                                        {{__('common.Time')}} <br>
                                                             ({{__('common.Start')}} - {{__('common.End')}})
                                                    </span>
                                                        <h6 class="mb-0">{{date('g:i A',$meeting->datetime)}}
                                                            - @if($meeting->duration==0)
                                                                N/A
                                                            @else
                                                                {{date('g:i A',$meeting->datetime+($meeting->duration*60))}}
                                                            @endif</h6>

                                                    </div>
                                                    <div class="{{$allow?'col-sm-3':'col-sm-4'}} margin_auto"
                                                         style="{{$allow?'border-right: 1px solid #E1E2E6;':''}}">
                                                        <span>
                                                       {{__('common.Duration')}}
                                                    </span>
                                                        @php
                                                            $str = $meeting->duration?? 0;
                                                            $duration =preg_replace('/[^0-9]/', '', $str);

                                                        @endphp
                                                        <h6 class="mb-0 nowrap">{{MinuteFormat($duration)}}</h6>
                                                    </div>


                                                    @if (Auth::check() &&  $isEnrolled)

                                                        <div class="col-sm-3 margin_auto">
                                                            @php
                                                                $start = \Illuminate\Support\Carbon::parse($meeting->date . ' ' .$meeting->time);
                                                                 $nowDate = \Illuminate\Support\Carbon::now();
                                                                 $not_start = $start->gt($nowDate);
                                                                 $end =$start->addMinutes($meeting->duration);
                                                                 $not_end =$end->gt($nowDate);
                                                            @endphp
                                                            @if(!$not_start && $not_end)

                                                                <a target="_blank"
                                                                   href="{{route('classStart', [$course->slug,'Jitsi',$meeting->id])}}"
                                                                   class="theme_btn small_btn2 d-block text-center height_50   p-3 ">
                                                                    {{__('common.Watch Now')}}
                                                                </a>

                                                            @else

                                                                @php
                                                                    $last_time = Illuminate\Support\Carbon::parse($meeting->date. ' ' . $meeting->time);
                                                                   $nowDate = Illuminate\Support\Carbon::now();
                                                                   $isWaiting = $last_time->gt($nowDate);

                                                                @endphp
                                                                @if($isWaiting)
                                                                    <span
                                                                        class="theme_btn small_btn2 d-block text-center height_50   p-3 ">
                                                                    {{__('frontend.Waiting')}}
                                                                </span>
                                                                @else
                                                                    <span
                                                                        class="theme_btn small_btn2 d-block text-center height_50   p-3 ">
                                                                    {{__('frontend.Closed')}}
                                                                </span>
                                                                @endif
                                                            @endif
                                                        </div>
                                                    @endif


                                                </div>
                                            @endforeach

                                        @elseif($course->class->host=="Custom")

                                            @foreach($course->class->customMeetings as $key=>$meeting)
                                                <div class="row justify-content-between text-center p-3 m-2"
                                                     style="border:1px solid #E1E2E6">
                                                    <div class="{{$allow?'col-sm-3':'col-sm-4'}} margin_auto"
                                                         style="border-right: 1px solid #E1E2E6;">
                                                        <span>
                                                        {{__('common.Start Date')}}
                                                    </span>

                                                        <h6 class="mb-0">{{date('d M Y',$meeting->datetime)}}  </h6>
                                                    </div>
                                                    <div class="{{$allow?'col-sm-3':'col-sm-4'}} margin_auto"
                                                         style="border-right: 1px solid #E1E2E6;">
                                                         <span>
                                                        {{__('common.Time')}} <br>
                                                             ({{__('common.Start')}} - {{__('common.End')}})
                                                    </span>
                                                        <h6 class="mb-0">{{date('g:i A',$meeting->datetime)}}
                                                            - @if($meeting->duration==0)
                                                                N/A
                                                            @else
                                                                {{date('g:i A',$meeting->datetime+($meeting->duration*60))}}
                                                            @endif</h6>

                                                    </div>
                                                    <div class="{{$allow?'col-sm-3':'col-sm-4'}} margin_auto"
                                                         style="{{$allow?'border-right: 1px solid #E1E2E6;':''}}">
                                                        <span>
                                                       {{__('common.Duration')}}
                                                    </span>
                                                        @php
                                                            $str = $meeting->duration?? 0;
                                                            $duration =preg_replace('/[^0-9]/', '', $str);

                                                        @endphp
                                                        <h6 class="mb-0 nowrap">{{MinuteFormat($duration)}}</h6>
                                                    </div>


                                                    @if (Auth::check() &&  $isEnrolled)

                                                        <div class="col-sm-3 margin_auto">
                                                            @php
                                                                $start = \Illuminate\Support\Carbon::parse($meeting->date . ' ' .$meeting->time);
                                                                 $nowDate = \Illuminate\Support\Carbon::now();
                                                                 $not_start = $start->gt($nowDate);
                                                                 $end =$start->addMinutes($meeting->duration);
                                                                 $not_end =$end->gt($nowDate);
                                                            @endphp
                                                            @if(!$not_start && $not_end && !empty($meeting->link))

                                                                <a target="_blank"
                                                                   href="{{route('classStart', [$course->slug,'Custom',$meeting->id])}}"
                                                                   class="theme_btn small_btn2 d-block text-center height_50   p-3 ">
                                                                    {{__('common.Watch Now')}}
                                                                </a>

                                                            @else

                                                                @php
                                                                    $last_time = Illuminate\Support\Carbon::parse($meeting->date. ' ' . $meeting->time);
                                                                   $nowDate = Illuminate\Support\Carbon::now();
                                                                   $isWaiting = $last_time->gt($nowDate);

                                                                @endphp
                                                                @if($isWaiting)
                                                                    <span
                                                                        class="theme_btn small_btn2 d-block text-center height_50   p-3 ">
                                                                    {{__('frontend.Waiting')}}
                                                                </span>
                                                                @else
                                                                    <span
                                                                        class="theme_btn small_btn2 d-block text-center height_50   p-3 ">
                                                                    {{__('frontend.Closed')}}
                                                                </span>
                                                                @endif
                                                            @endif
                                                        </div>
                                                    @endif


                                                </div>
                                            @endforeach
                                        @elseif($course->class->host=="InAppLiveClass")

                                            @foreach($course->class->inAppMeetings as $key=>$meeting)
                                                <div class="row justify-content-between text-center p-3 m-2"
                                                     style="border:1px solid #E1E2E6">
                                                    <div class="{{$allow?'col-sm-3':'col-sm-4'}} margin_auto"
                                                         style="border-right: 1px solid #E1E2E6;">
                                                        <span>
                                                        {{__('common.Start Date')}}
                                                    </span>

                                                        <h6 class="mb-0">{{date('d M Y',$meeting->datetime)}}  </h6>
                                                    </div>
                                                    <div class="{{$allow?'col-sm-3':'col-sm-4'}} margin_auto"
                                                         style="border-right: 1px solid #E1E2E6;">
                                                         <span>
                                                        {{__('common.Time')}} <br>
                                                             ({{__('common.Start')}} - {{__('common.End')}})
                                                    </span>
                                                        <h6 class="mb-0">{{date('g:i A',$meeting->datetime)}}
                                                            - @if($meeting->duration==0)
                                                                N/A
                                                            @else
                                                                {{date('g:i A',$meeting->datetime+($meeting->duration*60))}}
                                                            @endif</h6>

                                                    </div>
                                                    <div class="{{$allow?'col-sm-3':'col-sm-4'}} margin_auto"
                                                         style="{{$allow?'border-right: 1px solid #E1E2E6;':''}}">
                                                        <span>
                                                       {{__('common.Duration')}}
                                                    </span>
                                                        @php
                                                            $str = $meeting->duration?? 0;
                                                            $duration =preg_replace('/[^0-9]/', '', $str);

                                                        @endphp
                                                        <h6 class="mb-0 nowrap">{{MinuteFormat($duration)}}</h6>
                                                    </div>


                                                    @if (Auth::check() &&  $isEnrolled)

                                                        <div class="col-sm-3 margin_auto">
                                                            @php
                                                                $start = \Illuminate\Support\Carbon::parse($meeting->date . ' ' .$meeting->time);
                                                                 $nowDate = \Illuminate\Support\Carbon::now();
                                                                 $not_start = $start->gt($nowDate);
                                                                 $end =$start->addMinutes($meeting->duration);
                                                                 $not_end =$end->gt($nowDate);
                                                            @endphp
                                                            @if(!$not_start && $not_end)

                                                                <a target="_blank"
                                                                   href="{{route('classStart', [$course->slug,'InAppLiveClass',$meeting->id])}}"
                                                                   class="theme_btn small_btn2 d-block text-center height_50   p-3 ">
                                                                    {{__('common.Watch Now')}}
                                                                </a>

                                                            @else

                                                                @php
                                                                    $last_time = Illuminate\Support\Carbon::parse($meeting->date. ' ' . $meeting->time);
                                                                   $nowDate = Illuminate\Support\Carbon::now();
                                                                   $isWaiting = $last_time->gt($nowDate);

                                                                @endphp
                                                                @if($isWaiting)
                                                                    <span
                                                                        class="theme_btn small_btn2 d-block text-center height_50   p-3 ">
                                                                    {{__('frontend.Waiting')}}
                                                                </span>
                                                                @else
                                                                    <span
                                                                        class="theme_btn small_btn2 d-block text-center height_50   p-3 ">
                                                                    {{__('frontend.Closed')}}
                                                                </span>
                                                                @endif
                                                            @endif
                                                        </div>
                                                    @endif


                                                </div>
                                            @endforeach

                                        @elseif($course->class->host=="Zoom")
                                            @foreach($course->class->zoomMeetings as $key=>$meeting)

                                                <div class="row justify-content-between text-center p-3 m-2"
                                                     style="border:1px solid #E1E2E6">
                                                    <div class="{{$allow?'col-sm-3':'col-sm-4'}} margin_auto"
                                                         style="border-right: 1px solid #E1E2E6;">
                                                        <span>
                                                     {{__('common.Start Date')}}
                                                    </span>

                                                        <h6 class="mb-0">{{date('d M Y',strtotime($meeting->start_time))}}  </h6>
                                                    </div>
                                                    <div class="{{$allow?'col-sm-3':'col-sm-4'}} margin_auto"
                                                         style="border-right: 1px solid #E1E2E6;">
                                                         <span>
                                                       {{__('common.Time')}} <br>
                                                             ({{__('common.Start')}} - {{__('common.End')}})
                                                    </span>
                                                        <h6 class="mb-0">{{date('g:i A',strtotime($meeting->start_time))}}
                                                            -{{date('g:i A',strtotime($meeting->end_time))}}</h6>


                                                    </div>
                                                    <div class="{{$allow?'col-sm-3':'col-sm-4'}} margin_auto"
                                                         style="{{$allow?'border-right: 1px solid #E1E2E6;':''}}">
                                                        <span>
                                                       {{__('common.Duration')}}
                                                    </span>
                                                        @php

                                                            $str = $meeting->meeting_duration?? 0;
                                                            $duration =preg_replace('/[^0-9]/', '', $str);


                                                        @endphp
                                                        <h6 class="mb-0 nowrap">{{MinuteFormat($duration)}}</h6>
                                                    </div>


                                                    @if (Auth::check() &&  $isEnrolled)
                                                        <div class="col-sm-3 margin_auto">
                                                            @if(@$meeting->currentStatus=="started")
                                                                <a target="_blank"
                                                                   href="{{route('classStart', [$course->slug,'Zoom',$meeting->id])}}"
                                                                   class="theme_btn small_btn2 d-block text-center height_50   p-3 ">
                                                                    {{__('common.Watch Now')}}
                                                                </a>
                                                            @elseif (@$meeting->currentStatus== 'waiting')
                                                                <span
                                                                    class="theme_line_btn  small_btn2 d-block text-center height_50   p-3 ">
                                                                    {{__('frontend.Waiting')}}
                                                               </span>
                                                            @else
                                                                <span
                                                                    class="theme_line_btn  small_btn2 d-block text-center height_50   p-3 ">
                                                                    {{__('frontend.Closed')}}
                                                                </span>
                                                            @endif
                                                        </div>
                                                    @endif
                                                </div>
                                            @endforeach

                                        @elseif($course->class->host=="GoogleMeet")
                                            @foreach($course->class->googleMeetMeetings as $key=>$meeting)

                                                <div class="row justify-content-between text-center p-3 m-2"
                                                     style="border:1px solid #E1E2E6">
                                                    <div class="{{$allow?'col-sm-3':'col-sm-4'}} margin_auto"
                                                         style="border-right: 1px solid #E1E2E6;">
                                                    <span>
                                                 {{__('common.Start Date')}}
                                                </span>

                                                        <h6 class="mb-0">{{date('d M Y',strtotime($meeting->start_date_time))}}  </h6>
                                                    </div>
                                                    <div class="{{$allow?'col-sm-3':'col-sm-4'}} margin_auto"
                                                         style="border-right: 1px solid #E1E2E6;">
                                                     <span>
                                                   {{__('common.Time')}} <br>
                                                         ({{__('common.Start')}} - {{__('common.End')}})
                                                </span>
                                                        <h6 class="mb-0">{{date('g:i A',strtotime($meeting->start_date_time))}}
                                                            -{{date('g:i A',strtotime($meeting->end_date_time))}}</h6>


                                                    </div>
                                                    <div class="{{$allow?'col-sm-3':'col-sm-4'}} margin_auto"
                                                         style="{{$allow?'border-right: 1px solid #E1E2E6;':''}}">
                                                    <span>
                                                   {{__('common.Duration')}}
                                                </span>

                                                        <h6 class="mb-0 nowrap">{{MinuteFormat(\Carbon\Carbon::parse($meeting->start_date_time)->diffInMinutes($meeting->end_date_time))}}</h6>
                                                    </div>


                                                    @if (Auth::check() &&  $isEnrolled)
                                                        <div class="col-sm-3 margin_auto">
                                                            @if(@$meeting->currentStatus=="started")
                                                                <a target="_blank"
                                                                   href="{{route('classStart', [$course->slug,'GoogleMeet',$meeting->id])}}"
                                                                   class="theme_btn small_btn2 d-block text-center height_50   p-3 ">
                                                                    {{__('common.Watch Now')}}
                                                                </a>
                                                            @elseif (@$meeting->currentStatus== 'waiting')
                                                                <span
                                                                    class="theme_line_btn  small_btn2 d-block text-center height_50   p-3 ">
                                                                {{__('frontend.Waiting')}}
                                                           </span>
                                                            @else
                                                                <span
                                                                    class="theme_line_btn  small_btn2 d-block text-center height_50   p-3 ">
                                                                {{__('frontend.Closed')}}
                                                            </span>
                                                            @endif
                                                        </div>
                                                    @endif
                                                </div>
                                            @endforeach

                                        @endif
                                    </div>

                                </div>
                                <div class="tab-pane fade " id="Instructor" role="tabpanel"
                                     aria-labelledby="Instructor-tab">
                                    <div class="instractor_details_wrapper">
                                        <div class="instractor_title">
                                            <h4 class="font_22 f_w_700">{{__('frontend.Instructor')}}</h4>
                                            <p class="font_16 f_w_400">{{@$course->user->headline}}</p>
                                        </div>
                                        <div class="instractor_details_inner">
                                            <div class="thumb">
                                                <img class="w-100"
                                                     src="{{getProfileImage(@$course->user->image,$course->user->name)}}"
                                                     alt="">
                                            </div>
                                            <div class="instractor_details_info">
                                                <a href="{{route('instructorDetails',[$course->user->id,$course->user->name])}}">
                                                    <h4 class="font_22 f_w_700">{{@$course->user->name}}</h4>
                                                </a>
                                                <h5>  {{@$course->user->headline}}</h5>
                                                <div class="ins_details">
                                                    <p>{!! @$course->user->short_details !!}</p>
                                                </div>
                                                <div class="intractor_qualification">
                                                    <div class="single_qualification">
                                                        <i class="ti-star"></i> {{@$course->user->totalRating()['rating']}}
                                                        {{__('frontend.Rating')}}
                                                    </div>
                                                    <div class="single_qualification">
                                                        <i class="ti-comments"></i> {{@$course->user->totalRating()['total']}}
                                                        {{__('frontend.Reviews')}}
                                                    </div>
                                                    <div class="single_qualification">
                                                        <i class="ti-user"></i> {{@$course->user->totalEnrolled()}}
                                                        {{__('frontend.Students')}}
                                                    </div>
                                                    <div class="single_qualification">
                                                        <i class="ti-layout-media-center-alt"></i> {{@$course->user->totalCourses()}}
                                                        {{__('frontend.Courses')}}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <p>
                                            {!! @$course->user->about !!}                                        </p>
                                    </div>
                                    <div class="author_courses">
                                        <div class="section__title mb_80">
                                            <h3>{{__('frontend.More Courses by Author')}}</h3>
                                        </div>
                                        <div class="row">
                                            @foreach(@$course->user->courses->take(2) as $c)
                                                <div class="col-xl-6">
                                                    <div class="couse_wizged mb_30">
                                                        <div class="thumb">
                                                            <a href="{{courseDetailsUrl(@$c->id,@$c->type,@$c->slug)}}">
                                                                <img class="w-100"
                                                                     src="{{ file_exists($c->thumbnail) ? asset($c->thumbnail) : asset('public/\uploads/course_sample.png') }}"
                                                                     alt="">

                                                                <x-price-tag :price="$course->price"
                                                                             :discount="$course->discount_price"/>

                                                            </a>
                                                        </div>
                                                        <div class="course_content">
                                                            <a href="{{courseDetailsUrl(@$c->id,@$c->type,@$c->slug)}}">
                                                                <h4>{{@$c->title}}</h4>
                                                            </a>
                                                            <div class="rating_cart">
                                                                <div class="rateing">
                                                                    <span>{{$c->totalReview}}/5</span>
                                                                    <i class="fas fa-star"></i>
                                                                </div>
                                                                @auth()
                                                                    @if(!$c->isLoginUserEnrolled && !$c->isLoginUserCart)
                                                                        <a href="#" class="cart_store"
                                                                           data-id="{{$c->id}}">
                                                                            <i class="fas fa-shopping-cart"></i>
                                                                        </a>
                                                                    @endif
                                                                @endauth
                                                                @guest()
                                                                    @if(!$c->isGuestUserCart)
                                                                        <a href="#" class="cart_store"
                                                                           data-id="{{$c->id}}">
                                                                            <i class="fas fa-shopping-cart"></i>
                                                                        </a>
                                                                    @endif
                                                                @endguest
                                                            </div>
                                                            <div class="course_less_students">
                                                                <a href="#"> <i
                                                                        class="ti-agenda"></i> {{count($c->lessons)}}
                                                                    {{__('frontend.Lessons')}}</a>
                                                                <a href="#"> <i
                                                                        class="ti-user"></i> {{$c->total_enrolled}}
                                                                    {{__('frontend.Students')}} </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade " id="Reviews" role="tabpanel" aria-labelledby="Reviews-tab">
                                    <!-- content  -->
                                    <div class="course_review_wrapper">
                                        <div class="details_title">
                                            <h4 class="font_22 f_w_700">{{__('frontend.Student Feedback')}}</h4>
                                            <p class="font_16 f_w_400">{{$course->title}}</p>
                                        </div>
                                        <div class="course_feedback">
                                            <div class="course_feedback_left">
                                                <h2>{{$course->total_rating}}</h2>
                                                <div class="feedmak_stars">
                                                    @php

                                                        $main_stars=$course->total_rating;
                                                        $stars=intval($main_stars);

                                                    @endphp
                                                    @for ($i = 0; $i <  $stars; $i++)
                                                        <i class="fas fa-star"></i>
                                                    @endfor
                                                    @if ($main_stars>$stars)
                                                        <i class="fas fa-star-half"></i>
                                                    @endif
                                                    @if($main_stars==0)
                                                        @for ($i = 0; $i <  5; $i++)
                                                            <i class="far fa-star"></i>
                                                        @endfor
                                                    @endif
                                                </div>
                                                <span>{{__('frontend.Course Rating')}}</span>
                                            </div>
                                            <div class="feedbark_progressbar">
                                                <div class="single_progrssbar">
                                                    <div class="progress">
                                                        <div class="progress-bar" role="progressbar"
                                                             style="width: {{getPercentageRating($course->starWiseReview,5)}}%"
                                                             aria-valuenow="{{getPercentageRating($course->starWiseReview,5)}}"
                                                             aria-valuemin="0" aria-valuemax="100">
                                                        </div>
                                                    </div>
                                                    <div class="rating_percent d-flex align-items-center">
                                                        <div class="feedmak_stars d-flex align-items-center">
                                                            <i class="fas fa-star"></i>
                                                            <i class="fas fa-star"></i>
                                                            <i class="fas fa-star"></i>
                                                            <i class="fas fa-star"></i>
                                                            <i class="fas fa-star"></i>
                                                        </div>
                                                        <span>{{getPercentageRating($course->starWiseReview,5)}}%</span>
                                                    </div>
                                                </div>
                                                <div class="single_progrssbar">
                                                    <div class="progress">
                                                        <div class="progress-bar" role="progressbar"
                                                             style="width: {{getPercentageRating($course->starWiseReview,4)}}%"
                                                             aria-valuenow="{{getPercentageRating($course->starWiseReview,4)}}"
                                                             aria-valuemin="0" aria-valuemax="100">
                                                        </div>
                                                    </div>
                                                    <div class="rating_percent d-flex align-items-center">
                                                        <div class="feedmak_stars d-flex align-items-center">
                                                            <i class="fas fa-star"></i>
                                                            <i class="fas fa-star"></i>
                                                            <i class="fas fa-star"></i>
                                                            <i class="fas fa-star"></i>
                                                            <i class="far fa-star"></i>
                                                        </div>
                                                        <span>{{getPercentageRating($course->starWiseReview,4)}}%</span>
                                                    </div>
                                                </div>
                                                <div class="single_progrssbar">
                                                    <div class="progress">
                                                        <div class="progress-bar" role="progressbar"
                                                             style="width: {{getPercentageRating($course->starWiseReview,3)}}%"
                                                             aria-valuenow="{{getPercentageRating($course->starWiseReview,3)}}"
                                                             aria-valuemin="0" aria-valuemax="100">
                                                        </div>
                                                    </div>
                                                    <div class="rating_percent d-flex align-items-center">
                                                        <div class="feedmak_stars d-flex align-items-center">
                                                            <i class="fas fa-star"></i>
                                                            <i class="fas fa-star"></i>
                                                            <i class="fas fa-star"></i>
                                                            <i class="far fa-star"></i>
                                                            <i class="far fa-star"></i>

                                                        </div>
                                                        <span>{{getPercentageRating($course->starWiseReview,3)}}%</span>
                                                    </div>
                                                </div>
                                                <div class="single_progrssbar">
                                                    <div class="progress">
                                                        <div class="progress-bar" role="progressbar"
                                                             style="width: {{getPercentageRating($course->starWiseReview,2)}}%"
                                                             aria-valuenow="{{getPercentageRating($course->starWiseReview,2)}}"
                                                             aria-valuemin="0" aria-valuemax="100">
                                                        </div>
                                                    </div>
                                                    <div class="rating_percent d-flex align-items-center">
                                                        <div class="feedmak_stars d-flex align-items-center">
                                                            <i class="fas fa-star"></i>
                                                            <i class="fas fa-star"></i>
                                                            <i class="far fa-star"></i>
                                                            <i class="far fa-star"></i>
                                                            <i class="far fa-star"></i>
                                                        </div>
                                                        <span>{{getPercentageRating($course->starWiseReview,2)}}%</span>
                                                    </div>
                                                </div>
                                                <div class="single_progrssbar">
                                                    <div class="progress">
                                                        <div class="progress-bar" role="progressbar"
                                                             style="width: {{getPercentageRating($course->starWiseReview,1)}}%"
                                                             aria-valuenow="{{getPercentageRating($course->starWiseReview,1)}}"
                                                             aria-valuemin="0" aria-valuemax="100">
                                                        </div>
                                                    </div>
                                                    <div class="rating_percent d-flex align-items-center">
                                                        <div class="feedmak_stars d-flex align-items-center">
                                                            <i class="fas fa-star"></i>
                                                            <i class="far fa-star"></i>
                                                            <i class="far fa-star"></i>
                                                            <i class="far fa-star"></i>
                                                            <i class="far fa-star"></i>
                                                        </div>
                                                        <span>{{getPercentageRating($course->starWiseReview,1)}}%</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="course_review_header mb_20">
                                            <div class="row align-items-center">
                                                <div class="col-md-6">
                                                    <div class="review_poients">
                                                        @if ($course->reviews->count()<1)
                                                            @if (Auth::check() && $isEnrolled)
                                                                <p class="theme_color font_16 mb-0">{{ __('frontend.Be the first reviewer') }}</p>
                                                            @else

                                                                <p class="theme_color font_16 mb-0">{{ __('frontend.No Review found') }}</p>
                                                            @endif

                                                        @else


                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="rating_star text-end">

                                                        @php
                                                            $PickId=$course->id;
                                                        @endphp
                                                        @if (Auth::check() && Auth::user()->role_id==3)
                                                            @if (!in_array(Auth::user()->id,$reviewer_user_ids) && $isEnrolled)

                                                                <div
                                                                    class="star_icon d-flex align-items-center justify-content-end">
                                                                    <a class="rating">
                                                                        <input type="radio" id="star5" name="rating"
                                                                               value="5"
                                                                               class="rating"/><label
                                                                            class="full" for="star5" id="star5"
                                                                            title="Awesome - 5 stars"
                                                                            onclick="Rates(5, {{@$PickId }})"></label>

                                                                        <input type="radio" id="star4" name="rating"
                                                                               value="4"
                                                                               class="rating"/><label
                                                                            class="full" for="star4"
                                                                            title="Pretty good - 4 stars"
                                                                            onclick="Rates(4, {{@$PickId }})"></label>

                                                                        <input type="radio" id="star3" name="rating"
                                                                               value="3"
                                                                               class="rating"/><label
                                                                            class="full" for="star3"
                                                                            title="Meh - 3 stars"
                                                                            onclick="Rates(3, {{@$PickId }})"></label>

                                                                        <input type="radio" id="star2" name="rating"
                                                                               value="2"
                                                                               class="rating"/><label
                                                                            class="full" for="star2"
                                                                            title="Kinda bad - 2 stars"
                                                                            onclick="Rates(2, {{@$PickId }})"></label>

                                                                        <input type="radio" id="star1" name="rating"
                                                                               value="1"
                                                                               class="rating"/><label
                                                                            class="full" for="star1"
                                                                            title="Bad  - 1 star"
                                                                            onclick="Rates(1,{{@$PickId }})"></label>

                                                                    </a>
                                                                </div>
                                                            @endif
                                                        @else

                                                            <p class="font_14 f_w_400 mt-0"><a href="{{url('login')}}"
                                                                                               class="theme_color2">Sign
                                                                    In</a>
                                                                or <a
                                                                    class="theme_color2" href="{{url('register')}}">Sign
                                                                    Up</a>
                                                                as student to post a review</p>
                                                        @endif

                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="course_cutomer_reviews">
                                            <div class="details_title">
                                                <h4 class="font_22 f_w_700">{{__('frontend.Reviews')}}</h4>

                                            </div>
                                            <div class="customers_reviews" id="customers_reviews">


                                            </div>
                                        </div>

                                        <div class="author_courses">
                                            <div class="section__title mb_80">
                                                <h3>{{__('frontend.Course you might like')}}</h3>
                                            </div>
                                            <div class="row">
                                                @foreach(@$related as $r)
                                                    <div class="col-xl-6">
                                                        <div class="couse_wizged mb_30">
                                                            <div class="thumb">
                                                                <a href="{{courseDetailsUrl(@$r->id,@$r->type,@$r->slug)}}">
                                                                    <img class="w-100"
                                                                         src="{{ file_exists($r->thumbnail) ? asset($r->thumbnail) : asset('public/\uploads/course_sample.png') }}"
                                                                         alt="">
                                                                    <x-price-tag :price="$course->price"
                                                                                 :discount="$course->discount_price"/>
                                                                </a>
                                                            </div>
                                                            <div class="course_content">
                                                                <a href="{{courseDetailsUrl(@$r->id,@$r->type,@$r->slug)}}">
                                                                    <h4>{{@$r->title}}</h4>
                                                                </a>
                                                                <div class="rating_cart">
                                                                    <div class="rateing">
                                                                        <span>{{$r->totalReview}}/5</span>
                                                                        <i class="fas fa-star"></i>
                                                                    </div>
                                                                    @auth()
                                                                        @if(!$r->isLoginUserEnrolled && !$r->isLoginUserCart)
                                                                            <a href="#" class="cart_store"
                                                                               data-id="{{$r->id}}">
                                                                                <i class="fas fa-shopping-cart"></i>
                                                                            </a>
                                                                        @endif
                                                                    @endauth
                                                                    @guest()
                                                                        @if(!$r->isGuestUserCart)
                                                                            <a href="#" class="cart_store"
                                                                               data-id="{{$r->id}}">
                                                                                <i class="fas fa-shopping-cart"></i>
                                                                            </a>
                                                                        @endif
                                                                    @endguest
                                                                </div>
                                                                <div class="course_less_students">
                                                                    <a href="#"> <i
                                                                            class="ti-agenda"></i> {{count($r->lessons)}}
                                                                        {{__('frontend.Lessons')}}</a>
                                                                    <a href="#"> <i
                                                                            class="ti-user"></i> {{$r->total_enrolled}}
                                                                        {{__('frontend.Students')}} </a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    <!-- content  -->
                                </div>

                                <div class="tab-pane fade " id="QASection" role="tabpanel" aria-labelledby="QA-tab">
                                    <!-- content  -->

                                    <div class="conversition_box">
                                        <div id="conversition_box"></div>
                                        <div class="row">
                                            @if ($isEnrolled)
                                                <div class="col-lg-12 " id="mainComment">
                                                    <form action="{{route('saveComment')}}" method="post" class="">
                                                        @csrf
                                                        <input type="hidden" name="course_id" value="{{@$course->id}}">
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <div class="section_title3 mb_20">
                                                                    <h3>{{__('frontend.Leave a question/comment') }}</h3>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-12">
                                                                <div class="single_input mb_25">
                                                                                        <textarea
                                                                                            placeholder="{{__('frontend.Leave a question/comment') }}"
                                                                                            name="comment"
                                                                                            class="primary_textarea gray_input"></textarea>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-12 mb_30">

                                                                <button type="submit"
                                                                        class="theme_btn height_50">
                                                                    <i class="fas fa-comments"></i>
                                                                    {{__('frontend.Question') }}/
                                                                    {{__('frontend.comment') }}
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            @else
                                                <div class="col-lg-12 text-center" id="mainComment">
                                                    <h4>{{__('frontend.You must be enrolled to ask a question')}}</h4>
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                </div>

                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-4">
                            <div class="sidebar__widget mb_30">
                                @if(isModuleActive('EarlyBird') && Auth::check() && !$isEnrolled)
                                    @includeIf(theme('partials._early_bird_offer'), ['price_plans' => $course->pricePlans, 'product' => $course])
                                @endif

                                <div class="sidebar__title">
                                    <div id="price-container">
                                        <h3 id="price_show_tag">
                                            {{getPriceFormat($course_price)}}
                                        </h3>
                                        <div class="price_loader"></div>
                                    </div>

                                    <p>
                                        @if (Auth::check() && $isBookmarked )
                                            <i class="fas fa-heart"></i>
                                            <a href="{{route('bookmarkSave',[$course->id])}}"
                                               class="theme_button mr_10 sm_mb_10">{{__('frontend.Already In Wishlist')}}
                                            </a>
                                        @elseif (Auth::check() && !$isBookmarked )
                                            <a href="{{route('bookmarkSave',[$course->id])}}"
                                               class="">
                                                <i
                                                    class="far fa-heart"></i>
                                                {{__('frontend.Add To Wishlist')}}  </a>
                                    @endif

                                </div>
                                @if($showWaitList)
                                    <a type="button" data-bs-toggle="modal" data-bs-target="#courseWaitList"
                                       class="theme_btn d-block text-center height_50 mb_10">
                                        {{ __('frontend.Enter to Wait List') }}
                                    </a>
                                    @include(theme('partials._course_wait_list_form'),['course' => $course])
                                @endif
                                @if($alreadyWaitListRequest)
                                    <a href="#"
                                       class="theme_btn d-block text-center height_50 mb_10">
                                        {{ __('frontend.Already In Wait List') }}
                                    </a>
                                @endif
                                @if(!onlySubscription())
                                    @if (Auth::check())
                                        @if ($isEnrolled)
                                            <a href="#"
                                               class="theme_btn d-block text-center height_50 mb_10">{{__('common.Already Enrolled')}}</a>

                                            {{--                                        @if($certificateCanDownload)--}}
                                            {{--                                            <a href="{{route('getCertificate',[$course->id,$course->title])}}"--}}
                                            {{--                                               class="theme_line_btn d-block text-center height_50 mb_10">--}}
                                            {{--                                                {{__('frontend.Get Certificate')}}--}}
                                            {{--                                            </a>--}}
                                            {{--                                        @endif--}}
                                        @else
                                            @if($isFree)
                                                @if($is_cart == 1)
                                                    <a href="javascript:void(0)"
                                                       class="theme_btn d-block text-center height_50 mb_10">{{__('common.Added To Cart')}}</a>
                                                @else
                                                    <a href="{{route('addToCart',[@$course->id])}}"
                                                       class="theme_btn d-block text-center height_50 mb_10">{{__('common.Add To Cart')}}</a>
                                                @endif
                                            @else
                                                @if($is_cart == 1)
                                                    <a href="javascript:void(0)"
                                                       class="theme_btn d-block text-center height_50 mb_10">{{__('common.Added To Cart')}}</a>
                                                @else
                                                    <a href=" {{route('addToCart',[@$course->id])}} "
                                                       class="theme_btn d-block text-center height_50 mb_10">{{__('common.Add To Cart')}}</a>
                                                    <a href="{{route('buyNow',[@$course->id])}}"
                                                       class="theme_line_btn d-block text-center height_50 mb_10">{{__('common.Buy Now')}}</a>
                                                @endif
                                            @endif
                                        @endif

                                    @else
                                        @if($isFree)
                                            @if($is_cart == 1)
                                                <a href="javascript:void(0)"
                                                   class="theme_btn d-block text-center height_50 mb_10">{{__('common.Added To Cart')}}</a>
                                            @else
                                                <a href=" {{route('addToCart',[@$course->id])}} "
                                                   class="theme_btn d-block text-center height_50 mb_10">{{__('common.Add To Cart')}}</a>
                                            @endif
                                        @else
                                            @if($is_cart == 1)
                                                <a href="javascript:void(0)"
                                                   class="theme_btn d-block text-center height_50 mb_10">{{__('common.Added To Cart')}}</a>
                                            @else
                                                <a href=" {{route('addToCart',[@$course->id])}} "
                                                   class="theme_btn d-block text-center height_50 mb_10">{{__('common.Add To Cart')}}</a>
                                                <a href="{{route('buyNow',[@$course->id])}}"
                                                   class="theme_line_btn d-block text-center height_50 mb_10">{{__('common.Buy Now')}}</a>
                                            @endif
                                        @endif
                                    @endif
                                    <x-google-calendar-reminder :title="$course->title"
                                                                :date="$course->class->start_date"
                                                                :time="$course->class->time"
                                                                :duration="$course->class->duration"/>
                                @endif

                                @includeIf('gift::buttons.course_details_page_button', ['course' => $course])
                                @if(isModuleActive('Installment') && $course_price > 0)
                                    @includeIf(theme('partials._installment_plan_button'), ['course' => $course])
                                @endif
                                @if(isModuleActive('Cashback'))
                                    @includeIf(theme('partials._cashback_card'), ['product' => $course])
                                @endif
                                <p class="font_14 f_w_500 text-center mb_30"></p>
                                <h4 class="f_w_700 mb_10">{{__('frontend.This class includes')}}:</h4>
                                <ul class="course_includes">

                                    <li>
                                        <i class="ti-calendar"></i>
                                        <p class="nowrap">  {{ __('common.Start Date') }}  {{ showDate($course->class->start_date)}}  {{__('common.At')}}
                                            {{date('h:i A', strtotime($course->class->time))}}
                                        </p>
                                    </li>

                                    <li>
                                        <i class="ti-user"></i>
                                        <p class="nowrap"> {{ __('virtual-class.Capacity') }} {{$course->class->capacity??"Unlimited"}}</p>
                                    </li>


                                    <li>
                                        <i class="ti-timer"></i>
                                        <p class="nowrap"> {{ __('frontend.Duration') }} {{convertMinutesToHourAndMinute($course->class->duration)}}
                                            Hours</p>
                                    </li>

                                    <li>
                                        <i class="ti-agenda"></i>
                                        <p>{{__('frontend.Sessions')}} {{$course->class->total_class}} </p>
                                    </li>
                                    <li>
                                        <i class="ti-user"></i>
                                        <p>{{__('frontend.Enrolled')}} {{$course->total_enrolled}} {{__('frontend.students')}}</p>
                                    </li>

                                    @if($course->certificate)
                                        <li>
                                            <i class="ti-crown"></i>
                                            <p>{{__('frontend.Certificate of Completion')}}</p>
                                        </li>
                                    @endif

                                    @if(isModuleActive('SupportTicket') && $course->support)
                                        <li>
                                            <i class="ti-support"></i>
                                            <p>{{__('common.Support')}}</p>
                                        </li>
                                    @endif

                                </ul>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="modal cs_modal fade admin-query" id="myModal" role="dialog">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('frontend.Review') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"><i
                            class="ti-close "></i></button>
                </div>

                <form action="{{route('submitReview')}}" method="Post">
                    <div class="modal-body">
                        @csrf
                        <input type="hidden" name="course_id" id="rating_course_id"
                               value="">
                        <input type="hidden" name="rating" id="rating_value" value="">

                        <div class="text-center">
                                                                <textarea class="lms_summernote" name="review" name=""
                                                                          id=""
                                                                          placeholder="{{__('frontend.Write your review') }}"
                                                                          cols="30"
                                                                          rows="10">{{old('review')}}</textarea>
                            <span class="text-danger" role="alert">{{$errors->first('review')}}</span>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-center">
                        <div class="mt-40 d-flex justify-content-between">
                            <button type="button" class="theme_line_btn me-2"
                                    data-bs-dismiss="modal">{{ __('common.Cancel') }}
                            </button>
                            <button class="theme_btn "
                                    type="submit">{{ __('common.Submit') }}</button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>

    @include(theme('partials._delete_model'))


</div>
