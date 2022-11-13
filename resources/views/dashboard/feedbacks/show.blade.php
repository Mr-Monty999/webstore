@extends('layouts.dashboard')

@section('section')
    <div class="d-flex flex-column justify-content-center align-items-center feedback">
        <h1 class="text-break">رسالة {{ $feedback->name }}</h1>
        <h6 class="my-5 col-md-6 col-12 text-right text-break">
            {{ $feedback->message }}
        </h6>
        <form id="feedback-delete" method="POST">
            @csrf
            @method('DELETE')
            <input type="text" hidden name="id" value="{{ $feedback->id }}">
            <a href="{{ URL::previous() }}" class="btn btn-dark">رجوع</a>
            <button type="submit" class="btn btn-danger">حذف</button>

        </form>





    </div>
@endsection

@push('ajax')
    <script>
        //Delete Feedback
        $("form#feedback-delete").on("submit", function(e) {
            e.preventDefault();

            $(".alert").remove();



            let deleteFeedback = confirm("هل أنت متأكد من حذف هذه الرسالة؟");

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


                        if (response.success) {
                            $("form").after(
                                '<div class = "alert alert-success text-white" >' + response
                                .message +
                                ' </div>'
                            );
                            location.href = "{{ URL::previous() }}";
                        } else
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
            }
        });
    </script>
@endpush
