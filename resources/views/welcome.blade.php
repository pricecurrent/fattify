@extends('layouts.base')

@section('head')
  <title>Fittify</title>
  <script src="https://f.convertkit.com/ckjs/ck.5.js"></script>
  @vite('resources/js/alpine/index.js')

@stop

@section('content')
  <div class="min-h-full">
    <x-landing.navbar />
    <x-landing.navbar-mobile />
    <x-landing.hero />
    <x-landing.how-it-works />
    <x-landing.features />
    <x-landing.advantages />
    <x-landing.cta-mid-section />
  </div>
@stop
