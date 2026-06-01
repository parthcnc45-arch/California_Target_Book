@extends('layouts.master')

@section('title', 'Error | California Target Book')

@section('content')

    <div class="container-fluid pt-lg">

        <div class="row">
            <div class="col-md-8 center-block fn">
                <div class="panel skinny mt-xl">
                    <div class="row">
                        <h2>Something went wrong.</h2>

                        @if(app()->bound('sentry') && class_exists('Sentry') && !empty(Sentry::getLastEventID()))
                            <div class="subtitle">
                                Error ID:
                                <i class="text-red">{{ Sentry::getLastEventID() }}</i>
                            </div>


                            <div class="mt-xl clearfix text-right">
                                <a href="javascript:history.back()" class="btn btn-default">
                                    Go Back
                                </a>
                                <button id="reportError" class="btn btn-primary">
                                    Tell Us What Went Wrong.
                                </button>

                            </div>

                        @endif


                    </div>

                </div>

            </div>
        </div>

    </div>
@endsection

@section('scripts')

    @if(app()->bound('sentry') && class_exists('Sentry') && !empty(Sentry::getLastEventID()))
        <!-- Sentry JS SDK 2.1.+ required -->
        <script src="https://cdn.ravenjs.com/3.3.0/raven.min.js"></script>

        <script>
            $('#reportError').on('click', () => {
              Raven.showReportDialog({
                eventId: '{{ Sentry::getLastEventID() }}',
                dsn: 'https://e9ebbd88548a441288393c457ec90441@sentry.io/3235',
                user: {
                    @auth
                    'id': '{{ Auth::id() }}',
                    'name': '{{ Auth::user()->name() }}',
                    'email': '{{ Auth::user()->email }}',
                    @endauth
                    @if(class_exists('Tracker'))
                    'tracker_session': '{{ Tracker::getSessionId()['id'] }}',
                    @endif
                }
              });
            });

        </script>
    @endif

@endsection
