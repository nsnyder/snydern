@extends('templates.master')

@section('content')
    @include('partials.section', ['section_number' => 1])
    @include('partials.section', ['section_number' => 2])
@endsection