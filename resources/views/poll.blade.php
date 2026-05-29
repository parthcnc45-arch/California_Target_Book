@extends('layouts.book')

@section('title', "Weekly Poll | California Target Book")

@section('bodyClasses', "main-bg-gray page-poll")

@section('content')
<div class="container-fluid pt-lg">
    <div class="row">
        <div class="col-lg-5 col-md-6 col-sm-8 center-block fn">
            <article class="panel">
                <h5 class="upper text-red mb-md">
                    Target Book Insider Poll {{ $poll->dateDisplay() }}
                </h5>
                <h2 class="mb-xl">{{ $poll->title }}</h2>
                <form id="poll" action="{{ route('book.poll', ['id' => $poll->id]) }}" method="POST">
                    {{ csrf_field() }}

                    <ol class="questions">
                        @foreach ($poll->questions as $q)
                        <li>
                            <p>{{ $q->text }}</p>
                            <div class="row">
                                @switch($q->type)
                                    @case("open")
                                        <div class="form-group">
                                            <textarea class="form-control" name="{{ $q->id }}" required></textarea>
                                        </div>
                                        @break

                                    @default
                                        <ul class="multiple-choice">
                                            @foreach ($q->answerOptions as $o)
                                                <li>
                                                    <label class="block row">
                                                        <div class="col-xs-1 text-right">
                                                            <input name="{{ $q->id }}" type="radio" value="{{$o->id}}" required/>
                                                        </div>
                                                        <div class="col-xs-10">
                                                            {{ $o->text }}
                                                        </div>
                                                    </label>
                                                </li>
                                            @endforeach
                                        </ul>

                                @endswitch
                            </div>

                        </li>
                        @endforeach
                    </ol>
                    <div class="row">
                        <div class="col-xs-12">
                        <button type="submit" class="btn btn-primary pull-right">
                            Submit Poll
                        </button>
                        </div>
                    </div>

                </form>
            </article>
        </div>
    </div>

</div>
@endsection

@section('scripts')
    <script>
        document.querySelector('form#poll').addEventListener('submit', function () {
          gtag('event', 'poll_response', {
            'event_label': 'Poll {{ $poll->id }}',
            'event_category': 'polls',
          });
          return true;
        });
    </script>
    <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
@endsection
