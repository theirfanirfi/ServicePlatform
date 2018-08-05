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
        #project_files{
            max-height: 150px;
            overflow: auto;
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
            <div class="col-sm-8 offset-2">
                <h2 class="mt-4">Project {{ $project->name }}</h2>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-8 offset-2">
                <div class="row">
                    <div class="col-6">
                        <div class="col-md-12">
                            <span><b>Port:</b></span> {{ $project->port }}
                        </div>

                        <div class="col-md-12">
                            <span><b>Date:</b></span> {{ $project->date }}
                        </div>

                        <div class="col-md-12">
                            <span><b>Eta:</b></span> {{ $project->eta }}
                        </div>
                        <div class="col-md-12">
                            <span><b>Etb:</b></span> {{ $project->etb }}
                        </div>

                        <div class="col-md-12">
                            <span><b>Etd:</b></span> {{ $project->etd }}
                        </div>

                        <div class="col-md-12">
                            <span><b>Description:</b></span> {{ $project->description }}
                        </div>
                    </div>
                    @if($project->canViewFiles())
                        <div class="col-6" id="project_files">
                            <h4>Files</h4>
                            @foreach($project->files as $file)
                                <div><i class="fas fa-file"></i> <a href="{{ asset("uploads/project/{$project->id}/" . $file->getOriginal('filename')) }}" target="_blank">{{ $file->filename }}</a></div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-8 mt-3 mb-3 offset-2">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active"  href="#wall_feed" data-toggle="tab">Feed</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#wall_costs" data-toggle="tab">Costs</a>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="wall_feed">
                        <div class="col-12 mb-3 text-right">
                            @if($project->closed === 'open')
                                {{ Form::open(['route' => ['project.form.close', $project->id]]) }}
                                <input type="submit" value="CLOSE PROJECT" class="btn btn-warning btn-sm">
                                {{ Form::close() }}
                            @endif
                        </div>
                        @if($project->closed === 'open')
                            <form id="postForm">
                                <textarea type="text" class="form-control" name="post" id="editor"></textarea>
                                <p class="text-right"><input type="submit" class="btn btn-info col-2 mt-1" value="Send"></p>
                            </form>
                        @else
                            <h3 class="text-center">PROJECT IS CLOSED</h3>
                        @endif
                        <div class="mt-4 row">
                            <div class="col-12 text-right">
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
                    </div>
                    <div class="tab-pane fade" id="wall_costs">
                        @if($project->user->id === auth()->user()->id)
                        {{ Form::open(['route' => 'project.form.cost', 'id' => 'form_costs'])  }}
                        <div class="row mt-4 mb-4">
                            <div class="col">
                                {{ Form::label('name') }}
                                {{ Form::text('name', null, ['class' => 'form-control']) }}
                            </div>

                            <div class="col">
                            {{ Form::label('quantity') }}
                            {{ Form::text('quantity', null, ['class' => 'form-control']) }}
                            </div>

                            <div class="col">
                                {{ Form::label('amount') }}
                                <div class="input-group">
                                    {{ Form::text('amount', null, ['class' => 'form-control']) }}
                                    <div class="input-group-append">
                                        {{ Form::submit('create', ['class' => 'btn btn-info']) }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{ Form::close()  }}
                        @endif

                        <div id="project_costs" class="row"></div>

                    </div>
                </div>

            </div>
        </div>



        <div class="linked_users">
            {{--                @include('invitation.view');--}}
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
                url: '{{ route('project.feed.store', $project->id) }}',
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
                url: '{{ route('project.feeds', $project->id) }}',
                dataType: 'json',
                success:function(data){
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
                url: '/project/count/news/feed/',
                data: {'last_feed': last_feed},
                dataType: 'json',
                success:function(data){
                    if(data.count > 0){
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
    @include('project_feed_template')
    @include('project_cost_template')
    <script type="text/javascript">
        $(document).ready(function(){
            $('#form_costs').submit(function(e){
                e.preventDefault();
                var self = this;
                $.ajax({
                    type: 'POST',
                    url: $(self).prop('action'),
                    data: $(self).serialize()  + '&project_id=' + {{ $project->id }} ,
                    dataType: 'json',
                    success:function(object){
                        project_cost_template = _.template($('#project_cost_template').html());
//                        $('#project_costs').html('');
                        /*$.each(data, function(index, object){
                            $('#project_costs').append(project_cost_template(object));
                        })*/
                        $('#project_costs').append(project_cost_template(object));
                    },
                    error:function(e){
                        console.log(e);
                    }
                });
            });
            loadCosts();
            setInterval(function(){loadCosts()}, 30000);
            function loadCosts(){
                $.ajax({
                    type: 'GET',
                    url: '{{ route('project.get.cost', $project->id) }}',
                    dataType: 'json',
                    success:function(data){
                        project_cost_template = _.template($('#project_cost_template').html());
                        $('#project_costs').html('');
                        $.each(data, function(index, object){
                            $('#project_costs').append(project_cost_template(object));
                        })
                    },
                    error:function(e){
                        console.log(e);
                    }
                });
            }
            $(document).on('click', '.btn-cost-action', function(e){
                e.preventDefault();
                var type = $(this).data('type');
                var cost_id = $(this).data('cost');
                if(!type || !cost_id){
                    return false;
                }

                $.ajax({
                    type: 'POST',
                    url: '{{ route('project.cost.action') }}',
                    data: {type: type, cost_id: cost_id, _token: '{{ csrf_token() }}' },
                    dataType: 'json',
                    success:function(data){
                        loadCosts();
                    },
                    error:function(e){
                        console.log(e);
                    }
                });

            })

            $(document).on('click', '.btn-cost-remove', function(e){
                e.preventDefault();
                var cost_id = $(this).data('cost');
                if(!cost_id){
                    return false;
                }

                $.ajax({
                    type: 'DELETE',
                    url: '{{ route('project.cost.remove') }}',
                    data: {cost_id: cost_id, _token: '{{ csrf_token() }}' },
                    dataType: 'json',
                    success:function(data){
                        if(!data.status){
                            alert(data.msg);
                        }
                        loadCosts();
                    },
                    error:function(e){
                        console.log(e);
                    }
                });

            })
        })
    </script>
@endpush