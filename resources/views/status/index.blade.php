@extends('layouts.app')

@section('title', 'Role Management')

@push('before-styles')
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
            @include('includes.pageheader');
            <!-- /page header -->
            <!-- Content area -->
            <div class="content">
                <!-- Dashboard content -->
                <div class="row">
                    <div class="col-xl-12">
                        <!-- Quick stats boxes -->
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-header header-elements-inline">
                                        <h6 class="card-title">{{ (isset($status)? 'Update Status':'Add Status') }}</h6>
                                        <div class="header-elements">
                                            <div class="list-icons">
                                                <a class="list-icons-item" data-action="collapse"></a>
                                            </div>
                                        </div>
                                    </div>

                                        <div class="card-body">
                                            @if(isset($status))
                                                {{ Form::model($status,['method'=>'put','route' => ['status.update',$status->id]]) }}
                                            @else
                                                {{ Form::open(['route' => 'status.store']) }}
                                            @endif
                                            <div class="row">
                                                <div class="col">
                                                    <div class="form-group">
                                                        {{ Form::label('title','Title') }}<span style="color: red;">*</span>
                                                        {{ Form::text('title',old('title'),array('class'=>'form-control', 'style'=> 'margin-bottom:10px;','placeholder'=>'Enter title')) }}
                                                        {!! $errors->first('title', '<label id="title-error" class="error" for="title">:message</label>') !!}
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="form-group">
                                                        {{ Form::label('classname','Class Name') }}<span style="color: red;">*</span>
                                                        {{ Form::text('classname',old('classname'),array('class'=>'form-control', 'style'=> 'margin-bottom:10px;','placeholder'=>'Enter Display name')) }}
                                                        {!! $errors->first('classname', '*<label id="classname-error" class="error" for="classname">:message</label>') !!}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="d-flex justify-content-end align-items-center">
                                                <button type="submit" name="submit" class="btn bg-blue ml-3">{{ (isset($status)? 'Update':'Save') }}</button>
                                            </div>

                                            {{ Form::close() }}
                                        </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div >
                                    <!-- Basic initialization -->
                                    <div class="card">
                                        <div class="card-header header-elements-inline">
                                            <h5 class="card-title">Status List</h5>
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
                                                <th>Class Name</th>
                                                <th>Created at</th>
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
                                                    ajax: '{!! route('status.index') !!}',
                                                    columns: [
                                                        { data: 'DT_RowIndex', name: 'DT_RowIndex' },
                                                        { data: 'title', name: 'title' },
                                                        { data: 'classname', name: 'classname' },
                                                        { data: 'created_at', name: 'created_at' },
                                                        { data: 'actions', name: 'actions' }
                                                    ],
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
                                                        ]
                                                    }
                                                });
                                            });
                                        </script>
                                    @endpush
                                </div>
                                <!-- /basic initialization -->
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

