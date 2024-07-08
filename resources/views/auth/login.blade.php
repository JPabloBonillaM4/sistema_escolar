@push('css')
<!--begin::Page bg image-->
<style>
    body { background-image: url('assets/media/auth/bg4.jpg'); } [data-bs-theme="dark"] body { background-image: url('assets/media/auth/bg4-dark.jpg'); }
</style>
<!--end::Page bg image-->
@endpush
@extends('index')
@section('content')
<!--begin::Authentication - Sign-in -->
<login-component route_login="{{ route('login') }}"></login-component>
<!--end::Authentication - Sign-in-->
@endsection