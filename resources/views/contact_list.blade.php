@extends('layouts.frontlayout')

@section('frontcontent')
    <!-- Page Content -->
    <div class="container">

        @if (session()->has('message'))
            <div class="alert alert-success hi">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <p>{{ session()->get('message') }}</p>
            </div>
        @endif

        @if (session()->has('error'))
            <div class="alert alert-danger hi">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <p>{{ session()->get('error') }}</p>
            </div>
        @endif

        <div class="row">
            <div class="col-sm-12">
                <h2 class="mt-4">Contact Details</h2>
                <a class="btn btn--primary" href="{{ route('contacts.index') }}">Add New Contact</a>

                <table class="table" id="contact-list-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Surname</th>
                            {{--<th>Company</th>--}}
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Address</th>
                            <th>Contact</th>
                            <th>Organisation Name</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($contacts as $key=>$value)
                            <tr>
                                <td>{{ $value->id }}</td>
                                <td>{{ $value->name }}</td>
                                <td>{{ $value->surname }}</td>
                                {{--<td>{{ $value->company }}</td>--}}
                                <td>{{ $value->email }}</td>
                                <td>{{ $value->phone }}</td>
                                <td>{{ $value->address }}</td>
                                <td>{{ $value->contact }}</td>
                                <td>{{ ($value->organisation != null ? $value->organisation->name : 'Remove') }}</td>
                                <td>

                                    <div class="row">
                                        <div class="col-md-6">

                                            {{ Form::open(array('url' => route('contacts.edit',['contacts'=>$value->id]), 'method' => 'GET', 'class'=>'col-md-12')) }}
                                            <input type="submit" name="contacts_edit" value="Edit" class="btn btn-primary">
                                            {{ Form::close() }}

                                        </div>
                                        <div class="col-md-6">

                                            {{ Form::open(array('url' => route('contacts.destroy',['contact'=>$value->id]), 'method' => 'DELETE', 'class'=>'col-md-12')) }}
                                            <input type="submit" name="contact_remove" value="Delete" class="btn btn-primary">
                                            {{ Form::close() }}

                                        </div>
                                    </div>


                                    {{--<a href="contacts/{{ $value->id }}/edit">Edit</a>--}}

                                </td>


                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection

@push('after_css')
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">
@endpush

@push('after_scripts')
   <script src="//cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready( function () {
            $('#contact-list-table').DataTable();
        } );
    </script>
@endpush