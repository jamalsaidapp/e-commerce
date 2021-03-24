<template>
<div>
    <headerr></headerr>
    <sidebarr></sidebarr>
    <contentt></contentt>
    <footerr></footerr>

    <el-dialog title="Session Expirer !" center :visible.sync="showWarning" :close-on-click-modal="false" custom-class="rounded" lock-scroll :show-close="false" :width="WinWidth < 600 ? '40%' : '30%'">
        <strong class="offset-1">Vous serez Déconnecter Dans une Minute</strong>
        <el-button class="mt-3 offset-4" type="primary" size="small" @click="showWarning = false">Rester Conneté !</el-button>
    </el-dialog>
</div>
</template>

<script>
export default {
    name: "Body",
    data(){
        return{
            WinWidth:'',
            events: ['click','mousemove','mousedown', 'scroll', 'keypress','load'],
            warninigTimer : null,
            logoutTimer :null,
            showWarning : false,
        }
    },
    created(){
        window.addEventListener('resize', this.handleResize);
    },
    mounted() {
        this.events.forEach(event => {
            window.addEventListener(event, this.resetTimer);
        });
        this.setTimer();
    },
    destroyed(){
        window.removeEventListener('resize', this.handleResize);
        this.events.forEach(event => {
            window.removeEventListener(event, this.resetTimer);
        });
        this.resetTimer();
    },

    methods:{
        setTimer(){
            this.warninigTimer = setTimeout(() =>this.warningMessage(),   29 * 60 * 1000);
            this.logoutTimer = setTimeout(() =>this.logoutuser(),  30 * 60 * 1000);
        },
        warningMessage(){
            this.showWarning = true;
        },
        logoutuser(){
            this.showWarning = false;
            axios.post('/logout').then(()=>{
                window.location.replace('/admin');
            });
        },
        resetTimer(){
            clearTimeout(this.warninigTimer);
            clearTimeout(this.logoutTimer);
            this.setTimer();
        },

    }
}
</script>

<style scoped>

</style>
