@extends ('layouts.base')

@section('head')
<script
    src="{{ mix('/js/app.js') }}"
    defer
></script>

@endsection

@section ('content')
@routes
@inertia
@stop
