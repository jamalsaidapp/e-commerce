<template>
 <div class="col-md-12 mt-4">
        <div class="row">
        <div class="col-md-12  mt-4">
         <div class="card card-widget widget-user">
              <!-- Add the bg color to the header using any of the bg-* classes -->
              <div class="widget-user-header text-white bg-gradient-dark" >
                <!--<h3 class="widget-user-username text-right" >{{this.form.name}}</h3>-->
              </div>
              <div class="widget-user-image">
                  <img :src="this.form.photo" class="ht-100 img-circle elevation-2 wd-100" alt="User Avatar" v-if="imagechanged">
                  <img v-else class="ht-100 img-circle elevation-2 wd-100" :src="getProfilePhoto()" alt="User Avatar">
              </div>
              <div class="card-footer">
                 <div class="row col-md-12">
                  <div class="col-sm-4 border-right">
                    <div class="description-block">
                      <h5 class="description-header">Email</h5>
                      <span class="description-text">{{this.form.email}}</span>
                    </div>
                    <!-- /.description-block -->
                  </div>
                  <!-- /.col -->
                  <div class="col-sm-4 border-right">
                    <div class="description-block">
                      <h5 class="description-header">Utilisateur</h5>
                      <span class="description-text">{{this.form.name}}</span>
                    </div>
                    <!-- /.description-block -->
                  </div>
                  <!-- /.col -->
                  <div class="col-sm-4">
                    <div class="description-block">
                      <h5 class="description-header">Creation du Compte</h5>
                      <span class="description-text">{{this.form.created_at}}</span>
                    </div>
                    <!-- /.description-block -->
                  </div>
                  <!-- /.col -->
                </div>
                <!-- /.row -->
              </div>
            </div>
          </div>
          <!-- ./col -->
          </div>
          <!-- /.row -->
              <div class="row">

                    <div class="col-md-6">
                    <div class="card card-secondary">
                        <div class="card-header">
                            <h3 class="card-title mx-auto">
                                <i class="fas fa-id-card mr-2"></i>
                                Mon Profile
                            </h3>
                        </div>
                    <!-- /.card-header -->
                        <div class="card-body">
                            <form action="">
                                <section class="form-profile">
                                    <b-field label="Nom & Prénom" horizontal :type="{'is-danger':form.errors.get('name')}">
                                        <b-input v-model="form.name" type="search" placeholder="Nom & Prénom" size="is-small" icon-pack="fas" icon="user" @input="ResetError('name')" style="width:240px" required />
                                    </b-field>
                                    <b-field label="Email" horizontal :type="{'is-danger':form.errors.get('email')}" >
                                        <b-input v-model="form.email" type="email" placeholder="Votre email" size="is-small" icon="email" @input="ResetError('email')" style="width:240px" required/>
                                    </b-field>
                                    <b-field label="Password" horizontal :type="{'is-danger':form.errors.get('password')}" >
                                        <b-input v-model="form.password" type="password" placeholder="Votre password" size="is-small" icon="key" @input="ResetError('password')" style="width:240px"/>
                                    </b-field>
                                    <b-field label="Role" horizontal>
                                        <b-input v-model="form.role"  size="is-small" icon-pack="fas" icon="tag" style="text-align: center;" disabled/>
                                    </b-field>
                                </section>
                                <footer class="mt-3 mx-auto">
                                        <span class="btn btn-outline-secondary btn-file btn-sm ">
                                                <i class="fas fa-image"> </i> Charger Une image
                                                <input type="file" @change="checkimageSize" name="photo">
                                         </span>
                                    <b-button class="float-right" @click.prevent="updateInfo()" label="Enregistrer" type="is-success" size="is-small"/>
                                </footer>
                            </form>
                        </div>
                    <!-- /.card-body -->
                    </div>
                </div>

              </div>
</div>
</template>

<script>
    export default {
         data(){
            return {
                imagechanged: false,
                 form: new Form({
                    id:'',
                    name : '',
                    email: '',
                    password: '',
                    role:'',
                    photo: '',
                    created_at: ''
                }),
            }
        },
        methods: {

            getProfilePhoto(){
                if (this.form.photo !== '') {
                    let photo = "/Users/"+ this.form.id +"/Profile/"+ this.form.photo ;
                    return photo;
                }
                else {
                    let photo = "/img/profile.png" ;
                    return photo;
                }
            },
            updateInfo(){
                    if(this.form.password === ''){
                        this.form.password = undefined;
                    }
                    this.form.put('api/profile')
                        .then(()=>{
                            toast.fire({icon: 'success', title: 'Profile Bien Modifier !',});
                            this.$root.$emit('ReloadInfo');
                            this.form.password = '';
                        })
                        .catch(() => {
                            toast.fire("Failed!", "There was something wronge.", "warning");
                        });
            },
            checkimageSize(e){
                let file = e.target.files[0];
                let reader = new FileReader();
                let limit = 1024 * 1024 * 2;
                let accept = ['png', 'jpeg', 'jpg'];
                let filename = file.name;

                let ext = filename.split('.').pop();
                if (accept.indexOf(ext) === -1) {
                    toast.fire({icon: 'error', title: 'Type De Fichier Non Supporter',});
                    return false;
                }
                if(file['size'] > limit){
                    toast.fire({icon: 'error', title: 'Fichier Dépasse 2Mo',});
                    return false;
                }

                reader.onloadend = (file) => {
                    this.imagechanged = true;
                    this.form.photo = reader.result;
                };
                reader.readAsDataURL(file);
            },
            ResetError(id){
                this.form.errors.clear(id)
            },
        },
         beforeMount() {
            axios.get("api/profile").then(({data}) => {
                this.form.fill(data);
                });
        },
    }
</script>
