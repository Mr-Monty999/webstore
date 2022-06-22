@extends('layouts.dashboard')

@section('section')
    <div class="d-flex flex-column justify-content-center align-items-center">
        <h1>الاصناف</h1>
        <form action="{{ route('items.store') }}" method="POST">
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

        <div class="container-fluid row my-8">
            <div class="col-12">
                <div class="card my-4">
                    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                        <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                            <h6 class="text-white text-capitalize ps-3 text-center">جدول الاصناف</h6>
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
                                            اسم الصنف</th>

                                        <th class="text-uppercase text-primary  font-weight-bolder">الاحداث</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $i = 0;
                                    @endphp
                                    @foreach ($items as $item)
                                        <tr>
                                            <td>
                                                <p class="text-dark text-center">{{ ++$i }}</p>
                                            </td>
                                            <td>
                                                <p class="text-dark text-center">{{ $item->item_name }}</p>
                                            </td>

                                            <td class="align-middle text-center">
                                                <a href="{{ route('items.edit', $item->id) }}" class="btn btn-dark">تعديل
                                                </a>
                                                <form action="{{ route('items.delete', $item->id) }}" method="post">
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
            {!! $items->links() !!}

        </div>

    </div>
@endsection
