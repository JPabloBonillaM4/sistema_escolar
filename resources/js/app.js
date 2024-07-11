import './bootstrap';
toastr.options = {
    // "closeButton"   : false,
    // "positionClass" : 'toastr-top-center'
}
// Vue instance
import { createApp } from 'vue';
// General components
import tablePaginationPersonalize from './components/globals/pagination-personalize.vue';
// Start:Components - Vue
import loginComponent from './components/login/index.vue';
import servicesComponent from './components/admin/services/index.vue';
import careersComponent from './components/admin/careers/index.vue';
import subjectsComponent from './components/admin/subjects/index.vue';
const app = createApp({
    components : {
        "login-component" : loginComponent,
        "services-component" : servicesComponent,
        "careers-component" : careersComponent,
        "subjects-component" : subjectsComponent
    }
});
app.component("table-pagination", tablePaginationPersonalize);
// End:Components - Vue
app.mount('#app'); // Init Vue on #app