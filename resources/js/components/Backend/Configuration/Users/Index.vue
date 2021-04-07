<template>
    <div>
        <div class="content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h5 class="m-0 text-dark">Users</h5>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="" tag="a" @click.prevent="$router.push('back_index')">E-Commerce</a>
                            </li>
                            <li class="breadcrumb-item active">Users</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12 mt-2">

            <div class="card card-secondary">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fa fa-table  mt-1  mr-2"></i>
                        Users Table
                    </h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <j-data-table :TotalItems="TotalItems"
                                  :columns="columns"
                                  :loading="loading"
                                  :perPage="perPage"
                                  :search="search"
                                  :tableData="SearchQuery(search)"
                                  @checkedRows-updated="OnCheckedRows"
                                  @enable-reset-filter="enableResFilter">
                        <template #table_tools>
                            <b-field group-multiline>
                                <div>
                                    <div class="float-left mb-3 d-flex">
                                        <div width="60%">
                                            <b-field label="Recherche" label-position="on-border">
                                                <b-input v-model="search" icon="magnify" size="is-small"
                                                         type="search"></b-input>
                                            </b-field>
                                        </div>
                                        <div style=" margin-left: 5px">
                                            <b-field>
                                                <b-select v-model="perPage" expanded placeholder="Small"
                                                          size="is-small">
                                                    <option v-for="item in perPages" :key="item.value"
                                                            :value="item.value">{{ item.label }}
                                                    </option>
                                                </b-select>
                                            </b-field>
                                        </div>

                                    </div>
                                    <div class="tools-buttons float-right mb-3">
                                        <b-button v-if="enableClearFilter" icon-right="filter-remove" rounded
                                                  size="is-small" type="is-dark" @click="resetFiltter"/>
                                        <el-dropdown style="font-size: 16px;" trigger="click">
                                            <b-button icon-pack="fas" icon-right="columns" rounded
                                                      size="is-small"
                                                      type="is-warning"
                                                      @click="showhideCols ?  showhideCols = false : showhideCols = true "/>
                                            <el-dropdown-menu slot="dropdown">
                                                <b-checkbox v-for="col in columns" :key="col.id"
                                                            v-model="col.visible" class="ml-2 mr-1 d-flex">
                                                    {{ col.label }}
                                                </b-checkbox>
                                            </el-dropdown-menu>
                                        </el-dropdown>
                                        <b-button v-if="checkedRows.length > 0 && tableData.length > 0" icon-right="delete" rounded
                                                  size="is-small" type="is-danger"
                                                  @click="MultiUserDelete"/>
                                        <b-button icon-right="refresh" rounded size="is-small"
                                                  type="is-secondary" @click="loadData"/>
                                        <b-button icon-right="plus" rounded size="is-small"
                                                  type="is-primary" @click="openmodel('add',null)"/>
                                    </div>
                                </div>
                            </b-field>
                        </template>

                        <template #table_buttons_tools>
                            <b-table-column v-slot="props" centered class="is-actions-cell" custom-key="actions"
                                            label="Actions" width="12%">
                                <div :style="WinWidth < 600 ? 'padding-bottom: 10px !important;' : ''"
                                     class="buttons buttonsFix">
                                    <el-button circle icon="el-icon-edit" size="mini"
                                               type="primary" @click.native="openmodel('edit',props.row)"></el-button>
                                    <el-button circle icon="el-icon-view" size="mini"
                                               type="info" @click.native="openmodel('view',props.row)"></el-button>
                                    <el-button circle icon="el-icon-delete" size="mini"
                                               type="danger" @click="deleteRow(props.row.id)"></el-button>
                                </div>
                            </b-table-column>
                        </template>

                    </j-data-table>
                </div>
            </div>
        </div>

        <el-dialog :close-on-click-modal="false" :show-close="false" :title="title" :visible.sync="dialog_User"
                   :width="WinWidth < 600 ? '95%' : '35%'" center>
            <div id="body" class="modal_c_body">
                <el-row :gutter="24" class="mb-3">
                    <el-col :span="12">
                        <b-field :type="{ 'is-danger': user.errors.has('first_name') }" label="First Name"
                                 label-position="on-border">
                            <b-input v-model="user.first_name" :disabled="viewmode" size="is-small" type="search"
                                     @input="ResetError('first_name')"></b-input>
                        </b-field>
                        <form-error :form="user" label="first_name"></form-error>
                    </el-col>
                    <el-col :span="12">
                        <b-field :type="{ 'is-danger': user.errors.has('last_name') }" label="Last Name"
                                 label-position="on-border">
                            <b-input v-model="user.last_name" :disabled="viewmode" size="is-small" type="text"
                                     @input="ResetError('last_name')"></b-input>
                        </b-field>
                        <form-error :form="user" label="last_name"></form-error>
                    </el-col>
                </el-row>
                <el-row :gutter="24" class="mb-3">
                    <el-col :span="12">
                        <b-field :type="{ 'is-danger': user.errors.has('username') }" label="Nom & Prénom"
                                 label-position="on-border">
                            <b-input v-model="user.username" :disabled="viewmode" size="is-small" type="search"
                                     @input="ResetError('username')"></b-input>
                        </b-field>
                        <form-error :form="user" label="username"></form-error>
                    </el-col>
                    <el-col :span="12">
                        <b-field :type="{ 'is-danger': user.errors.has('email') }" label="Email"
                                 label-position="on-border">
                            <b-input v-model="user.email" :disabled="viewmode" size="is-small" type="email"
                                     @input="ResetError('email')"></b-input>
                        </b-field>
                        <form-error :form="user" label="email"></form-error>
                    </el-col>
                </el-row>

                <el-row :gutter="24" class="mb-3">
                    <el-col v-if="!viewmode" :span="12">
                        <b-field :type="{ 'is-danger': user.errors.has('password') }" label="Password"
                                 label-position="on-border">
                            <b-input v-model="user.password" :disabled="viewmode" password-reveal size="is-small"
                                     type="password" @input="ResetError('password')"></b-input>
                        </b-field>
                        <form-error :form="user" label="password"></form-error>
                    </el-col>
                    <el-col :span="12" style="padding-left: 0px;padding-right: 0px;">
                        <el-col :span="13">
                            <b-field :type="{ 'is-danger': user.errors.has('role') }" label="Role"
                                     label-position="on-border">
                                <b-select v-model="user.role" :disabled="viewmode" expanded
                                          placeholder="Choisir..." size="is-small" @input="ResetError('role')">
                                    <option v-for="item in Roles" :value="item.value">{{ item.label }}</option>
                                </b-select>
                            </b-field>
                        </el-col>
                        <el-col :span="11">
                            <b-field :type="{ 'is-danger': user.errors.has('status') }" label="Statut"
                                     label-position="on-border">
                                <b-select v-model="user.status" :disabled="viewmode" expanded
                                          placeholder="Choisir..." size="is-small" @input="ResetError('status')">
                                    <option v-for="item in Status" :value="item.value">{{ item.label }}</option>
                                </b-select>
                            </b-field>
                        </el-col>
                    </el-col>
                </el-row>
            </div>
            <div id="footer">
                <el-button size="small" type="info" @click="dialog_User = false">Fermer</el-button>
                <el-button v-if="editmode" class="float-right" size="small" type="success" @click="editRow">Modifier
                </el-button>
                <el-button v-if="addmode" class="float-right" size="small" type="success" @click="createRow">Ajouter
                </el-button>
            </div>
        </el-dialog>
    </div>
</template>

<script>
export default {

    data() {
        return {
            tableData: [],
            columns: [
                {field: 'id', label: '#', width: '50', sortable: true, numeric: true, centered: true, visible: true},
                {field: 'username', label: 'Username', width: '150', centered: true, sortable: true, visible: true},
                {field: 'first_name', label: 'First Name', width: '100', centered: true, sortable: true, visible: true},
                {field: 'last_name', label: 'Last Name', width: '100', centered: true, sortable: true, visible: true},
                {field: 'email', label: 'Email', width: '200', sortable: true, centered: true, visible: true},
                {field: 'created_at', label: 'Date Création', width: '120', sortable: true, centered: true, visible: true},
                {field: 'role', label: 'Role', width: '80', sortable: true, centered: true, visible: true},
                {field: 'status', label: 'Status', width: '80', sortable: true, centered: true, visible: true},
            ],
            showhideCols: false,
            loading: false,
            enableClearFilter: false,
            checkable: true,
            search: '',
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
            TotalItems: 0,
            user: new Form({
                id: '',
                username: '',
                first_name :'',
                last_name :'',
                email: '',
                password: '',
                status: undefined,
                role: undefined
            }),
            title: '',
            dialog_User: false,
            addmode: false,
            editmode: false,
            viewmode: false,
            WinWidth: ''
        }
    },
    methods: {
        //Table Functions
        resetFiltter() {
            this.$root.$emit("reset-filters");
            this.enableClearFilter = false;
        },
        SearchQuery(val) {
            if (val) {
                let dataSear = this.tableData.filter(item => {
                    return val.toLowerCase().split(' ').every(v =>
                        item.username && item.username.toLowerCase().includes(v.toLowerCase()) ||
                        item.first_name && item.first_name.toLowerCase().includes(v.toLowerCase()) ||
                        item.last_name && item.last_name.toLowerCase().includes(v.toLowerCase()) ||
                        item.email && item.email.toLowerCase().includes(v.toLowerCase()) ||
                        item.id && item.id.toString().toLowerCase().includes(v.toLowerCase()) ||
                        item.created_at && item.created_at.toString().toLowerCase().includes(v.toLowerCase()) ||
                        item.role && item.role.toLowerCase().includes(v.toLowerCase())
                    )
                });
                this.TotalItems = dataSear.length;
                return dataSear;
            } else {
                this.TotalItems = this.tableData.length;
                return this.tableData;
            }
        },
        OnCheckedRows(val) {
            this.checkedRows = val
        },
        enableResFilter(val) {
            this.enableClearFilter = val.length > 0;
        },
        //Modal Function
        openmodel(type, val) {
            if (type === 'add') {
                this.title = 'Ajouter Un Utilisateur';
                this.addmode = true;
                this.viewmode = false;
                this.editmode = false;
                this.dialog_User = true;
                this.user.reset();
                this.user.clear()
            } else if (type === 'edit') {
                this.title = 'Modifier Utilisateur : ' + val.username;
                this.editmode = true;
                this.addmode = false;
                this.viewmode = false;
                this.dialog_User = true;
                this.user.fill(val);
            } else if (type === 'view') {
                this.title = 'Affichage Utilisateur : ' + val.username;
                this.viewmode = true;
                this.addmode = false;
                this.addmode = false;
                this.dialog_User = true;
                this.user.fill(val);
            }
        },
        //Ajax Function
        loadData() {
            this.loading = true;
            axios.get('api/user').then((response) => {
                this.tableData = response.data;
                this.loading = false;
            })
        },
        createRow() {
            this.user.post('api/user').then(() => {
                this.loadData();
                this.dialog_User = false;
                toast.fire({icon: 'success', title: 'Utilisteur Bien Ajouter !!'});
            })
        },
        editRow() {
            this.user.put('api/user/' + this.user.id).then(() => {
                this.loadData();
                this.dialog_User = false;
                toast.fire({icon: 'success', title: 'Utilisteur Bien Modifier !!'});
            })
        },
        deleteRow(id) {
            if (id !== this.$Auth.id) {
                this.$confirm('Voulez-vous Supprimer ce Element ?', 'Suppression', {
                    confirmButtonText: 'Supprimer', cancelButtonText: 'Annulé', type: 'warning'
                }).then(() => {
                    this.user.delete('api/user/' + id).then(() => {
                        this.loadData();
                        toast.fire({icon: 'success', title: 'Utilisteur Supprimer !!'});
                    }).catch(() => {
                        toast.fire("Failed!", "There was something wronge.", "warning");
                    });
                })
            } else {
                toast.fire("Failed!", "Impossible Compte Connecter", "warning");
            }
        },
        MultiUserDelete() {
            let ids = this.$R.pluck('id')(this.checkedRows);
            if (!ids.includes(this.$Auth.id)) {
                this.$confirm('Voulez-vous Supprimer ces Elements ?', 'Suppression', {
                    confirmButtonText: 'Supprimer', cancelButtonText: 'Annulé', type: 'warning'
                }).then(() => {
                    let data = {ids: ids};
                    axios.post('api/MultiUserDelete', data).then(() => {
                        this.loadData();
                        this.checkedRows = [];
                        toast.fire({icon: 'success', title: 'SIMs Supprimer !!'});
                    }).catch(() => {
                        toast.fire("Failed!", "There was something wronge.", "warning");
                    });
                });
            } else {
                toast.fire("Failed!", "Impossible Compte Connecter", "warning");
            }
        },
        //Others
        ResetError(id) {
            this.user.errors.clear(id)
        },
        handleResize() {
            this.WinWidth = window.innerWidth;
        },
    },
    created() {
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
