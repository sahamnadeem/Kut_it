@extends('layouts.app')

@section('title', 'Dashboard')

@push('before-styles')
    <style>
        .margbg{
            margin:5px;
            display: inline-block;
            position: center;
        }
    </style>
    <link href="{{ asset('css/layout.min.css') }}" rel="stylesheet" type="text/css">
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
    <script src="{{ asset('js/plugins/visualization/d3/d3.min.js') }}"></script>
    <script src="{{ asset('js/plugins/visualization/d3/d3_tooltip.js') }}"></script>
    <script src="{{ asset('js/demo_pages/dashboard.js') }}"></script>
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
                @include('includes.pageheader');
            <!-- /page header -->


            <!-- Content area -->
            <div class="content">


                <!-- Dashboard content -->
                <div class="row">
                    <div class="col-xl-12">


                        <!-- Quick stats boxes -->
                        <div class="row">
                            <div class="col-lg-3">

                                <!-- Members online -->
                                <div class="card bg-teal-400">
                                    <div class="card-body">
                                        <div class="d-flex">
                                            <h3 class="font-weight-semibold mb-0">3,450</h3>
                                            <span class="badge bg-teal-800 badge-pill align-self-center ml-auto">+53,6%</span>
                                        </div>

                                        <div>
                                            Members online
                                            <div class="font-size-sm opacity-75">489 avg</div>
                                        </div>
                                    </div>

                                    <div class="container-fluid">
                                        <div id="members-online"></div>
                                    </div>
                                </div>
                                <!-- /members online -->

                            </div>

                            <div class="col-lg-3">

                                <!-- Current server load -->
                                <div class="card bg-pink-400">
                                    <div class="card-body">
                                        <div class="d-flex">
                                            <h3 class="font-weight-semibold mb-0">49.4%</h3>
                                            <div class="list-icons ml-auto">
                                                <div class="list-icons-item dropdown">
                                                    <a href="#" class="list-icons-item dropdown-toggle" data-toggle="dropdown"><i class="icon-cog3"></i></a>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        <a href="#" class="dropdown-item"><i class="icon-sync"></i> Update data</a>
                                                        <a href="#" class="dropdown-item"><i class="icon-list-unordered"></i> Detailed log</a>
                                                        <a href="#" class="dropdown-item"><i class="icon-pie5"></i> Statistics</a>
                                                        <a href="#" class="dropdown-item"><i class="icon-cross3"></i> Clear list</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div>
                                            Current server load
                                            <div class="font-size-sm opacity-75">34.6% avg</div>
                                        </div>
                                    </div>

                                    <div id="server-load"></div>
                                </div>
                                <!-- /current server load -->

                            </div>

                            <div class="col-lg-3">

                                <!-- Today's revenue -->
                                <div class="card bg-blue-400">
                                    <div class="card-body">
                                        <div class="d-flex">
                                            <h3 class="font-weight-semibold mb-0">$18,390</h3>
                                            <div class="list-icons ml-auto">
                                                <a class="list-icons-item" data-action="reload"></a>
                                            </div>
                                        </div>

                                        <div>
                                            Today's revenue
                                            <div class="font-size-sm opacity-75">$37,578 avg</div>
                                        </div>
                                    </div>

                                    <div id="today-revenue"></div>
                                </div>
                                <!-- /today's revenue -->

                            </div>

                            <div class="col-lg-3">

                                <!-- Current server load -->
                                <div class="card bg-purple-400">
                                    <div class="card-body">
                                        <div class="d-flex">
                                            <h3 class="font-weight-semibold mb-0">49.4%</h3>
                                            <div class="list-icons ml-auto">
                                                <div class="list-icons-item dropdown">
                                                    <a href="#" class="list-icons-item dropdown-toggle" data-toggle="dropdown"><i class="icon-cog3"></i></a>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        <a href="#" class="dropdown-item"><i class="icon-sync"></i> Update data</a>
                                                        <a href="#" class="dropdown-item"><i class="icon-list-unordered"></i> Detailed log</a>
                                                        <a href="#" class="dropdown-item"><i class="icon-pie5"></i> Statistics</a>
                                                        <a href="#" class="dropdown-item"><i class="icon-cross3"></i> Clear list</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div>
                                            Current server load
                                            <div class="font-size-sm opacity-75">34.6% avg</div>
                                        </div>
                                    </div>

                                    <div id="server-loadtwo"></div>
                                </div>
                                <!-- /current server load -->

                            </div>
                        </div>
                        <!-- /quick stats boxes -->
                        <div class="row">
                            <div class="col-lg-6">
                                <div>
                                    <div class="card">
                                        <div class="card-header header-elements-inline">
                                            <h5 class="card-title">Service Request List</h5>
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
                                                <th>Title</th>
                                                <th>price</th>
                                                <th>created_by</th>
                                                <th>Actions</th>
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
                                                    ajax: '{!! route('request.index') !!}',
                                                    columns: [
                                                        { data: 'DT_RowIndex', name: 'DT_RowIndex' },
                                                        { data: 'title', name: 'title' },
                                                        { data: 'price', name: 'price' },
                                                        { data: 'created_by_user', name: 'created_by_user' },
                                                        { data: 'actions', name: 'actions' }
                                                    ],
                                                    "lengthMenu": [ [5, 10, 25, 50, 100, -1], [5, 10, 25, 50, 100, "All"] ],
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
                            <div class="col-lg-6">
                                <div>
                                    <div class="card">
                                        <div class="card-header header-elements-inline">
                                            <h5 class="card-title">Barber Request List</h5>
                                            <div class="header-elements">
                                                <div class="list-icons">
                                                    <a class="list-icons-item" data-action="collapse"></a>
                                                </div>
                                            </div>
                                        </div>

                                        <table class="table" id="rtable">
                                            <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Name</th>
                                                <th>Status</th>
                                                <th>Actions</th>
                                            </tr>
                                            </thead>
                                        </table>
                                    </div>
                                    @push('after-scripts')
                                        <script>
                                            $(function() {
                                                $('#rtable').DataTable({
                                                    processing: true,
                                                    serverSide: true,
                                                    autoWidth: false,
                                                    responsive: true,
                                                    ajax: '{!! route('barber.request.index') !!}',
                                                    columns: [
                                                        { data: 'DT_RowIndex', name: 'DT_RowIndex' },
                                                        { data: 'name', name: 'name' },
                                                        { data: 'status', name: 'status' },
                                                        { data: 'actions', name: 'actions' }
                                                    ],
                                                    "lengthMenu": [ [5, 10, 25, 50, 100, -1], [5, 10, 25, 50, 100, "All"] ],
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
