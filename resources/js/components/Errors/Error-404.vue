<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="container">
                <img style="width: 100%" src="img/Error404_2.jpg" alt="404">
                <el-button class="btni" type="warning" @click="goback" round>Go Back</el-button>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        methods:{
            goback(){
                 // window.location.href = '/dashboard'
                this.$router.push({ name: 'dashboard' })
            }
        },
        mounted() {
        }
    }
</script>
<style>
    .container {
        position: relative;
    }
    .container .btni {
        position: absolute;
        top: 76%;
        left: 6%;
    }
</style>
