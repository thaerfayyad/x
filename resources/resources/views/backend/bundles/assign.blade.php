@extends('backend.layouts.app')
@section('title', __('labels.backend.bundles.title').' | '.app_name())

@section('content')

    {!! Form::model($bundle, ['method' => 'POST', 'route' => ['admin.courses.getNow', $bundle->id], 'files' => true,]) !!}

    <div class="card">
        <div class="card-header">
            <h3 class="page-title float-left mb-0">@lang('labels.backend.bundles.edit')</h3>
            <div class="float-right">
                <a href="{{ route('admin.bundles.index',['company' => $company]) }}"
                   class="btn btn-success">@lang('labels.backend.bundles.view')</a>
            </div>
        </div>
        <input type="hidden" name="bundle_id" value="{{ $bundle_id}}" />
        <div class="card-body">
                <div class="row">
                    <div class="col-10 form-group">
                        {!! Form::label('teachers',('Employees'), ['class' => 'control-label']) !!}
                            <select type="text" id="employee_id[]" name="employee_id[]" multiple class="form-control select2 multiple"  aria-invalid="false">
                                @foreach ($employees as $id=>$name)
                                <option value="{{$id}}"@foreach ($employees_enroll as $ee)@if($ee->id==$id) selected @endif @endforeach>{{$name}}</option>
                                @endforeach
                            </select>
                    </div>
                </div>

            

            <div class="row">
                <div class="col-12  text-center form-group">
                    {!! Form::submit(trans('strings.backend.general.app_update'), ['class' => 'btn btn-danger']) !!}
                </div>
            </div>
        </div>
    </div>

    {!! Form::close() !!}
@stop

@push('after-scripts')
    <script>

        $(document).ready(function () {
            $(".js-example-placeholder-multiple").select2({
                placeholder: "{{trans('labels.backend.bundles.select_teachers')}}",
            });
        });

    </script>

@endpush
