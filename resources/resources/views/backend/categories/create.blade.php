@extends('backend.layouts.app')
@section('title', __('labels.backend.categories.title').' | '.app_name())

@push('after-styles')
    <link rel="stylesheet" href="{{asset('plugins/bootstrap-iconpicker/css/bootstrap-iconpicker.min.css')}}"/>
@endpush
@section('content')

    <div class="card">
        <div class="card-header">
            <h3 class="page-title d-inline">@lang('labels.backend.categories.create')</h3>
            <div class="float-right">
                <a href="{{ route('admin.categories.index',['company' => $company]) }}"
                   class="btn btn-success">@lang('labels.backend.categories.view')</a>

            </div>
        </div>
        <div class="card-body">
            {!! Form::open(['method' => 'POST', 'route' => ['admin.categories.store'], 'files' => true,]) !!}
            @if(auth()->user()->isAdmin())
                <div class="form-group row">        
                    <div class="col-md-4">
                        <select type="text" id="company_id" name="company_id" class="form-control js-example-placeholder-single select2"  aria-invalid="false">
                            <option value="" disabled selected> {{ __('validation.attributes.backend.access.users.company_name') }} </option>
                            @foreach ($Companies as $company_c)
                            <option value="{{$company_c->id}}" {{ $company_c->id==$company?'selected':''}}>{{$company_c->company_name}}</option>
                            @endforeach
                        </select>
                    </div><!--col-->
                </div><!--form-group-->
            @else
            <input type="hidden" name="company_id" value="{{ $company }}" />
            @endif
            <div class="row">
                <div class="col-12">

                    

                    <div class="row justify-content-center">
                        <div class="col-12 col-lg-4 form-group">
                            {!! Form::label('title', trans('labels.backend.categories.fields.name').' *', ['class' => 'control-label']) !!}
                            {!! Form::text('name', old('name'), ['class' => 'form-control', 'placeholder' => trans('labels.backend.categories.fields.name'), 'required' => false]) !!}

                        </div>


                        <div class="col-12 col-lg-2  form-group">

                                {!! Form::label('icon',  trans('labels.backend.categories.fields.select_icon'), ['class' => 'control-label  d-block']) !!}
                                <button class="btn  btn-block btn-default border" id="icon" name="icon"></button>

                        </div>

                        <div class="col-12 form-group text-center">

                            {!! Form::submit(trans('strings.backend.general.app_save'), ['class' => 'btn mt-auto  btn-danger']) !!}
                        </div>
                    </div>

                    {!! Form::close() !!}


                </div>

            </div>
        </div>
    </div>
@endsection

@push('after-scripts')
    <script src="{{asset('plugins/bootstrap-iconpicker/js/bootstrap-iconpicker.bundle.min.js')}}"></script>

    <script>
        $(document).ready(function () {
            $('#icon').iconpicker({
                cols: 10,
                icon: 'fas fa-bomb',
                iconset: 'fontawesome5',
                labelHeader: '{0} of {1} pages',
                labelFooter: '{0} - {1} of {2} icons',
                placement: 'bottom', // Only in button tag
                rows: 5,
                search: true,
                searchText: 'Search',
                selectedClass: 'btn-success',
                unselectedClass: ''
            });


        })

    </script>
@endpush
