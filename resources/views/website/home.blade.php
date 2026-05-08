@extends('website.layouts.website')

@section('title', 'Home | CuddlyDuddly')
@push('styles')
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
@endpush

@section('content')
    @foreach ($sections as $section)
        @php
            $view = 'website.home.sections.' . $section->key;
        @endphp

        @if (view()->exists($view))
            @include($view, ['data' => (array) $section->data])
        @endif
    @endforeach
@endsection
