<template lang="">
    <Head>
        <title>
            {{
                `${$inertia.page.component.toUpperCase()} | ${toko.nama.toUpperCase()}`
            }}
        </title>
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
                <a class="btn btn-ghost text-xl no-animation uppercase">{{
                    toko.nama
                }}</a>
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
                    <li class="group">
                        <a
                            :class="{
                                active:
                                    $page.component == 'satuan' ||
                                    $page.component == 'kategori' ||
                                    $page.component == 'transaksi' ||
                                    $page.component == 'pengeluaran' ||
                                    $page.component == 'pembelian' ||
                                    $page.component == 'member' ||
                                    $page.component == 'supplier' ||
                                    $page.component == 'produk',
                            }"
                            ><i class="fa fa-home"></i>Master</a
                        >
                        <ul
                            class="p-5 gap-2 shadow-lg bg-base-100 grid-cols-2 transition-all duration-300 w-max hidden group-hover:grid"
                        >
                            <Link :href="route('satuan.index')">
                                <li>
                                    <a
                                        :class="{
                                            active: $page.component == 'satuan',
                                        }"
                                        ><i class="fa-solid fa-folder"></i
                                        >Satuan</a
                                    >
                                </li>
                            </Link>
                            <Link :href="route('kategori.index')">
                                <li>
                                    <a
                                        :class="{
                                            active:
                                                $page.component == 'kategori',
                                        }"
                                        ><i class="fa-solid fa-folder-open"></i
                                        >kategori</a
                                    >
                                </li>
                            </Link>
                            <Link :href="route('produk.index')">
                                <li>
                                    <a
                                        :class="{
                                            active: $page.component == 'produk',
                                        }"
                                        ><i class="fa-brands fa-shopify"></i
                                        >produk</a
                                    >
                                </li>
                            </Link>
                            <Link :href="route('transaksi.index')">
                                <li>
                                    <a
                                        :class="{
                                            active:
                                                $page.component == 'transaksi',
                                        }"
                                        ><i class="fa-solid fa-right-left"></i
                                        >Transaksi</a
                                    >
                                </li>
                            </Link>
                            <Link :href="route('pengeluaran.index')">
                                <li>
                                    <a
                                        :class="{
                                            active:
                                                $page.component ==
                                                'pengeluaran',
                                        }"
                                        ><i class="fa-solid fa-sack-dollar"></i
                                        >Pengeluaran</a
                                    >
                                </li>
                            </Link>
                            <Link :href="route('pembelian.index')">
                                <li>
                                    <a
                                        :class="{
                                            active:
                                                $page.component == 'pembelian',
                                        }"
                                        ><i class="fa-solid fa-truck"></i
                                        >Pembelian</a
                                    >
                                </li>
                            </Link>
                            <Link :href="route('member.index')">
                                <li>
                                    <a
                                        :class="{
                                            active: $page.component == 'member',
                                        }"
                                        ><i class="fa-solid fa-user"></i
                                        >Member</a
                                    >
                                </li>
                            </Link>
                            <Link :href="route('supplier.index')">
                                <li>
                                    <a
                                        :class="{
                                            active:
                                                $page.component == 'supplier',
                                        }"
                                        ><i class="fa-solid fa-truck-fast"></i
                                        >Supplier</a
                                    >
                                </li>
                            </Link>
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
                    <Link :href="route('settings.menu.index')">
                        <li>
                            <a
                                :class="{
                                    active:
                                        $inertia.page.component == 'settings',
                                }"
                                ><i class="fa-solid fa-gear"></i>pengaturan</a
                            >
                        </li>
                    </Link>
                </ul>
            </div>
            <div class="navbar-end">
                <div class="dropdown dropdown-end">
                    <label tabindex="0" class="btn btn-ghost avatar flex gap-2">
                        <div class="w-10 rounded-full">
                            <img :src="user.foto" />
                        </div>
                        {{ user.name }}
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
        <transition name="content">
            <div class="h-full p-5 w-full flex flex-col gap-5" v-if="transisi">
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
        </transition>
    </div>
</template>
<script>
import axios from "axios";

export default {
    props: {
        header: Boolean,
        user: Object,
        toko: Object,
        success: String,
    },
    created() {
        axios.get(route("get_user")).then((response) => {
            this.$store.state.profiles.name = response.data.name;
            this.$store.state.profiles.email = response.data.email;
            this.$store.state.profiles.foto = response.data.foto;
        });
    },
    data() {
        return {
            transisi: false,
        };
    },
    mounted() {
        this.transisi = true;
    },
};
</script>
<style>
.content-enter,
.content-enter-to {
    transform: scale(60%);
    opacity: 0%;
}
.content-enter-to,
.content-leave {
    transform: scale(100%);
    opacity: 100%;
}
.content-enter-active {
    animation: konten 0.5s ease-in-out;
}
.content-leave-active {
    animation: konten 0.5s ease-in-out reverse;
}

@keyframes konten {
    0% {
        transform: scale(60%);
        opacity: 0%;
    }
    100% {
        transform: scale(100%);
        opacity: 100%;
    }
}
</style>
