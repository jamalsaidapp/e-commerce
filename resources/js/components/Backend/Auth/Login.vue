<template>
    <div class="center" :style=" WinWidth < 600 ? 'width: 80%' : ''">
        <div class="login-box">
            <div class="login-logo">
                <a href="" class="text-decoration-none"><b>E-Commerce</b> Panel</a>
            </div>
            <!-- /.login-logo -->
            <div class="card">
                <div class="card-body login-card-body">
                    <p class="login-box-msg">Connectez-vous pour démarrer votre Session </p>
                    <form action="">
                        <div class="modal-card" style="width:300px;">
                            <section>
                                <b-field :type="{'is-danger':mail}" :message="mail">
                                    <b-input v-model="form.email" type="email" placeholder="Votre email" size="is-small" icon="email" required></b-input>
                                </b-field>
                                <b-field :type="{'is-danger':pass}" :message="pass">
                                    <b-input v-model="form.password" type="password" @keydown.enter.native="login" placeholder="Votre password" size="is-small" icon="key" required></b-input>
                                </b-field>
                            </section>
                            <footer class="mt-3 mx-auto">
                                <b-button @click.prevent="login()" label="Se Connecter" type="is-primary" size="is-small"/>
                            </footer>
                        </div>
                    </form>
                </div>
                <!-- /.login-card-body -->
            </div>
        </div>
    </div>


</template>

<script>
    export default {
        name: "Login",
        data(){
            return {
                form : new Form({
                    email: '',
                    password :''
                }),
                message : '',
                mail : '',
                pass : '',
                WinWidth : ''
            }
        },

        methods:{
            login(){
                this.form.post('/login').then((response)=>{
                    // this.message = response.data.message;
                    this.mail = response.data.mail;
                    this.pass = response.data.pass;
                    if (response.data.redirect) {
                        window.location.replace("/back_index");
                    }
                })
            },
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
    }
</script>

<style scoped>
    a:hover {
        color: unset !important;
    }
</style>
