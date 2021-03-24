<template>
    <section>
        <slot name="table_tools"/>

        <b-table
            :ref="tableref"
            :data="tableData"
            narrowed bordered hoverable pagination-rounded paginated
            :mobile-cards="hasMobileCards"
            :per-page="perPage"
            :loading="loading"
            :checkable="checkable"
            :detailed="hasDetails"
            :v-model:checked-rows="checkedRows"
            :checked-rows.sync="checkedRows"
            :sort-icon="sortIcon"
            :sort-icon-size="sortIconSize"
            @update:checkedRows="fillArray"
            @sort="enableResFilter"
            :opened-detailed="defaultOpenedDetails"
            detail-key="id"
            @details-open="(row, index) => closeAllOtherDetails(row, index)"
        >

            <b-table-column  v-for="col in columns" :key="col.id" v-bind="col" v-slot="props" >
                <p class="truncate">{{ props.row[col.field]}}</p>
            </b-table-column>

            <template #detail="props">
                <slot name="details"></slot>
            </template>

            <slot name="table_columns"></slot>

            <slot name="table_buttons_tools"></slot>

            <div slot="empty" colspan="2">
                    <div class="content has-text-grey has-text-centered">
                        <p class="mb-0">
                            <b-icon icon="emoticon-sad" size="is-large"></b-icon>
                        </p>
                        <span>Aucun Données a Afficher !!</span>
                    </div>
            </div>

            <template #bottom-left>
               <div class="bg-gradient-grayf p-1 border-gray-dark text-center">
                   <span class="text-bold text-capitalize" >Total : {{TotalItems}}</span>
               </div>
            </template>
        </b-table>
    </section>
</template>

<script>
    export default {

        data() {
            return {
                checkedRows : [],
                defaultOpenedDetails: [],
            }
        },
        props:{
            tableData :{
                type : Array,
                default : []
            },
            columns :{
                type : Array,
                default : function () {
                    return [];
                },
            },
            showhideCols : {
                type: Boolean,
                default : false
            },
            loading: {
                type : Boolean,
                default : false
            },
            hasMobileCards: {
                type : Boolean,
                default : true
            },
            hasDetails: {
                type : Boolean,
                default : false
            },
            checkable: {
                type : Boolean,
                default : true
            },
            search: {
                type : String,
                default : ''
            },
            tableref: {
                type : String,
                default : 'montable'
            },
            paginationPosition: {
                type : String,
                default : 'bottom'
            },
            defaultSortDirection: {
                type : String,
                default : 'asc'
            },
            sortIcon: {
                type : String,
                default : 'arrow-up'
            },
            sortIconSize: {
                type : String,
                default : 'is-small'
            },
            currentPage: {
                type : Number,
                default : 1
            },

            perPage: {
                type : Number,
                default : 7
            },
            TotalItems: {
                type : Number,
                default : 0
            },

        },
        methods:{
            fillArray() {
                let FilledArray = this.checkedRows;
                this.$emit("checkedRows-updated", FilledArray);
            },
            detailOpened(row) {
                this.$emit("Opened_detail", row);
            },
            closeAllOtherDetails(row, index) {
                this.detailOpened(row);
                this.defaultOpenedDetails = [row.id]
            },
            enableResFilter(val){
                this.$emit("enable-reset-filter", val);
            },
            resetFillters(){
                    if (this.$refs[this.tableref])
                 this.$refs[this.tableref].resetMultiSorting();
            },
        },
        created() {
            this.$root.$on('reset-filters',()=>{
                this.resetFillters();
            })
        }
    }
</script>

