@extends('layouts.dashboard')

@section('section')
    <div class="d-flex flex-column justify-content-center align-items-center feedback">
        <h1>رسالة {{ $feedback->name }}</h1>
        <h6 class="my-5 col-md-6 col-12 text-right feedback-article">
            {{ $feedback->message }}
        </h6>
        <form class="" action="{{ route('dashboard.feedbacks.delete', $feedback->id) }}" method="POST">
            @csrf
            @method('DELETE')

            <a href="{{ route('dashboard.feedbacks.index') }}" class="btn btn-dark">رجوع</a>
            <button type="submit" class="btn btn-danger">حذف</button>

        </form>





    </div>
@endsection
