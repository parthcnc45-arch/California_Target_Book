@extends('layouts.master')@section('title', 'CTBEvent')

@section('content')

    @php
        $user = Auth::user();
        if (!empty($user)) {
            $profile = $user->profile();
        } else {
            $profile = [];
        }
    @endphp

    <ctb-event-signup inline-template class="container focused-form" :user="{{ json_encode($profile) }}"
            :server-errors="{{ json_encode($errors) }}" :old-input="{{ json_encode(old()) }}">

        <div class="" id="event">


            <div class="col-lg-10 col-lg-offset-1">
                <div class="alert alert-danger sold-out">
                    <div class="row">
                        <div class="col-xs-1 text-center">
                            <i class="material-icons">info</i>
                        </div>
                        <div class="col-xs-11">
                            <h4 class="upper"> This event is sold out.</h4>
                            <p>
                                To be placed on a wait list, please email Roxanne Connelly,
                                <a href="mailto:roxanne@californiatargetbook.com,">roxanne@californiatargetbook.com,</a>
                                with your contact information. If space becomes available, we will contact you.
                            </p>
                        </div>
                    </div>
                </div>


                <div class="panel panel-accent p-n">
                    <div class="row m-n event-hero ">
                        <div class="col-md-8 jumbotron text-center mb-n"></div>
                        <div class="col-md-4 event-header">
                            <h5 class="upper text-red mb-lg">
                                JUN <br/> <span class="h4">11</span>
                            </h5>
                            <h3>Sacramento <br/> Post Primary Analysis</h3>
                            <h5 class="text-light mb-xl">
                                Winners, Losers, & the <br/> Road to November </h5>

                            <h5 class=" text-light">$50</h5>
                        </div>
                    </div>
                    <div class="panel-body p-xl row">

                        <div class="col-sm-6 col-md-8">

                            <h5 class="upper text-red">Description</h5>
                            <p>
                                Panel discussions on Statewide Races, November Ballot Measures,
                                Congressional and Legislative Target Seats, followed by a Reception. </p>

                            <p class="mb-n">Panels:</p>
                            <ol class="pl-md">
                                <li>Congressional and Legislative Target Seats</li>
                                <li>US Senate and Statewide Races</li>
                                <li>November Ballot Measures</li>
                            </ol>

                            <p class="mb-xl">
                                <a href="/resources/road_to_november_2018_invite.pdf" target="_blank">Click here for
                                    event invite.</a>
                            </p>


                        </div>

                        <div class="col-sm-6 col-md-4 event-info">

                            <div class="mb-lg">
                                <h5 class="upper text-red">Location</h5>
                                <p>
                                    California Chamber of Commerce <br/>
                                    California Room <br/>
                                    1215 K Street, Suite 1400, Sacramento </p>
                            </div>

                            <div class="mb-lg">
                                <h5 class="upper text-red">Date & Time</h5>
                                <p>
                                    Monday, June 11, 2018 <br/>
                                    2:30 pm to 6:30 pm </p>
                            </div>

                            <div class="mb-lg">
                                <h5 class="upper text-red">RSVP Deadline</h5>
                                <p>
                                    Monday, June 4, 2018 </p>
                            </div>

                        </div>

                    </div>
                </div>

            </div>
        </div>
    </ctb-event-signup>
@endsection

