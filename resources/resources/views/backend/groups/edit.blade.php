@extends('backend.layouts.app')
@section('title', __('labels.backend.courses.title') . ' | ' . app_name())

@section('content')

    {!! Form::open(['method' => 'PUT', 'route' =>  ['admin.groups.update',$group->id], 'files' => true]) !!}

    <div class="card">
        <div class="card-header">
            <h3 class="page-title float-left">Create Group</h3>
            <div class="float-right">
                <a href="{{ route('admin.groups.index') }}" class="btn btn-success"> View Groups</a>
            </div>
        </div>
        

        <div class="card-body">


            <div class="row">
                <div class="col-10 form-group">
                    {!! Form::label('name', trans('labels.backend.courses.fields.title') . ' *', ['class' => 'control-label']) !!}
                    <input type="text" class="form-control" name="name" id="name" value="{{ $group->name }}"  >
                     
                </div>

            </div> 
            <div class="row">
                <div class="col-10 form-group">
                    {!! Form::label('user',('Employees'), ['class' => 'control-label']) !!}
                    <select type="text" id="user[]" name="users[]" multiple class="form-control select2 multiple"  aria-invalid="false">
                     @foreach ($employees as  $employee)
 

                        <option value="{{  $employee->id }}"@foreach ($employees_enroll as $ee)@if($ee->id==$employee->id) selected @endif @endforeach >{{ $employee->name}}</option>
                         
                     @endforeach
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-12  text-center form-group">

                    {!! Form::submit(trans('strings.backend.general.app_save'), ['class' => 'btn btn-lg btn-danger']) !!}
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}


@stop

@push('after-scripts')
    <script type="text/javascript" src="{{ asset('/vendor/unisharp/laravel-ckeditor/ckeditor.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/vendor/unisharp/laravel-ckeditor/adapters/jquery.js') }}"></script>
    <script src="{{ asset('/vendor/laravel-filemanager/js/lfm.js') }}"></script>
    <script>
        $('.editor').each(function() {

            CKEDITOR.replace($(this).attr('id'), {
                filebrowserImageBrowseUrl: '/laravel-filemanager?type=Images',
                filebrowserImageUploadUrl: '/laravel-filemanager/upload?type=Images&_token={{ csrf_token() }}',
                filebrowserBrowseUrl: '/laravel-filemanager?type=Files',
                filebrowserUploadUrl: '/laravel-filemanager/upload?type=Files&_token={{ csrf_token() }}',
                extraPlugins: 'smiley,lineutils,widget,codesnippet,prism,flash,colorbutton,colordialog',
            });

        });

        $(document).ready(function() {
            $('#start_date').datepicker({
                autoclose: true,
                dateFormat: "{{ config('app.date_format_js') }}"
            });

            var dateToday = new Date();
            $('#expire_at').datepicker({
                autoclose: true,
                minDate: dateToday,
                dateFormat: "{{ config('app.date_format_js') }}"
            });

            $(".js-example-placeholder-single").select2({
                placeholder: "{{ trans('labels.backend.courses.select_category') }}",
            });

            $(".js-example-placeholder-multiple").select2({
                placeholder: "{{ trans('labels.backend.courses.select_teachers') }}",
            });
        });

        var uploadField = $('input[type="file"]');

        $(document).on('change', 'input[type="file"]', function() {
            var $this = $(this);
            $(this.files).each(function(key, value) {
                if (value.size > 5000000) {
                    alert('"' + value.name + '"' + 'exceeds limit of maximum file upload size')
                    $this.val("");
                }
            })
        })


        $(document).on('change', '#media_type', function() {
            if ($(this).val()) {
                if ($(this).val() != 'upload') {
                    $('#video').removeClass('d-none').attr('required', true)
                    $('#video_file').addClass('d-none').attr('required', false)
                    //                    $('#video_subtitle_box').addClass('d-none').attr('required', false)

                } else if ($(this).val() == 'upload') {
                    $('#video').addClass('d-none').attr('required', false)
                    $('#video_file').removeClass('d-none').attr('required', true)
                    //                    $('#video_subtitle_box').removeClass('d-none').attr('required', true)
                }
            } else {
                $('#video_file').addClass('d-none').attr('required', false)
                //                $('#video_subtitle_box').addClass('d-none').attr('required', false)
                $('#video').addClass('d-none').attr('required', false)
            }
        })
    </script>
@endpush
