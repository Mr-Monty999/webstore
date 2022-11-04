@extends('layouts.dashboard')
@section('section')
    <h1>تعديل رتبة {{ $role->name }}</h1>
    <a href="{{ URL::previous() }}" class="btn btn-dark">رجوع</a>

    <form id="roles" method="POST">
        @csrf
        @method('put')
        <div class="input-group input-group-outline my-3 bg-white is-filled">
            <label class="form-label">اسم الرتبة</label>
            <input type="text" name="name" value="{{ $role->name }}" class="form-control">
        </div>
        <br>
        <h4>صلاحيات الرتبة</h4>
        <div class="form-check form-check-inline col-7">
            @foreach ($permissions as $permission)
                <input class="form-check-input" type="checkbox" @if ($role->hasPermissionTo($permission->id)) checked @endif
                    id="permission{{ $permission->id }}" value="{{ $permission->id }}">
                <label class="form-check-label" for="permission{{ $permission->id }}">{{ $permission->name }}</label>
            @endforeach
        </div>


        <button type="submit" class="btn btn-success margin my-3 d-block">حفظ</button>
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
                url: "{{ route('roles.update', $role->id) }}",
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
                success: function(response, success) {

                    console.log(response);
                    $(".alert").remove();


                    if (success)
                        $("form").after(
                            '<div class = "alert alert-success text-white" >تم حفظ الرتبة بنجاح' +
                            ' </div>'
                        );
                    // else
                    //     $("form").after(
                    //         '<div class = "alert alert-danger text-white" >' + response.message +
                    //         ' </div>'
                    //     );




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
