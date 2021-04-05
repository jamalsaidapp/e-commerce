<template>
    <div >
        <div class="content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h5 class="m-0 text-dark">Users</h5>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a tag="a" href="" @click.prevent="$router.push('back_index')">E-Commerce</a></li>
                            <li class="breadcrumb-item active">Users</li>
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
                        Users Table
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

        <el-dialog :title="title" :width="WinWidth < 600 ? '95%' : '35%'" center :show-close="false" :close-on-click-modal="false" :visible.sync="dialog_User">
            <div class="modal_c_body" id="body">
                <el-row class="mb-3" :gutter="24">
                    <el-col :span="12">
                        <b-field label="Nom & Prénom" label-position="on-border" :type="{ 'is-danger': user.errors.has('name') }">
                            <b-input size="is-small" type="search" v-model="user.name" :disabled="viewmode" @input="ResetError('name')"></b-input>
                        </b-field>
                        <form-error :form="user" label="name"></form-error>
                    </el-col>
                    <el-col :span="12">
                        <b-field label-position="on-border" label="Email" :type="{ 'is-danger': user.errors.has('email') }">
                            <b-input size="is-small" type="email" v-model="user.email" :disabled="viewmode" @input="ResetError('email')"></b-input>
                        </b-field>
                        <form-error :form="user" label="email"></form-error>
                    </el-col>
                </el-row>

                <el-row class="mb-3" :gutter="24">
                    <el-col :span="12" v-if="!viewmode">
                        <b-field label="Password" label-position="on-border" :type="{ 'is-danger': user.errors.has('password') }">
                            <b-input size="is-small" v-model="user.password" type="password" password-reveal :disabled="viewmode" @input="ResetError('password')"></b-input>
                        </b-field>
                        <form-error :form="user" label="password"></form-error>
                    </el-col>
                    <el-col :span="12" style="padding-left: 0px;padding-right: 0px;">
                        <el-col :span="13">
                            <b-field label-position="on-border" label="Role" :type="{ 'is-danger': user.errors.has('role') }">
                                <b-select placeholder="Choisir..." :disabled="viewmode" size="is-small" v-model="user.role" expanded @input="ResetError('role')">
                                    <option v-for="item in Roles" :value="item.value">{{item.label}}</option>
                                </b-select>
                            </b-field>
                        </el-col>
                        <el-col :span="11">
                            <b-field label-position="on-border" label="Statut" :type="{ 'is-danger': user.errors.has('status') }">
                                <b-select placeholder="Choisir..." :disabled="viewmode" size="is-small" v-model="user.status" expanded @input="ResetError('status')">
                                    <option v-for="item in Status" :value="item.value">{{item.label}}</option>
                                </b-select>
                            </b-field>
                        </el-col>
                    </el-col>
                </el-row>
            </div>
            <div id="footer">
                <el-button size="small" type="info" @click="dialog_User = false">Fermer</el-button>
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
                {field: 'name', label: 'Utilisateur', width: '200', centered: true, sortable : true, visible: true},
                {field: 'email', label: 'Email', width: '250', sortable: true, centered: true, visible: true},
                {field: 'created_at', label: 'Date Création', width: '150', sortable: true, centered: true, visible: true},
                {field: 'role', label: 'Role',width: '80', sortable: true, centered: true, visible: true},
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
            Roles: [
                {value: 'user', label: 'User'},
                {value: 'admin', label: 'Admin',}
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
            user: new Form({
                id : '',
                name: '',
                email: '',
                password: '',
                status :undefined,
                role:undefined
            }),
            title: '',
            dialog_User:false,
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
                        item.name && item.name.toLowerCase().includes(v.toLowerCase()) ||
                        item.email && item.email.toLowerCase().includes(v.toLowerCase()) ||
                        item.id && item.id.toString().toLowerCase().includes(v.toLowerCase()) ||
                        item.created_at && item.created_at.toString().toLowerCase().includes(v.toLowerCase()) ||
                        item.role && item.role.toLowerCase().includes(v.toLowerCase())
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
                this.dialog_User = true;
                this.user.reset();
                this.user.clear()
            }
            else if(type === 'edit') {
                this.title = 'Modifier Utilisateur : ' + val.name;
                this.editmode = true;
                this.addmode = false;
                this.viewmode = false;
                this.dialog_User = true;
                this.user.fill(val);
            }
            else if (type === 'view') {
                this.title = 'Affichage Utilisateur : ' + val.name;
                this.viewmode = true;
                this.addmode = false;
                this.addmode = false;
                this.dialog_User = true;
                this.user.fill(val);
            }
        },
        //Ajax Function
        loadData(){
            this.loading = true;
            axios.get('api/user').then((response) => {
                this.tableData = response.data;
                this.loading = false;
            })
        },
        createRow(){
            this.user.post('api/user').then(()=>{
                this.loadData();
                this.dialog_User = false;
                toast.fire({icon: 'success', title: 'Utilisteur Bien Ajouter !!'});
            })
        },
        editRow(){
            this.user.put('api/user/'+this.user.id).then(()=>{
                this.loadData();
                this.dialog_User = false;
                toast.fire({icon: 'success', title: 'Utilisteur Bien Modifier !!'});
            })
        },
        deleteRow(id){
           if (id !== this.$Auth.id) {
               this.$confirm('Voulez-vous Supprimer ce Element ?', 'Suppression', {
                   confirmButtonText: 'Supprimer', cancelButtonText: 'Annulé', type: 'warning'
               }).then(() => {
                   this.user.delete('api/user/'+id).then(()=>{
                       this.loadData();
                       toast.fire({icon: 'success', title: 'Utilisteur Supprimer !!'});
                   }).catch(()=> {
                       toast.fire("Failed!", "There was something wronge.", "warning");
                   });
               })
           }else{
               toast.fire("Failed!", "Impossible Compte Connecter", "warning");
           }
        },
        MultiUserDelete(){
            let ids = this.$R.pluck('id')(this.checkedRows);
            if (!ids.includes(this.$Auth.id)) {
                this.$confirm('Voulez-vous Supprimer ces Elements ?', 'Suppression', {
                    confirmButtonText: 'Supprimer', cancelButtonText: 'Annulé', type: 'warning'
                }).then(() => {
                    let data = {ids : ids};
                    axios.post('api/MultiUserDelete',data).then(()=>{
                        this.loadData();
                        this.checkedRows =[];
                        toast.fire({icon: 'success', title: 'SIMs Supprimer !!'});
                    }).catch(()=> {
                        toast.fire("Failed!", "There was something wronge.", "warning");
                    });
                });
            }else{
                toast.fire("Failed!", "Impossible Compte Connecter", "warning");
            }
        },
        //Others
        ResetError(id){
            this.user.errors.clear(id)
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
