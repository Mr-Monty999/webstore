@extends('layouts.dashboard')

@section('section')
    <div class="d-flex flex-column justify-content-center align-items-center feedback">
        <h1 class="text-break">رسالة {{ $feedback->name }}</h1>
        <h6 class="my-5 col-md-6 col-12 text-right text-break">
            {{ $feedback->message }}
        </h6>
        <form class="" action="{{ route('dashboard.feedbacks.delete', $feedback->id) }}" method="POST">
            @csrf
            @method('DELETE')

            <a href="{{ URL::previous() }}" class="btn btn-dark">رجوع</a>
            <button type="submit" class="btn btn-danger">حذف</button>

        </form>





    </div>
@endsection
