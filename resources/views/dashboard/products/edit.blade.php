@extends('layouts.dashboard')

@section('section')
    <div class="d-flex flex-column justify-content-center align-items-center">
        <h1>تعديل منتج</h1>

        <form action="" id="products" enctype="multipart/form-data" method="POST">
            @csrf
            @method('PUT')
            <div class="input-group input-group-outline my-3 bg-white is-filled focus is-focused">
                <label class="form-label">اسم المنتج</label>
                <input type="text" name="product_name" value="{{ $product->product_name }}" class="form-control">
            </div>
            <div class="input-group input-group-outline my-3 bg-white is-filled focus is-focused">
                <label class="form-label">سعر المنتج</label>
                <input type="text" name="product_price" value="{{ $product->product_price }}" class="form-control">
            </div>
            <div class="input-group input-group-outline my-3 bg-white is-filled focus is-focused">
                <label class="form-label">تخفيض %</label>
                <input type="text" name="product_discount" value="{{ $product->product_discount }}" class="form-control">
            </div>
            <label class="text-dark">صنف المنتج :</label>
            <div class="input-group input-group-outline  bg-white">
                <select class="form-control" name="item_id" id="">
                    @foreach ($items as $item)
                        <option value="{{ $item->id }}" @if ($product->item_id == $item->id) selected @endif>
                            {{ $item->item_name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="d-flex justify-content-center align-items-center">
                <img src="{{ asset($product->product_photo) }}" class="photo my-3" alt="">
            </div>
            <label class="text-dark">صورة المنتج :</label>
            <div class="input-group input-group-outline  bg-white">
                <input type="file" name="product_photo" class="form-control">
            </div>
            <button type="submit" class="btn btn-success margin my-3">تعديل</button>

            <a href="{{ URL::previous() }}" type="submit" class="btn btn-dark  my-3">رجوع</a>

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
        $("form#products").on("submit", function(e) {
            e.preventDefault();


            $(".alert").remove();




            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                method: "post",
                url: "{{ route('products.update', $product->id) }}",
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
