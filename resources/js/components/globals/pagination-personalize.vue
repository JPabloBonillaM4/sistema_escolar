<template>
    <div class="mt-2">
        <p class="m-1">Registros totales: {{ total }}</p>
        <div class="d-flex justify-content-start">
            <ul class="pagination pagination-outline">
                <!-- Go to the first page -->
                <li :class="['page-item first m-1',(actual_page == first_page) ? 'disabled' : '']" title="Primera página">
                    <button type="button" class="page-link px-0" @click="setCurrentPage(first_page);">
                        <i class="ki-duotone ki-double-left fs-2"><span class="path1"></span><span class="path2"></span></i>
                    </button>
                </li>
                <!-- Prev page -->
                <li :class="['page-item previous m-1',(actual_page == 1) ? 'disabled' : '']" title="Página anterior">
                    <button type="button" class="page-link px-0" @click="prevPage">
                        <i class="ki-duotone ki-left fs-2"></i>
                    </button>
                </li>
                <!-- All pages -->
                <li :class="['page-item m-1',(page == actual_page) ? 'active' : '']" v-for="page in pageCounter" @click="setCurrentPage(page)"><button type="button" class="page-link">{{ page }}</button></li>
                <!-- Next page -->
                <li :class="['page-item next m-1',(actual_page == last_page) ? 'disabled' : '']" title="Siguiente página">
                    <button type="button" class="page-link px-0" @click="nextPage">
                        <i class="ki-duotone ki-right fs-2"></i>
                    </button>
                </li>
                <!-- Go to the last page -->
                <li :class="['page-item last m-1',(actual_page == last_page) ? 'disabled' : '']" title="Última página">
                    <button type="button" class="page-link px-0" @click="setCurrentPage(last_page)">
                        <i class="ki-duotone ki-double-right fs-2"><span class="path1"></span><span class="path2"></span></i>
                    </button>
                </li>
            </ul>
        </div>
    </div>
</template>
<script>
export default {
    props : {
        "total" : {
            type     : Number,
            required : true,
            default  : 0
        },
        "page_size" : {
            type     : Number,
            required : true,
            default  : 10
        },
        "current_page" : {
            type     : Number,
            required : true,
            default  : 1
        },
        "pages_to_show" : {
            type     : Number,
            default  : 3
        }
    },
    data(){
        return {
            actual_page           : this.current_page,
            page_counter          : this.pages_to_show,
            is_last_pages_section : null,
            total_pages           : 1,
            last_page             : 0,
            first_page            : 1,
        }
    },
    computed : {
        pageCounter(){
            this.total_pages  = (this.total > 0) ? Math.ceil(this.total / this.page_size) : 1;
            this.last_page    = this.total_pages;
            let firstBlock    = Math.floor((this.actual_page / this.page_counter) - 0.1);
            let totalPages    = [];
            let pages_to_show = [];
            for (let index = 1; index <= this.total_pages; index++) {
                totalPages.push(index);
            }
            if((firstBlock > 0) && (this.actual_page > this.page_counter)){
                let secondBlock = this.page_counter * (firstBlock + 1);
                pages_to_show = totalPages.slice(this.page_counter * firstBlock,secondBlock);
            } else {
                pages_to_show = totalPages.slice(firstBlock,this.page_counter);
            }
            if(pages_to_show.includes(this.last_page) && this.total_pages > this.page_counter){
                this.is_last_pages_section = true;
            } else if(!pages_to_show.includes(this.last_page) && this.total_pages > this.page_counter) {
                this.is_last_pages_section = false;
            }
            return pages_to_show;
        }
    },
    methods: {
        setCurrentPage(page){
            this.actual_page = page;
            this.$emit("current-page-change",this.actual_page);
        },
        updateCurrentPage(page){
            this.actual_page = page;
        },
        nextPage(){
            this.setCurrentPage(this.actual_page + 1)
        },
        prevPage(){
            this.setCurrentPage(this.actual_page - 1)
        }
    },
}
</script>