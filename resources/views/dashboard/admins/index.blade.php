@extends('layouts.dashboard')

@section('section')
    <div class="d-flex flex-column justify-content-center align-items-center">
        <h1>المشرفين</h1>
        <form action="{{ route('admins.store') }}" enctype="multipart/form-data" method="POST">
            @csrf
            <div class="input-group input-group-outline my-3 bg-white">
                <label class="form-label">اسم المشرف</label>
                <input type="text" name="admin_name" class="form-control">
            </div>
            <div class="input-group input-group-outline my-3 bg-white">
                <label class="form-label">كلمة المرور</label>
                <input type="text" name="password" class="form-control">
            </div>


            <label class="text-dark">صورة المشرف :</label>
            <div class="input-group input-group-outline  bg-white">
                <input type="file" name="admin_photo" class="form-control">
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
                            <h6 class="text-white text-capitalize ps-3 text-center">جدول المشرفين</h6>
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
                                            اسم المشرف</th>
                                        <th class="text-uppercase text-primary  font-weight-bolder  ps-2">
                                            صورة المشرف</th>
                                        <th class="text-uppercase text-primary  font-weight-bolder  ps-2">
                                            تاريخ الانشاء</th>
                                        <th class="text-uppercase text-primary  font-weight-bolder  ps-2">
                                            اخر تعديل</th>
                                        <th class="text-uppercase text-primary  font-weight-bolder">الاحداث</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        use Illuminate\Support\Facades\Auth;
                                        
                                        $i = 0;
                                    @endphp
                                    @foreach ($admins as $admin)
                                        @if ($admin->id != Auth::guard('admin')->id())
                                            <tr>
                                                <td>
                                                    <p class="text-dark text-center">{{ ++$i }}</p>
                                                </td>
                                                <td>
                                                    <p class="text-dark text-center">{{ $admin->admin_name }}</p>
                                                </td>
                                                <td>
                                                    @if ($admin->admin_photo != null)
                                                        <img src="{{ asset($admin->admin_photo) }}" alt="">
                                                    @else
                                                        <p class="text-dark text-center">لاتوجد صورة</p>
                                                    @endif
                                                </td>
                                                <td>
                                                    <p class="text-dark text-center" dir="ltr">
                                                        {{ $admin->created_at->diffForHumans() }}
                                                    </p>
                                                </td>
                                                <td>
                                                    <p class="text-dark text-center" dir="ltr">
                                                        {{ $admin->updated_at->diffForHumans() }}
                                                    </p>
                                                </td>

                                                <td class="align-middle text-center">
                                                    <a href="{{ route('admins.edit', $admin->id) }}"
                                                        class="btn btn-dark">تعديل </a>
                                                    <form action="{{ route('admins.delete', $admin->id) }}"
                                                        method="post">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger">حذف </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach


                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
            {{ $admins->links() }}

        </div>



    </div>
@endsection
