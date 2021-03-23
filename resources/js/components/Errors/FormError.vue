<template>
    <div>
        <span v-for="item in form.errors.getAll(label)" class="custum-error"> {{item}}</span>
    </div>
</template>

<script>
    export default {
        props: {
            form : '',
            label: '',
        }
    }
</script>
<style scoped >
    .custum-error{
        font-size: 0.7rem !important;
        color: #e3342f !important;
    }
</style>
