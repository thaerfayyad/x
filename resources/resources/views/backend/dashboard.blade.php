@extends('backend.layouts.app')

@section('title', __('strings.backend.dashboard.title').' | '.app_name())

@push('after-styles')
    <style>
        .trend-badge-2 {
            top: -10px;
            left: -52px;
            color: #fff;
            font-size: 12px;
            font-weight: 700;
            position: absolute;
            padding: 40px 40px 12px;
            -webkit-transform: rotate(-45deg);
            transform: rotate(-45deg);
            background-color: #ff5a00;
        }

        .progress {
            background-color: #b6b9bb;
            height: 2em;
            font-weight: bold;
            font-size: 0.8rem;
            text-align: center;
        }

        .best-course-pic {
            background-color: #333333;
            background-position: center;
            background-size: cover;
            height: 150px;
            width: 100%;
            background-repeat: no-repeat;
        }


    </style>
@endpush

@section('content')
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <strong>@lang('strings.backend.dashboard.welcome') {{ $logged_in_user->name }}!</strong>
                </div><!--card-header-->
                <div class="card-body">
                    <div class="row">
                        @if(auth()->user()->hasRole('employee'))
                            @if(count($pending_orders) > 0)
                                <div class="col-12">
                                    <h4>@lang('labels.backend.dashboard.pending_orders')</h4>
                                </div>
                                <div class="col-12 text-center">

                                    <table class="table table table-bordered table-striped">
                                        <thead>
                                        <tr>

                                            <th>@lang('labels.general.sr_no')</th>
                                            <th>@lang('labels.backend.orders.fields.reference_no')</th>
                                            <th>@lang('labels.backend.orders.fields.items')</th>
                                            <th>@lang('labels.backend.orders.fields.amount')
                                                <small>(in {{$appCurrency['symbol']}})</small>
                                            </th>
                                            <th>@lang('labels.backend.orders.fields.payment_status.title')</th>
                                            <th>@lang('labels.backend.orders.fields.date')</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($pending_orders as $key=>$item)
                                            @php $key++ @endphp
                                            <tr>
                                                <td>
                                                    {{$key}}
                                                </td>
                                                <td>
                                                    {{$item->reference_no}}
                                                </td>
                                                <td>
                                                    @foreach($item->items as $key=>$subitem)
                                                        @php $key++ @endphp
                                                        @if($subitem->item != null)
                                                            {{$key.'. '.$subitem->item->title}} <br>
                                                        @endif
                                                    @endforeach
                                                </td>
                                                <td>
                                                    {{$item->amount}}
                                                </td>
                                                <td>
                                                    @if($item->status == 0)
                                                        @lang('labels.backend.dashboard.pending')
                                                    @elseif($item->status == 1)
                                                        @lang('labels.backend.dashboard.success')
                                                    @elseif($item->status == 2)
                                                        @lang('labels.backend.dashboard.failed')
                                                    @endif
                                                </td>
                                                <td>
                                                    {{$item->created_at->format('d-m-Y h:i:s')}}
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>

                            @endif

                            <div class="col-12">
                                <h4>@lang('labels.backend.dashboard.my_courses')</h4>
                            </div>


                            @if(count($purchased_courses) > 0)
                                @foreach($purchased_courses as $item)
                                <div class="col-md-3">
                                        <div class="best-course-pic-text position-relative border">
                                            <div class="best-course-pic position-relative overflow-hidden"
                                                 @if($item->course_image != "") style="background-image: url({{asset('storage/uploads/'.$item->course_image)}})" @endif>

                                                @if($item->trending == 1)
                                                    <div class="trend-badge-2 text-center text-uppercase">
                                                        <i class="fas fa-bolt"></i>
                                                        <span>@lang('labels.backend.dashboard.trending') </span>
                                                    </div>
                                                @endif

                                                <div class="course-rate ul-li">
                                                    <ul>
                                                        @for($i=1; $i<=(int)$item->rating; $i++)
                                                            <li><i class="fas fa-star"></i></li>
                                                        @endfor
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="best-course-text d-inline-block w-100 p-2">
                                                <div class="course-title mb20 headline relative-position">
                                                    <h5>
                                                        <a href="{{ route('courses.show', [$item->slug]) }}">{{$item->title}}</a>
                                                    </h5>
                                                </div>
                                                <div class="course-meta d-inline-block w-100 ">
                                                    <div class="d-inline-block w-100 0 mt-2">
                                                     <span class="course-category float-left">
                                                <a href="{{route('courses.category',['category'=>$item->category->slug])}}"
                                                   class="bg-success text-decoration-none px-2 p-1">{{$item->category->name}}</a>
                                            </span>
                                                        <span class="course-author float-right">
                                                 {{ $item->students()->count() }}
                                                            @lang('labels.backend.dashboard.students')
                                            </span>
                                                    </div>

                                                    <div class="progress my-2">
                                                        <div class="progress-bar"
                                                             style="width:{{$item->progress() }}%">
                                                            @lang('labels.backend.dashboard.completed')
                                                            {{ $item->progress_by_user_id($logged_in_user,$item)  }} %
                                                        </div>
                                                    </div>
                                                    @if($item->progress() == 100)
                                                        @if(!$item->isUserCertified())
                                                            <form method="post"
                                                                  action="{{route('admin.certificates.generate')}}">
                                                                @csrf
                                                                <input type="hidden" value="{{$item->id}}"
                                                                       name="course_id">
                                                                <button class="btn btn-success btn-block text-white mb-3 text-uppercase font-weight-bold"
                                                                        id="finish">@lang('labels.frontend.course.finish_course')</button>
                                                            </form>
                                                        @else
                                                            <div class="alert alert-success px-1 text-center mb-0">
                                                                @lang('labels.frontend.course.certified')
                                                            </div>
                                                        @endif
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="col-12 text-center">
                                    <h4 class="text-center">@lang('labels.backend.dashboard.no_data')</h4>
                                    <a class="btn btn-primary"
                                       href="{{route('courses.all')}}">@lang('labels.backend.dashboard.buy_course_now')
                                        <i class="fa fa-arrow-right"></i></a>
                                </div>
                            @endif
                            @if(count($purchased_bundles) > 0)

                                <div class="col-12 mt-5">
                                    <h4>@lang('labels.backend.dashboard.my_course_bundles')</h4>
                                </div>
                                @foreach($purchased_bundles as $key=>$bundle)
                                    @php $key++ @endphp
                                    <div class="col-12">
                                        <h5><a href="{{route('bundles.show',['slug'=>$bundle->slug ])}}">{{$key.'. '.$bundle->title}}</a></h5>
                                    </div>
                                    @if(count($bundle->courses) > 0)
                                        @foreach($bundle->courses as $item)
                                            <div class="col-md-3 mb-5">
                                                <div class="best-course-pic-text position-relative border">
                                                    <div class="best-course-pic position-relative overflow-hidden"
                                                         @if($item->course_image != "") style="background-image: url({{asset('storage/uploads/'.$item->course_image)}})" @endif>

                                                        @if($item->trending == 1)
                                                            <div class="trend-badge-2 text-center text-uppercase">
                                                                <i class="fas fa-bolt"></i>
                                                                <span>@lang('labels.backend.dashboard.trending') </span>
                                                            </div>
                                                        @endif

                                                        <div class="course-rate ul-li">
                                                            <ul>
                                                                @for($i=1; $i<=(int)$item->rating; $i++)
                                                                    <li><i class="fas fa-star"></i></li>
                                                                @endfor
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <div class="best-course-text d-inline-block w-100 p-2">
                                                        <div class="course-title mb20 headline relative-position">
                                                            <h5>
                                                                <a href="{{ route('courses.show', [$item->slug]) }}">{{$item->title}}</a>
                                                            </h5>
                                                        </div>
                                                        <div class="course-meta d-inline-block w-100 ">
                                                            <div class="d-inline-block w-100 0 mt-2">
                                                                <span class="course-category float-left">
                                                                    <a href="{{route('courses.category',['category'=>$item->category->slug])}}"
                                                                    class="bg-success text-decoration-none px-2 p-1">{{$item->category->name}}</a>
                                                                </span>
                                                                <span class="course-author float-right">
                                                                    {{ $item->students()->count() }}
                                                                    @lang('labels.backend.dashboard.students')
                                                                </span>
                                                            </div>

                                                            <div class="progress my-2">
                                                                <div class="progress-bar"
                                                                     style="width:{{$item->progress() }}%">{{ $item->progress()  }}
                                                                    %
                                                                    @lang('labels.backend.dashboard.completed')
                                                                </div>
                                                            </div>
                                                            @if($item->progress() == 100)
                                                                @if(!$item->isUserCertified())
                                                                    <form method="post"
                                                                          action="{{route('admin.certificates.generate')}}">
                                                                        @csrf
                                                                        <input type="hidden" value="{{$item->id}}"
                                                                               name="course_id">
                                                                        <button class="btn btn-success btn-block text-white mb-3 text-uppercase font-weight-bold"
                                                                                id="finish">@lang('labels.frontend.course.finish_course')</button>
                                                                    </form>
                                                                @else
                                                                    <div class="alert alert-success px-1 text-center mb-0">
                                                                        @lang('labels.frontend.course.certified')
                                                                    </div>
                                                                @endif
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                @endforeach
                            @endif
                            @if($subscribed_courses->count() > 0)
                                <div class="col-12 mt-5">
                                    <h4>@lang('labels.backend.dashboard.my_subscribed_courses')</h4>
                                </div>
                                @foreach($subscribed_courses as $item)

                                    <div class="col-md-3">
                                        <div class="best-course-pic-text position-relative border">
                                            <div class="best-course-pic position-relative overflow-hidden"
                                                 @if($item->course_image != "") style="background-image: url({{asset('storage/uploads/'.$item->course_image)}})" @endif>

                                                @if($item->trending == 1)
                                                    <div class="trend-badge-2 text-center text-uppercase">
                                                        <i class="fas fa-bolt"></i>
                                                        <span>@lang('labels.backend.dashboard.trending') </span>
                                                    </div>
                                                @endif

                                                <div class="course-rate ul-li">
                                                    <ul>
                                                        @for($i=1; $i<=(int)$item->rating; $i++)
                                                            <li><i class="fas fa-star"></i></li>
                                                        @endfor
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="best-course-text d-inline-block w-100 p-2">
                                                <div class="course-title mb20 headline relative-position">
                                                    <h5>
                                                        <a href="{{ route('courses.show', [$item->slug]) }}">{{$item->title}}</a>
                                                    </h5>
                                                </div>
                                                <div class="course-meta d-inline-block w-100 ">
                                                    <div class="d-inline-block w-100 0 mt-2">
                                         <span class="course-category float-left">
                                    <a href="{{route('courses.category',['category'=>$item->category->slug])}}"
                                       class="bg-success text-decoration-none px-2 p-1">{{$item->category->name}}</a>
                                </span>
                                                        <span class="course-author float-right">
                                     {{ $item->students()->count() }}
                                                            @lang('labels.backend.dashboard.students')
                                </span>
                                                    </div>

                                                    <div class="progress my-2">
                                                        <div class="progress-bar"
                                                             style="width:{{$item->progress() }}%">
                                                            @lang('labels.backend.dashboard.completed')
                                                            {{ $item->progress()  }} %
                                                        </div>
                                                    </div>
                                                    @if($item->progress() == 100)
                                                        @if(!$item->isUserCertified())
                                                            <form method="post"
                                                                  action="{{route('admin.certificates.generate')}}">
                                                                @csrf
                                                                <input type="hidden" value="{{$item->id}}"
                                                                       name="course_id">
                                                                <button class="btn btn-success btn-block text-white mb-3 text-uppercase font-weight-bold"
                                                                        id="finish">@lang('labels.frontend.course.finish_course')</button>
                                                            </form>
                                                        @else
                                                            <div class="alert alert-success px-1 text-center mb-0">
                                                                @lang('labels.frontend.course.certified')
                                                            </div>
                                                        @endif
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif

                            @if($subscribed_bundles->count() > 0)
                                <div class="col-12 mt-5">
                                    <h4>@lang('labels.backend.dashboard.my_subscribed_course_bundles')</h4>
                                </div>
                                @foreach($subscribed_bundles as $key=>$bundle)
                                    @php $key++ @endphp
                                    <div class="col-12">
                                        <h5><a href="{{route('bundles.show',['slug'=>$bundle->slug ])}}">{{$key.'. '.$bundle->title}}</a></h5>
                                    </div>
                                    @if(count($bundle->courses) > 0)
                                        @foreach($bundle->courses as $item)
                                            <div class="col-md-3 mb-5">
                                                <div class="best-course-pic-text position-relative border">
                                                    <div class="best-course-pic position-relative overflow-hidden"
                                                         @if($item->course_image != "") style="background-image: url({{asset('storage/uploads/'.$item->course_image)}})" @endif>

                                                        @if($item->trending == 1)
                                                            <div class="trend-badge-2 text-center text-uppercase">
                                                                <i class="fas fa-bolt"></i>
                                                                <span>@lang('labels.backend.dashboard.trending') </span>
                                                            </div>
                                                        @endif

                                                        <div class="course-rate ul-li">
                                                            <ul>
                                                                @for($i=1; $i<=(int)$item->rating; $i++)
                                                                    <li><i class="fas fa-star"></i></li>
                                                                @endfor
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <div class="best-course-text d-inline-block w-100 p-2">
                                                        <div class="course-title mb20 headline relative-position">
                                                            <h5>
                                                                <a href="{{ route('courses.show', [$item->slug]) }}">{{$item->title}}</a>
                                                            </h5>
                                                        </div>
                                                        <div class="course-meta d-inline-block w-100 ">
                                                            <div class="d-inline-block w-100 0 mt-2">
                                                            <span class="course-category float-left">
                                                                <a href="{{route('courses.category',['category'=>$item->category->slug])}}"
                                                                   class="bg-success text-decoration-none px-2 p-1">{{$item->category->name}}</a>
                                                            </span>
                                                                <span class="course-author float-right">
                                                                {{ $item->students()->count() }}
                                                                    @lang('labels.backend.dashboard.students')
                                                            </span>
                                                            </div>

                                                            <div class="progress my-2">
                                                                <div class="progress-bar"
                                                                     style="width:{{$item->progress() }}%">{{ $item->progress()  }}
                                                                    %
                                                                    @lang('labels.backend.dashboard.completed')
                                                                </div>
                                                            </div>
                                                            @if($item->progress() == 100)
                                                                @if(!$item->isUserCertified())
                                                                    <form method="post"
                                                                          action="{{route('admin.certificates.generate')}}">
                                                                        @csrf
                                                                        <input type="hidden" value="{{$item->id}}"
                                                                               name="course_id">
                                                                        <button class="btn btn-success btn-block text-white mb-3 text-uppercase font-weight-bold"
                                                                                id="finish">@lang('labels.frontend.course.finish_course')</button>
                                                                    </form>
                                                                @else
                                                                    <div class="alert alert-success px-1 text-center mb-0">
                                                                        @lang('labels.frontend.course.certified')
                                                                    </div>
                                                                @endif
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                @endforeach
                            @endif

                    @elseif(auth()->user()->hasRole('company admin'))
                       
                        <div class="col-lg-12">
                            <!-- BAR CHART -->
                                <div class="card card-success">
                                    <div class="card-header">
                                    <h3 class="card-title">Employee Courses</h3>
                    
                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                        </button>
                                        <button type="button" class="btn btn-tool" data-card-widget="remove">
                                        <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                    </div>
                                    <div class="card-body">
                                    <div class="chart">
                                        <canvas id="barChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                                    </div>
                                    </div>
                                    <!-- /.card-body -->
                                </div>
                                <!-- /.card -->
                            {{-- <div class="card">
                            <div class="card-header border-0">
                                <div class="d-flex justify-content-between">
                                <h3 class="card-title">Sales</h3>
                                <a href="{{ route('admin.reports.sales') }}">View Report</a>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="d-flex">
                                <p class="d-flex flex-column">
                                    <span class="text-bold text-lg">${{ $orders_sales }}</span>
                                    <span>Sales Over Time</span>
                                </p>
                                <p class="ml-auto d-flex flex-column text-right">
                                    <span class="text-success">
                                    <i class="fas fa-arrow-up"></i> <span class="percantage2">0</span>%
                                    </span>
                                    <span class="text-muted">Since last month</span>
                                </p>
                                </div>
                                <!-- /.d-flex -->
                
                                <div class="position-relative mb-4">
                                <canvas id="sales-chart" height="200"></canvas>
                                </div>
                
                                <div class="d-flex flex-row justify-content-end">
                                <span class="mr-2">
                                    <i class="fas fa-square text-primary"></i> This year
                                </span>
                
                                <span>
                                    <i class="fas fa-square text-gray"></i> Last year
                                </span>
                                </div>
                            </div>
                            </div> --}}
                        </div>
                        <div class="col-lg-12">
                            <!-- BAR CHART -->
                            <div class="card card-success">
                                <div class="card-header">
                                <h3 class="card-title">Employee Bundle</h3>
                
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                    </button>
                                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                                    <i class="fas fa-times"></i>
                                    </button>
                                </div>
                                </div>
                                <div class="card-body">
                                <div class="chart">
                                    <canvas id="barChart2" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                                </div>
                                </div>
                                <!-- /.card-body -->
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <!-- PIE CHART -->
                            <div class="card card-danger">
                                <div class="card-header">
                                <h3 class="card-title">Courses Chart</h3>
                
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                    </button>
                                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                                    <i class="fas fa-times"></i>
                                    </button>
                                </div>
                                </div>
                                <div class="card-body">
                                    <div class="col">
                                        <label for="students">@lang('labels.backend.reports.select_course')</label>
                                        <select class="form-control select2" name="course" id="course">
                                            <option value="">@lang('labels.backend.reports.select_course')</option>
                                            @foreach ($courses as $course)
                                            <option value="{{ $course->id }}">{{ $course->title }}</option>
                                            @endforeach()
                                        </select>
                                    </div>
                                <canvas id="pieChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->
                        </div>
                        <div class="col-lg-6">
                            <!-- PIE CHART -->
                            <div class="card card-danger">
                                <div class="card-header">
                                <h3 class="card-title">Bundles Chart</h3>
                
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                    </button>
                                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                                    <i class="fas fa-times"></i>
                                    </button>
                                </div>
                                </div>
                                <div class="card-body">
                                    <div class="col">
                                        <label for="students">@lang('labels.backend.reports.select_bundle')</label>
                                        <select class="form-control select2" name="bundle" id="bundle">
                                            <option value="">@lang('labels.backend.reports.select_bundle')</option>
                                            @foreach($bundles as $bundle)
                                                <option value="{{ $bundle->id }}">{{ $bundle->title }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                <canvas id="pieChart2" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->
                        </div>
                        <div class="col-lg-6">
                            <!-- PIE CHART -->
                            <div class="card card-danger">
                                <div class="card-header">
                                <h3 class="card-title">Employee Chart</h3>
                
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                    </button>
                                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                                    <i class="fas fa-times"></i>
                                    </button>
                                </div>
                                </div>
                                <div class="card-body">
                                    <div class="col">
                                        <label for="students">Select Employee</label>
                                        <select class="form-control select2" name="bundle" id="employee">
                                            <option value="">Select Employee</option>
                                            @foreach($employees as $employee)
                                                <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                <canvas id="pieChart3" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->
                        </div>
                    @elseif(auth()->user()->hasRole('administrator')||auth()->user()->hasRole('company admin'))
                        {{-- <div class="col-md-4 col-12">
                            <div class="card text-white bg-dark text-center py-3">
                                <div class="card-body">
                                    <h1 class="">{{$courses_count}}</h1>
                                    <h3>@lang('labels.backend.dashboard.course_and_bundles')</h3>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4 col-12">
                            <div class="card text-white bg-light text-dark text-center py-3">
                                <div class="card-body">
                                    <h1 class="">{{$students_count}}</h1>
                                    <h3>@lang('labels.backend.dashboard.students')</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-12">
                            <div class="card text-white bg-primary text-center py-3">
                                <div class="card-body">
                                    <h1 class="">{{$teachers_count}}</h1>
                                    <h3>@lang('labels.backend.dashboard.teachers')</h3>
                                </div>
                            </div>
                        </div> --}}
                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-header border-0">
                                  <div class="d-flex justify-content-between">
                                    <h3 class="card-title">Recent Orders</h3>
                                    <a href="{{route('admin.orders.index')}}">View Report</a>
                                  </div>
                                </div>
                                <div class="card-body">
                                  <div class="d-flex">
                                    <p class="d-flex flex-column">
                                      <span class="text-bold text-lg">{{$orders_count}}</span>
                                      <span>Orders Over Time</span>
                                    </p>
                                    <p class="ml-auto d-flex flex-column text-right">
                                      <span class="text-success">
                                        <i class="fas fa-arrow-up"></i> <span class="percantage">0</span>%
                                      </span>
                                      <span class="text-muted">Since last week</span>
                                    </p>
                                  </div>
                                  <!-- /.d-flex -->
                  
                                  <div class="position-relative mb-4">
                                    <canvas id="visitors-chart" height="200"></canvas>
                                  </div>
                  
                                  <div class="d-flex flex-row justify-content-end">
                                    <span class="mr-2">
                                      <i class="fas fa-square text-primary"></i> This Week
                                    </span>
                  
                                    <span>
                                      <i class="fas fa-square text-gray"></i> Last Week
                                    </span>
                                  </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="card">
                              <div class="card-header border-0">
                                <div class="d-flex justify-content-between">
                                  <h3 class="card-title">Sales</h3>
                                  <a href="{{ route('admin.reports.sales') }}">View Report</a>
                                </div>
                              </div>
                              <div class="card-body">
                                <div class="d-flex">
                                  <p class="d-flex flex-column">
                                    <span class="text-bold text-lg">${{ $orders_sales }}</span>
                                    <span>Sales Over Time</span>
                                  </p>
                                  <p class="ml-auto d-flex flex-column text-right">
                                    <span class="text-success">
                                      <i class="fas fa-arrow-up"></i> <span class="percantage2">0</span>%
                                    </span>
                                    <span class="text-muted">Since last month</span>
                                  </p>
                                </div>
                                <!-- /.d-flex -->
                
                                <div class="position-relative mb-4">
                                  <canvas id="sales-chart" height="200"></canvas>
                                </div>
                
                                <div class="d-flex flex-row justify-content-end">
                                  <span class="mr-2">
                                    <i class="fas fa-square text-primary"></i> This year
                                  </span>
                
                                  <span>
                                    <i class="fas fa-square text-gray"></i> Last year
                                  </span>
                                </div>
                              </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="card">
                            <div class="card-header border-0">
                                <div class="d-flex justify-content-between">
                                <h3 class="card-title">Sales</h3>
                                <a href="{{ route('admin.reports.sales') }}">View Report</a>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="d-flex">
                                <p class="d-flex flex-column">
                                    <span class="text-bold text-lg">${{ $orders_sales }}</span>
                                    <span>Sales Over Time</span>
                                </p>
                                <p class="ml-auto d-flex flex-column text-right">
                                    <span class="text-success">
                                    <i class="fas fa-arrow-up"></i> <span class="percantage2">0</span>%
                                    </span>
                                    <span class="text-muted">Since last month</span>
                                </p>
                                </div>
                                <!-- /.d-flex -->
                
                                <div class="position-relative mb-4">
                                <canvas id="sales-chart2" height="200"></canvas>
                                </div>
                
                                <div class="d-flex flex-row justify-content-end">
                                <span class="mr-2">
                                    <i class="fas fa-square text-primary"></i> This year
                                </span>
                
                                <span>
                                    <i class="fas fa-square text-gray"></i> Last year
                                </span>
                                </div>
                            </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-12 border-right">
                            <div class="d-inline-block form-group w-100">
                                <h4 class="mb-0">@lang('labels.backend.dashboard.recent_orders') <a
                                            class="btn btn-primary float-right"
                                            href="{{route('admin.orders.index')}}">@lang('labels.backend.dashboard.view_all')</a>
                                </h4>

                            </div>
                            <table class="table table-responsive-sm table-striped">
                                <thead>
                                <tr>
                                    <td>@lang('labels.backend.dashboard.ordered_by')</td>
                                    <td>@lang('labels.backend.dashboard.amount')</td>
                                    <td>@lang('labels.backend.dashboard.time')</td>
                                    <td>@lang('labels.backend.dashboard.view')</td>
                                </tr>
                                </thead>
                                <tbody>
                                @if(count($recent_orders) > 0)
                                    @foreach($recent_orders as $item)
                                        <tr>
                                            <td>
                                                {{$item->user?$item->user->full_name : ''}}
                                            </td>
                                            <td>{{$item->amount.' '.$appCurrency['symbol']}}</td>
                                            <td>{{$item->created_at->diffforhumans()}}</td>
                                            <td><a class="btn btn-sm btn-primary"
                                                   href="{{route('admin.orders.show', $item->id)}}" target="_blank"><i
                                                            class="fa fa-arrow-right"></i></a></td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="4">@lang('labels.backend.dashboard.no_data')</td>
                                    </tr>
                                @endif
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="d-inline-block form-group w-100">
                                <h4 class="mb-0">@lang('labels.backend.dashboard.recent_contact_requests') <a
                                            class="btn btn-primary float-right"
                                            href="{{route('admin.contact-requests.index')}}">@lang('labels.backend.dashboard.view_all')</a>
                                </h4>

                            </div>
                            <table class="table table-responsive-sm table-striped">
                                <thead>
                                <tr>
                                    <td>@lang('labels.backend.dashboard.name')</td>
                                    <td>@lang('labels.backend.dashboard.email')</td>
                                    <td>@lang('labels.backend.dashboard.message')</td>
                                    <td>@lang('labels.backend.dashboard.time')</td>
                                </tr>
                                </thead>
                                <tbody>
                                @if(count($recent_contacts) > 0)
                                    @foreach($recent_contacts as $item)
                                        <tr>
                                            <td>
                                                {{$item->name}}
                                            </td>
                                            <td>{{$item->email}}</td>
                                            <td>{{$item->message}}</td>
                                            <td>{{$item->created_at->diffforhumans()}}</td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="4">@lang('labels.backend.dashboard.no_data')</td>

                                    </tr>
                                @endif
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="col-12">
                            <h1>@lang('labels.backend.dashboard.title')</h1>
                        </div>
                    @endif
                </div>
            </div><!--card-body-->
        </div><!--card-->
    </div><!--col-->
@endsection
@if(auth()->user()->isAdmin()||auth()->user()->hasRole('company admin'))
@push('after-scripts')
<script src="{{ asset('assets/plugins/chart.js/Chart.min.js') }}"></script>
<script src="{{ asset('assets/dist/js/pages/dashboard3.js') }}"></script>
@endpush

@push('after-scripts')
    <script>
        $(document).on('change', '#course', function () {
                
            $.ajax({
                url: '{{ route('admin.get-course-chartjsData')}}?course='+$(this).val(),
                type: 'get',
                dataType: 'JSON',
                success: function (response) {
                    console.log(response);
                    labels=['Complete','In Progress','Just Enrolled'];
                    data=[response.complete_count,response.inProgress,response.zeroProgress]
                    // if (typeof PieChart !== 'undefined') {
                    //     PieChart.destroy();
                    // }

                    drawChart('pieChart',labels,data);
                }
            })
        });
        $(document).on('change', '#bundle', function () {
                
            $.ajax({
                url: '{{ route('admin.get-bundle-chartjsData')}}?bundle='+$(this).val(),
                type: 'get',
                dataType: 'JSON',
                success: function (response) {
                    console.log(response);
                    labels=['Complete','In Progress','Just Enrolled'];
                    data=[response.complete_count,response.inProgress,response.zeroProgress]
                    // if (typeof PieChart !== 'undefined') {
                    //     PieChart.destroy();
                    // }
                    drawChart('pieChart2',labels,data);
                }
            })
        });
        $(document).on('change', '#employee', function () {
                
            $.ajax({
                url: '{{ route('admin.get-employee-chartjsData')}}?employee='+$(this).val(),
                type: 'get',
                dataType: 'JSON',
                success: function (response) {
                    console.log(response);
                    labels=['Complete','In Progress','Just Enrolled'];
                    data=[response.complete_count,response.inProgress,response.zeroProgress]
                    drawChart('pieChart3',labels,data);
                }
            })
        });
        
        @if(auth()->user()->hasRole('company admin'))
        names=[@foreach ($name as $n)'{{ $n }}',@endforeach];
        data=[@foreach ($prog as $p)
        @foreach ($p as $progress)
            {
                label               : '',
                backgroundColor     : 'rgba(60,141,188,0.9)',
                borderColor         : 'rgba(60,141,188,0.8)',
                pointRadius          : false,
                pointColor          : '#3b8bba',
                pointStrokeColor    : 'rgba(60,141,188,1)',
                pointHighlightFill  : '#fff',
                pointHighlightStroke: 'rgba(60,141,188,1)',
                data                : [ @if($progress!=0){{ $progress }}@else 1 @endif ,]
            },
            @endforeach
        @endforeach]
        draw4(names,data,'barChart');
        names=[@foreach ($namesBundles as $n)'{{ $n }}',@endforeach];
        data=[@foreach ($bundleProgress as $p)
        @foreach ($p as $progress)
            {
                label               : '',
                backgroundColor     : 'rgba(60,141,188,0.9)',
                borderColor         : 'rgba(60,141,188,0.8)',
                pointRadius          : false,
                pointColor          : '#3b8bba',
                pointStrokeColor    : 'rgba(60,141,188,1)',
                pointHighlightFill  : '#fff',
                pointHighlightStroke: 'rgba(60,141,188,1)',
                data                : [ @if($progress!=0){{ $progress }}@else 1 @endif ,]
            },
            @endforeach
        @endforeach]
        draw4(names,data,'barChart2');
        // drawChart('pieChart');
        // drawChart('pieChart2');
        // drawChart('pieChart3');
        $(document).ready(function () {
            $.ajax({
                url: '{{ route('admin.get-chartData2',['company'=>$logged_in_user->id]) }}',
                type: 'get',
                dataType: 'JSON',
                success: function (response) {
                        var ChartData= response.allMonth;
                        
                        // console.log(names);
                        $('.percantage2').html(response.percentage);
                        
                }
            })
        })
        @endif
        @if(auth()->user()->isAdmin())
        $(document).ready(function () {
            $.ajax({
                url: '{{ route('admin.get-chartData',['company'=>$logged_in_user->id]) }}',
                type: 'get',
                dataType: 'JSON',
                success: function (response) {
                        var ChartData= response.allDay;
                        // console.log(response);
                        $('.percantage').html(response.percentage);
                        draw(ChartData);
                }
            })
        })
        $(document).ready(function () {
            $.ajax({
                url: '{{ route('admin.get-chartData2',['company'=>$logged_in_user->id]) }}',
                type: 'get',
                dataType: 'JSON',
                success: function (response) {
                        var ChartData= response.allMonth;
                        // console.log(response);
                        $('.percantage2').html(response.percentage);
                        draw2(ChartData);
                }
            })
        })
        $(document).ready(function () {
            $.ajax({
                url: '{{ route('admin.getCompanies') }}',
                type: 'get',
                dataType: 'JSON',
                success: function (response) {
                        let ChartData= response;
                        console.log(response);
                        // $('.percantage3').html(response.percentage);
                        draw3(ChartData);
                }
            })
        })
        @endif
    </script>
@endpush
@endif