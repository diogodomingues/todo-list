@extends('layouts.app')

@section('content')
    <!-- pass as a prop the user details -->
    <home-component userdetails="{{Auth::user()}}"></home-component>
@endsection
