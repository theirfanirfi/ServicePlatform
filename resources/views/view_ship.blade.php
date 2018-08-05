@extends('layouts.frontlayout')
@push('after_css')
    <style type="text/css">
        .ck-editor__editable:first-child {
            min-height: 100px;
        }
        .feed_area{
        }
        .feed_area .feed_header{
            padding:2px 8px
        }
        .row{
            margin:0;
        }
        .div_reply_feed{
            display: none;
        }
    </style>
@endpush
@php
    $vessels = [
        1 => "Aggregates Carrier",
        2 => "Anchor Handling Vessel",
        3 => "Asphalt/Bitumen Tanker",
        4 => "Bulk Carrier",
        5 => "Bunkering Tanker",
        6 => "Cable Layer",
        8 => "Cement Carrier",
        9 => "Chemical Tanker",
        10 => "Container Ship",
        11 => "Crew Boat",
        12 => "Crude Oil Tanker",
        13 => "Dredger",
        14 => "Drill Ship",
        15 => "Fire Fighting Vessel",
        16 => "Fish Carrier",
        18 => "Fishing Vessel",
        19 => "Floating Crane",
        20 => "Floating Storage/Production",
        21 => "General Cargo",
        22 => "Heavy Load Carrier",
        23 => "High Speed Craft",
        24 => "Icebreaker",
        25 => "Inland Passenger Ship",
        26 => "Landing Craft",
        27 => "Livestock Carrier",
        28 => "LNG Tanker",
        29 => "LPG Tanker",
        30 => "Military Ops",
        31 => "Navigation Aids",
        32 => "OBO Carrier",
        33 => "Offshore Structure",
        34 => "Offshore Vessel",
        35 => "Oil Products Tanker",
        36 => "Oil/Chemical Tanker",
        37 => "Ore Carrier",
        38 => "Special Craft",
        39 => "Special Cargo",
        40 => "Special Fishing Vessel",
        41 => "Special Passenger Vessel",
        42 => "Other Pleasure Craft",
        43 => "Special Tanker",
        45 => "Passenger/Cargo Ship",
        46 => "Passenger Ship",
        47 => "Patrol Vessel",
        48 => "Pilot Boat",
        49 => "Platform",
        50 => "Pollution Control Vessel",
        51 => "Pusher Tug",
        52 => "Reefer",
        53 => "Research/Survey Vessel",
        54 => "Ro-Ro/Passenger Ship",
        55 => "Ro-Ro/Vehicles Carrier",
        56 => "Sailing Vessel",
        57 => "Search & Rescue",
        58 => "Service Vessel",
        59 => "Special Tug",
        60 => "Supply Vessel",
        61 => "Tanker",
        62 => "Training Ship",
        63 => "Trawler",
        64 => "Tug",
        65 => "Tug/Supply Vessel",
        66 => "Water Tanker",
        67 => "Yacht",
        68 => "Barge",
        69 => "Inland Tanker",
        70 => "Inland Cargo",
        71 => "Inland Tug",
        900 => "Unspecified",
        902 => "Other Fishing",
        903 => "Other Tug / Special Craft",
        904 => "High Speed Craft",
        906 => "Other Passenger Ship",
        907 => "Other Cargo",
        908 => "Other Tanker",
    ];
@endphp
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
            <div class="col-sm-8 offset-2">
                <h2 class="mt-4">Ship {{ $ship->name }}</h2>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-8 offset-2">
                <div class="row">
                    <div class="col-md-12">
                        <span><b>IMO:</b></span> {{ $ship->imo }}
                    </div>

                    <div class="col-md-12">
                        <span><b>Name:</b></span> {{ $ship->name }}
                    </div>

                    <div class="col-md-12">
                        <span><b>MMSI:</b></span> {{ $ship->mmsi }}
                    </div>
{{--{{ dd($vessels[$ship->vessel]) }}--}}
                    <div class="col-md-12">
                        <span><b>Vessel:</b></span> {{ $vessels[$ship->vessel] }}
                    </div>

                    <div class="col-md-12">
                        <span><b>Gross tonnage:</b></span> {{ $ship->gross_tonnage }}
                    </div>

                    <div class="col-md-12">
                        <span><b>Build:</b></span> {{ $ship->build }}
                    </div>

                    <div class="col-md-12">
                        <span><b>Flag:</b></span> {{ $ship->flag }}
                    </div>

                    <div class="col-md-12">
                        <span><b>Home port:</b></span> {{ $ship->home_port }}
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-8 mt-3 mb-3 offset-2">
                <form id="postForm">
                    <textarea type="text" class="form-control" name="post" id="editor"></textarea>
                    <p class="text-right"><input type="submit" class="btn btn-info col-2 mt-1" value="Send"></p>
                </form>
            </div>
        </div>

        <div class="mt-4 row">
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

            <div class="linked_users">
                @include('invitation.view');
            </div>
        
    </div>
@endsection
@push('after_scripts')
    <script src="https://cdn.ckeditor.com/ckeditor5/10.0.1/classic/ckeditor.js"></script>
    <script src="{{ asset('js/underscore.min.js') }}"></script>
    <script src="{{ asset('js/js.cookie.js') }}"></script>
    <script>
        $(document).ready(function(){
            $(document).on('click', '.btn-reply', function(e){
                e.preventDefault();
                var id = $(this).data('id');
                $('#form_reply' + id).toggle();
            })

            $(document).on('submit', '.form_reply', function(e){
                e.preventDefault();
                var feed_id = $(this).data('feed');
                var reply_id = $(this).data('parent') || null;
                if(!feed_id){
                    return false;
                }

                $.ajax({
                    type: 'POST',
                    url: $(this).prop('action'),
                    data: $(this).serialize() + '&feed_id=' + feed_id + '&reply_id=' + reply_id + '&_token={{ csrf_token() }}',
                    dataType: 'json',
                    success:function(data){
                        console.log('FORM REPLY FEED');
                        console.log(data);
                        getShipFeeds();
                    },
                    error:function(e){
                        console.log(e);
                    }
                });
            })
        })
    </script>

    <script>
        const editor = ClassicEditor
            .create( document.querySelector( '#editor' ), {
                    ckfinder: {
                        uploadUrl: "{{ route('storeImageShip') }}?command=QuickUpload&type=Files&responseType=json"
                    },
                    toolbar: [ 'bold', 'italic', 'link', 'blockQuote', '|', 'imageUpload' ],
                    image: {
                        toolbar: [
                            'imageStyle:full',
                            'imageStyle:side',
                            '|',
                            'imageTextAlternative'
                        ]
                    }
                }
            ).then( editor => {
            $('#postForm').submit(function(e){
            e.preventDefault()
            $.ajax({
                type: 'POST',
                url: '{{ route('storeFeedShip', $ship->id) }}',
                data: { '_token': '{{ csrf_token() }}', post: editor.getData() },
                beforeSend:function(){
                },
                success:function(data){
                    editor.setData('');
                    feed_template = _.template($('#feed_template').html());
                    $('#feed_content').prepend(feed_template(data));
                },
                error:function(e){
                    console.log(e);
                }
            });
        })
        }
        )
        .catch( error => {
            console.error( error );
        }
        );
        function getShipFeeds(){
            $.ajax({
                type: 'GET',
                url: '{{ route('getShipFeed', $ship->id) }}',
                dataType: 'json',
                success:function(data){
                    console.log('FEED');
                    feed_template = _.template($('#feed_template').html());
                    $('#feed_content').html('');
                    $.each(data, function(index, object){
                        $('#feed_content').append(feed_template(object));
                    })
                    if(window.location.hash){
                        var to = $(window.location.hash);
                        $(document).scrollTop((to.offset().top - 100) );
                        history.replaceState('', document.title, window.location.pathname);
                        to.closest('.feed_area').css({border: '0 solid #f37736'})
                            .animate({borderWidth: 1}, 0)
                            .animate({borderWidth: 0}, 3000);
                    }
                },
                error:function(e){
                    console.log(e);
                }
            });
        }
        getShipFeeds();
        $('.feed_refresh').click(function(e){
            e.preventDefault();
            var reload = $(this).data('time');
            if(!reload){
                return false;
            }
            setTimeFeed(reload);
        });

        var reload_time = Cookies.get('feed_reload') || 2;
        setTimeFeed(reload_time);
        function setTimeFeed(reload_time){
            if(reload_time === 'now'){
                getShipFeeds();
                $('#count-feed').hide();
                return false;
            }
            if(reload_time !== undefined && reload_time !== null) {
                Cookies.set('feed_reload', reload_time);
            }
            //reset badges
            $('.feed_refresh span').removeClass('badge-primary');
            $('.feed_refresh span').addClass('badge-secondary');

            $(".feed_refresh[data-time='" + reload_time + "'] span").addClass('badge-primary');
            $(".feed_refresh[data-time='" + reload_time + "'] span").removeClass('badge-secondary');
            window.setTimeout(function(){
                checkIfNewsFeeds();
                setTimeFeed(reload_time);
            }, (reload_time * 1000) * 60)
        }
        function checkIfNewsFeeds(){
            var last_feed = $("a[id*='feed-box']").prop('id');
            if(!last_feed){
                return false;
            }
            last_feed = last_feed.replace('feed-box', '');
            $.ajax({
                type: 'GET',
                url: '/count/news/feed/',
                data: {'last_feed': last_feed},
                dataType: 'json',
                success:function(data){
                    if(data.count > 0){
                        console.log(data.count);
                        $('#count-feed .badge-light').html(data.count);
                        $('#count-feed').show();
                    }
                },
                error:function(e){
                    console.log(e);
                }
            });
        }
    </script>
    @include('ship_feed_template')
@endpush