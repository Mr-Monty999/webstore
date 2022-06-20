@extends('layouts.dashboard')

@section('section')
    <div class="d-flex flex-column justify-content-center align-items-center">
        <h1>المنتجات</h1>
        @if ($items->count() > 0)
            <form action="{{ route('products.store') }}" enctype="multipart/form-data" method="POST">
                @csrf
                <div class="input-group input-group-outline my-3 bg-white">
                    <label class="form-label">اسم المنتج</label>
                    <input type="text" name="product_name" class="form-control">
                </div>
                <div class="input-group input-group-outline my-3 bg-white">
                    <label class="form-label">سعر المنتج</label>
                    <input type="text" name="product_price" class="form-control">
                </div>
                <div class="input-group input-group-outline my-3 bg-white">
                    <label class="form-label">تخفيض %</label>
                    <input type="text" name="product_discount" class="form-control">
                </div>
                <label class="text-dark">صنف المنتج :</label>
                <div class="input-group input-group-outline  bg-white">
                    <select class="form-control" name="item_id" id="">
                        @foreach ($items as $item)
                            <option value="{{ $item->id }}">{{ $item->item_name }}</option>
                        @endforeach
                    </select>
                </div>

                <label class="text-dark">صورة المنتج :</label>
                <div class="input-group input-group-outline  bg-white">
                    <input type="file" name="product_photo" class="form-control">
                </div>
                <button type="submit" class="btn btn-success margin my-3 col-6">اضافة</button>
            </form>

            @foreach ($errors->all() as $error)
                <div class="alert alert-danger text-white">{{ $error }}</div>
            @endforeach

            @if (Session::has('success'))
                <div class="alert alert-success text-white">{{ Session::get('success') }}</div>
            @elseif(Session::has('error'))
                <div class="alert alert-danger text-white">{{ Session::get('error') }}</div>
            @endif


            <div class="container-fluid row my-8">
                <div class="col-12">
                    <div class="card my-4">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                            <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                                <h6 class="text-white text-capitalize ps-3 text-center">جدول المنتجات</h6>
                            </div>
                        </div>
                        <div class="card-body px-0 pb-2">
                            <div class="table-responsive p-0">
                                <table class="table align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            <th class="text-uppercase text-primary font-weight-bolder">
                                                الرقم</th>
                                            <th class="text-uppercase text-primary  font-weight-bolder  ps-2">
                                                اسم المنتج</th>
                                            <th class="text-uppercase text-primary  font-weight-bolder  ps-2">
                                                سعر المنتج</th>
                                            <th class="text-uppercase text-primary  font-weight-bolder  ps-2">
                                                التخفيض</th>
                                            <th class="text-uppercase text-primary  font-weight-bolder  ps-2">
                                                صنف المنتج</th>
                                            <th class="text-uppercase text-primary  font-weight-bolder  ps-2">
                                                صورة المنتج</th>
                                            <th class="text-uppercase text-primary  font-weight-bolder">الاحداث</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $i = 0;
                                        @endphp
                                        @foreach ($products as $product)
                                            <tr>
                                                <td>
                                                    <p class="text-dark text-center">{{ ++$i }}</p>
                                                </td>
                                                <td>
                                                    <p class="text-dark text-center">{{ $product->product_name }}</p>
                                                </td>
                                                <td>
                                                    <p class="text-dark text-center">{{ $product->product_price }}</p>
                                                </td>
                                                <td>
                                                    @if ($product->product_discount != null)
                                                        <p class="text-dark text-center">{{ $product->product_discount }}%
                                                        </p>
                                                    @else
                                                        <p class="text-dark text-center">لايوجد تخفيض</p>
                                                    @endif
                                                </td>
                                                <td>
                                                    <p class="text-dark text-center">{{ $product->item->item_name }}</p>
                                                </td>

                                                <td>
                                                    @if ($product->product_photo != null)
                                                        <img src="{{ asset($product->product_photo) }}" alt="">
                                                    @else
                                                        <p class="text-dark text-center">لاتوجد صورة</p>
                                                    @endif
                                                </td>
                                                <td class="align-middle text-center">
                                                    <a href="{{ route('products.edit', $product->id) }}"
                                                        class="btn btn-dark">تعديل </a>
                                                    <form action="{{ route('products.delete', $product->id) }}"
                                                        method="post">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger">حذف </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach


                                    </tbody>
                                </table>

                            </div>
                        </div>
                    </div>
                </div>
                {{ $products->links() }}

            </div>
        @else
            <div class="alert alert-danger text-white"> عفوا لايوجد اصناف, الرجاء ادخال الاصناف اولا</div>
        @endif


    </div>
@endsection
