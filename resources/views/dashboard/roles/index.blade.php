@extends('layouts.dashboard')
@section('section')
    <a href="{{ route('roles.create') }}" class="btn btn-primary">إضافة رتبة جديدة</a>
    <div class="container-fluid d-flex flex-column justify-content-center align-items-center row my-2 mytable">
        @include('dashboard.roles.table')
    </div>
@endsection

@push('ajax')
    <script>
        ////Delete Role And Update Table ////
        $(document).on("submit", "form#role-delete", function(e) {
            e.preventDefault();

            $(".alert").remove();


            let deleteProduct = confirm("هل أنت متأكد من حذف الرتبة؟");

            let pageNumber = $(".pagination .active").text();
            if (pageNumber == "")
                pageNumber = 1;

            if (deleteProduct) {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    method: "post",
                    url: "{{ route('roles.destroy', '0') }}",
                    data: new FormData(this),
                    dataType: "json",
                    processData: false,
                    contentType: false,
                    complete: function() {},
                    success: function(response, success) {

                        $(".alert").remove();

                        let table = $(".mytable");
                        let url = "{{ route('roles.table', '') }}/" + pageNumber + "";

                        table.load(url, function(res, status, request) {
                            if (success)
                                $(".mytable").append(
                                    '<div class = "alert alert-success text-center col-7 col-md-3 text-white" >تم حذف الرتبة بنجاح' +
                                    ' </div>'
                                );
                            // else $(".mytable").append(
                            //     '<div class = "alert alert-danger text-center col-7 col-md-3 text-white" >' +
                            //     message + ' </div>'
                            // );

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

        //Delete All Roles ////
        $(document).on("submit", "form#delete-all-roles", function(e) {
            e.preventDefault();

            $(".alert").remove();


            let deleteProduct = confirm("هل أنت متأكد من حذف جميع الرتب؟");

            // let pageNumber = $(".pagination .active").text();

            if (deleteProduct) {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    method: "post",
                    url: "{{ route('roles.destroy.all') }}",
                    data: new FormData(this),
                    dataType: "json",
                    processData: false,
                    contentType: false,
                    beforeSend: function() {
                        $("form#delete-all-roles").after(
                            '<div class="d-flex spinner"><p>جار المعالجة...</p>' +
                            '<div class="spinner-border text-primary margin-1" role="status"></div>' +
                            '</div>'
                        );
                    },
                    complete: function() {
                        $(".spinner").remove();
                    },
                    success: function(response, sucess) {

                        $(".alert").remove();

                        let table = $(".mytable");
                        let url = "{{ route('roles.table', '1') }}";

                        table.load(url, function(res, status, request) {
                            if (success)
                                $("form#delete-all-roles").after(
                                    '<div class = "alert alert-success text-center col-7 col-md-3 text-white" >تم حذف جميع الرتب بنجاح' +
                                    ' </div>'
                                );
                            // else $("form#delete-all-roles").after(
                            //     '<div class = "alert alert-danger text-center col-7 col-md-3 text-white" >' +
                            //     response.message + ' </div>'
                            // );

                        });
                    },
                    error: function(response) {
                        $(".alert").remove();


                        let errors = response.responseJSON.errors;
                        for (let error in errors) {
                            $("form#delete-all-roles").after(
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
            let url = "{{ route('roles.table', '') }}/" + pageNumber + "";

            table.load(url, function(response, status,
                request) {


            });
        });
    </script>
@endpush
