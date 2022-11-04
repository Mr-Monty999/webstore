@extends('layouts.dashboard')

@section('section')
    <div class="d-flex flex-column justify-content-center align-items-center">
        <h1>تعديل مشرف</h1>
        <form id="users" enctype="multipart/form-data" method="POST">
            @csrf
            @method('PUT')
            <div class="input-group input-group-outline my-3 bg-white is-filled focus is-focused">
                <label class="form-label">الاسم</label>
                <input type="text" name="name" value="{{ $user->name }}" class="form-control">
            </div>
            <div class="input-group input-group-outline my-3 bg-white is-filled focus is-focused">
                <label class="form-label">كلمة المرور الجديدة</label>
                <input type="text" name="password" class="form-control">
            </div>
            <div class="d-flex justify-content-center align-items-center">
                <img src="{{ asset($user->photo) }}" class="photo my-3" alt="">
            </div>
            <label class="text-dark">الصورة الشخصية :</label>
            <div class="input-group input-group-outline bg-white">
                <input type="file" name="photo" class="form-control">
            </div>
            <div class="my-4">
                <h4>رتب المستخدم</h4>
                <div class="form-check form-check-inline col-9">
                    @foreach ($roles as $role)
                        @if ($role->name != 'owner')
                            <input class="form-check-input" @if ($user->hasRole($role->name)) checked @endif type="checkbox"
                                id="role{{ $role->id }}" value="{{ $role->name }}">
                            <label class="form-check-label" for="role{{ $role->id }}">{{ $role->name }}</label>
                        @endif
                    @endforeach
                </div>
            </div>
            <button type="submit" class="btn btn-success margin my-3">حفظ</button>
            <a href="{{ URL::previous() }}" class="btn btn-dark my-3">رجوع</a>
        </form>


        @foreach ($errors->all() as $error)
            <div class="alert alert-danger text-white">{{ $error }}</div>
        @endforeach

        @if (Session::has('success'))
            <div class="alert alert-success text-white">{{ Session::get('success') }}</div>
        @elseif(Session::has('error'))
            <div class="alert alert-danger text-white">{{ Session::get('error') }}</div>
        @endif



    </div>
@endsection
@push('ajax')
    <script>
        $("form#users").on("submit", function(e) {
            e.preventDefault();

            let roles = [];
            $(".form-check-input:checked").each(function(index, element) {
                roles.push($(element).val());
            });
            let formData = new FormData(this);
            formData.append("roles", roles);

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                method: "post",
                url: "{{ route('users.update', $user->id) }}",
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
                success: function(response) {

                    $(".alert").remove();

                    if (response.photo_path != null)
                        $("form img").attr("src", response.photo_path);

                    if (response.success)
                        $("form").after(
                            '<div class = "alert alert-success text-white" >' + response.message +
                            ' </div>'
                        );
                    else
                        $("form").after(
                            '<div class = "alert alert-danger text-white" >' + response.message +
                            ' </div>'
                        );




                },
                error: function(response) {

                    $(".alert").remove();


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
