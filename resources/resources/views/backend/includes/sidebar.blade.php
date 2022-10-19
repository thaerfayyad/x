@inject('request', 'Illuminate\Http\Request')
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <div class="user-panel d-flex">
            <a class="brand-link" href="{{ route('admin.dashboard') }}">
                <img class="brand-image  elevation-3" src="{{asset('storage/logos/'.config('logo_b_image'))}}" style="opacity: .8"  height="25" >
                {{-- <img class="navbar-brand-minimized" src="{{asset('storage/logos/'.config('logo_popup'))}}" height="30" alt="Square Logo"> --}}
            </a>
        
    </div>  
    <div class="sidebar">
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ $logged_in_user->picture }}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="{{ route('admin.dashboard') }}" class="d-block">{{ $logged_in_user->company_name }}</a>
            </div>
        </div>  

            <!-- SidebarSearch Form -->
        <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
                <div class="input-group-append">
                <button class="btn btn-sidebar">
                    <i class="fas fa-search fa-fw"></i>
                </button>
                </div>
            </div>
        </div>
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-header">
                    @lang('menus.backend.sidebar.general')
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ $request->segment(2) == 'dashboard' ? 'active' : '' }} {{ active_class(Active::checkUriPattern('')) }}"
                        href="{{ route('admin.dashboard') }}">
                        <i class="nav-icon icon-speedometer"></i>
                        <p>
                            @lang('menus.backend.sidebar.dashboard')
                        </p>
                    </a>
                </li>


                <!--=======================Custom menus===============================-->
                @can('order_access')
                    <li class="nav-item ">
                        <a class="nav-link {{ $request->segment(2) == 'orders' ? 'active' : '' }}"
                            href="{{ route('admin.orders.index') }}">
                            <i class="nav-icon icon-bag"></i>
                            <p class="title">@lang('menus.backend.sidebar.orders.title')</p>
                        </a>
                    </li>
                @endcan
                @if ($logged_in_user->isAdmin())
                    <li class="nav-item ">
                        <a class="nav-link {{ $request->segment(2) == 'teachers' ? 'active' : '' }}"
                        href="{{ route('admin.teachers.index') }}">
                            <i class="nav-icon icon-directions"></i>
                            <p class="title">@lang('menus.backend.sidebar.teachers.title')</p>
                        </a>
                    </li>
                @endif

                @can('category_access')
                    <li class="nav-item ">
                        <a class="nav-link {{ $request->segment(2) == 'categories' ? 'active' : '' }}"
                        href="{{ route('admin.categories.index',['company'=>$logged_in_user->id]) }}">
                            <i class="nav-icon icon-folder-alt"></i>
                            <p class="title">@lang('menus.backend.sidebar.categories.title')</p>
                        </a>
                    </li>
                @endcan
                @if((!$logged_in_user->hasRole('employee')) && ($logged_in_user->hasRole('company admin') || $logged_in_user->isAdmin() || $logged_in_user->hasAnyPermission(['course_access','lesson_access','test_access','question_access','bundle_access'])))
                    {{--@if($logged_in_user->hasRole('teacher') || $logged_in_user->isAdmin() || $logged_in_user->hasAnyPermission(['course_access','lesson_access','test_access','question_access','bundle_access']))--}}

                    <li class="nav-item {{ active_class(Active::checkUriPattern(['user/courses*','user/lessons*','user/tests*','user/questions*','user/live-lessons*','user/live-lesson-slots*']), 'open') }}">
                        <a class="nav-link {{ active_class(Active::checkUriPattern('admin/*')) }}"
                        href="#">
                            <i class="nav-icon icon-puzzle"></i> 
                            <p>
                                @lang('menus.backend.sidebar.courses.management')
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>

                        <ul class="nav nav-treeview">

                            @can('course_access')
                                <li class="nav-item ">
                                    <a class="nav-link {{ $request->segment(2) == 'courses' ? 'active' : '' }}"
                                    href="{{ route('admin.courses.index',['company'=>$logged_in_user->id]) }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p class="title">@lang('menus.backend.sidebar.courses.title')</p>
                                    </a>
                                </li>
                            @endcan

                            @can('lesson_access')
                                <li class="nav-item ">
                                    <a class="nav-link {{ $request->segment(2) == 'lessons' ? 'active' : '' }}"
                                    href="{{ route('admin.lessons.index') }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p class="title">@lang('menus.backend.sidebar.lessons.title')</p>
                                    </a>
                                </li>
                            @endcan

                            @can('test_access')
                                <li class="nav-item ">
                                    <a class="nav-link {{ $request->segment(2) == 'tests' ? 'active' : '' }}"
                                    href="{{ route('admin.tests.index') }}">
                                    <i class="far fa-circle nav-icon"></i>
                                        <p class="title">@lang('menus.backend.sidebar.tests.title')</p>
                                    </a>
                                </li>
                            @endcan


                            @can('question_access')
                                <li class="nav-item">
                                    <a class="nav-link {{ $request->segment(2) == 'questions' ? 'active' : '' }}"
                                    href="{{ route('admin.questions.index') }}">
                                    <i class="far fa-circle nav-icon"></i>
                                        <p class="title">@lang('menus.backend.sidebar.questions.title')</p>
                                    </a>
                                </li>
                            @endcan


                            @can('live_lesson_access')
                                <li class="nav-item ">
                                    <a class="nav-link {{ $request->segment(2) == 'live-lessons' ? 'active' : '' }}"
                                    href="{{ route('admin.live-lessons.index') }}">
                                    <i class="far fa-circle nav-icon"></i>
                                        <p class="title">@lang('menus.backend.sidebar.live_lessons.title')</p>
                                    </a>
                                </li>
                            @endcan

                            @can('live_lesson_slot_access')
                                <li class="nav-item ">
                                    <a class="nav-link {{ $request->segment(2) == 'live-lesson-slots' ? 'active' : '' }}"
                                    href="{{ route('admin.live-lesson-slots.index') }}">
                                    <i class="far fa-circle nav-icon"></i>
                                        <p class="title">@lang('menus.backend.sidebar.live_lesson_slots.title')</p>
                                    </a>
                                </li>
                            @endcan

                        </ul>
                    </li>
                    @can('bundle_access')
                        <li class="nav-item ">
                            <a class="nav-link {{ $request->segment(2) == 'bundles' ? 'active' : '' }}"
                            href="{{ route('admin.bundles.index',['company'=>$logged_in_user->id]) }}">
                                <i class="nav-icon icon-layers"></i>
                                <p class="title">@lang('menus.backend.sidebar.bundles.title')</p>
                            </a>
                        </li>
                        
                    @endcan
                    <li class="nav-item ">
                        <a class="nav-link {{ $request->segment(2) == 'bundles' ? 'active' : '' }}"
                        href="{{ route('admin.groups.index') }}">
                            <i class="nav-icon icon-layers"></i>
                            <p class="title">@lang('menus.backend.sidebar.bundles.groups')</p>
                        </a>
                    </li>
                    @if($logged_in_user->hasRole('company admin') || $logged_in_user->isAdmin())
                        {{-- <li class="nav-item ">
                            <a class="nav-link {{ $request->segment(2) == 'certificates/create' ? 'active' : '' }}"
                            href="{{ route('admin.certificates.create',['company'=>$logged_in_user->id]) }}">
                                <i class="nav-icon icon-badge"></i> 
                                <p class="title">Create Certificates</p>
                            </a>
                        </li> --}}
                    
                        <li class="nav-item  {{ active_class(Active::checkUriPattern(['user/reports*']), 'open') }}">
                            <a class="nav-link {{ active_class(Active::checkUriPattern('admin/*')) }}"
                            href="#">
                                <i class="nav-icon icon-pie-chart"></i>
                                <p>
                                    @lang('menus.backend.sidebar.reports.title')
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                {{-- @if ($logged_in_user->isAdmin())
                                <li class="nav-item ">
                                    <a class="nav-link {{ $request->segment(2) == 'sales' ? 'active' : '' }}"
                                    href="{{ route('admin.reports.sales') }}">
                                    <i class="far fa-circle nav-icon"></i>
                                        @lang('menus.backend.sidebar.reports.sales')
                                    </a>
                                </li>
                                @endif --}}
                                <li class="nav-item ">
                                    <a class="nav-link {{ $request->segment(2) == 'students' ? 'active' : '' }}"
                                    href="{{ route('admin.reports.students') }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    @lang('menus.backend.sidebar.reports.students')
                                    </a>
                                </li>
                                <li class="nav-item ">
                                    <a class="nav-link {{ $request->segment(2) == 'students' ? 'active' : '' }}"
                                    href="{{ route('admin.reports.teachers') }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    @lang('labels.backend.reports.report_details')
                                    </a>
                                </li>
                       
                                
                            </ul>
                        </li>

                        <li class="nav-item  {{ active_class(Active::checkUriPattern(['user/reports*']), 'open') }}">
                            <a class="nav-link {{ active_class(Active::checkUriPattern('admin/*')) }}"
                            href="#">
                                <i class="nav-icon icon-pie-chart"></i>
                                <p>
                                    @lang('labels.backend.upload.upload')
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                 
                                
                                <li class="nav-item ">
                                    <a class="nav-link {{ $request->segment(2) == 'students' ? 'active' : '' }}"
                                    href="{{ route('admin.gallerys.index') }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    @lang('labels.backend.upload.imgaes')
                                    </a>
                                </li>
                                <li class="nav-item ">
                                    <a class="nav-link {{ $request->segment(2) == 'students' ? 'active' : '' }}"
                                    href="{{ route('admin.articles.index') }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    @lang('labels.backend.upload.articles')
                                    </a>
                                </li>
                                <li class="nav-item ">
                                    <a class="nav-link {{ $request->segment(2) == 'students' ? 'active' : '' }}"
                                    href="{{ route('admin.upload-cover-settings') }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    Header
                                    </a>
                                </li>
                                
                            </ul>
                        </li>
                    @endif
                @endif




                @if ($logged_in_user->isAdmin() || $logged_in_user->hasAnyPermission(['blog_access','page_access','reason_access']))
                    <li class="nav-item {{ active_class(Active::checkUriPattern(['user/contact','user/sponsors*','user/testimonials*','user/faqs*','user/footer*','user/blogs','user/sitemap*']), 'open') }}">
                        <a class="nav-link {{ active_class(Active::checkUriPattern('admin/*')) }}"
                        href="#">
                            <i class="nav-icon icon-note"></i> 
                            <p>
                                @lang('menus.backend.sidebar.site-management.title')
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>

                        <ul class="nav nav-treeview">
                            @can('page_access')
                                <li class="nav-item ">
                                    <a class="nav-link {{ $request->segment(2) == 'pages' ? 'active' : '' }}"
                                    href="{{ route('admin.pages.index') }}">
                                    <i class="far fa-circle nav-icon"></i>
                                        <p class="title">@lang('menus.backend.sidebar.pages.title')</p>
                                    </a>
                                </li>
                            @endcan
                            @can('blog_access')
                                <li class="nav-item ">
                                    <a class="nav-link {{ $request->segment(2) == 'blogs' ? 'active' : '' }}"
                                    href="{{ route('admin.blogs.index') }}">
                                    <i class="far fa-circle nav-icon"></i>
                                        <p class="title">@lang('menus.backend.sidebar.blogs.title')</p>
                                    </a>
                                </li>
                            @endcan
                            @if ($logged_in_user->isAdmin())
                                <li class="nav-item">
                                    <a class="nav-link {{ $request->segment(2) == 'reasons' ? 'active' : '' }}"
                                    href="{{ route('admin.reasons.index') }}">
                                    <i class="far fa-circle nav-icon"></i>
                                        <p class="title">@lang('menus.backend.sidebar.reasons.title')</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ active_class(Active::checkUriPattern('admin/menu-manager')) }}"
                                    href="{{ route('admin.menu-manager',['company'=>$logged_in_user->id]) }}">
                                    {{-- href="{{ route('admin.menu-manager',['company'=>$logged_in_user->id]) }}">  --}}
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>
                                            {{ __('menus.backend.sidebar.menu-manager.title') }}
                                        </p>
                                    </a>
                                </li>


                                <li class="nav-item ">
                                    <a class="nav-link {{ active_class(Active::checkUriPattern('admin/sliders*')) }}"
                                    href="{{ route('admin.sliders.index',['company'=>$logged_in_user->id]) }}">
                                    <i class="far fa-circle nav-icon"></i>
                                        <p class="title">@lang('menus.backend.sidebar.hero-slider.title')</p>
                                    </a>
                                </li>
                                <li class="nav-item ">
                                    <a class="nav-link {{ $request->segment(2) == 'sponsors' ? 'active' : '' }}"
                                    href="{{ route('admin.sponsors.index') }}">
                                    <i class="far fa-circle nav-icon"></i>
                                        <p class="title">@lang('menus.backend.sidebar.sponsors.title')</p>
                                    </a>
                                </li>
                                <li class="nav-item ">
                                    <a class="nav-link {{ $request->segment(2) == 'testimonials' ? 'active' : '' }}"
                                    href="{{ route('admin.testimonials.index') }}">
                                    <i class="far fa-circle nav-icon"></i>
                                        <p class="title">@lang('menus.backend.sidebar.testimonials.title')</p>
                                    </a>
                                </li>
                                <li class="nav-item ">
                                    <a class="nav-link {{ $request->segment(2) == 'forums-category' ? 'active' : '' }}"
                                    href="{{ route('admin.forums-category.index') }}">
                                    <i class="far fa-circle nav-icon"></i>
                                        <p class="title">@lang('menus.backend.sidebar.forums-category.title')</p>
                                    </a>
                                </li>
                                <li class="nav-item ">
                                    <a class="nav-link {{ $request->segment(2) == 'faqs' ? 'active' : '' }}"
                                    href="{{ route('admin.faqs.index') }}">
                                    <i class="far fa-circle nav-icon"></i>
                                        <p class="title">@lang('menus.backend.sidebar.faqs.title')</p>
                                    </a>
                                </li>
                                <li class="nav-item ">
                                    <a class="nav-link {{ $request->segment(2) == 'contact' ? 'active' : '' }}"
                                    href="{{ route('admin.contact-settings') }}">
                                    <i class="far fa-circle nav-icon"></i>
                                        <p class="title">@lang('menus.backend.sidebar.contact.title')</p>
                                    </a>
                                </li>
                                <li class="nav-item ">
                                    <a class="nav-link {{ $request->segment(2) == 'newsletter' ? 'active' : '' }}"
                                    href="{{ route('admin.newsletter-settings') }}">
                                    <i class="far fa-circle nav-icon"></i>
                                        <p class="title">@lang('menus.backend.sidebar.newsletter-configuration.title')</p>
                                    </a>
                                </li>
                                <li class="nav-item ">
                                    <a class="nav-link {{ $request->segment(2) == 'footer' ? 'active' : '' }}"
                                    href="{{ route('admin.footer-settings',['company'=>$logged_in_user->id]) }}">
                                    <i class="far fa-circle nav-icon"></i>
                                        <p class="title">@lang('menus.backend.sidebar.footer.title')</p>
                                    </a>
                                </li>
                                <li class="nav-item ">
                                    <a class="nav-link {{ $request->segment(2) == 'sitemap' ? 'active' : '' }}"
                                    href="{{ route('admin.sitemap.index') }}">
                                    <i class="far fa-circle nav-icon"></i>
                                        <p class="title">@lang('menus.backend.sidebar.sitemap.title')</p>
                                    </a>
                                </li>
                            @endif

                        </ul>


                    </li>
                @else
                    @can('blog_access')
                        <li class="nav-item ">
                            <a class="nav-link {{ $request->segment(2) == 'blogs' ? 'active' : '' }}"
                            href="{{ route('admin.blogs.index') }}">
                                <i class="nav-icon icon-note"></i>
                                <p class="title">@lang('menus.backend.sidebar.blogs.title')</p>
                            </a>
                        </li>
                    @endcan
                    @can('reason_access')
                        <li class="nav-item">
                            <a class="nav-link {{ $request->segment(2) == 'reasons' ? 'active' : '' }}"
                            href="{{ route('admin.reasons.index') }}">
                                <i class="nav-icon icon-layers"></i>
                                <p class="title">@lang('menus.backend.sidebar.reasons.title')</p>
                            </a>
                        </li>
                    @endcan
                @endif

                <li class="nav-item ">
                    <a class="nav-link {{ $request->segment(2) == 'messages' ? 'active' : '' }}"
                    href="{{ route('admin.messages') }}">
                        <i class="nav-icon icon-envelope-open"></i> 
                        <p class="title">@lang('menus.backend.sidebar.messages.title')</p>
                    </a>
                </li>
                @if ($logged_in_user->hasRole('employee'))
                    {{-- <li class="nav-item ">
                        <a class="nav-link {{ $request->segment(2) == 'invoices' ? 'active' : '' }}"
                        href="{{ route('admin.invoices.index') }}">
                            <i class="nav-icon icon-notebook"></i> 
                            <p class="title">@lang('menus.backend.sidebar.invoices.title')</p>
                        </a>
                    </li> --}}
                    <li class="nav-item ">
                        <a class="nav-link {{ $request->segment(2) == 'certificates' ? 'active' : '' }}"
                        href="{{ route('admin.certificates.index') }}">
                            <i class="nav-icon icon-badge"></i> 
                            <p class="title">@lang('menus.backend.sidebar.certificates.title')</p>
                        </a>
                    </li>
                @endif
                @if ($logged_in_user->isAdmin())
                    {{-- <li class="nav-item ">
                        <a class="nav-link {{ $request->segment(2) == 'reviews' ? 'active' : '' }}"
                        href="{{ route('admin.reviews.index') }}">
                            <i class="nav-icon icon-speech"></i> 
                            <p class="title">@lang('menus.backend.sidebar.reviews.title')</p>
                        </a>
                    </li> --}}
                
                    <li class="nav-item ">
                        <a class="nav-link {{ $request->segment(2) == 'contact-requests' ? 'active' : '' }}"
                        href="{{ route('admin.contact-requests.index') }}">
                            <i class="nav-icon icon-envelope-letter"></i>
                            <p class="title">@lang('menus.backend.sidebar.contacts.title')</p>
                        </a>
                    </li>
                    {{-- <li class="nav-item ">
                        <a class="nav-link {{ $request->segment(2) == 'coupons' ? 'active' : '' }}"
                        href="{{ route('admin.coupons.index') }}">
                            <i class="nav-icon icon-star"></i>
                            <p class="title">@lang('menus.backend.sidebar.coupons.title')</p>
                        </a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link {{ $request->segment(2) == 'tax' ? 'active' : '' }}"
                        href="{{ route('admin.tax.index') }}">
                            <i class="nav-icon icon-credit-card"></i>
                            <p class="title">@lang('menus.backend.sidebar.tax.title')</p>
                        </a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link {{ $request->segment(2) == 'payments-requests' ? 'active' : '' }}"
                        href="{{ route('admin.payments.requests') }}">
                            <i class="nav-icon icon-people"></i>
                            <p class="title">@lang('menus.backend.sidebar.payments_requests.title')</p>
                        </a>
                    </li> --}}
                @endif
                <li class="nav-item ">
                    <a class="nav-link {{ $request->segment(2) == 'account' ? 'active' : '' }}"
                    href="{{ route('admin.account') }}">
                        <i class="nav-icon icon-key"></i>
                        <p class="title">@lang('menus.backend.sidebar.account.title')</p>
                    </a>
                </li>
                @if ($logged_in_user->hasRole('employee'))
                {{-- <li class="nav-item ">
                    <a class="nav-link {{ $request->segment(2) == 'subscriptions' ? 'active' : '' }}"
                    href="{{ route('admin.subscriptions') }}">
                        <i class="nav-icon fas fa-briefcase"></i>
                        <p class="title">@lang('menus.backend.sidebar.subscription.title')</p>
                    </a>
                </li>
                <li class="nav-item ">
                    <a class="nav-link {{ $request->segment(2) == 'wishlist' ? 'active' : '' }}"
                    href="{{ route('admin.wishlist.index') }}">
                        <i class="nav-icon fas fa-heart"></i>
                        <p class="title">@lang('menus.backend.sidebar.wishlist.title')</p>
                    </a>
                </li> --}}
                @endif
                

                @if ($logged_in_user->isAdmin()||$logged_in_user->hasRole('company admin'))
                    <li class="nav-header">
                        @lang('menus.backend.sidebar.system')
                    </li>
                @endif
                {{-- @if ($logged_in_user->isAdmin())
                    <li class="nav-item  {{ active_class(Active::checkUriPattern(['admin/stripe*','admin/stripe/plans*']), 'open') }}">
                        <a class="nav-link  {{ active_class(Active::checkUriPattern('admin/stripe*')) }}"
                        href="#">
                            <i class="nav-icon fab fa-stripe"></i> 
                            <p>
                                @lang('menus.backend.stripe.title')
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a class="nav-link {{ active_class(Active::checkUriPattern('admin/stripe/plans*')) }}"
                                href="{{ route('admin.stripe.plans.index') }}">
                                <i class="far fa-circle nav-icon"></i>
                                    <p>
                                        @lang('menus.backend.stripe.plan')
                                    </p>    
                                </a>
                            </li>
                        </ul>
                    </li>
            @endif --}}
            @if ($logged_in_user->isAdmin()||$logged_in_user->hasRole('company admin'))

                    <li class="nav-item  {{ active_class(Active::checkUriPattern('admin/auth*'), 'open') }}">
                        <a class="nav-link  {{ active_class(Active::checkUriPattern('admin/auth*')) }}"
                        href="#">
                            <i class="nav-icon icon-user"></i> 
                            <p>
                                @lang('menus.backend.access.title')
                                <i class="fas fa-angle-left right"></i>
                            </p>
                            @if ($pending_approval > 0)
                                <span class="badge badge-danger">{{ $pending_approval }}</span>
                            @endif
                        </a>

                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a class="nav-link {{ active_class(Active::checkUriPattern('admin/auth/user*')) }}"
                                href="{{ route('admin.auth.user.index') }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>
                                    @lang('labels.backend.access.users.management')
                                </p>

                                    @if ($pending_approval > 0)
                                        <span class="badge badge-danger">{{ $pending_approval }}</span>
                                    @endif
                                </a>
                            </li>
                        @if ($logged_in_user->isAdmin())
                            <li class="nav-item">
                                <a class="nav-link {{ active_class(Active::checkUriPattern('admin/auth/role*')) }}"
                                href="{{ route('admin.auth.role.index') }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>
                                    @lang('labels.backend.access.roles.management')
                                </p>
                                </a>
                            </li>
                        @endif
                         
                        </ul>
                    </li>


                    <!--==================================================================-->
                    <li class="divider"></li>
                @endif
                    @if($logged_in_user->hasRole('company admin') || $logged_in_user->isAdmin())
                    <li class="nav-item {{ active_class(Active::checkUriPattern('admin/*'), 'open') }}">
                        <a class="nav-link {{ active_class(Active::checkUriPattern('admin/settings*')) }}"
                        href="#">
                            <i class="nav-icon icon-settings"></i> 
                            <p>
                                @lang('menus.backend.sidebar.settings.title')
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                       


                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a class="nav-link {{ active_class(Active::checkUriPattern('admin/settings')) }}"
                                href="{{ route('admin.general-settings') }}/{{ $logged_in_user->id }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>
                                        @lang('menus.backend.sidebar.settings.general')
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ active_class(Active::checkUriPattern('admin/settings')) }}"
                                href="{{ route('admin.mail-settings') }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>
                                        mail Template
                                    </p>
                                </a>
                            </li>
                            @if($logged_in_user->hasRole('company admin'))
                                <li class="nav-item ">
                                    <a class="nav-link {{ active_class(Active::checkUriPattern('admin/sliders*')) }}"
                                    href="{{ route('admin.sliders.index',['company'=>$logged_in_user->id]) }}">
                                    <i class="far fa-circle nav-icon"></i>
                                        <p class="title">@lang('menus.backend.sidebar.hero-slider.title')</p>
                                    </a>
                                </li>
                            @endif
                    @endif
                    @if($logged_in_user->isAdmin())
                            <li class="nav-item">
                                <a class="nav-link {{ active_class(Active::checkUriPattern('admin/log-viewer/logs*')) }}"
                                href="{{ route('admin.social-settings') }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>
                                        @lang('menus.backend.sidebar.settings.social-login')
                                    </p>
                                </a>
                            </li>
                    @endif
                    @if($logged_in_user->isAdmin()||$logged_in_user->hasRole('company admin'))
                            <li class="nav-item">
                                <a class="nav-link {{ active_class(Active::checkUriPattern('admin/settings/zoom-settings*')) }}"
                                href="{{ route('admin.zoom-settings') }}/{{ $logged_in_user->id }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>
                                        @lang('menus.backend.sidebar.settings.zoom_setting')
                                    </p>
                                </a>
                            </li>
                    @endif
                    @if($logged_in_user->isAdmin())
                        </ul>
                    </li>
                    <li class="nav-item  {{ active_class(Active::checkUriPattern('admin/log-viewer*'), 'open') }}">
                        <a class="nav-link {{ active_class(Active::checkUriPattern('admin/log-viewer*')) }}"
                        href="#">
                            <i class="nav-icon icon-list"></i> 
                            <p>
                            @lang('menus.backend.sidebar.debug-site.title')
                            <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>

                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a class="nav-link {{ active_class(Active::checkUriPattern('admin/log-viewer')) }}"
                                href="{{ route('log-viewer::dashboard') }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>
                                        @lang('menus.backend.log-viewer.dashboard')
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ active_class(Active::checkUriPattern('admin/log-viewer/logs*')) }}"
                                href="{{ route('log-viewer::logs.list') }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>
                                        @lang('menus.backend.log-viewer.logs')
                                    </p>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item ">
                        <a class="nav-link {{ $request->segment(2) == 'translation-manager' ? 'active' : '' }}"
                        href="{{ asset('user/translations') }}">
                            <i class="nav-icon icon-docs"></i>
                            <p class="title">@lang('menus.backend.sidebar.translations.title')</p>
                        </a>
                    </li>

                    <li class="nav-item ">
                        <a class="nav-link {{ $request->segment(2) == 'backup' ? 'active' : '' }}"
                        href="{{ route('admin.backup') }}">
                            <i class="nav-icon icon-shield"></i>
                            <p class="title">@lang('menus.backend.sidebar.backup.title')</p>
                        </a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link {{ $request->segment(2) == 'update-theme' ? 'active' : '' }}"
                        href="{{ route('admin.update-theme') }}">
                            <i class="nav-icon icon-refresh"></i>
                            <p class="title">@lang('menus.backend.sidebar.update.title')</p>
                        </a>
                    </li>

                    {{-- <li class="nav-item ">
                        <a class="nav-link {{ $request->segment(2) == 'payments' ? 'active' : '' }}"
                            href="{{ route('admin.payments') }}">
                            <i class="nav-icon icon-wallet"></i>
                            <p class="title">@lang('menus.backend.sidebar.payments.title')</p>
                        </a>
                    </li> --}}
                @endif
                
            </ul>
            
        </nav>

        <button class="sidebar-minimizer brand-minimizer" type="button"></button>
    </div><!--sidebar-->
</aside>
