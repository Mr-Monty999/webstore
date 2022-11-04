@extends('layouts.dashboard')
@section('section')
    <h1>إضافة رتبة</h1>
    <a href="{{ URL::previous() }}" class="btn btn-dark">رجوع</a>

    <form id="roles" method="POST">
        @csrf
        <div class="input-group input-group-outline my-3 bg-white">
            <label class="form-label">اسم الرتبة</label>
            <input type="text" name="name" class="form-control">
        </div>
        <br>
        <h4>صلاحيات الرتبة</h4>
        <div class="form-check form-check-inline col-7">
            @foreach ($permissions as $permission)
                <input class="form-check-input" type="checkbox" checked id="permission{{ $permission->id }}"
                    value="{{ $permission->name }}">
                <label class="form-check-label" for="permission{{ $permission->id }}">{{ $permission->name }}</label>
            @endforeach

        </div>


        <button type="submit" class="btn btn-success margin my-3 d-block">اضافة</button>
    </form>

    @foreach ($errors->all() as $error)
        <div class="alert alert-danger text-white">{{ $error }}</div>
    @endforeach

    @if (Session::has('success'))
        <div class="alert alert-success text-white">{{ Session::get('success') }}</div>
    @elseif(Session::has('error'))
        <div class="alert alert-danger text-white">{{ Session::get('error') }}</div>
    @endif
@endsection

@push('ajax')
    <script>
        $("form#roles").on("submit", function(e) {
            e.preventDefault();

            $(".alert").remove();


            let permissions = [];
            $(".form-check-input:checked").each(function(index, element) {
                permissions.push($(element).val());
            });
            let formData = new FormData(this);
            formData.append("permissions", permissions);


            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                method: "post",
                url: "{{ route('roles.store') }}",
                data: formData,
                dataType: "json",
                processData: false,
                contentType: false,
                beforeSend: function() {
                    $("form").after(
                        '<div class="d-flex spinner"><p>جار المعالجة...</p>' +
                        '<div class="spinner-border text-primary margin-1" role="status"></div>' +
                        '</div>'
                    );
                },
                complete: function() {
                    $(".spinner").remove();
                },
                success: function(response, success, code) {

                    $(".alert").remove();


                    if (success)
                        $("form").after(
                            '<div class = "alert alert-success text-white" >تم إضافة الرتبة بنجاح' +
                            ' </div>'
                        );





                },
                error: function(response) {

                    $(".alert").remove();
                    if (response.status == 409)
                        $("form").after(
                            '<div class = "alert alert-danger text-white" >هذه الرتبة موجودة بالفعل' +
                            ' </div>'
                        );

                    let errors = response.responseJSON.errors;

                    for (let error in errors) {


                        $("form").after(
                            '<div class = "alert alert-danger text-white" >' + errors[error] +
                            ' </div>'
                        );
                    }

                }

            });
        });
    </script>
@endpush
