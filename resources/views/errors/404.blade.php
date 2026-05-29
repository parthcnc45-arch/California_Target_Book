@extends('layouts.master')

@section('title', 'Page Not Found | California Target Book')

@section('content')

    <div class="container-fluid pt-lg">

        <div class="row">
            <div class="col-md-8 center-block fn">
                <div class="panel skinny mt-xl">
                    <div class="row">
                        <h2>Page Not Found.</h2>

                        <div class="mt-xl clearfix text-right">
                            <a href="javascript:history.back()" class="btn btn-default">
                                Go Back
                            </a>

                            @if(Auth::check())
                            <a href="{{ route('book') }}" class="btn btn-primary">
                                Go To Book
                            </a>
                            @else()
                            <a href="{{ route('home') }}" class="btn btn-primary">
                                Go Home
                            </a>
                            @endif
                        </div>


                    </div>

                </div>

            </div>
        </div>

    </div>
@endsection


