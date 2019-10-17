@extends('layouts.app')

@section('title', 'Booking Management')

@push('before-styles')
    <style>
        .margbg{
            margin:5px;
            display: inline-block;
            position: center;
        }
    </style>
    <link href="{{ asset('css/layout.min.css') }}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />
@endpush

@push('after-scripts')
    <script src="{{ asset('js/plugins/extensions/jquery_ui/interactions.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>
    <script src="{{ asset('js/plugins/tables/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('js/plugins/forms/selects/select2.min.js') }}"></script>
    <script src="{{ asset('js/plugins/tables/datatables/extensions/jszip/jszip.min.js') }}"></script>
    <script src="{{ asset('js/plugins/tables/datatables/extensions/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ asset('js/plugins/tables/datatables/extensions/pdfmake/vfs_fonts.min.js') }}"></script>
    <script src="{{ asset('js/plugins/tables/datatables/extensions/buttons.min.js') }}"></script>
    <script src="{{ asset('js/myapp.js') }}"></script>
    <script src="{{ asset('js/custom.js') }}"></script>
    <script src="{{ asset('js/demo_pages/datatables_extension_buttons_html5.js') }}"></script>
    <script src="{{ asset('js/plugins/forms/styling/uniform.min.js') }}"></script>
    <script src="{{ asset('js/plugins/forms/selects/bootstrap_multiselect.js') }}"></script>
    <script src="{{ asset('js/demo_pages/form_multiselect.js') }}"></script>

@endpush

@section('content')
    @include('includes.navbar')
    <!-- Page content -->
    <div class="page-content" style="margin-top: 0px; ">
        <!-- Main sidebar -->
    @include('includes.sidebar')
    <!-- /main sidebar -->
        <!-- Main content -->
        <div class="content-wrapper">
            <!-- Page header -->
        @include('includes.pageheader')
        <!-- /page header -->
            <!-- Content area -->
            <div class="content">
                <!-- Dashboard content -->
                <div class="row">
                    <div class="col">
                        <!-- Quick stats boxes -->

                        <div class="row">
                            <div class="col-lg-12">
                                <div>
                                    <div class="card">
                                        <div class="card-header header-elements-inline">
                                            <h5 class="card-title">Bookings List</h5>
                                            <div class="header-elements">
                                                <div class="list-icons">
                                                    <a class="list-icons-item" data-action="collapse"></a>
                                                </div>
                                            </div>
                                        </div>

                                        <table class="table" id="utable">
                                            <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>customer</th>
                                                <th>Barber</th>
                                                <th>Order Value</th>
                                                <th>Status</th>
                                                <th>Cancled By</th>
                                                <th>Date Time</th>
                                            </tr>
                                            </thead>
                                        </table>
                                    </div>
                                    @push('after-scripts')
                                        <script>
                                            $(function() {
                                                $('#utable').DataTable({
                                                    processing: true,
                                                    serverSide: true,
                                                    autoWidth: false,
                                                    responsive: true,
                                                    ajax: '{!! route('bookings.index') !!}',
                                                    columns: [
                                                        { data: 'DT_RowIndex', name: 'DT_RowIndex' },
                                                        { data: 'user', name: 'user' },
                                                        { data: 'barber', name: 'barber' },
                                                        { data: 'total', name: 'total' },
                                                        { data: 'status', name: 'status' },
                                                        { data: 'canceled_by', name: 'canceled_by' },
                                                        { data: 'created_at', name: 'created_at' }
                                                    ],
                                                    "lengthMenu": [ [10, 25, 50, 100, -1], [10, 25, 50, 100, "All"] ],
                                                    buttons: {
                                                        dom: {
                                                            button: {
                                                                className: 'btn btn-light'
                                                            }
                                                        },
                                                        buttons: [
                                                            'copyHtml5',
                                                            'excelHtml5',
                                                            'csvHtml5',
                                                            'pdfHtml5'
                                                        ],
                                                        'columnDefs': [
                                                            {
                                                                "className": "dt-center", "targets": "_all"
                                                            }
                                                        ],
                                                    }
                                                });
                                            });
                                        </script>
                                @endpush
                                <!-- /basic initialization -->


                                </div>
                            </div>
                        </div>
                        <!-- /quick stats boxes -->
                    </div>
                </div>
                <!-- /dashboard content -->
            </div>
            <!-- /content area -->


            <!-- Footer -->
        @include('includes.footer')
        <!-- /footer -->

        </div>
        <!-- /main content -->

    </div>
@endsection

