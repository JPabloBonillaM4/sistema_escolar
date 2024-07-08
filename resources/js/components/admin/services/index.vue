<template>
    <div class="mt-5">
        <div class="row mb-5">
            <div class="col-md-10">
                <input type="text" v-model="filters.text" class="form-control bg-transparent" placeholder="Buscar..." @input="getData">
            </div>
            <div class="col-md-2 text-center">
                <button class="btn btn-success btn-sm" @click="createModal">Nuevo <i class="bi bi-plus-lg"></i></button>
            </div>
        </div>
        <div class="row">
            <div class="table-responsive">
                <table class="table border table-striped border border-dark table-bordered table-hover">
                    <thead>
                        <tr class="fw-bold fs-6 text-gray-800 text-center">
                            <th>Nombre</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="text-center" v-if="data.length > 0">
                        <tr v-for="item in data">
                            <td>{{ item.name }}</td>
                            <td>
                                <button class="btn btn-sm btn-icon btn-info me-2" data-bs-toggle="tooltip" data-bs-placement="left" title="Ver carreras"><i class="bi bi-list-ol"></i></button>
                                <button class="btn btn-sm btn-icon btn-warning me-2" data-bs-toggle="tooltip" data-bs-placement="top" title="Editar" @click="editModal(item)"><i class="bi bi-pencil-fill"></i></button>
                                <button class="btn btn-sm btn-icon btn-danger" data-bs-toggle="tooltip" data-bs-placement="right" title="Eliminar" @click="deleteRecord(item)"><i class="bi bi-trash-fill"></i></button>
                            </td>
                        </tr>
                    </tbody>
                    <tbody v-else>
                        <tr class="text-center">
                            <td colspan="2">Sin registros</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <!-- begin:Pagination -->
            <table-pagination
                ref="table_pagination"
                :total="total_length_data"
                :page_size="page_size"
                :current_page="current_page"
                @current-page-change="setPage"
            ></table-pagination>
            <!-- end:Pagination -->
            <!-- MODALS -->
            <form-modal ref="form_modal" @refreshData="getData"></form-modal>
        </div>
    </div>
</template>
<script>
import formModal from './modals/form.vue';
export default {
    data() {
        return {
            data              : [],
            current_page      : 1,
            page_size         : 5,
            total_length_data : 0,
            filters : {
                text : null
            },
        }
    },
    components: {
        "form-modal" : formModal
    },
    mounted() {
        this.getData();
    },
    methods: {
        setPage (val) {
            this.current_page = val;
            this.getData();
        },
        getData() {
            let _this = this;
            axios.get('/get-services',{
                params : {
                    filters   : this.filters,
                    paginated : true,
                    page      : this.current_page
                }
            }).then(function(response){
                _this.data = response.data.data;
                _this.total_length_data = response.data.total;
                setTimeout(() => {
                    $('[data-bs-toggle="tooltip"]').tooltip();
                }, 250);
            });
        },
        createModal(){
            this.$refs.form_modal.openModal();
        },
        editModal(data) {
            this.$refs.form_modal.openModal(data);
        },
        deleteRecord(data) {
            let _this = this;
            Swal.fire({
                text: `¿Está seguro de eliminar el servicio ${data.name}?`,
                icon: 'question',
                showDenyButton: true,
                confirmButtonText: "Si",
                denyButtonText: `No, cancelar`
            }).then((result) => {
                if (result.isConfirmed) {
                    axios.delete(`/servicios/${data.id}`).then(function(response){
                        response = response.data;
                        if(!response.error){
                            toastr.success(response.message);
                            _this.getData();
                        } else {
                            toastr.error(response.message);
                        }
                    });
                }
            });
        }
    },
}
</script>