@extends ('layouts.base')

@section('head')
@routes
@vite(['resources/js/app.js'])
@inertiaHead
@endsection

@section ('content')
@inertia
@stop
