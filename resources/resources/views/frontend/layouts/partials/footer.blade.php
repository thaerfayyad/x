<!-- Start of footer area
    ============================================= -->
@php
    $footer_data = json_decode(config('footer_data'));
@endphp

@if($footer_data != "")
<footer>
    <section id="footer-area" class="footer-area-section">
        <div class="container">
            
            <!-- /footer-widget-content -->
            
            @if($footer_data->bottom_footer->status == 1)
            <div class="copy-right-menu">
                <div class="row">

                    @if($footer_data->copyright_text->status == 1)
                    <div class="col-md-6">
                        <div class="copy-right-text">
                            <p>Powered By <a href="https://www.cystack.ps/" target="_blank" class="mr-4"> CYSAFE</a>  {!!  $footer_data->copyright_text->text !!}</p>
                        </div>
                    </div>
                    @endif
                    @if(($footer_data->bottom_footer_links->status == 1) && (count($footer_data->bottom_footer_links->links) > 0))
                    <div class="col-md-6">
                        <div class="copy-right-menu-item float-right ul-li">
                            <ul>
                                @foreach($footer_data->bottom_footer_links->links as $item)
                                <li><a href="{{$item->link}}">{{$item->label}}</a></li>
                                @endforeach
                                @if(config('show_offers'))
                                    <li><a href="{{route('frontend.offers')}}">@lang('labels.frontend.layouts.partials.offers')</a> </li>
                                @endif
                                <li><a href="{{route('frontend.certificates.getVerificationForm')}}">@lang('labels.frontend.layouts.partials.certificate_verification')</a></li>
                            </ul>
                        </div>
                    </div>
                     @endif
                </div>
            </div>
            @endif
        </div>
    </section>
</footer>
@endif
<!-- End of footer area
============================================= -->

@push('after-scripts')
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css"/>
    <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>
    <script>
        window.addEventListener('load', function () {
            alertify.set('notifier', 'position', 'top-right');
        });

        function showNotice(type, message) {
            var alertifyFunctions = {
                'success': alertify.success,
                'error': alertify.error,
                'info': alertify.message,
                'warning': alertify.warning
            };

            alertifyFunctions[type](message, 10);
        }
    </script>
    <script src="{{ asset('js/wishlist.js') }}"></script>
    <style>
        .alertify-notifier .ajs-message{
            color: #ffffff;
        }
    </style>
@endpush
