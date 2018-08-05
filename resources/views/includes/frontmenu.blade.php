<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Business Frontpage</title>

    <!-- Bootstrap core CSS -->
    <link href="{{asset('css/bootstrap.min.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css" integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt" crossorigin="anonymous">
    <!-- Custom styles for this template -->
    <link href="{{asset('css/business-frontpage.css')}}" rel="stylesheet">
    <link href="{{asset('css/jquery.dataTables.min.css')}}" rel="stylesheet">
    <link href="{{ asset('css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/jquery.datetimepicker.min.css') }}" rel="stylesheet">

    @stack('after_css')
    <style type="text/css">
        .select2{
            height:40px;}

        .select2 .selection{
            height:40px;}

        .select2 .select2-selection{
            height:40px;}

        .select2 .selection .select2-selection__arrow{
            height:40px;}

        .select2-selection{
            height: 38px;
            padding-top: 4px;
        }
    </style>

</head>

<body>

<!-- Navigation -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="container ">
        <a class="navbar-brand" href="#">Your Website</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ml-auto">
                @auth
                    @if(auth()->user() != null && (3 === auth()->user()->roles->first()->id) || 4 ===auth()->user()->roles->first()->id))
                    <li class="nav-item active">
                        <a href="{{ route('ships') }}" class="nav-link">Ships</a>
                    </li>
                    @endif
                    <li class="nav-item active">
                        <a href="{{ route('projects') }}" class="nav-link">Projects</a>
                    </li>
                @endauth

                {{--<li class="nav-item active">--}}
                {{--<a class="nav-link" href="{{url('/')}}">Home--}}
                {{--<span class="sr-only">(current)</span>--}}
                {{--</a>--}}
                {{--</li>--}}

                <li class="nav-item">
                    <a class="nav-link" href="{{url('/dashboard')}}">Dashboard
                        <span class="sr-only">(current)</span>
                    </a>
                </li>

                @if(Auth::check())
                    <li class="nav-item active">
                        <a class="nav-link" href="#"> Welcome {{ Auth::user()->name }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <div class="dropdown">
                            <button class="btn btn-dark dropdown-toggle" type="button" id="dropdownMenuButton"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="glyphicon glyphicon-globe" aria-hidden="true"></span> Notification
                                @if(count(auth()->user()->notifications) > 0)
                                    <span class="badge badge-danger">{{ count(auth()->user()->notifications) }}</span>
                                @endif
                            </button>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                                @if(count(auth()->user()->notifications) > 0)
                                    @foreach(auth()->user()->notifications as $notification)
                                        @include('includes.notifications.' . snake_case(class_basename($notification->type)))
                                    @endforeach
                                @else
                                    <a class="dropdown-item" href="#">No Notification</a>
                                @endif
                            </div>
                        </div>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link" href="{{ route('form.contacts.contactList') }}">Contact
                        </a>
                    </li>

                    <li class="nav-item ">
                        <a class="nav-link" href="{{ route('organisation.index') }}">Organisation
                        </a>
                    </li>

                    <li class="nav-item">

                        <a href="{{ route('logout') }}"
                           onclick="event.preventDefault();
							 document.getElementById('logout-form').submit();" class="nav-link">
                            Logout
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>
                    </li>
                @else
                    <li class="nav-item">
                        <a href="{{ route('login') }}" class="nav-link">Login</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('register') }}" class="nav-link">Register</a>
                    </li>
                @endif

            </ul>
        </div>
    </div>
</nav>
