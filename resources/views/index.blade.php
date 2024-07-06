@include('layouts.head')
{{-- @if ($actual_route != 'login')
    @include('layouts.preloader')
@endif --}}
<!--begin::App-->
<div class="d-flex flex-column flex-root app-root" id="app">
    @yield('content')
</div>
<!--end::App-->
@include('layouts.foot')