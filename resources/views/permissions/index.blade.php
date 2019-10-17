@extends('layouts.app')

@section('title', 'Permission Management')

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
                                        <h6 class="card-title">Manage Permissions</h6>
                                        <div class="header-elements">
                                            <div class="list-icons">
                                                <a class="list-icons-item" data-action="collapse"></a>
                                            </div>
                                        </div>
                                    </div>
                                    @if(isset($role))
                                        <div class="card-body">
                                            {{ Form::model($role,['method'=>'put','route' => ['roles.update',$role->id]]) }}
                                            <div class="row">
                                                <div class="col">
                                                    <div class="form-group">
                                                        {{ Form::label('name','Name') }}<span style="color: red;">*</span>
                                                        {{ Form::text('name',old('name'),array('class'=>'form-control', 'style'=> 'margin-bottom:10px;','placeholder'=>'Enter Name')) }}
                                                        {!! $errors->first('name', '*<label id="name-error" class="error" for="name">:message</label>') !!}
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="form-group">
                                                        {{ Form::label('display_name','Display Name') }}<span style="color: red;">*</span>
                                                        {{ Form::text('display_name',old('display_name'),array('class'=>'form-control', 'style'=> 'margin-bottom:10px;','placeholder'=>'Enter Display Name')) }}
                                                        {!! $errors->first('display_name', '*<label id="display-error" class="error" for="display_name">:message</label>') !!}
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col">
                                                    <div class="form-group">
                                                        {{ Form::label('description','Description') }}<span style="color: red;">*</span>
                                                        {{ Form::textarea('description',old('description'),array('class'=>'form-control', 'style'=> 'margin-bottom:10px;','placeholder'=>'Enter role Description','rows'=>'3')) }}
                                                        {!! $errors->first('description', '*<label id="description-error" class="error" for="description">:message</label>') !!}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="d-flex justify-content-end align-items-center">
                                                <button type="submit" name="submit" class="btn bg-blue ml-3">Update </button>
                                            </div>

                                            {{ Form::close() }}
                                        </div>
                                    @else
                                        <div class="card-body">
                                            {{ Form::open(['route' => 'roles.store']) }}
                                            <div class="row">
                                                <div class="col">
                                                    <div class="form-group">
                                                        {{ Form::label('name','Name') }}<span style="color: red;">*</span>
                                                        {{ Form::text('name',old('name'),array('class'=>'form-control', 'style'=> 'margin-bottom:10px;','placeholder'=>'Enter Name')) }}
                                                        {!! $errors->first('name', '<label id="name-error" class="error" for="name">:message</label>') !!}
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="form-group">
                                                        {{ Form::label('display_name','Display Name') }}<span style="color: red;">*</span>
                                                        {{ Form::text('display_name',old('display_name'),array('class'=>'form-control', 'style'=> 'margin-bottom:10px;','placeholder'=>'Enter Display name')) }}
                                                        {!! $errors->first('display_name', '*<label id="display-error" class="error" for="display_name">:message</label>') !!}
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col">
                                                    <div class="form-group">
                                                        {{ Form::label('display_name','Display Name') }}<span style="color: red;">*</span>
                                                        {{ Form::text('display_name',old('display_name'),array('class'=>'form-control', 'style'=> 'margin-bottom:10px;','placeholder'=>'Enter Display name')) }}
                                                        {!! $errors->first('display_name', '*<label id="display-error" class="error" for="display_name">:message</label>') !!}
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="form-group">
                                                        {{ Form::label('status','Status') }}<span style="color:red;">*</span>
                                                        <select class="form-control" name="status" id="status">
                                                            @foreach($status_lists as $list)
                                                                <option value="{{ $list->id }}">{{ ucfirst($list->title) }}</option>
                                                            @endforeach
                                                        </select>
                                                        {!! $errors->first('status', '*<label id="status-error" class="error" for="status">:message</label>') !!}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="d-flex justify-content-end align-items-center">
                                                <button type="submit" name="submit" class="btn bg-blue ml-3">Save </button>
                                            </div>

                                            {{ Form::close() }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div >
                                    <!-- Basic initialization -->
                                    <div class="card">
                                        <div class="card-header header-elements-inline">
                                            <h5 class="card-title">Permissions List</h5>
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
                                                <th>Name</th>
                                                <th>Display Name</th>
                                                <th>Description</th>
                                                <th>Status</th>
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
                                                    ajax: '{!! route('permissions.index') !!}',
                                                    columns: [
                                                        { data: 'DT_RowIndex', name: 'DT_RowIndex' },
                                                        { data: 'name', name: 'name' },
                                                        { data: 'display_name', name: 'display_name' },
                                                        { data: 'description', name: 'description' },
                                                        { data: 'status', name: 'status' },
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

