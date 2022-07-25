@extends('layouts.dashboard')

@section('section')
    <div class="d-flex flex-column justify-content-center align-items-center">
        <h1>رسائل زوار الموقع</h1>

        @foreach ($errors->all() as $error)
            <div class="alert alert-danger text-white">{{ $error }}</div>
        @endforeach

        @if (Session::has('success'))
            <div class="alert alert-success text-white">{{ Session::get('success') }}</div>
        @elseif(Session::has('error'))
            <div class="alert alert-danger text-white">{{ Session::get('error') }}</div>
        @endif

        <div class="container-fluid d-flex flex-column justify-content-center align-items-center row my-8 mytable">
            @include('dashboard.feedbacks.table')
        </div>
        <form action="" id="delete-all-feedbacks" method="post">
            @method('DELETE')
            @csrf
            <button type="submit" class="btn btn-warning">مسح جميع الرسائل</button>
        </form>
    </div>
@endsection
@push('ajax')
    <script>
        //Delete All Feedbacks ////
        $(document).on("submit", "form#delete-all-feedbacks", function(e) {
            e.preventDefault();

            $(".alert").remove();


            let deleteProduct = confirm("هل أنت متأكد من حذف جميع الرسائل؟");

            // let productId = $(this).find("#item-id");

            if (deleteProduct) {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    method: "post",
                    url: "{{ route('dashboard.feedbacks.delete.all') }}",
                    data: new FormData(this),
                    dataType: "json",
                    processData: false,
                    contentType: false,
                    beforeSend: function() {
                        $("form#delete-all-feedbacks").after(
                            '<div class="d-flex spinner"><p>جار المعالجة...</p>' +
                            '<div class="spinner-border text-primary margin-1" role="status"></div>' +
                            '</div>'
                        );
                    },
                    complete: function() {
                        $(".spinner").remove();

                    },
                    success: function(response) {

                        let table = $(".mytable");
                        table.load("{{ route('dashboard.feedbacks.table') }}", function(res, status,
                            request) {
                            if (response.success)
                                $("form#delete-all-feedbacks").after(
                                    '<div class = "alert alert-success text-center col-7 col-md-3 text-white" >' +
                                    response
                                    .message +
                                    ' </div>'
                                );
                            else $("form#delete-all-feedbacks").after(
                                '<div class = "alert alert-success text-center col-7 col-md-3 text-white" >' +
                                response.message + ' </div>'
                            );

                        });
                    },
                    error: function(response) {


                        let errors = response.responseJSON.errors;
                        for (let error in errors) {
                            $("form#delete-all-feedbacks").after(
                                '<div class = "alert alert-danger text-center col-7 col-md-3 text-white" >' +
                                errors[error] +
                                ' </div>'
                            );
                        }


                    }

                });
            }
        });
    </script>
@endpush
