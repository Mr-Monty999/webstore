@extends('layouts.public')

@section('content')
    <section class="d-flex flex-column justify-content-center align-items-center">
        <h1 class="mar-3">{{ $setting->home_title }} </h1>

        {{-- @if ($setting->store_logo != null) --}}
        <img src="{{ asset('images/local/welcome.png') }}" class="img-fluid photo btn-radius mar-3" alt="">
        {{-- @endif --}}
    </section>
@endsection
