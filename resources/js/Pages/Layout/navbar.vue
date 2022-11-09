<template lang="">
    <Head>
        <title>{{ $inertia.page.component.toUpperCase() }}</title>
    </Head>
    <div class="min-h-screen relative">
        <div class="toast toast-top toast-end z-50" v-if="success">
            <div class="alert alert-success">
                <div>
                    <span class="flex gap-2"
                        ><button
                            class="btn btn-xs btn-outline bg-green-500 text-white btn-circle"
                        >
                            <i class="fa-solid fa-check"></i>
                        </button>
                        {{ success }}</span
                    >
                </div>
            </div>
        </div>
        <div class="navbar bg-base-100 shadow-lg sticky top-0 z-40">
            <div class="navbar-start">
                <a class="btn btn-ghost normal-case text-xl">daisyUI</a>
            </div>
            <div class="navbar-center hidden lg:flex">
                <ul class="menu menu-horizontal p-0 capitalize gap-2">
                    <Link :href="route('dashboard')">
                        <li>
                            <a
                                :class="{
                                    active:
                                        $inertia.page.component == 'dashboard',
                                }"
                                ><i class="fa fa-home"></i>Dashboard</a
                            >
                        </li>
                    </Link>
                    <li>
                        <a><i class="fa fa-home"></i>Master</a>
                        <ul class="p-2 bg-base-100">
                            <Link :href="route('satuan.index')">
                                <li><a>Satuan</a></li>
                            </Link>
                            <Link :href="route('kategori.index')">
                                <li><a>kategori</a></li>
                            </Link>
                            <Link :href="route('produk.index')">
                                <li><a>produk</a></li>
                            </Link>
                            <Link :href="route('transaksi.index')">
                                <li><a>Transaksi</a></li>
                            </Link>
                            <Link :href="route('pengeluaran.index')">
                                <li><a>Pengeluaran</a></li>
                            </Link>
                            <li><a>pemasukkan</a></li>
                        </ul>
                    </li>
                    <Link :href="route('penjualan.index')">
                        <li>
                            <a
                                :class="{
                                    active:
                                        $inertia.page.component == 'penjualan',
                                }"
                                ><i class="fa-solid fa-cart-shopping"></i
                                >penjualan</a
                            >
                        </li>
                    </Link>
                    <li>
                        <a
                            :class="{
                                active: $inertia.page.component == 'pengaturan',
                            }"
                            ><i class="fa-solid fa-gear"></i>pengaturan</a
                        >
                    </li>
                </ul>
            </div>
            <div class="navbar-end">
                <div class="dropdown dropdown-end">
                    <label tabindex="0" class="btn btn-ghost avatar flex gap-2">
                        <div class="w-10 rounded-full">
                            <img :src="$store.state.profiles.foto" />
                        </div>
                        {{ $store.state.profiles.name }}
                    </label>
                    <ul
                        tabindex="0"
                        class="menu menu-compact dropdown-content mt-3 p-2 shadow bg-base-100 rounded-box w-52"
                    >
                        <Link :href="route('logout_user')"
                            ><li><a>Logout</a></li></Link
                        >
                    </ul>
                </div>
            </div>
        </div>
        <div class="h-full p-5 w-full flex flex-col gap-5">
            <div class="flex gap-4 p-2 rounded-2xl" v-if="header">
                <div class="prose capitalize w-max pl-4">
                    <h2><slot name="title"></slot></h2>
                </div>
                <slot name="title_left"></slot>
                <div class="flex justify-end w-full">
                    <slot name="title_right"></slot>
                </div>
            </div>
            <div
                class="flex w-full h-full bg-base-100 shadow-lg rounded-lg p-4"
            >
                <slot name="content"></slot>
            </div>
        </div>
    </div>
</template>
<script>
import axios from "axios";

export default {
    props: {
        header: Boolean,
        user: Object,
        success: String,
    },
    created() {
        axios.get(route("get_user")).then((response) => {
            this.$store.state.profiles.name = response.data.name;
            this.$store.state.profiles.email = response.data.email;
            this.$store.state.profiles.foto = response.data.foto;
        });
    },
};
</script>
<style lang=""></style>
