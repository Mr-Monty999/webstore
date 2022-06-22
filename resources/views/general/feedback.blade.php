@extends('layouts.public')

@section('content')
    <section class="feedback d-flex flex-column justify-content-center align-items-center">
        <h3 class="text-center mar-3">ساعدنا بتطوير خدماتنا بارسالك اقتراحات ونصائح </h3>
        <form class="mar-3" action="{{ route('feedback.store') }}" method="post">
            @csrf

            <div class="form-group">
                <label for="">الاسم او البريد الالكتروني:</label>
                <input type="text" name="name" class="form-control" placeholder="الاسم او البريد الالكتروني"
                    id="">
            </div>
            <div class="form-group">
                <label for="">الرسالة:</label>
                <textarea name="message" class="form-control" id="" placeholder="محتوى الرسالة" cols="30" rows="10"></textarea>
            </div>
            <div class="mar-3 d-flex flex-column justify-content-center align-items-center">
                {!! NoCaptcha::display() !!}
            </div>
            <button type="submit" class="btn btn-success  mar-3 col-5 offset-4">ارسال</button>
        </form>
        @foreach ($errors->all() as $error)
            <div class="alert alert-danger text-dark">{{ $error }}</div>
        @endforeach

        @if (Session::has('success'))
            <div class="alert alert-success text-dark mar-3">{{ Session::get('success') }}</div>
        @elseif(Session::has('error'))
            <div class="alert alert-danger text-dark mar-3">{{ Session::get('error') }}</div>
        @endif
    </section>
@endsection

@section('scripts')
    {!! NoCaptcha::renderJs() !!}
@endsection
