@extends('backend.layouts.app')

@section('title', app_name() . ' | ' . __('labels.backend.access.users.management'))

@section('breadcrumb-links')
    @include('backend.auth.user.includes.breadcrumb-links')
@endsection

@section('content')
    {!! Form::open(['method' => 'POST', 'route' => ['admin.auth.user.upload'], 'files' => true]) !!}
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-7">
                        <h4 class="card-title mb-0">
                            Import User
                            <small class="text-muted">{{ __('labels.backend.access.users.active') }}</small>
                        </h4>
                    </div><!--col-->
                </div><!--row-->

                <div class="row mt-4">
                    <div class="col-12 form-group text-center">
                        {{-- {!! Form::label('course_image', 'Choose CSV File', ['class' => 'control-label']) !!} --}}
                        <div class="h3"> Choose CSV File </div>
                        <div class="" style="margin-left:3%">
                            <input type="file" id="user_file" accept="application/vnd.ms-excel" name="user_file">                    
                        </div>
                    </div><!--col-->
                </div><!--row-->
                <div class="row mt-4">
                    <div class="form-actions col-12" style="border-top:0px;">
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary" name="addBtn">
                                Save 
                                <i class="ft-thumbs-up position-right"></i></button>
                            <a href="{{ route('admin.auth.user.index') }}" class="btn btn-warning ml-1" data-toggle="tooltip" title="Back To Users Table">Back</a>
                        </div>
                    </div>
                </div>
            </div><!--card-body-->
        </div><!--card-->
    {!! Form::close() !!}
@endsection


@push('after-scripts')
    <script>


    </script>

@endpush
