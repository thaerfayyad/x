@extends('backend.layouts.app')
@section('title', __('labels.backend.upload.articles').' | '.app_name())

@push('after-styles')
    <link rel="stylesheet" href="{{asset('plugins/bootstrap-iconpicker/css/bootstrap-iconpicker.min.css')}}"/>

    <link rel="stylesheet" href="{{asset('assets/css/colors/switch.css')}}">
    <style>
        .color-list li {
            float: left;
            width: 8%;
        }

        .options {
            line-height: 35px;
        }

        .color-list li a {
            font-size: 20px;
        }

        .color-list li a.active {
            border: 4px solid grey;
        }

        .color-default {
            font-size: 18px !important;
            background: #101010;
            border-radius: 100%;
        }

        .form-control-label {
            line-height: 35px;
        }

        .switch.switch-3d {
            margin-bottom: 0px;
            vertical-align: middle;

        }

        .color-default i {
            background-clip: text;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .preview {
            background-color: #dcd8d8;
            background-image: url(https://www.transparenttextures.com/patterns/carbon-fibre-v2.png);
        }
    </style>
@endpush
@section('content')
    

    <div class="card">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="card-header">
            <div class="row">
                <div class="col-sm-5">
                    <h3 class="page-title d-inline">      @lang('labels.backend.upload.articles')</h3>
                </div>
            </div>
        </div>
        <form action="{{ route('admin.articles.store') }}" method="POST" enctype="multipart/form-data">
            
            @csrf
            <div class="card-body"  >
 
                <div class="row">
                    <div class="col-sm-12  ">
                        <div class="form-group row">
                            <label>    @lang('labels.backend.upload.name') </label>
                            <input type="text" name="name"  class="form-control "  >
                        </div>
                    </div>
                    <div class="col-sm-12  ">
                        <div class="form-group row">
                            <label>    @lang('labels.backend.upload.descriptoin')</label>
                           <textarea name="description" id="description"  class="form-control" cols="30" rows="5"></textarea>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="form-group">
                            <label>  @lang('labels.backend.upload.uploadFile')</label>
                            <input type="file" name="files" class="form-control" >
                        </div>                   

                    </div>
                   
                    <div class="col-md-8">
                        <div class="form-group">
                            <label>    @lang('labels.backend.upload.image')</label>
                            <input type="file" name="image" class="form-control image" >
                        </div>                   

                    </div>
                  
                    <div class="col-md-2">
                        <div class="form-group">
                          
                              <img src=" " style="width: 1000px" class="img-thumbnail image-preview" alt="">
                        </div>

                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-update"></i> @lang('strings.backend.general.app_save')</button>
                    </div>
                
                </div>
            </div>
        </form>
         
    </div>

 

@endsection


@push('after-scripts')
    <script>


        // // image preview
         $(".image").change(function () {
         
             if (this.files && this.files[0]) {
             var reader = new FileReader();
        
                reader.onload = function (e) {
                     $('.image-preview').attr('src', e.target.result);
                 }
        
               reader.readAsDataURL(this.files[0]);
             }
         });  




        //=========Preset contact data ==========//
       @if(config('contact_data'))
            var contact_data = {!! config('contact_data') !!};


        $(contact_data).each(function (key, element) {
            if (element.name == 'location_on_map') {
                $('#' + element.name).html(element.value);

            } else {
                $('#' + element.name).val(element.value)
            }

            if (element.status == 1) {
                $('#' + element.name).parents('.form-group').find('input[type="checkbox"]').attr('checked', true);
            } else {
                $('#' + element.name).parents('.form-group').find('input[type="checkbox"]').attr('checked', false);
            }
        });
        @endif


        $(document).on('submit', '#general-settings-form', function (e) {
//                            e.preventDefault();
            //============Saving Contact Details=====//
            var dataJson = {};
            var inputs = $('#contact').find('input[type="text"],textarea,input[type="email"]');
            var data = [];
            var val, name, status
            $(inputs).each(function (key, value) {
                name = $(value).attr('id')
                if (name == 'location_on_map') {
                    val = $(value).val().replace(/"/g, "'")
                } else {
                    val = $(value).val()
                }
                status = ($(value).parents('.form-group').find('input[type="checkbox"]:checked').val()) ? 1 : 0;
                data.push({name: name, value: val, status: status});
            });
            dataJson = JSON.stringify(data);
            $('#contact_data').val(dataJson);
        });
    </script>
@endpush