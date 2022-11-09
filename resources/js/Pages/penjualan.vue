<template lang="">
    <div class="flex min-h-screen">
        <div
            class="z-30 bg-base-100 w-20 flex flex-col p-2 gap-2 h-screen shadow-md"
        >
            <div class="flex item-start flex-col m-auto">
                <div class="dropdown dropdown-right">
                    <label tabindex="0" class="btn m-1"
                        ><i class="fa-solid fa-home"></i
                    ></label>
                    <ul
                        tabindex="0"
                        class="dropdown-content menu p-2 shadow-lg bg-base-100 rounded-box w-52"
                    >
                        <Link :href="'/'"
                            ><li><a>Dashboard</a></li></Link
                        >
                    </ul>
                </div>
                <div class="dropdown dropdown-right">
                    <label tabindex="0" class="btn m-1"
                        ><i class="fa-solid fa-list"></i
                    ></label>
                    <ul
                        tabindex="0"
                        class="dropdown-content menu p-2 shadow-lg bg-base-100 rounded-box w-52 capitalize"
                    >
                        <Link :href="route('satuan.index')"
                            ><li><a>Satuan</a></li></Link
                        >
                        <Link :href="route('kategori.index')"
                            ><li><a>kategori</a></li></Link
                        >
                        <Link :href="route('produk.index')"
                            ><li><a>produk</a></li></Link
                        >
                        <li><a>Data Transaksi</a></li>
                        <li><a>Pengeluaran</a></li>
                        <li><a>Pemasukkan</a></li>
                    </ul>
                </div>
                <div class="dropdown dropdown-right">
                    <label tabindex="0" class="btn m-1"
                        ><i class="fa-solid fa-lock"></i
                    ></label>
                    <ul
                        tabindex="0"
                        class="dropdown-content menu p-2 shadow-lg bg-base-100 rounded-box w-52"
                    >
                        <Link :href="route('lock')" replace>
                            <li><a>Lock Mode</a></li>
                        </Link>
                    </ul>
                </div>
            </div>
            <div class="flex items-end h-full">
                <div class="dropdown dropdown-right">
                    <label tabindex="0" class="btn m-1"
                        ><i class="fa-solid fa-arrow-right-from-bracket"></i
                    ></label>
                    <ul
                        tabindex="0"
                        class="dropdown-content menu p-2 shadow-lg bg-base-100 rounded-box w-52"
                    >
                        <Link
                            :href="route('logout_user')"
                            replace
                            :only="['users']"
                        >
                            <li><a>Logout</a></li>
                        </Link>
                    </ul>
                </div>
            </div>
        </div>
        <div class="w-full flex flex-col min-h-screen max-h-screen relative">
            <div
                class="flex flex-col content-between gap-6 p-5 min-h-screen max-h-screen w-full z-0"
            >
                <div class="flex gap-2 items-center">
                    <div class="prose">
                        <h1>Penjualan</h1>
                    </div>
                    <label
                        @click="drawer_produk = !drawer_produk"
                        class="btn btn-primary"
                        ><i class="fa fa-cart-shopping"></i
                    ></label>
                </div>
                <div class="w-full h-full overflow-auto">
                    <table
                        class="table table-compact table-zebra w-full text-center"
                    >
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Jumlah</th>
                                <th>Harga</th>
                                <th>Subtotal</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                v-for="(item, index) in list_pesanan"
                                :key="index"
                            >
                                <th>{{ item.nama }}</th>
                                <td>{{ item.jumlah }}</td>
                                <td>{{ rupiah(item.harga) }}</td>
                                <td>{{ rupiah(item.subtotal) }}</td>
                                <td class="flex justify-center">
                                    <button
                                        class="btn btn-sm btn-error"
                                        @click="hapus(item)"
                                    >
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div
                    class="w-full h-max bg-base-100 rounded-xl justify-between flex p-5"
                >
                    <div class="h-full w-full flex justify-center items-center">
                        <div
                            class="prose text-center"
                            v-if="data_pesanan.bayar == 0"
                        >
                            <h2 class="font-extrabold">TOTAL PEMBAYARAN</h2>
                            <h1 class="font-extrabold">
                                {{ rupiah(data_pesanan.grand_total) }}
                            </h1>
                            <h3 class="font-extrabold">
                                {{ terbilang_rupiah(data_pesanan.grand_total) }}
                            </h3>
                        </div>
                        <div class="prose text-center" v-else>
                            <h2 class="font-extrabold">TOTAL KEMBALIAN</h2>
                            <h1 class="font-extrabold">
                                {{ rupiah(data_pesanan.kembalian) }}
                            </h1>
                            <h3 class="font-extrabold">
                                {{
                                    terbilang_rupiah(
                                        data_pesanan.kembalian < 0
                                            ? 0
                                            : data_pesanan.kembalian
                                    )
                                }}
                            </h3>
                        </div>
                    </div>
                    <table class="table-compact w-[28rem]">
                        <tbody>
                            <tr>
                                <td
                                    class="w-36 leading-3 capitalize text-lg font-bold"
                                >
                                    total
                                </td>
                                <td class="text-end leading-3 text-lg">
                                    {{ rupiah(data_pesanan.total) }}
                                </td>
                            </tr>
                            <tr>
                                <td
                                    class="w-36 leading-3 capitalize text-lg font-bold"
                                >
                                    diskon
                                </td>
                                <td class="text-end leading-3">
                                    <label for="diskon" class="btn btn-sm">{{
                                        rupiah(data_pesanan.diskon.final_diskon)
                                    }}</label>
                                </td>
                            </tr>
                            <tr>
                                <td
                                    class="w-36 leading-3 capitalize text-lg font-bold"
                                >
                                    PPN 11%
                                </td>
                                <td
                                    class="text-end leading-3 text-lg font-bold"
                                >
                                    {{ rupiah(data_pesanan.ppn_total) }}
                                </td>
                            </tr>
                            <tr>
                                <td
                                    class="w-36 leading-3 capitalize text-lg font-bold"
                                >
                                    grand total
                                </td>
                                <td
                                    class="text-end leading-3 text-lg font-bold"
                                >
                                    {{ rupiah(data_pesanan.grand_total) }}
                                </td>
                            </tr>
                            <tr>
                                <td
                                    class="w-36 leading-3 capitalize text-lg font-bold"
                                >
                                    bayar
                                </td>
                                <td class="text-end leading-3 text-lg">
                                    <label for="bayar" class="btn btn-sm">{{
                                        rupiah(data_pesanan.bayar.nominal)
                                    }}</label>
                                </td>
                            </tr>
                            <tr>
                                <td
                                    class="w-36 leading-3 capitalize text-lg font-bold"
                                >
                                    kembalian
                                </td>
                                <td class="text-end leading-3 text-lg">
                                    {{ rupiah(data_pesanan.kembalian) }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="absolute w-full flex bg-opacity-40 overflow-hidden">
                <div class="w-full h-full relative flex justify-end">
                    <transition name="produk">
                        <div
                            v-if="drawer_produk"
                            class="bg-white z-10 w-[45rem] min-h-screen max-h-screen overflow-hidden flex flex-col gap-2"
                        >
                            <div class="flex justify-between p-2">
                                <input
                                    type="text"
                                    class="input input-bordered"
                                    placeholder="Nama..."
                                    v-model="cari_produk"
                                />
                                <button
                                    @click="drawer_produk = !drawer_produk"
                                    class="btn"
                                >
                                    close
                                </button>
                            </div>
                            <div
                                class="overflow-y-auto select-none p-5 justify-center"
                            >
                                <table class="table table-compact w-full px-5">
                                    <tbody>
                                        <tr
                                            class="hover:scale-105 hover:bg-primary group transition-all ease-out duration-200 hover:shadow-lg hover:z-10"
                                            :class="{
                                                'opacity-40': item.stok == 0,
                                            }"
                                            v-for="(item, index) in list_produk"
                                            :key="index"
                                            @click="
                                                item.stok > 0
                                                    ? get_produk(item)
                                                    : ''
                                            "
                                        >
                                            <td
                                                class="group-hover:bg-primary group-hover:text-white"
                                            >
                                                {{ item.nama }}
                                            </td>
                                            <td
                                                class="group-hover:bg-primary group-hover:text-white"
                                            >
                                                {{ rupiah(item.harga) }}
                                            </td>
                                            <td
                                                class="group-hover:bg-primary group-hover:text-white"
                                            >
                                                Stok : {{ item.stok }}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </transition>
                    <div
                        v-if="drawer_produk"
                        class="w-screen h-screen absolute bg-gray-800 opacity-10"
                    ></div>
                </div>
            </div>
        </div>
    </div>
    <modal-md id="bayar">
        <template v-slot:title>Pembayaran </template>
        <template v-slot:content>
            <div class="form-control">
                <div class="grid grid-cols-12 gap-2">
                    <select
                        class="select select-bordered w-full col-span-3"
                        v-model="data_pesanan.bayar.jenis_pembayaran"
                    >
                        <option value="tunai">Tunai</option>
                        <option value="debit">Debit</option>
                    </select>
                    <input
                        type="text"
                        class="input input-bordered col-span-9"
                        v-model="data_pesanan.bayar.no_transaksi"
                        placeholder="No Transaksi..."
                        v-if="data_pesanan.bayar.jenis_pembayaran != 'tunai'"
                    />
                </div>
            </div>
            <div class="flex flex-col gap-2 border-2 rounded-xl py-5 mt-2 px-2">
                <div class="flex justify-center text-4xl font-bold">
                    {{ rupiah(data_pesanan.bayar.nominal) }}
                </div>
                <div class="grid grid-cols-3 gap-2 mt-2">
                    <button
                        class="btn btn-outline text-2xl font-bold col-span-3"
                        @click="button('pas')"
                    >
                        Uang Pas
                    </button>
                    <button
                        class="btn btn-outline text-2xl font-bold"
                        v-for="item in 9"
                        @click="button(item)"
                    >
                        {{ item }}
                    </button>
                    <button
                        class="btn btn-outline text-2xl font-bold"
                        @click="button('clear')"
                    >
                        Clear
                    </button>
                    <button
                        class="btn btn-outline text-2xl font-bold"
                        @click="button(0)"
                    >
                        0
                    </button>
                    <button
                        class="btn btn-outline text-2xl font-bold"
                        @click="button('delete')"
                    >
                        delete
                    </button>
                </div>
            </div>
        </template>
        <template v-slot:action>
            <button
                class="btn btn-success font-extrabold"
                :disabled="
                    data_pesanan.kembalian < 0 || data_pesanan.produk.length < 1
                "
                @click="push_pesanan"
            >
                Proses
            </button>
        </template>
    </modal-md>
    <modal-md id="diskon">
        <template v-slot:content>
            <div class="form-control">
                <label class="label"
                    >Diskon :
                    {{ rupiah(data_pesanan.diskon.final_diskon) }}</label
                >
                <div class="w-full flex gap-2">
                    <select
                        class="select select-bordered"
                        v-model="data_pesanan.diskon.tipe_diskon"
                    >
                        <option value="persen">%</option>
                        <option value="rupiah">Rp.</option>
                    </select>
                    <input
                        type="number"
                        class="input input-bordered w-full"
                        v-model="data_pesanan.diskon.input_diskon"
                    />
                </div>
            </div>
        </template>
    </modal-md>
</template>
<script>
import { useForm } from "@inertiajs/inertia-vue3";

export default {
    props: {
        produk: Object,
        user: Object,
    },
    watch: {
        "data_pesanan.diskon.input_diskon"() {
            const { tipe_diskon, input_diskon } = this.data_pesanan.diskon;
            const { total } = this.data_pesanan;
            if (tipe_diskon == "persen") {
                if (input_diskon >= 0 && input_diskon <= 100) {
                    this.data_pesanan.diskon.final_diskon =
                        total * (input_diskon / 100);
                } else {
                    this.data_pesanan.diskon.input_diskon = 0;
                }
            } else if (tipe_diskon == "rupiah") {
                if (input_diskon >= 0 && input_diskon <= total) {
                    this.data_pesanan.diskon.final_diskon = input_diskon;
                } else {
                    this.data_pesanan.diskon.input_diskon = 0;
                }
            }
        },
    },
    data() {
        return {
            cari_produk: "",
            drawer_produk: false,
            data_pesanan: {
                produk: [],
                total: 0,
                jumlah: 0,
                ppn: 11,
                ppn_total: 0,
                diskon: {
                    tipe_diskon: "persen",
                    input_diskon: 0,
                    final_diskon: 0,
                },
                grand_total: 0,
                bayar: {
                    jenis_pembayaran: "tunai",
                    no_transaksi: "",
                    nominal: null,
                },
                kembalian: 0,
            },
        };
    },
    setup(props) {
        const transaksi = useForm({
            data_transkasi: null,
        });
        return {
            transaksi,
        };
    },
    methods: {
        button(data) {
            if (data == "pas") {
                this.data_pesanan.bayar.nominal = this.data_pesanan.grand_total;
            } else if (data == "clear") {
                this.data_pesanan.bayar.nominal = 0;
            } else if (data == "delete") {
                if (String(this.data_pesanan.bayar.nominal).length > 1) {
                    this.data_pesanan.bayar.nominal = parseInt(
                        String(this.data_pesanan.bayar.nominal).slice(
                            this.data_pesanan.bayar.nominal.length,
                            -1
                        )
                    );
                } else {
                    this.data_pesanan.bayar.nominal = 0;
                }
            } else {
                var bayar = String(this.data_pesanan.bayar.nominal);
                if (bayar == 0) {
                    this.data_pesanan.bayar.nominal = parseInt(data);
                } else {
                    this.data_pesanan.bayar.nominal = parseInt(
                        String(this.data_pesanan.bayar.nominal) + String(data)
                    );
                }
            }
        },
        kembalian(data) {
            this.$swal({
                icon: "success",
                title: "Kembalian " + this.rupiah(data),
                text: "Transaksi berhasil disimpan",
            });
        },
        async push_pesanan() {
            const { kembalian } = this.data_pesanan;
            this.transaksi.data_transkasi = this.data_pesanan;
            await this.transaksi.post(route("transaksi.index"), {
                onSuccess: () => {
                    document.getElementById("bayar").click();
                    this.kembalian(kembalian);
                    this.data_pesanan = {
                        produk: [],
                        total: 0,
                        jumlah: 0,
                        ppn: 11,
                        ppn_total: 0,
                        diskon: {
                            tipe_diskon: "persen",
                            input_diskon: 0,
                            final_diskon: 0,
                        },
                        grand_total: 0,
                        bayar: {
                            jenis_pembayaran: "tunai",
                            no_transaksi: "",
                            nominal: null,
                        },
                        kembalian: 0,
                    };
                },
            });
        },
        hapus(data) {
            var id_index;
            this.data_pesanan.produk.find((item, index) => {
                if (item.id == data.id) {
                    item.stok += data.jumlah;
                    id_index = index;
                    data.jumlah = 1;
                }
            });
            this.data_pesanan.produk.splice(id_index, 1);
        },
        get_produk(data) {
            if (this.data_pesanan.produk.length < 1) {
                this.data_pesanan.produk.push(data);
            } else {
                var cek = true;
                this.data_pesanan.produk.find((item) => {
                    if (item.id == data.id) {
                        item.jumlah++;
                        cek = false;
                    }
                });
                if (cek) {
                    this.data_pesanan.produk.push(data);
                }
            }
            data.stok--;
        },
    },
    computed: {
        list_produk() {
            return this.produk.filter((produk) => {
                return produk.nama
                    .toLowerCase()
                    .includes(this.cari_produk.toLowerCase());
            });
        },
        list_pesanan() {
            var total = 0;
            this.data_pesanan.produk.forEach((element) => {
                element.subtotal = element.jumlah * element.harga;
                total += element.subtotal;
            });

            this.data_pesanan.total = total;
            this.data_pesanan.ppn_total = (total * this.data_pesanan.ppn) / 100;
            this.data_pesanan.grand_total =
                total +
                this.data_pesanan.ppn_total -
                this.data_pesanan.diskon.final_diskon;
            this.data_pesanan.kembalian =
                this.data_pesanan.bayar.nominal - this.data_pesanan.grand_total;

            var data = this.data_pesanan.produk;
            if (total == 0) {
                this.data_pesanan.diskon.final_diskon = 0;
                this.data_pesanan.diskon.input_diskon = 0;
                this.data_pesanan.grand_total = 0;
                this.data_pesanan.kembalian = 0;
                this.data_pesanan.bayar.nominal = 0;
            }
            return data.slice().reverse();
        },
    },
};
</script>
<style>
.produk-enter-from,
.produk-leave-to {
    transform: translateX(100%);
}
.produk-enter-active {
    animation: slide-right 0.3s;
}
.produk-leave-active {
    animation: slide-right 0.3s reverse;
}
.produk-enter-to,
.produk-leave-from {
    transform: translateX(0%);
}
@keyframes slide-right {
    0% {
        transform: translateX(100%);
    }
    100% {
        transform: translateX(0%);
    }
}
</style>
