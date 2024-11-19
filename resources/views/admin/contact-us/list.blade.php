@extends('layouts.admin.master')
@section('title')
    Contact Us Forms
@endsection

@section('css')
    <link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    <style>
        .user-add-shedule-list {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .user-add-shedule-list button.btn-primary,
        .user-add-shedule-list button.btn-primary span {
            color: white !important;
            border-radius: 10px;
        }
    </style>
@endsection

@section('content')
    <div id="content">
        <!-- Begin Page Content -->
        <div class="container-fluid">
            <!-- Page Heading -->
            <h1 class="h3 mb-2 text-gray-800">Contact List</h1>
            @if (Auth::user()->can('contact.add'))
                <div class="user-add-shedule-list">
                    <div class="col-auto float-right ml-auto">
                        <a href="{{ route('contact.create') }}">
                            <button class="btn-primary" data-toggle="modal" data-target="#add_schedule">Add Contact</button>
                        </a>
                        {{-- <button class="btn-primary" data-toggle="modal" data-target="#add_shift"> Add Shifts</button> --}}
                    </div>
                </div>
            @endif

            <!-- DataTales Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">

                    @if (session('message'))
                        <div class="alert alert-success mt-3">
                            {{ session('message') }}
                        </div>
                    @endif
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Subject</th>
                                    <th>Phone Number</th>
                                    <th>Message</th>
                                    @if (Auth::user()->can('contact.edit') || Auth::user()->can('contact.delete'))
                                        <th>Action</th>
                                    @endif
                                </tr>
                            </thead>
                            {{-- <tfoot>
                                <tr>
                                    <th>Name</th>
                                    <th>Position</th>
                                    <th>Office</th>
                                    <th>Age</th>
                                    <th>Start date</th>
                                    <th>Salary</th>
                                </tr>
                            </tfoot> --}}
                            <tbody>

                                @foreach ($contacts as $contact)
                                    <tr>
                                        <td>
                                            <p class="p-2"> {{ $contact->name }}</p>
                                        </td>
                                        <td>
                                            <p class="p-2"> {{ $contact->email }}</p>
                                        </td>
                                        <td>
                                            <p class="p-2"> {{ $contact->subject }}</p>
                                        </td>
                                        <td>
                                            <p class="p-2"> {{ $contact->phone }}</p>
                                        </td>
                                        <td>
                                            <p class="p-2"> {{ $contact->message }}</p>
                                        </td>

                                        @if (Auth::user()->can('contact.edit') || Auth::user()->can('contact.delete'))
                                            <td class="d-flex justify-content-start">
                                                <div class="btn-group" role="group" aria-label="Action buttons">
                                                    @if (Auth::user()->can('contact.edit'))
                                                        <a href="{{ route('contact.edit', ['contact' => $contact->id]) }}"
                                                            class="btn btn-warning btn-sm m-1">Edit</a>
                                                    @endif

                                                    <a href="{{ route('gallery-images.createimages', ['contact_id' => $contact->id]) }}"
                                                        class="btn btn-warning btn-sm m-1">Add Gallery Images</a>
                                                    <a
                                                        href="{{ route('contact.inventories', ['contact_id' => $contact->id]) }}">
                                                        <input class="btn btn-warning btn-sm m-1" type="button"
                                                            value="View Inventory">
                                                    </a>
                                                    @if (Auth::user()->can('contact.delete'))
                                                        <form
                                                            action="{{ route('contact.destroy', ['contact' => $contact->id]) }}"
                                                            method="POST" class="d-inline">
                                                            @method('DELETE')
                                                            @csrf
                                                            <button type="submit" class="btn btn-danger btn-sm m-1"
                                                                onclick="return confirm('Do you want to delete this Contact!')">Delete</button>
                                                        </form>
                                                    @endif
                                                </div>
                                            </td>
                                        @endif




                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
        <!-- /.container-fluid -->

    </div>
@endsection

@section('js')
    <script>
        //to disable initial ordering

        $(document).ready(function() {
            $('#dataTable').DataTable({
                "order": [], // Disable initial ordering
                // "columnDefs": [{
                //         "orderable": false,
                //         "targets": [3]
                //     } // Disable ordering on the Action column
                // ]
            });
        });
    </script>
    <!-- Page level plugins -->
    <script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

    <!-- Page level custom scripts -->
    <script src="{{ asset('js/demo/datatables-demo.js') }}"></script>
@endsection
