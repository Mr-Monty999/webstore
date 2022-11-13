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


            let deleteFeedback = confirm("هل أنت متأكد من حذف جميع الرسائل؟");

            // let productId = $(this).find("#item-id");

            if (deleteFeedback) {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    method: "post",
                    url: "{{ route('dashboard.feedbacks.destroy.all') }}",
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

                        $(".alert").remove();

                        let table = $(".mytable");
                        let url = "{{ route('dashboard.feedbacks.table', '') }}/1";

                        table.load(url, function(res, status,
                            request) {
                            if (response.success)
                                $("form#delete-all-feedbacks").after(
                                    '<div class = "alert alert-success text-center col-7 col-md-3 text-white" >' +
                                    response
                                    .message +
                                    ' </div>'
                                );
                            else $("form#delete-all-feedbacks").after(
                                '<div class = "alert alert-danger text-center col-7 col-md-3 text-white" >' +
                                response.message + ' </div>'
                            );

                        });
                    },
                    error: function(response) {

                        $(".alert").remove();

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
        ////Delete Feedback And Update Table ////
        $(document).on("submit", "form#feedback-delete", function(e) {
            e.preventDefault();

            $(".alert").remove();



            let deleteFeedback = confirm("هل أنت متأكد من حذف هذه الرسالة؟");

            let pageNumber = $(".pagination .active").text();
            if (pageNumber == "")
                pageNumber = 1;


            if (deleteFeedback) {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    method: "post",
                    url: "{{ route('dashboard.feedbacks.destroy', 0) }}",
                    data: new FormData(this),
                    dataType: "json",
                    processData: false,
                    contentType: false,
                    complete: function() {},
                    success: function(response) {

                        $(".alert").remove();
                        let table = $(".mytable");
                        let url = "{{ route('dashboard.feedbacks.table', '') }}/" + pageNumber + "";

                        table.load(url, function(res, status,
                            request) {

                            if (response.success)
                                $(".mytable").append(
                                    '<div class="alert alert-success text-center col-7 col-md-3 text-white" >' +
                                    response.message +
                                    '</div>'
                                );
                            else
                                $(".mytable").append(
                                    '<div class="alert alert-danger text-center col-7 col-md-3 text-white" >' +
                                    response.message +
                                    ' </div>'
                                );

                        });




                    },
                    error: function(response) {
                        $(".alert").remove();


                        let errors = response.responseJSON.errors;

                        for (let error in errors) {


                            $(".mytable").append(
                                '<div class = "alert alert-danger text-center col-7 col-md-3 text-white" >' +
                                errors[error] +
                                ' </div>'
                            );
                        }


                    }

                });
            }
        });
        //Load Table By Page Link//
        $(document).on("click", ".pagination .page-link", function(e) {
            e.preventDefault();



            let pageNumber = parseInt($(this).text());

            if ($(this).attr("rel") == "prev")
                pageNumber = parseInt($(".pagination .active").text()) - 1;
            else if ($(this).attr("rel") == "next")
                pageNumber = parseInt($(".pagination .active").text()) + 1;


            let table = $(".mytable");
            let url = "{{ route('dashboard.feedbacks.table', '') }}/" + pageNumber + "";

            table.load(url, function(res, status,
                request) {


            });
        });
    </script>
@endpush
