@inject('request', 'Illuminate\Http\Request')
@extends('backend.layouts.app')
@section('title', __('labels.backend.courses.title').' | '.app_name())

@section('content')


    <div class="card">
        <div class="card-header">
            {{--  @lang('labels.backend.courses.title')   --}}
            <h3 class="page-title float-left mb-0">@lang('menus.backend.sidebar.bundles.groups')</h3>
            @can('course_create')
                <div class="float-right">
                    
                    <a href="{{ route('admin.groups.create') }}"
                       class="btn btn-success">@lang('strings.backend.general.app_add_new')</a>

                </div>
            @endcan
        </div>
        <div class="card-body">
            @if(auth()->user()->isAdmin())
                <div class="form-group row">        
                    <div class="col-md-4">
                        <select type="text" id="company_id" name="company_id" class="form-control js-example-placeholder-single select2"  aria-invalid="false">
                            <option value="" disabled selected> {{ __('validation.attributes.backend.access.users.company_name') }} </option>
                           
                            <option value=" " > </option>
                         
                        </select>
                    </div><!--col-->
                </div><!--form-group-->
            @else
            <input type="hidden" name="company_id" value=" " />
            @endif
            <div class="table-responsive">
                <div class="d-block">
                    <ul class="list-inline">
                        <li class="list-inline-item">
                            <a href=" "
                               style="{{ request('show_deleted') == 1 ? '' : 'font-weight: 700' }}">{{trans('labels.general.all')}}</a>
                        </li>
                        
                        <li class="list-inline-item">
                            <a href=" "
                               style="{{ request('show_deleted') == 1 ? 'font-weight: 700' : '' }}">{{trans('labels.general.trash')}}</a>
                        </li>
                    </ul>
                </div>


                <table id="myTable" class="table table-bordered table-striped @can('course_delete') @if ( request('show_deleted') != 1 ) dt-select @endif @endcan">
                    <thead>
                    <tr>
                         
                        <th>@lang('labels.general.id')</th>
                        <th>@lang('labels.backend.access.users.table.name')</th>                     
                        <th>&nbsp; @lang('strings.backend.general.actions')</th>

                    </tr>
                    </thead>

                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@stop

@push('after-scripts')
    <script>
        $(document).on('change', '#company_id', function () {
            location.href = '{{ url('user/courses')}}/'+$(this).val();
        });
        $(document).ready(function () {
            var route = '{{route('admin.group.get_data')}}';

            $('#myTable').DataTable({
                processing: true,
                serverSide: true,
                iDisplayLength: 10,
                retrieve: true,
                dom: 'lfBrtip<"actions">',
                buttons: [
                    {
                        extend: 'csv',
                        exportOptions: {
                            columns: [ 1, 2, 3]
                        }
                    },
                    {
                        extend: 'pdf',
                        exportOptions: {
                            columns: [ 1, 2, 3 ]
                        }
                    },
                    'colvis'
                ],
                ajax: route,
                columns: [
                    {data: "DT_RowIndex", name: 'DT_RowIndex', searchable: false, orderable:false},
                    {{--  {data: "id", name: 'id'},  --}}
                    {data: "name", name: 'name'},
                    {data: "actions", name: "actions"}
                ],
                language:{
                    url : "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/{{$locale_full_name}}.json",
                    buttons :{
                        colvis : '{{trans("datatable.colvis")}}',
                        pdf : '{{trans("datatable.pdf")}}',
                        csv : '{{trans("datatable.csv")}}',
                    }
                }
            });
        });

    </script>

@endpush