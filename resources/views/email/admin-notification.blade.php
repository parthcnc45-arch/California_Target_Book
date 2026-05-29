@extends('layouts.email')

@section('content')

<h1>California Target Book Admin</h1>

<p>
  Hello {{$name}},
</p>

<p>{{$notification}}</p>

<p>Click below to see more.</p>

<a href="{{url($link)}}">
  {{ url($link) }}
</a>


@endsection