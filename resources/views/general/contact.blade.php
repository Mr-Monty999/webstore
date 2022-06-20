@extends('layouts.public')

@section('content')
    <section class="contact container d-flex flex-column justify-content-center align-items-center">
        <h1 class="mar-3">تواصل معنا في الارقام التالية:</h1>
        <h4>{{ $setting->contact_phone1 }}</h4>
        <h4>{{ $setting->contact_phone2 }}</h4>

        <h1 class="mar-3">او قم بزيارة موقعنا:</h1>
        <h4>{{ $setting->contact_address }}</h4>

        <div>
            <img src="{{ asset('images/local/contact1.png') }}" class="img-fluid photo mar-3" alt="">
        </div>
    </section>
@endsection
