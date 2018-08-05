@extends('layouts.frontlayout')

@section('frontcontent')
    <!-- Page Content -->
    <div class="container">

        @if ($message = session()->get('success'))
            <div class="alert alert-success">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <p>{{ $message }}</p>
            </div>
        @endif
        @if ($message = session()->get('error'))
            <div class="alert alert-error">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <p>{{ $message }}</p></div>
        @endif
        @if(auth()->user()->roles->first()->id === 4)
        <div class="row">
            <div class="mt-4 col-xs-12">
                <a href="{{ route('form.project', 'new') }}" class="btn btn-primary">Create Project</a>
            </div>
        </div>
        @endif
        <div class="row">
            <div class="col-sm-12">
                <h2 class="mt-4">Projects</h2>
                {!! $dataTable->table() !!}
            </div>

        </div>
        <!-- /.row -->
    </div>
@endsection
@push('after_scripts')
    {!! $dataTable->scripts() !!}
@endpush