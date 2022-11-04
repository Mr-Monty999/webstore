@extends('layouts.dashboard')

@section('section')
    <div class="d-flex flex-column justify-content-center align-items-center">
        <h1>المشرفين</h1>
        <form id="users" enctype="multipart/form-data" method="POST">
            @csrf
            <div class="input-group input-group-outline my-3 bg-white">
                <label class="form-label">اسم المشرف</label>
                <input type="text" name="name" class="form-control">
            </div>
            <div class="input-group input-group-outline my-3 bg-white">
                <label class="form-label">كلمة المرور</label>
                <input type="text" name="password" class="form-control">
            </div>


            <label class="text-dark">صورة المشرف :</label>
            <div class="input-group input-group-outline  bg-white">
                <input type="file" name="photo" class="form-control">
            </div>
            <div class="my-4">
                <h4>رتب المستخدم</h4>
                <div class="form-check form-check-inline col-9">
                    @foreach ($roles as $role)
                        @if ($role->name != 'owner')
                            <input class="form-check-input" type="checkbox" id="role{{ $role->id }}"
                                value="{{ $role->name }}">
                            <label class="form-check-label" for="role{{ $role->id }}">{{ $role->name }}</label>
                        @endif
                    @endforeach

                </div>
            </div>
            <button type="submit" class="btn btn-success margin my-3 col-6">اضافة</button>
        </form>

        {{-- <div class="d-flex spinner">
            <p>
                جار الاضافة...
            </p>
            <div class="spinner-border text-primary margin-1" role="status">
            </div>
        </div> --}}

        @foreach ($errors->all() as $error)
            <div class="alert alert-danger text-white">{{ $error }}</div>
        @endforeach

        @if (Session::has('success'))
            <div class="alert alert-success text-white">{{ Session::get('success') }}</div>
        @elseif(Session::has('error'))
            <div class="alert alert-danger text-white">{{ Session::get('error') }}</div>
        @endif


        <div class="container-fluid d-flex flex-column justify-content-center align-items-center row my-8 mytable">
            @include('dashboard.users.table')
        </div>

        <form action="" id="delete-all-users" method="post">
            @method('DELETE')
            @csrf
            <button type="submit" class="btn btn-warning">مسح جميع المشرفين</button>
        </form>


    </div>
@endsection

@push('ajax')
    <script>
        // Insert Admin And Update Table //
        $("form#users").on("submit", function(e) {
            e.preventDefault();

            $(".alert").remove();

            let roles = [];
            $(".form-check-input:checked").each(function(index, element) {
                roles.push($(element).val());
            });
            let formData = new FormData(this);
            formData.append("roles", roles);

            let pageNumber = $(".pagination .active").text();
            if (pageNumber == "")
                pageNumber = 1;

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                method: "post",
                url: "{{ route('users.store') }}",
                data: formData,
                dataType: "json",
                processData: false,
                contentType: false,
                beforeSend: function() {
                    $("form#users").after(
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
                    let url = "{{ route('users.table', '') }}/" + pageNumber + "";

                    table.load(url, function(res, status,
                        request) {


                    });

                    if (response.success) {
                        $("form#users").after(
                            '<div class = "alert alert-success text-white" >' + response.message +
                            ' </div>'
                        );
                        $("form#users input").val("");

                    } else
                        $("form#users").after(
                            '<div class = "alert alert-danger text-white" >' + response.message +
                            ' </div>'
                        );



                },
                error: function(response) {
                    $(".alert").remove();


                    let errors = response.responseJSON.errors;

                    for (let error in errors) {


                        $("form#users").after(
                            '<div class = "alert alert-danger text-white" >' + errors[error] +
                            ' </div>'
                        );
                    }


                }

            });
        });


        ////Delete Admin And Update Table ////
        $(document).on("submit", "form#user-delete", function(e) {
            e.preventDefault();

            $(".alert").remove();


            let deleteProduct = confirm("هل أنت متأكد من حذف هذا المشرف؟");

            // let productId = $(this).find("#item-id");

            let pageNumber = $(".pagination .active").text();
            if (pageNumber == "")
                pageNumber = 1;

            if (deleteProduct) {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    method: "post",
                    url: "{{ route('users.delete', '0') }}",
                    data: new FormData(this),
                    dataType: "json",
                    processData: false,
                    contentType: false,
                    complete: function() {},
                    success: function(response) {
                        $(".alert").remove();


                        let table = $(".mytable");
                        let url = "{{ route('users.table', '') }}/" + pageNumber + "";

                        table.load(url, function(res, status,
                            request) {

                            if (response.success)
                                $(".mytable").append(
                                    '<div class = "alert alert-success text-center col-7 col-md-3 text-white" >' +
                                    response
                                    .message +
                                    ' </div>'
                                );
                            else
                                $(".mytable").append(
                                    '<div class = "alert alert-danger text-center col-7 col-md-3 text-white" >' +
                                    response
                                    .message +
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

        ////Delete All Admins And Update Table ////
        $(document).on("submit", "form#delete-all-users", function(e) {
            e.preventDefault();

            $(".alert").remove();



            let deleteProduct = confirm("هل أنت متأكد من حذف جميع المشرفين؟");

            // let productId = $(this).find("#item-id");

            if (deleteProduct) {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    method: "post",
                    url: "{{ route('users.delete.all') }}",
                    data: new FormData(this),
                    dataType: "json",
                    processData: false,
                    contentType: false,
                    beforeSend: function() {
                        $("form#delete-all-users").after(
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
                        let url = "{{ route('users.table', '1') }}";

                        table.load(url, function(res, status,
                            request) {

                            if (response.success)
                                $("form#delete-all-users").after(
                                    '<div class = "alert alert-success text-center col-7 col-md-3 text-white" >' +
                                    response
                                    .message +
                                    ' </div>'
                                );
                            else
                                $("form#delete-all-users").after(
                                    '<div class = "alert alert-danger text-center col-7 col-md-3 text-white" >' +
                                    response
                                    .message +
                                    ' </div>'
                                );

                        });




                    },
                    error: function(response) {

                        $(".alert").remove();

                        let errors = response.responseJSON.errors;

                        for (let error in errors) {


                            $("form#delete-all-users").after(
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


            let url = "{{ route('users.table', '') }}/" + pageNumber + "";
            let table = $(".mytable");
            table.load(url, function(res, status,
                request) {


            });
        });
    </script>
@endpush
