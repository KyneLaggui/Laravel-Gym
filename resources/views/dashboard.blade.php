@extends('layout')
@section('content')
    <h1 class="text">I love you {{ auth()->user()->name }}</h1>
    <style>
        .text{
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 10em;
            width: 100%;
            height: 100vh;

        }
    </style>
@endsection
