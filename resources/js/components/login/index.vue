<template>
    <div class="d-flex flex-column flex-column-fluid flex-lg-row">
        <!--begin::Aside-->
        <div class="d-flex flex-center w-lg-50 pt-15 pt-lg-0 px-10">
            <!--begin::Aside-->
            <div class="d-flex flex-center flex-lg-start flex-column">
                <!--begin::Logo-->
                <a href="index.html" class="mb-7">
                    <img alt="Logo" src="assets/media/logos/custom-3.svg" />
                </a>
                <!--end::Logo-->
                <!--begin::Title-->
                <h2 class="text-white fw-normal m-0">Sistema de control escolar</h2>
                <!--end::Title-->
            </div>
            <!--begin::Aside-->
        </div>
        <!--begin::Aside-->
        <!--begin::Body-->
        <div class="d-flex flex-column-fluid flex-lg-row-auto justify-content-center justify-content-lg-end p-12 p-lg-20">
            <!--begin::Card-->
            <div class="bg-body d-flex flex-column align-items-stretch flex-center rounded-4 w-md-600px p-20">
                <!--begin::Wrapper-->
                <div class="d-flex flex-center flex-column flex-column-fluid px-lg-10 pb-15 pb-lg-20">
                    <!--begin::Form-->
                    <form class="form w-100" @submit="loading = true" method="POST" :action="route_login">
                        <input type="hidden" :value="csrf_token" name="_token" autocomplete="off">
                        <!--begin::Heading-->
                        <div class="text-center mb-11">
                            <!--begin::Title-->
                            <h1 class="text-gray-900 fw-bolder mb-3 text-uppercase">Iniciar sesión</h1>
                            <!--end::Title-->
                            <!--begin::Subtitle-->
                            <div class="text-gray-500 fw-semibold fs-6">Ingrese sus credenciales de acceso</div>
                            <!--end::Subtitle=-->
                        </div>
                        <div class="alert alert-danger d-flex align-items-center p-5 mb-10" v-if="errors.length > 0">
                            <!--begin::Svg Icon | path: icons/duotune/general/gen048.svg-->
                            <span class="svg-icon svg-icon-2hx svg-icon-danger me-4">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path opacity="0.3" d="M20.5543 4.37824L12.1798 2.02473C12.0626 1.99176 11.9376 1.99176 11.8203 2.02473L3.44572 4.37824C3.18118 4.45258 3 4.6807 3 4.93945V13.569C3 14.6914 3.48509 15.8404 4.4417 16.984C5.17231 17.8575 6.18314 18.7345 7.446 19.5909C9.56752 21.0295 11.6566 21.912 11.7445 21.9488C11.8258 21.9829 11.9129 22 12.0001 22C12.0872 22 12.1744 21.983 12.2557 21.9488C12.3435 21.912 14.4326 21.0295 16.5541 19.5909C17.8169 18.7345 18.8277 17.8575 19.5584 16.984C20.515 15.8404 21 14.6914 21 13.569V4.93945C21 4.6807 20.8189 4.45258 20.5543 4.37824Z" fill="currentColor"></path>
                                    <path d="M10.5606 11.3042L9.57283 10.3018C9.28174 10.0065 8.80522 10.0065 8.51412 10.3018C8.22897 10.5912 8.22897 11.0559 8.51412 11.3452L10.4182 13.2773C10.8099 13.6747 11.451 13.6747 11.8427 13.2773L15.4859 9.58051C15.771 9.29117 15.771 8.82648 15.4859 8.53714C15.1948 8.24176 14.7183 8.24176 14.4272 8.53714L11.7002 11.3042C11.3869 11.6221 10.874 11.6221 10.5606 11.3042Z" fill="currentColor"></path>
                                </svg>
                            </span>
                            <!--end::Svg Icon-->
                            <div class="d-flex flex-column">
                                <h4 class="mb-1 text-danger">¡Cuidado!</h4>
                                <ul>
                                    <li v-for="error in errors">{{ error }}</li>
                                </ul>
                            </div>
                        </div>
                        <!--begin::Heading-->
                        <!--begin::Input group=-->
                        <div class="fv-row mb-8">
                            <!--begin::Email-->
                            <input type="text" placeholder="Usuario" name="email" autocomplete="off" class="form-control bg-transparent" required />
                            <!--end::Email-->
                        </div>
                        <!--end::Input group=-->
                        <div class="fv-row mb-3">
                            <!--begin::Password-->
                            <input type="password" placeholder="Contraseña" name="password" autocomplete="off" class="form-control bg-transparent" required />
                            <!--end::Password-->
                        </div>
                        <!--end::Input group=-->
                        <!--begin::Wrapper-->
                        <!-- <div class="d-flex flex-stack flex-wrap gap-3 fs-base fw-semibold mb-8">
                            <div></div>
                            <a href="authentication/layouts/creative/reset-password.html" class="link-primary">¿Olvidó su contraseña?</a>
                        </div> -->
                        <!--end::Wrapper-->
                        <!--begin::Submit button-->
                        <div class="d-grid mt-10">
                            <button type="submit" id="kt_sign_in_submit" :disabled="loading" class="btn btn-primary">
                                <!--begin::Indicator label-->
                                <span v-if="!loading" class="indicator-label">Iniciar sesión</span>
                                <!--end::Indicator label-->
                                <!--begin::Indicator progress-->
                                <span v-else>
                                    Ingresando...
                                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                </span>
                                <!--end::Indicator progress-->
                            </button>
                        </div>
                        <!--end::Submit button-->
                        <!--begin::Sign up-->
                        <!-- <div class="text-gray-500 text-center fw-semibold fs-6">Not a Member yet? 
                        <a href="authentication/layouts/creative/sign-up.html" class="link-primary">Sign up</a></div> -->
                        <!--end::Sign up-->
                    </form>
                    <!--end::Form-->
                </div>
                <!--end::Wrapper-->
            </div>
            <!--end::Card-->
        </div>
        <!--end::Body-->
    </div>
</template>
<script>
export default {
    props: ['route_login'],
    data() {
        return {
            loading    : false,
            csrf_token : window.Laravel.csrfToken,
            errors     : window.Laravel.errors
        }
    },
}
</script>