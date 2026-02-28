@extends('layouts.app')
@section('title', 'Dashboard')

@section('content')
    @if (auth()->user()->hasRole('admin'))
        @include('dashboards.admin')
    @elseif(auth()->user()->hasRole('hr'))
        @include('dashboards.hr')
    @elseif(auth()->user()->hasRole('candidate'))
        @include('dashboards.candidate')
    @endif
@endsection
