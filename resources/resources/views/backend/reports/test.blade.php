@extends('backend.layouts.app')

@section('title', __('labels.backend.reports.students_report').' | '.app_name())

@push('after-styles')
    <style>
        .dataTables_wrapper .dataTables_filter {
            float: right !important;
            text-align: left;
            margin-left: 25%;
        }

        div.dt-buttons {
            display: inline-block;
            width: 100%;
            text-align: center;
        }
    </style>
@endpush
@section('content')
     
    <div class="card">
        <div class="card-header">
            <h3 class="page-title d-inline">  Course  Details of : {{ $name->title }}</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <div class="table-responsive">
                        <table id="myTable" class="table table-bordered table-striped ">
                            <thead>
                            <tr>
                                <th>@lang('labels.general.sr_no')</th>
                                {{--  @lang('labels.backend.reports.fields.course')  --}}
                                <th>test name</th>
                                <th>@lang('labels.backend.reports.name') </th>
                                <th>email</th>
                                <th>result</th>
                                <th>created_at</th>
                                {{--  <th>@lang('labels.backend.reports.results')</th>  --}}
                                {{--  <th>@lang('labels.backend.reports.quiz') (@lang('labels.backend.reports.try')) </th>  --}}
                                {{--  <th> date </th>  --}}
                            </tr>
                            </thead>

                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@stop

@push('after-scripts')
    <script>

        $(document).ready(function () {
            var course_route = "{{route('admin.reports.get_tests_data', $id)}}";

           

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
                            columns: ':visible',
                        }
                    },
                    {
                        extend: 'pdf',
                        exportOptions: {
                            columns: ':visible',
                        }
                    },
                    'colvis'
                ],
                ajax: course_route,
                columns: [

                    {data: "DT_RowIndex", name: 'DT_RowIndex', width: '8%'},                    
                    {data: "test_name", name: 'test_name'},
                    {data: "name", name: 'name'},
                    {data: "email", name: 'email'},
                    {data: "result", name: 'result'},
                    {data: "created_at", name: 'created_at'},
                     
                ],
                language:{
                    url : "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/{{$locale_full_name}}.json",
                    buttons :{
                        colvis : '{{trans("datatable.colvis")}}',
                        pdf : '{{trans("datatable.pdf")}}',
                        csv : '{{trans("datatable.csv")}}',
                    }
                },

                createdRow: function (row, data, dataIndex) {
                    $(row).attr('data-entry-id', data.id);
                },
            });
        });

    </script>

@endpush
