@extends('frontend.layouts.app' . config('theme_layout'))
@section('title', trans('labels.backend.upload.articles') . ' | ' . app_name())

@push('after-styles')
    <style>
        .couse-pagination li.active {
            color: #333333 !important;
            font-weight: 700;
        }

        .page-link {
            position: relative;
            display: block;
            padding: .5rem .75rem;
            margin-left: -1px;
            line-height: 1.25;
            color: #c7c7c7;
            background-color: white;
            border: none;
        }

        .page-item.active .page-link {
            z-index: 1;
            color: #333333;
            background-color: white;
            border: none;

        }

        .listing-filter-form select {
            height: 50px !important;
        }

        ul.pagination {
            display: inline;
            text-align: center;
        }
    </style>
@endpush
@section('content')
    

    
    <!-- Start of breadcrumb section
        ============================================= -->
    <section id="breadcrumb" class="breadcrumb-section relative-position backgroud-style" style="background-image: url('{{ $cover->article_path}}');" >
        <div class="blakish-overlay"></div>
        <div class="container">
            <div class="page-breadcrumb-content text-center">
                <div class="page-breadcrumb-title">
                    <h2 class="breadcrumb-head black bold">
                        <span>@lang('labels.backend.upload.articles')</span>
                    </h2>
                </div>
            </div>
        </div>
    </section>
    <!-- End of breadcrumb section
        ============================================= -->
    <section id="best-course" class="best-course-section {{ isset($class) ? $class : '' }}">
        <div class="container">
            <div class="section-title mb45 headline text-center ">

                <h2> </h2>
            </div>
            <div class="best-course-area mb45">
                <div class="row">

                    @forelse ($items as $item)
                        <div class="col-md-3">
                            <div class="best-course-pic-text relative-position ">
                                <div class="best-course-pic relative-position"
                                    @if ($item->image_path != '') style="background-image: url({{ $item->image_path }})" @endif>


                                    <div class="trend-badge-2 text-center text-uppercase hide">
                                        <i class="fas fa-bolt"></i>
                                        <span>@lang('labels.frontend.badges.trending')</span>
                                    </div>


                                    <div class="trend-badge-3 text-center text-uppercase hide">
                                        <i class="fas fa-bolt"></i>
                                        <span>@lang('labels.backend.courses.fields.free')</span>
                                    </div>

                                    <div class="course-price text-center gradient-bg hide">

                                        <span> {{ trans('labels.backend.courses.fields.free') }}</span>

                                        <span>

                                        </span>


                                    </div>
                                    <div class="course-details-btn">
                                        <a class="text-uppercase" href="{{ $item->file_path }}" target="_BLANK"> Downlaod
                                            file <i class="fas fa-arrow-right"></i></a>
                                    </div>
                                    <div class="blakish-overlay"></div>
                                </div>
                                <div class="best-course-text">
                                    <div class="course-title mb20 headline relative-position">
                                        <h3>
                                            <a href=" ">{{ $item->name }}</a>
                                        </h3>
                                    </div>
                                    <div class="course-meta">
                                        <div class="col-md-4">
                                            <p style="width: 8rem;word-break: break-word ">
                                                {{ \Illuminate\Support\Str::limit(strip_tags($item->description), 50) }} </p>

                                        </div>

                                    </div>

                                </div>
                            </div>
                        </div>
                    @empty

                        <h4 class="text-center">@lang('labels.general.no_data_available')</h4>
                    @endforelse

                </div>
            </div>
        </div>
    </section>


    @include('frontend.layouts.partials.browse_courses')
    <!-- End of best course
                    ============================================= -->


@endsection

@push('after-scripts')
    <script>
        $(document).ready(function() {
            $(document).on('change', '#sortBy', function() {
                if ($(this).val() != "") {
                    location.href = '{{ url()->current() }}?type=' + $(this).val();
                } else {
                    location.href = '{{ route('courses.all') }}';
                }
            })

            @if (request('type') != '')
                $('#sortBy').find('option[value="' + "{{ request('type') }}" + '"]').attr('selected', true);
            @endif
        });
    </script>
@endpush
