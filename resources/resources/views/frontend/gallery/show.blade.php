@extends('frontend.layouts.app' . config('theme_layout'))

@section('title', 'Image')
@section('meta_description')
@section('meta_keywords')

    @push('after-styles')
        <style>
            .leanth-course.go {
                right: 0;
            }

            .video-container iframe {
                max-width: 100%;
            }
        </style>
        <link rel="stylesheet" href="https://cdn.plyr.io/3.5.3/plyr.css" />
    @endpush

@section('content')

    <!-- Start of breadcrumb section
                    ============================================= -->
    <section id="breadcrumb" class="breadcrumb-section relative-position backgroud-style">
        <div class="blakish-overlay"></div>
        <div class="container">
            <div class="page-breadcrumb-content text-center">
                <div class="page-breadcrumb-title">
                    <h2 class="breadcrumb-head black bold"><span> {{ $items->name }} </span></h2>
                </div>
            </div>
        </div>
    </section>
    <!-- End of breadcrumb section
                    ============================================= -->

    <!-- Start of course details section
                    ============================================= -->
    <section class="course-details-section">
        <div class="container mb-5"> 
                <div class="col-12 text-center">
                    <img src="{{ $items->image_path }}" class="img-fluid" width="800px" alt="">
                </div>
                <div class="text-center mt-5">
                    <a href="{{ route('image-download',$items->id) }}"  class="btn btn-info"> Download</a>

                </div>
 
        </div>

    </section>
    <!-- End of course details section
                    ============================================= -->

@endsection

@push('after-scripts')
    <script src="https://cdn.plyr.io/3.5.3/plyr.polyfilled.js"></script>

    <script>
        const player = new Plyr('#player');

        $(document).on('change', 'input[name="stars"]', function() {
            $('#rating').val($(this).val());
        })
        @if (isset($review))
            var rating = "{{ $review->rating }}";
            $('input[value="' + rating + '"]').prop("checked", true);
            $('#rating').val(rating);
        @endif
    </script>
@endpush
