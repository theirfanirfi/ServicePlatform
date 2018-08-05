@extends('layouts.frontlayout')

@push('after_css')
    <style type="text/css">
        .div_reply_feed{
            display: none;
        }
    </style>
@endpush

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

        <div class="row">
            <div class="mt-4 col-xs-12">
                <a href="{{ route('formShip', 'new') }}" class="btn btn-primary">Add Ship</a>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <h2 class="mt-4">Ships</h2>
                {!! $dataTable->table() !!}
            </div>

        </div>
        <!-- /.row -->

        <div class="row mt-5">
            <div class="col-8">
                <div class="row">
                    <div class="col-12 mb-3">
                        <h4>Latest feeds</h4>
                    </div>

                    <div class="col-10 mt-12">
                        <div class="col-10 text-right">
                            <ul class="list-inline mb-0">
                                <li class="list-inline-item"><a href="#" class="feed_refresh" style="display: none;" data-time="now" id="count-feed"><h6><span class="badge badge-info"><span class="badge badge-light"></span> load new feeds</span></h6></a></li>
                                <li class="list-inline-item"><a href="#" class="feed_refresh" data-time="2"><h6><span class="badge badge-secondary">2 minutes</span></h6></a></li>
                                <li class="list-inline-item"><a href="#" class="feed_refresh" data-time="5"><h6><span class="badge badge-secondary">5 minutes</span></h6></a></li>
                                <li class="list-inline-item"><a href="#" class="feed_refresh" data-time="10"><h6><span class="badge badge-secondary">10 minutes</span></h6></a></li>
                            </ul>
                        </div>
                    </div>

                    <div class=" row" id="feed_content">
                    </div>

                    {{--@foreach($latest_feeds as $feed)
                        <div class="col-12 offset-1">
                            <i>{{ $feed->ship->name }}</i>
                        </div>
                        <div class="col-1 no-gutters">
                            <img src="{{ $feed->user->profile }}" width="60">
                        </div>
                        <div class="col-11">
                            <p>
                                {{ $feed->user->name }}  <small><a href="{{ route('view_ship', $feed->ship_id) }}#feed-box{{ $feed->id }}">{{ $feed->created_at->diffForHumans() }}</a></small><br>
                                {!! strip_tags(str_limit($feed->post, 200)) !!}
                            </p>
                        </div>
                    @endforeach--}}
                </div>
            </div>
        </div>

    </div>
@endsection
@push('after_scripts')
    {!! $dataTable->scripts() !!}

    <script src="{{ asset('js/underscore.min.js') }}"></script>
    <script src="{{ asset('js/js.cookie.js') }}"></script>
    <script>
        var _token = '{{ csrf_token() }}';
        var _feed_route = '{{ route('getShipUserFeed') }}';
    </script>
    <script src="{{ asset('js/ship_feed.js') }}"></script>
    @include('ship_feeds_template')
@endpush