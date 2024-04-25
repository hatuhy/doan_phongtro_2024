@extends('frontend.layouts.master')
@section('title', 'Trang chủ')
@push('css')
    <link href="/css/home.css" rel="stylesheet">
@endpush

@section('content')
    <div>
        <h2> Home </h2>
    </div>
@stop

@push('script')
    <script src="/js/home.js"></script>
@endpush
