<template>
    <div >
        <div class="content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h5 class="m-0 text-dark">Categories</h5>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a tag="a" href="" @click.prevent="$router.push('back_index')">E-Commerce</a></li>
                            <li class="breadcrumb-item active">Categories</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12 mt-2" >

            <div class="card card-secondary">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fa fa-table  mt-1  mr-2"></i>
                        Categories Table
                    </h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <j-data-table :tableData="SearchQuery(search)"
                                  :loading="loading"
                                  :columns="columns"
                                  :search="search"
                                  :perPage="perPage"
                                  :TotalItems="TotalItems"
                                  @checkedRows-updated="OnCheckedRows"
                                  @enable-reset-filter="enableResFilter">
                        <template #table_tools>
                            <b-field  group-multiline>
                                <div>
                                    <div class="float-left mb-3 d-flex">
                                        <div width="60%">
                                            <b-field label="Recherche" label-position="on-border">
                                                <b-input v-model="search" icon="magnify" size="is-small" type="search"></b-input>
                                            </b-field>
                                        </div>
                                        <div style=" margin-left: 5px">
                                            <b-field >
                                                <b-select v-model="perPage" placeholder="Small" size="is-small" expanded>
                                                    <option v-for="item in perPages" :key="item.value" :value="item.value">{{item.label}}</option>
                                                </b-select>
                                            </b-field>
                                        </div>

                                    </div>
                                    <div class= "tools-buttons float-right mb-3">
                                        <b-button v-if="enableClearFilter" type="is-dark" size="is-small" icon-right="filter-remove" @click="resetFiltter" rounded />
                                        <el-dropdown trigger="click" style="font-size: 16px;">
                                            <b-button type="is-warning" size="is-small" icon-pack="fas" icon-right="columns" @click="showhideCols ?  showhideCols = false : showhideCols = true " rounded />
                                            <el-dropdown-menu slot="dropdown">
                                                <b-checkbox class="ml-2 mr-1 d-flex" v-for="col in columns" :key="col.id" v-model="col.visible" >
                                                    {{ col.label }}
                                                </b-checkbox>
                                            </el-dropdown-menu>
                                        </el-dropdown>
                                        <b-button type="is-danger" size="is-small" icon-right="delete" @click="MultiUserDelete" rounded
                                                  v-if="checkedRows.length > 0 && tableData.length > 0" />
                                        <b-button type="is-secondary" size="is-small" icon-right="refresh" @click="loadData" rounded />
                                        <b-button type="is-primary" size="is-small" icon-right="plus" @click="openmodel('add',null)" rounded />
                                    </div>
                                </div>
                            </b-field>
                        </template>

                        <template #table_buttons_tools>
                            <b-table-column custom-key="actions" label="Actions" centered width="12%" class="is-actions-cell" v-slot="props">
                                <div class="buttons buttonsFix" :style="WinWidth < 600 ? 'padding-bottom: 10px !important;' : ''">
                                    <el-button type="primary" @click.native="openmodel('edit',props.row)" size="mini" icon="el-icon-edit" circle></el-button>
                                    <el-button type="info" @click.native="openmodel('view',props.row)" size="mini" icon="el-icon-view" circle></el-button>
                                    <el-button type="danger" @click="deleteRow(props.row.id)" size="mini" icon="el-icon-delete" circle></el-button>
                                </div>
                            </b-table-column>
                        </template>

                    </j-data-table>
                </div>
            </div>
        </div>
        <el-dialog :title="title" :width="WinWidth < 600 ? '95%' : '35%'" center :show-close="false" :close-on-click-modal="false" :visible.sync="dialog_Categorie">
            <div class="modal_c_body" id="body">
                <el-row class="mb-3" :gutter="24">
                    <el-col :span="12">
                        <b-field label="Title" label-position="on-border" :type="{ 'is-danger': form.errors.has('title') }">
                            <b-input size="is-small" type="search" v-model="form.title" :disabled="viewmode" @input="ResetError('title')"></b-input>
                        </b-field>
                        <form-error :form="form" label="title"></form-error>
                    </el-col>
                    <el-col :span="12">
                        <b-field label-position="on-border" label="Slug" :type="{ 'is-danger': form.errors.has('slug') }">
                            <b-input size="is-small" type="search" v-model="form.slug" :disabled="viewmode" @input="ResetError('slug')"></b-input>
                        </b-field>
                        <form-error :form="form" label="slug"></form-error>
                    </el-col>
                </el-row>

                <el-row class="mb-3" :gutter="24">
                    <el-col :span="12" >
                        <b-field label-position="on-border" label="Statut" :type="{ 'is-danger': form.errors.has('status') }">
                            <b-select placeholder="Choisir..." :disabled="viewmode" size="is-small" v-model="form.status" expanded @input="ResetError('status')">
                                <option v-for="item in Status" :value="item.value">{{item.label}}</option>
                            </b-select>
                        </b-field>
                        <form-error :form="form" label="status"></form-error>
                    </el-col>
                </el-row>
            </div>
            <div id="footer">
                <el-button size="small" type="info" @click="dialog_Categorie = false">Fermer</el-button>
                <el-button v-if="editmode" class="float-right" size="small" type="success" @click="editRow">Modifier</el-button>
                <el-button v-if="addmode" class="float-right" size="small" type="success" @click="createRow">Ajouter</el-button>
            </div>
        </el-dialog>

    </div>
</template>

<script>
    export default {

    data() {
        return {
            tableData:[],
            columns: [
                {field: 'id', label: '#', width: '50',sortable: true, numeric: true, centered: true, visible: true },
                {field: 'title', label: 'Title', width: '100', centered: true, sortable : true, visible: true},
                {field: 'slug', label: 'Slug', width: '100', sortable: true, centered: true, visible: true},
                {field: 'summary', label: 'Summary', width: '100', sortable: true, centered: true, visible: false},
                {field: 'photo', label: 'Image',width: '80', sortable: true, centered: true, visible: true},
                {field: 'is_parent', label: 'Is_parent',width: '80', sortable: true, centered: true, visible: true},
                {field: 'added_by', label: 'Added_by',width: '100', sortable: true, centered: true, visible: true},
                {field: 'status', label: 'Status',width: '100', sortable: true, centered: true, visible: true},
            ],
            showhideCols : false,
            loading: false,
            enableClearFilter : false,
            checkable : true,
            search : '',
            checkedRows: [],
            Status: [
                {value: 'active', label: 'Active'},
                {value: 'inactive', label: 'Inactive',}
            ],
            perPages: [
                {value: 7, label: '7'},
                {value: 15, label: '15',},
                {value: 25, label: '25'},
                {value: 50, label: '50'},
                {value: 10000, label: 'Tous'},
            ],
            perPage: 7,
            TotalItems : 0,
            form: new Form({
                id : '',
                title: '',
                slug: '',
                summary: '',
                photo :'',
                status:''
            }),
            title: '',
            dialog_Categorie:false,
            addmode : false,
            editmode : false,
            viewmode: false,
            WinWidth : ''
        }
    },
    methods:{
        //Table Functions
        resetFiltter(){
            this.$root.$emit("reset-filters");
            this.enableClearFilter = false;
        },
        SearchQuery(val){
            if(val){
                let dataSear =  this.tableData.filter(item => {
                    return val.toLowerCase().split(' ').every(v =>
                        item.title && item.title.toLowerCase().includes(v.toLowerCase()) ||
                        item.slug && item.slug.toLowerCase().includes(v.toLowerCase()) ||
                        item.id && item.id.toString().toLowerCase().includes(v.toLowerCase()) ||
                        item.summary && item.summary.toString().toLowerCase().includes(v.toLowerCase()) ||
                        item.added_by && item.added_by.toLowerCase().includes(v.toLowerCase())
                    )
                });
                this.TotalItems = dataSear.length;
                return dataSear ;
            }
            else{
                this.TotalItems = this.tableData.length;
                return this.tableData;
            }
        },
        OnCheckedRows(val){
            this.checkedRows = val
        },
        enableResFilter(val){
            this.enableClearFilter = val.length > 0;
        },
        //Modal Function
        openmodel(type,val){
            if (type === 'add') {
                this.title = 'Ajouter Un Utilisateur';
                this.addmode = true;
                this.viewmode = false;
                this.editmode = false;
                this.dialog_Categorie = true;
                this.form.reset();
                this.form.clear()
            }
            else if(type === 'edit') {
                this.title = 'Modifier Utilisateur : ' + val.name;
                this.editmode = true;
                this.addmode = false;
                this.viewmode = false;
                this.dialog_Categorie = true;
                this.form.fill(val);
            }
            else if (type === 'view') {
                this.title = 'Affichage Utilisateur : ' + val.name;
                this.viewmode = true;
                this.addmode = false;
                this.addmode = false;
                this.dialog_Categorie = true;
                this.form.fill(val);
            }
        },
        //Ajax Function
        loadData(){
            this.loading = true;
            axios.get('api/categorie').then((response) => {
                this.tableData = response.data;
                this.loading = false;
            })
        },
        createRow(){
            this.form.post('api/categorie').then(()=>{
                this.loadData();
                this.dialog_Categorie = false;
                toast.fire({icon: 'success', title: 'Element Bien Ajouter !!'});
            })
        },
        editRow(){
            this.form.put('api/categorie/'+this.form.id).then(()=>{
                this.loadData();
                this.dialog_Categorie = false;
                toast.fire({icon: 'success', title: 'Element Bien Modifier !!'});
            })
        },
        deleteRow(id){
                this.$confirm('Voulez-vous Supprimer ce Element ?', 'Suppression', {
                    confirmButtonText: 'Supprimer', cancelButtonText: 'Annulé', type: 'warning'
                }).then(() => {
                    this.form.delete('api/categorie/'+id).then(()=>{
                        this.loadData();
                        toast.fire({icon: 'success', title: 'Element Supprimer !!'});
                    }).catch(()=> {
                        toast.fire("Failed!", "There was something wronge.", "warning");
                    });
                })
        },
        MultiUserDelete(){
            let ids = this.$R.pluck('id')(this.checkedRows);

                this.$confirm('Voulez-vous Supprimer ces Elements ?', 'Suppression', {
                    confirmButtonText: 'Supprimer', cancelButtonText: 'Annulé', type: 'warning'
                }).then(() => {
                    let data = {ids : ids};
                    axios.post('api/',data).then(()=>{
                        this.loadData();
                        this.checkedRows =[];
                        toast.fire({icon: 'success', title: 'SIMs Supprimer !!'});
                    }).catch(()=> {
                        toast.fire("Failed!", "There was something wronge.", "warning");
                    });
                });
        },
        //Others
        ResetError(id){
            this.form.errors.clear(id)
        },
        handleResize() {
            this.WinWidth = window.innerWidth;
        },
    },
    created(){
        window.addEventListener('resize', this.handleResize);
        this.handleResize();
    },
    destroyed() {
        window.removeEventListener('resize', this.handleResize);
    },
    beforeMount() {
        this.loadData();
    }
}
</script>

<style scoped>

</style>
