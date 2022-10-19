@extends('backend.layouts.app')
@section('title', __('labels.backend.teachers.title').' | '.app_name())

@section('content')
    {{ html()->modelForm($teacher, 'PATCH', route('admin.teachers.update', $teacher->id))->class('form-horizontal')->acceptsFiles()->open() }}

    <div class="card">
        <div class="card-header">
            <h3 class="page-title d-inline">@lang('labels.backend.teachers.edit')</h3>
            <div class="float-right">
                <a href="{{ route('admin.teachers.index') }}"
                   class="btn btn-success">@lang('labels.backend.teachers.view')</a>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <div class="form-group row">
                        {{ html()->label(__('labels.backend.teachers.fields.first_name'))->class('col-md-2 form-control-label')->for('first_name') }}

                        <div class="col-md-10">
                            {{ html()->text('first_name')
                                ->class('form-control')
                                ->placeholder(__('labels.backend.teachers.fields.first_name'))
                                ->attribute('maxlength', 191)
                                ->required()
                                ->autofocus() }}
                        </div><!--col-->
                    </div><!--form-group-->

                    <div class="form-group row">
                        {{ html()->label(__('labels.backend.teachers.fields.last_name'))->class('col-md-2 form-control-label')->for('last_name') }}

                        <div class="col-md-10">
                            {{ html()->text('last_name')
                                ->class('form-control')
                                ->placeholder(__('labels.backend.teachers.fields.last_name'))
                                ->attribute('maxlength', 191)
                                ->required() }}
                        </div><!--col-->
                    </div><!--form-group-->

                    <div class="form-group row">
                        {{ html()->label(__('labels.backend.teachers.fields.email'))->class('col-md-2 form-control-label')->for('email') }}

                        <div class="col-md-10">
                            {{ html()->email('email')
                                ->class('form-control')
                                ->placeholder(__('labels.backend.teachers.fields.email'))
                                ->attributes(['maxlength'=> 191,'readonly'=>true])
                                ->required() }}
                        </div><!--col-->
                    </div><!--form-group-->

                    <div class="form-group row">
                        {{ html()->label(__('labels.backend.teachers.fields.password'))->class('col-md-2 form-control-label')->for('password') }}

                        <div class="col-md-10">
                            {{ html()->password('password')
                                ->class('form-control')
                                ->value('')
                                ->placeholder(__('labels.backend.teachers.fields.password'))
}}
                        </div><!--col-->
                    </div><!--form-group-->

                    <div class="form-group row">
                        {{ html()->label(__('labels.backend.teachers.fields.image'))->class('col-md-2 form-control-label')->for('image') }}

                        <div class="col-md-10">
                            {!! Form::file('image', ['class' => 'form-control d-inline-block', 'placeholder' => '']) !!}
                        </div><!--col-->
                    </div>
                    <div class="form-group row">
                        {{ html()->label(__('labels.backend.general_settings.user_registration_settings.fields.gender'))->class('col-md-2 form-control-label')->for('gender') }}
                        <div class="col-md-10">
                            <label class="radio-inline mr-3 mb-0">
                                <input type="radio" name="gender" value="male" {{ $teacher->gender == 'male'?'checked':'' }}> {{__('validation.attributes.frontend.male')}}
                            </label>
                            <label class="radio-inline mr-3 mb-0">
                                <input type="radio" name="gender" value="female" {{ $teacher->gender == 'female'?'checked':'' }}> {{__('validation.attributes.frontend.female')}}
                            </label>
                            <label class="radio-inline mr-3 mb-0">
                                <input type="radio" name="gender" value="other" {{ $teacher->gender == 'other'?'checked':'' }}> {{__('validation.attributes.frontend.other')}}
                            </label>
                        </div>
                    </div>

                    @php
                        $teacherProfile = $teacher->teacherProfile?:'';
                        $payment_details = $teacher->teacherProfile?json_decode($teacher->teacherProfile->payment_details):new stdClass();
                    @endphp

                    

                    <div class="form-group row">
                        {{ html()->label(__('labels.teacher.description'))->class('col-md-2 form-control-label')->for('description') }}

                        <div class="col-md-10">
                            {{ html()->textarea('description')
                                    ->class('form-control')
                                    ->value($teacherProfile!=''?$teacherProfile->description:'')
                                    ->placeholder(__('labels.teacher.description')) }}
                        </div><!--col-->
                    </div>

                    <div class="form-group row">
                        {{ html()->label(__('labels.backend.teachers.fields.status'))->class('col-md-2 form-control-label')->for('active') }}
                        <div class="col-md-10">
                            {{ html()->label(html()->checkbox('')->name('active')
                                        ->checked(($teacher->active == 1) ? true : false)->class('switch-input')->value(($teacher->active == 1) ? 1 : 0)

                                    . '<span class="switch-label"></span><span class="switch-handle"></span>')
                                ->class('switch switch-lg switch-3d switch-primary')
                            }}
                        </div>

                    </div>
                    <div class="form-group row">
                        {{ html()->label(__('labels.backend.teachers.fields.is_company'))->class('col-md-2 form-control-label')->for('is_company') }}
                            <div class="col-md-10">
                                {{ html()->label(html()->checkbox('')->name('is_company')
                                ->id('is_company')
                                    ->checked(($teacher->is_company == 1) ? true : false)->class('switch-input')->value(($teacher->is_company == 1) ? 1 : 0)
                                        . '<span class="switch-label"></span><span class="switch-handle"></span>')
                                    ->class('switch switch-lg switch-3d switch-primary')

                                }}
                            </div>
                    </div>
                    <div class="form-group row company_form" {{ ($teacher->is_company == 1)?'':'style=display:none' }}>
                        {{ html()->label(__('labels.backend.teachers.fields.company_name'))->class('col-md-2 form-control-label')->for('company_name') }}

                        <div class="col-md-10">
                            {{ html()->text('company_name')
                                ->class('form-control')
                                ->value($teacher->company_name)
                                ->placeholder(__('labels.backend.teachers.fields.company_name'))
                            }}
                        </div><!--col-->
                    </div><!--form-group-->
                    <div class="form-group row justify-content-center">
                        <div class="col-4">
                            {{ form_cancel(route('admin.teachers.index'), __('buttons.general.cancel')) }}
                            {{ form_submit(__('buttons.general.crud.update')) }}
                        </div>
                    </div><!--col-->
                </div>
            </div>
        </div>

    </div>
    {{ html()->closeModelForm() }}
@endsection
@push('after-scripts')
    <script>
        $(document).on('change', '#payment_method', function(){
            if($(this).val() === 'bank'){
                $('.paypal_details').hide();
                $('.bank_details').show();
            }else{
                $('.paypal_details').show();
                $('.bank_details').hide();
            }
        });
        $(document).on('change', '#is_company', function(){

            if($(this).is(':checked')) 
                $(".company_form").show(); // checked
            else
                $(".company_form").hide(); 
        });
    </script>
@endpush