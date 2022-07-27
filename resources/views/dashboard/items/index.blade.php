@extends('layouts.dashboard')

@section('section')
    <div class="d-flex flex-column justify-content-center align-items-center">
        <h1>الاصناف</h1>
        <form id="items" method="POST">
            @csrf
            <div class="input-group input-group-outline my-3 bg-white">
                <label class="form-label">اسم الصنف</label>
                <input type="text" name="item_name" class="form-control">
            </div>
            <button type="submit" class="btn btn-success margin col-6">اضافة</button>
        </form>

        @foreach ($errors->all() as $error)
            <div class="alert alert-danger text-white">{{ $error }}</div>
        @endforeach

        @if (Session::has('success'))
            <div class="alert alert-success text-white">{{ Session::get('success') }}</div>
        @elseif(Session::has('error'))
            <div class="alert alert-danger text-white">{{ Session::get('error') }}</div>
        @endif

        <div class="container-fluid d-flex flex-column justify-content-center align-items-center row my-8 mytable">

            @include('dashboard.items.table')

        </div>
        <form id="delete-all-items" action="" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-warning">حذف جميع الاصناف</button>
        </form>
    </div>
@endsection
@push('ajax')
    <script>
        // Insert Item And Update Table //
        $("form#items").on("submit", function(e) {
            e.preventDefault();

            $(".alert").remove();



            let pageNumber = $(".pagination .active").text();
            if (pageNumber == "")
                pageNumber = 1;

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                method: "post",
                url: "{{ route('items.store') }}",
                data: new FormData(this),
                dataType: "json",
                processData: false,
                contentType: false,
                beforeSend: function() {
                    $("form#items").after(
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
                    let url = "{{ route('items.table', '') }}/" + pageNumber + "";

                    table.load(url, function(response, status,
                        request) {


                    });

                    if (response.success) {
                        $("form#items").after(
                            '<div class = "alert alert-success text-white" >' + response.message +
                            ' </div>'
                        );
                        $("form#items input").val("");

                    } else
                        $("form#items").after(
                            '<div class = "alert alert-danger text-white" >' + response.message +
                            ' </div>'
                        );



                },
                error: function(response) {

                    $(".alert").remove();

                    let errors = response.responseJSON.errors;

                    for (let error in errors) {


                        $("form#items").after(
                            '<div class = "alert alert-danger text-white" >' + errors[error] +
                            ' </div>'
                        );
                    }


                }

            });
        });


        ////Delete Item And Update Table ////
        $(document).on("submit", "form#item-delete", function(e) {
            e.preventDefault();

            $(".alert").remove();


            let deleteProduct = confirm("هل أنت متأكد من حذف الصنف؟");

            let pageNumber = $(".pagination .active").text();
            if (pageNumber == "")
                pageNumber = 1;

            if (deleteProduct) {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    method: "post",
                    url: "{{ route('items.delete', '0') }}",
                    data: new FormData(this),
                    dataType: "json",
                    processData: false,
                    contentType: false,
                    complete: function() {},
                    success: function(response) {

                        $(".alert").remove();

                        let table = $(".mytable");
                        let url = "{{ route('items.table', '') }}/" + pageNumber + "";

                        table.load(url, function(res, status, request) {
                            if (response.success)
                                $(".mytable").append(
                                    '<div class = "alert alert-success text-center col-7 col-md-3 text-white" >' +
                                    response
                                    .message +
                                    ' </div>'
                                );
                            else $(".mytable").append(
                                '<div class = "alert alert-danger text-center col-7 col-md-3 text-white" >' +
                                response.message + ' </div>'
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

        //Delete All Items ////
        $(document).on("submit", "form#delete-all-items", function(e) {
            e.preventDefault();

            $(".alert").remove();


            let deleteProduct = confirm("هل أنت متأكد من حذف جميع الاصناف؟");

            // let pageNumber = $(".pagination .active").text();

            if (deleteProduct) {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    method: "post",
                    url: "{{ route('items.delete.all') }}",
                    data: new FormData(this),
                    dataType: "json",
                    processData: false,
                    contentType: false,
                    beforeSend: function() {
                        $("form#delete-all-items").after(
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
                        let url = "{{ route('items.table', '1') }}";

                        table.load(url, function(res, status, request) {
                            if (response.success)
                                $("form#delete-all-items").after(
                                    '<div class = "alert alert-success text-center col-7 col-md-3 text-white" >' +
                                    response
                                    .message +
                                    ' </div>'
                                );
                            else $("form#delete-all-items").after(
                                '<div class = "alert alert-danger text-center col-7 col-md-3 text-white" >' +
                                response.message + ' </div>'
                            );

                        });
                    },
                    error: function(response) {
                        $(".alert").remove();


                        let errors = response.responseJSON.errors;
                        for (let error in errors) {
                            $("form#delete-all-items").after(
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
            let url = "{{ route('items.table', '') }}/" + pageNumber + "";

            table.load(url, function(response, status,
                request) {


            });
        });
    </script>
@endpush
