@extends('layouts.app')

@section('content')

@if (Auth::user()->type == "student")
    @include('student_home')
@else
    @include('teacher_home')
@endif
@endsection
