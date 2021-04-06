<template>
    <div>
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-light navbar-light ">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto ">
                <!-- Authentication Links -->
                <li class="nav-item dropdown user-menu">
                    <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" style="" aria-expanded="false">
                        <img  class="user-image img-circle elevation-2" :src="this.form.photo === null ? '/img/profile.png' : getProfilePhoto()" alt="User Image">
                        <span class="d-none d-md-inline">{{this.form.last_name}} {{this.form.first_name}} </span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right" style="left: inherit;right: -15px; top: 39px;">
                        <!-- User image -->
                        <li class="user-header bg-light">
                            <img :src="this.form.photo === null ? '/img/profile.png' : getProfilePhoto()" class="user-image img-circle elevation-2" alt="User Image">
                            <p>{{this.form.username}}
                                <small>{{this.form.email}}</small>
                            </p>
                        </li>
                        <!-- Menu Body -->
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <router-link class="btn btn-secondary btn-flat" :to="{ name: 'profile' }">Profile</router-link>
                            <a href="" @click.prevent="logout()" class="btn btn-danger btn-flat float-right" >Déconnecter</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->
    </div>

</template>

<script>
    export default {
        name: "Header",
        props :{
            user : {},
        },
        data (){
            return {
                form: new Form({
                    id:'',
                    username : '',
                    first_name: '',
                    last_name: '',
                    email: '',
                    role: '',
                    photo: '',
                }),
            }
        },
        methods : {
            getProfilePhoto(){
                    let photo = "/Users/"+ this.form.id +"/Profile/"+ this.form.photo ;
                    return photo;
            },
            logout() {
                this.$confirm('Are you sure you want to log out?', 'Attention !', {
                    confirmButtonText: 'Oui', cancelButtonText: 'Non', type: 'warning'
                }).then(() => {
                    axios.post('/logout').then(() => {
                        window.location.replace("/");
                    });
                })
            },
        },
        created(){
            axios.get("api/profile").then(({data}) => (this.form.fill(data)));

            this.$root.$on('ReloadInfo',() => {
                axios.get("api/profile").then(({data}) => (this.form.fill(data)));
                this.getProfilePhoto();
            });
        },
        mounted() {
        }

    }
</script>

<style scoped>

</style>
