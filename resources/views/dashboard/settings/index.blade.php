@extends('layouts.dashboard')

@section('section')
    <div class="d-flex flex-column justify-content-center align-items-center">
        <h1>اعدادت الموقع</h1>
        <form action="{{ route('settings.update') }}" enctype="multipart/form-data" method="POST">
            @csrf
            @method('PUT')
            <div class="input-group input-group-outline my-3 bg-white is-filled focus is-focused">
                <label class="form-label">اسم المتجر</label>
                <input type="text" name="store_name" value="{{ $setting->store_name }}" class="form-control">
            </div>
            <div class="input-group input-group-outline my-3 bg-white is-filled focus is-focused">
                <label class="form-label">عملة المتجر</label>
                <input type="text" name="store_currency" value="{{ $setting->store_currency }}" class="form-control">
            </div>
            <div class="input-group input-group-outline my-3 bg-white is-filled focus is-focused">
                <label class="form-label">رقم هاتف الواتس اب</label>
                <input type="text" name="whatsapp_phone" value="{{ $setting->whatsapp_phone }}" class="form-control">
            </div>
            <div class="input-group input-group-outline my-3 bg-white is-filled focus is-focused">
                <label class="form-label">عنوان الصفحة الرئيسية</label>
                <input type="text" name="home_title" value="{{ $setting->home_title }}" class="form-control">
            </div>

            <div class="d-flex justify-content-center align-items-center">
                <img src="{{ asset($setting->store_logo) }}" class="photo my-3" alt="">
            </div>
            <label class="text-dark">شعار الموقع :</label>
            <div class="input-group input-group-outline  bg-white">
                <input type="file" name="store_logo" class="form-control">
            </div>

            <div class="input-group input-group-outline my-3 bg-white is-filled focus is-focused">
                <label class="form-label">رقم الهاتف 1 :</label>
                <input type="text" name="contact_phone1" value="{{ $setting->contact_phone1 }}" class="form-control">
            </div>
            <div class="input-group input-group-outline my-3 bg-white is-filled focus is-focused">
                <label class="form-label">رقم الهاتف 2 :</label>
                <input type="text" name="contact_phone2" value="{{ $setting->contact_phone2 }}" class="form-control">
            </div>
            <div class="input-group input-group-outline my-3 bg-white is-filled focus is-focused">
                <label class="form-label">العنوان :</label>
                <input type="text" name="contact_address" value="{{ $setting->contact_address }}" class="form-control">
            </div>
            <button type="submit" class="btn btn-success margin col-6 my-3">حفظ</button>

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
