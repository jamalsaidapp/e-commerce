<template>
    <div >
        <div class="content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h5 class="m-0 text-dark">Brands</h5>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a tag="a" href="" @click.prevent="$router.push('back_index')">E-Commerce</a></li>
                            <li class="breadcrumb-item active">Brands</li>
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
                        Brand Table
                    </h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    Table
                </div>
            </div>

        </div>
    </div>
</template>

<script>
    export default {
        name: "Shipping"
    }
</script>

<style scoped>

</style>
