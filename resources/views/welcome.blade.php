@extends('layouts.base')

@section('head')
  <title>Fittify</title>
  <script src="https://f.convertkit.com/ckjs/ck.5.js"></script>

@stop

@section('content')
  <div class="min-h-full">
    <x-landing.navbar />
    <x-landing.hero />
    <x-landing.how-it-works />
    <x-landing.features />
    <x-landing.advantages />
    <x-landing.cta-mid-section />
  </div>
@stop
