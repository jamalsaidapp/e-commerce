<template>
    <div>
        <!-- Main Sidebar Container -->
        <aside class="main-sidebar nav-compact sidebar-dark-primary elevation-4" >
            <!-- Brand Logo -->
            <a href="" class="brand-link elevation-4" style="font-size: initial;">
                <img src="/img/logo.png"
                     alt="AdminLTE Logo"
                     class="brand-image"
                     style="opacity: .8">
                <span class="brand-text font-weight-light">E-Commerce | <small>Panel</small></span>
            </a>
            <!-- Sidebar -->
            <div class="sidebar scrlbar" >
                <!-- Sidebar Menu -->
                <nav class="mt-3">
                    <ul class="nav nav-pills nav-sidebar flex-column nav-child-indent text-sm" data-widget="treeview" role="menu" data-accordion="true">

                        <li class="nav-item">
                            <router-link  to="/back_index" class="nav-link">
                                <i class="nav-icon far fa-tachometer-alt"></i>
                                <p>Dashboard</p>
                            </router-link >
                        </li>
                        <li  class="nav-item has-treeview" :class="ConfClass">
                            <a href="#" class="nav-link">
                                <i class="nav-icon far fa-cog"></i>
                                <p>
                                    Paramètres
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <router-link  to="/Utilisateurs" class="nav-link">
                                        <i class="fal fa-users nav-icon"></i>
                                        <p>Users</p>
                                    </router-link>
                                </li>
                            </ul>
                        </li>

                        <li  class="nav-item has-treeview" :class="ShopClass">
                            <a href="#" class="nav-link">
                                <i class="nav-icon far fa-store-alt"></i>
                                <p>
                                    Shop
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <router-link  to="back_categories" class="nav-link">
                                        <i class="fal fa-network-wired nav-icon"></i>
                                        <p>Categories </p>
                                    </router-link>
                                </li>
                                <li class="nav-item">
                                    <router-link  to="back_products" class="nav-link">
                                        <i class="fal fa-shopping-bag nav-icon"></i>
                                        <p>Products </p>
                                    </router-link>
                                </li>
                                <li class="nav-item">
                                    <router-link  to="back_brands" class="nav-link">
                                        <i class="fal fa-code-branch nav-icon"></i>
                                        <p>Brands  </p>
                                    </router-link>
                                </li>
                                <li class="nav-item">
                                    <router-link  to="back_shipping" class="nav-link">
                                        <i class="fal fa-shipping-fast nav-icon"></i>
                                        <p>Shipping  </p>
                                    </router-link>
                                </li>
                            </ul>
                        </li>

                        <li class="nav-item">
                            <router-link to="back_orders" class="nav-link">
                                <i class="nav-icon far fa-hammer"></i>
                                <p>Orders</p>
                            </router-link >
                        </li>

                        <li class="nav-item">
                            <router-link to="back_reviews" class="nav-link">
                                <i class="nav-icon far fa-poll"></i>
                                <p>Reviews</p>
                            </router-link >
                        </li>

                        <li class="nav-item">
                            <router-link to="/profile" class="nav-link">
                                <i class="nav-icon far fa-user"></i>
                                <p>Mon Profile</p>
                            </router-link >
                        </li>

                        <li class="nav-item" @click.prevent="logout()">
                            <a href="" class="nav-link">
                                <i class="nav-icon far fa-sign-out"></i>
                                <p>Se Déconnecter</p>
                            </a >
                        </li>

                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>
    </div>
</template>
<script>
    export default {
        name: "Sidebar",
        computed: {
            ConfClass() {
                let routes = ['Utilisateurs', '', ''];
                return {'menu-open': routes.includes(this.$router.currentRoute.name)}
            },

            ShopClass() {
                let routes = ['categories', 'products', 'brands', 'shipping'];
                return {'menu-open': routes.includes(this.$router.currentRoute.name)}
            },
            logout() {
                this.$confirm('Are you sure you want to log out?', 'Attention !', {
                    confirmButtonText: 'Oui', cancelButtonText: 'Non', type: 'warning'
                }).then(() => {
                    axios.post('/logout').then(() => {
                        window.location.replace("/");
                    });

                })
            }
        }
    }
</script>

