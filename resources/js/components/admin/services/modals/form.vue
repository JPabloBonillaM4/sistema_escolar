<template>
    <div class="modal fade" tabindex="-1" id="modal-form-services">
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

                <div class="modal-body">
                    <form>
                        <label>Nombre</label>
                        <input type="text" v-model="form.name" class="form-control bg-transparent" placeholder="Ingresar el nombre del servicio">
                    </form>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary" @click="saveData" :disabled="saving">
                        <span v-if="saving">Guardando <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                        <span v-else>Guardar</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    data() {
        return {
            title  : 'Agregar servicio',
            mode   : 'create',
            saving : false,
            form : {
                id : 0,
                name : null
            }
        }
    },
    methods: {
        openModal(data = null) {
            this.resetData();
            if(data){
                this.title = 'Editar servicio';
                this.mode  = 'edit';
                this.setFormData(data);
            } else {
                this.mode = 'create';
                this.data = null;
            }
            $('#modal-form-services').modal('show');
        },
        setFormData(data) {
            this.form.id   = data.id;
            this.form.name = data.name;
        },
        validateData() {
            if(!this.form.name){
                toastr.warning('Ingrese un nombre');
                return false;
            }

            return true;
        },
        resetData(){
            this.saving    = false;
            this.form.id   = 0;
            this.form.name = null;
        },
        saveData() {
            if(this.validateData()){
                let response_request = null;
                this.saving          = true;
                let _this            = this;
                if(this.mode == 'edit'){
                    response_request = axios.put(`/servicios/${this.form.id}`,{
                        "name" : this.form.name,
                    });
                } else {
                    response_request = axios.post('/servicios',{
                        "name" : this.form.name,
                    });
                }
                if(response_request) {
                    response_request.then(function(response){
                        response = response.data;
                        if(!response.error){
                            toastr.success(response.message);
                            $('#modal-form-services').modal('hide');
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