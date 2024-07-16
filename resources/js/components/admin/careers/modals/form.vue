<template>
    <div class="modal fade" tabindex="-1" id="modal-form-careers">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">{{ title }}</h3>

                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                    </div>
                    <!--end::Close-->
                </div>
                <form @submit.prevent="saveData">
                    <div class="modal-body">
                        <div class="mb-5">
                            <label>Nombre</label>
                            <input type="text" v-model="form.name" class="form-control bg-transparent" placeholder="Ingresar el nombre de la carrera">
                        </div>
                        <div class="mb-5">
                            <label for="">Servicio</label>
                            <select id="select-input-service" class="form-select form-select-solid" data-control="select2" data-dropdown-parent="#modal-form-careers" data-placeholder="Seleccione una opción" style="width: 100%;">
                                <option></option>
                                <option v-for="service in services_options" :value="service.id">{{ service.name }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary" :disabled="saving">
                            <span v-if="saving">Guardando <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                            <span v-else>Guardar</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    data() {
        return {
            title  : 'Agregar carrera',
            mode   : 'create',
            saving : false,
            services_options : [],
            form : {
                id : 0,
                name : null,
                service_id : null
            }
        }
    },
    mounted() {
        this.select2Activate();
    },
    methods: {
        select2Activate() {
            let _this = this;
            $('#select-input-service').on('change', function() {
                _this.form.service_id = $(this).val();
            });
        },
        openModal(data = null) {
            this.resetData();
            this.getServices();
            if(data){
                this.title = 'Editar carrera';
                this.mode  = 'edit';
                this.setFormData(data);
            } else {
                this.mode = 'create';
                this.data = null;
            }
            $('#modal-form-careers').modal('show');
        },
        getServices() {
            let _this = this;
            axios.get('/get-services').then(function(response){
                _this.services_options = response.data;
            });
        },
        setFormData(data) {
            this.form.id   = data.id;
            this.form.name = data.name;
            setTimeout(() => {
                $('#select-input-service').val(data.service_id);
                $('#select-input-service').trigger('change');
            }, 250);
        },
        validateData() {
            if(!this.form.name){
                toastr.warning('Ingrese un nombre');
                return false;
            }

            if(!this.form.service_id){
                toastr.warning('Seleccione un servicio');
                return false;
            }

            return true;
        },
        resetData(){
            this.saving    = false;
            this.form.id   = 0;
            this.form.name = null;
            this.form.service_id = null;
            setTimeout(() => {
                $('#select-input-service').val(null);
                $('#select-input-service').trigger('change');
            }, 250);
        },
        saveData() {
            if(this.validateData()){
                let response_request = null;
                this.saving          = true;
                let _this            = this;
                if(this.mode == 'edit'){
                    response_request = axios.put(`/carreras/${this.form.id}`,this.form);
                } else {
                    response_request = axios.post('/carreras',this.form);
                }
                if(response_request) {
                    response_request.then(function(response){
                        response = response.data;
                        if(!response.error){
                            toastr.success(response.message);
                            $('#modal-form-careers').modal('hide');
                            _this.$emit("refreshData");
                        } else {
                            toastr.error(response.message);
                        }
                        _this.saving = false;
                    });
                }
            }
        }
    },
}
</script>