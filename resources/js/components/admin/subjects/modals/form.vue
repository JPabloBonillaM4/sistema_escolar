<template>
    <div class="modal fade" tabindex="-1" id="modal-form-subjects">
        <div class="modal-dialog modal-lg">
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
                        <div class="row">
                            <div class="col-md-12 mb-10">
                                <label>Nombre</label>
                                <input type="text" v-model="form.name" class="form-control bg-transparent" placeholder="Ingresar el nombre de la materia">
                            </div>
                            <div class="col-md-12 mb-10">
                                <label>Descripción</label>
                                <textarea v-model="form.description" class="form-control bg-transparent" placeholder="Ingresar la descripción de la materia" rows="2"></textarea>
                            </div>
                            <div class="col-md-6 mb-10 text-center">
                                <label for="">Tipo de materia</label>
                                <div class="form-check form-check-custom form-check-solid justify-content-center">
                                    <input class="form-check-input me-1" type="radio" v-model="form.type" :value="1" id="type_career_obligatoria" />
                                    <label class="form-check-label me-10" for="type_career_obligatoria">
                                        Obligatoria
                                    </label>
                                    <input class="form-check-input me-1" type="radio" v-model="form.type" :value="2" id="type_career_no_obligatoria" />
                                    <label class="form-check-label" for="type_career_no_obligatoria">
                                        No obligatoria
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-6 mb-10">
                                <label for="">Carrera</label>
                                <select id="select-input-career" class="form-select form-select-solid" data-control="select2" data-dropdown-parent="#modal-form-subjects" data-placeholder="Seleccione una opción" style="width: 100%;">
                                    <option></option>
                                    <option v-for="career in careers_options" :value="career.id">{{ career.name }}</option>
                                </select>
                            </div>
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
            title  : 'Agregar materia',
            mode   : 'create',
            saving : false,
            careers_options : [],
            form : {
                id : 0,
                name : null,
                description : null,
                type : null,
                career_id : 0
            }
        }
    },
    mounted() {
        this.select2Activate();
    },
    methods: {
        select2Activate() {
            let _this = this;
            $('#select-input-career').on('change', function() {
                _this.form.career_id = $(this).val();
            });
        },
        getCareers() {
            let _this = this;
            axios.get('/get-careers').then(function(response){
                _this.careers_options = response.data;
            });
        },
        openModal(data = null) {
            this.resetData();
            this.getCareers();
            if(data){
                this.title = 'Editar materia';
                this.mode  = 'edit';
                this.setFormData(data);
            } else {
                this.mode = 'create';
                this.data = null;
            }
            $('#modal-form-subjects').modal('show');
        },
        setFormData(data) {
            this.form.id   = data.id;
            this.form.name = data.name;
            this.form.description = data.description;
            this.form.type = data.type;
            setTimeout(() => {
                $('#select-input-career').val(data.career_id);
                $('#select-input-career').trigger('change');
            }, 250);
        },
        validateData() {
            if(!this.form.name){
                toastr.warning('Ingrese un nombre');
                return false;
            }

            if(!this.form.description){
                toastr.warning('Ingrese una descripción');
                return false;
            }

            if(!this.form.type){
                toastr.warning('Seleccione el tipo de materia');
                return false;
            }

            if(!this.form.career_id){
                toastr.warning('Seleccione la carrera relacionada');
                return false;
            }

            return true;
        },
        resetData(){
            this.saving    = false;
            this.form.id   = 0;
            this.form.name = null;
            this.form.description = null;
            this.form.type = null;
            setTimeout(() => {
                $('#select-input-career').val(null);
                $('#select-input-career').trigger('change');
            }, 250);
        },
        saveData() {
            if(this.validateData()){
                let response_request = null;
                this.saving          = true;
                let _this            = this;
                if(this.mode == 'edit'){
                    response_request = axios.put(`/materias/${this.form.id}`,this.form);
                } else {
                    response_request = axios.post('/materias',this.form);
                }
                if(response_request) {
                    response_request.then(function(response){
                        response = response.data;
                        if(!response.error){
                            toastr.success(response.message);
                            $('#modal-form-subjects').modal('hide');
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