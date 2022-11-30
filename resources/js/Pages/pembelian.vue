<template lang="">
    <navbar :toko="toko" header :success="success" :user="user">
        <template v-slot:title>Pembelian</template>
        <template v-slot:title_left>
            <label for="tambah" class="btn btn-sm btn-success">
                <i class="fa fa-plus"></i>
            </label>
        </template>
        <template v-slot:content>
            <div class="flex flex-col w-full gap-6">
                <div class="flex justify-between w-full">
                    <div class="form-control">
                        <div class="input-group">
                            <input
                                type="text"
                                v-model="input_cari"
                                placeholder="Search…"
                                class="input input-bordered"
                            />
                            <button
                                class="btn btn-square"
                                @click="get_pembelian()"
                            >
                                <i class="fa fa-search"></i>
                            </button>
                        </div>
                    </div>
                    <div class="flex gap-2">
                        <div class="flex gap-1">
                            <label class="label">Dari</label>
                            <input
                                @change="get_pembelian"
                                type="date"
                                class="input input-bordered"
                                v-model="input_range.dari"
                            />
                        </div>
                        <div class="flex gap-1">
                            <label class="label">Sampai</label>
                            <input
                                @change="get_pembelian"
                                type="date"
                                class="input input-bordered"
                                v-model="input_range.sampai"
                            />
                        </div>
                    </div>
                    <div class="flex gap-1">
                        <label class="label">Tampilkan </label>
                        <select
                            class="w-max select select-bordered"
                            v-model="input_show"
                            @change="get_pembelian()"
                        >
                            <option value="5">5</option>
                            <option value="10">10</option>
                            <option value="50">50</option>
                        </select>
                        <label class="label">Item</label>
                    </div>
                </div>
                <table
                    class="table table-compact table-zebra w-full text-center"
                >
                    <thead>
                        <tr>
                            <td>no</td>
                            <td>tanggal</td>
                            <td>supplier</td>
                            <td>total item</td>
                            <td>total harga</td>
                            <td>diskon</td>
                            <td>ppn</td>
                            <td>total bayar</td>
                            <td>Detail</td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr
                            v-for="(item, index) in master_pembelian.data"
                            :key="index"
                        >
                            <td>{{ index + 1 }}</td>
                            <td>{{ item.waktu }}</td>
                            <td>
                                {{ item.supplier ? item.supplier.nama : "" }}
                            </td>
                            <td>{{ item.total_item }}</td>
                            <td>{{ rupiah(item.total_harga) }}</td>
                            <td>{{ rupiah(item.diskon) }}</td>
                            <td>{{ rupiah(item.ppn) }}</td>
                            <td>{{ rupiah(item.total_bayar) }}</td>
                            <td class="flex justify-center">
                                <label
                                    @click="get_data_pembelian(item)"
                                    for="menu_detail"
                                    class="btn btn-sm btn-info"
                                >
                                    <i class="fa fa-list"></i>
                                </label>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="btn-group gap-1 flex justify-center">
                    <template v-for="item in master_pembelian.links">
                        <Link :href="item.url" v-if="item.url" preserveScroll>
                            <button
                                class="btn btn-sm"
                                :class="{ 'btn-outline': !item.active }"
                                v-html="item.label"
                            ></button>
                        </Link>
                        <button class="btn btn-sm btn-outline" disabled v-else>
                            ...
                        </button>
                    </template>
                </div>
            </div>
        </template>
    </navbar>
    <modal-md id="tambah">
        <template v-slot:title> Pilih Supplier </template>
        <template v-slot:content>
            <div class="flex flex-col gap-5 relative">
                <div class="flex justify-between">
                    <div class="form-control sticky top-0 w-full">
                        <div class="input-group">
                            <input
                                type="text"
                                v-model="cari_supplier"
                                placeholder="Search…"
                                class="input input-bordered input-sm"
                            />
                            <button class="btn btn-square btn-sm">
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="h-6 w-6"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"
                                    />
                                </svg>
                            </button>
                        </div>
                    </div>
                    <label for="tambah" class="btn btn-sm">close</label>
                </div>
                <table
                    class="table table-compact table-zebra w-full text-center"
                >
                    <thead>
                        <tr>
                            <td>nama</td>
                            <td>action</td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="item in list_supplier">
                            <th>{{ item.nama }}</th>
                            <th class="flex justify-center">
                                <label
                                    @click="get_supplier(item)"
                                    for="menu_pembelian"
                                    class="btn gap-2 btn-sm btn-info"
                                >
                                    Pilih
                                </label>
                            </th>
                        </tr>
                    </tbody>
                </table>
            </div>
        </template>
    </modal-md>
    <modal-lg id="menu_pembelian">
        <template v-slot:title>
            Supplier : {{ pembelian.supplier.nama }}
        </template>
        <template v-slot:content>
            <div class="flex flex-col h-full w-full gap-2">
                <div class="flex flex-col w-full h-full gap-5">
                    <label for="pilih_produk" class="btn btn-sm w-max gap-2">
                        <i class="fa-solid fa-cart-shopping"></i> pilih produk
                    </label>
                    <div class="h-[10rem] w-full overflow-auto">
                        <table
                            class="w-full text-center table table-compact table-zebra"
                        >
                            <thead class="sticky top-0">
                                <tr>
                                    <td>No</td>
                                    <td>Nama</td>
                                    <td>satuan</td>
                                    <td class="w-[8rem]">Jumlah</td>
                                    <td>Harga</td>
                                    <td class="w-[8rem]">Subtotal</td>
                                    <td>action</td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr
                                    v-for="(item, index) in list_pembelian
                                        .slice()
                                        .reverse()"
                                    :key="index"
                                >
                                    <td>{{ index + 1 }}</td>
                                    <td>{{ item.nama }}</td>
                                    <td>{{ item.satuan }}</td>
                                    <td
                                        class="flex justify-between items-center gap-1"
                                    >
                                        <button
                                            class="btn btn-xs"
                                            @mousedown="
                                                tambah_jumlah(item, true)
                                            "
                                            @mouseup="
                                                tambah_jumlah(item, false)
                                            "
                                            @mouseleave="
                                                tambah_jumlah(item, false)
                                            "
                                            @click="item.jumlah++"
                                        >
                                            <i class="fa fa-plus"></i>
                                        </button>
                                        <button class="btn btn-ghost btn-sm">
                                            {{ item.jumlah }}
                                        </button>
                                        <button
                                            class="btn btn-xs"
                                            @mousedown="
                                                kurang_jumlah(item, true)
                                            "
                                            @mouseup="
                                                kurang_jumlah(item, false)
                                            "
                                            @mouseleave="
                                                kurang_jumlah(item, false)
                                            "
                                            @click="
                                                item.jumlah > 1
                                                    ? item.jumlah--
                                                    : (item.jumlah = 1)
                                            "
                                        >
                                            <i class="fa fa-minus"></i>
                                        </button>
                                    </td>
                                    <td>{{ rupiah(item.harga_beli) }}</td>
                                    <td>{{ rupiah(item.subtotal) }}</td>
                                    <td class="flex justify-center">
                                        <button
                                            @click="hapus_pembelian(item.id)"
                                            class="btn btn-sm btn-error"
                                        >
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="flex">
                    <div
                        class="flex justify-center items-center w-full flex-col bg-blue-500 text-white gap-2 rounded-xl"
                    >
                        <div class="font-extrabold text-6xl">
                            {{ rupiah(pembelian.total_bayar) }}
                        </div>
                        <div class="">
                            {{ terbilang_rupiah(pembelian.total_bayar) }}
                        </div>
                    </div>
                    <table class="table table-compact table-zebra w-max">
                        <tbody>
                            <tr>
                                <th class="text-md w-[15rem] leading-3">
                                    Total
                                </th>
                                <td class="text-right font-semibold leading-3">
                                    <label class="btn btn-xs btn-ghost">
                                        {{ rupiah(pembelian.total_harga) }}
                                    </label>
                                </td>
                            </tr>
                            <tr>
                                <th class="text-md leading-3">Diskon</th>
                                <td class="text-right font-semibold leading-3">
                                    <label for="diskon" class="btn btn-xs">
                                        {{ rupiah(pembelian.diskon.final) }}
                                    </label>
                                </td>
                            </tr>
                            <tr>
                                <th class="text-md leading-3">
                                    PPN
                                    {{
                                        pembelian.ppn.nilai == 0 ||
                                        pembelian.ppn.nilai == ""
                                            ? null
                                            : pembelian.ppn.nilai + "%"
                                    }}
                                </th>
                                <td class="text-right font-semibold leading-3">
                                    <label class="btn btn-xs" for="ppn">
                                        {{ rupiah(pembelian.ppn.final) }}
                                    </label>
                                </td>
                            </tr>
                            <tr>
                                <th class="text-md leading-3">Bayar</th>
                                <td class="text-right font-semibold leading-3">
                                    <label class="btn btn-xs btn-ghost">
                                        {{ rupiah(pembelian.total_bayar) }}
                                    </label>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </template>
        <template v-slot:action>
            <button
                class="btn btn-success"
                :disabled="pembelian.processing"
                :class="{ loading: pembelian.processing }"
                @click="submit_pembelian"
            >
                simpan
            </button>
        </template>
    </modal-lg>
    <modal-md id="pilih_produk">
        <template v-slot:title> Pilih Produk </template>
        <template v-slot:content>
            <div class="flex flex-col w-full gap-5">
                <div class="flex justify-between w-full">
                    <div class="form-control">
                        <input
                            type="text"
                            v-model="cari_produk"
                            class="input input-bordered input-sm"
                            placeholder="Nama produk..."
                        />
                    </div>
                    <label for="pilih_produk" class="btn btn-sm">Close</label>
                </div>
                <table
                    class="table table-compact table-zebra w-full text-center"
                >
                    <thead>
                        <tr>
                            <td>Nama</td>
                            <td>harga beli</td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr
                            v-for="(item, index) in list_produk"
                            :key="index"
                            @click="push_produk(item, index)"
                        >
                            <td>{{ item.nama }}</td>
                            <td>{{ rupiah(item.harga_beli) }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </template>
    </modal-md>
    <modal-md id="diskon">
        <template v-slot:title>Input Diskon</template>
        <template v-slot:content>
            <div class="flex gap-2 w-full flex-col">
                <div class="flex gap-2">
                    <select
                        class="select select-bordered w-max"
                        v-model="pembelian.diskon.tipe"
                    >
                        <option value="persen">Persen %</option>
                        <option value="rupiah">Rupiah Rp.</option>
                    </select>
                    <input
                        type="number"
                        class="input input-bordered w-full"
                        v-model="pembelian.diskon.input_awal"
                    />
                </div>
                <div
                    class="flex justify-center items-center bg-blue-500 rounded-lg p-2 text-white text-xl"
                >
                    Diskon : {{ rupiah(pembelian.diskon.final) }}
                </div>
            </div>
        </template>
    </modal-md>
    <modal-md id="ppn">
        <template v-slot:title>Input PPN</template>
        <template v-slot:content>
            <div class="form-control">
                <input
                    type="number"
                    class="input input-bordered"
                    v-model="pembelian.ppn.nilai"
                />
            </div>
        </template>
    </modal-md>
    <modal-lg id="menu_detail">
        <template v-slot:title>
            Supplier : {{ pembelian_detail.supplier.nama }}
        </template>
        <template v-slot:content>
            <div class="flex flex-col h-full w-full gap-2">
                <div class="flex flex-col w-full h-full gap-5">
                    <!-- <label for="pilih_produk" class="btn btn-sm w-max gap-2">
                        <i class="fa-solid fa-cart-shopping"></i> pilih produk
                    </label> -->
                    <div class="h-[10rem] w-full overflow-auto">
                        <table
                            class="w-full text-center table table-compact table-zebra"
                        >
                            <thead class="sticky top-0">
                                <tr>
                                    <td>No</td>
                                    <td>Nama</td>
                                    <td>satuan</td>
                                    <td class="w-[8rem]">Jumlah</td>
                                    <td>Harga</td>
                                    <td class="w-[8rem]">Subtotal</td>
                                    <!-- <td>action</td> -->
                                </tr>
                            </thead>
                            <tbody>
                                <tr
                                    v-for="(
                                        item, index
                                    ) in pembelian_detail.produk
                                        .slice()
                                        .reverse()"
                                    :key="index"
                                >
                                    <td>{{ index + 1 }}</td>
                                    <td>{{ item.produk.nama }}</td>
                                    <td>{{ item.produk.satuan.satuan }}</td>
                                    <td
                                        class="flex justify-center items-center gap-1"
                                    >
                                        <!-- <button
                                            class="btn btn-xs"
                                            @mousedown="
                                                tambah_jumlah(item, true)
                                            "
                                            @mouseup="
                                                tambah_jumlah(item, false)
                                            "
                                            @mouseleave="
                                                tambah_jumlah(item, false)
                                            "
                                            @click="item.jumlah++"
                                        >
                                            <i class="fa fa-plus"></i>
                                        </button> -->
                                        <button class="btn btn-ghost btn-sm">
                                            {{ item.jumlah }}
                                        </button>
                                        <!-- <button
                                            class="btn btn-xs"
                                            @mousedown="
                                                kurang_jumlah(item, true)
                                            "
                                            @mouseup="
                                                kurang_jumlah(item, false)
                                            "
                                            @mouseleave="
                                                kurang_jumlah(item, false)
                                            "
                                            @click="
                                                item.jumlah > 1
                                                    ? item.jumlah--
                                                    : (item.jumlah = 1)
                                            "
                                        >
                                            <i class="fa fa-minus"></i>
                                        </button> -->
                                    </td>
                                    <td>{{ rupiah(item.harga_beli) }}</td>
                                    <td>{{ rupiah(item.subtotal) }}</td>
                                    <!-- <td class="flex justify-center">
                                        <button
                                            @click="hapus_pembelian(item.id)"
                                            class="btn btn-sm btn-error"
                                        >
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </td> -->
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="flex">
                    <div
                        class="flex justify-center items-center w-full flex-col bg-blue-500 text-white gap-2 rounded-xl"
                    >
                        <div class="font-extrabold text-6xl">
                            {{ rupiah(pembelian_detail.total_bayar) }}
                        </div>
                        <div class="">
                            {{ terbilang_rupiah(pembelian_detail.total_bayar) }}
                        </div>
                    </div>
                    <table class="table table-compact table-zebra w-max">
                        <tbody>
                            <tr>
                                <th class="text-md w-[15rem] leading-3">
                                    Total
                                </th>
                                <td class="text-right font-semibold leading-3">
                                    <label class="btn btn-xs btn-ghost">
                                        {{
                                            rupiah(pembelian_detail.total_harga)
                                        }}
                                    </label>
                                </td>
                            </tr>
                            <tr>
                                <th class="text-md leading-3">Diskon</th>
                                <td class="text-right font-semibold leading-3">
                                    <label class="btn btn-xs btn-ghost">
                                        {{ rupiah(pembelian_detail.diskon) }}
                                    </label>
                                </td>
                            </tr>
                            <tr>
                                <th class="text-md leading-3">PPN</th>
                                <td class="text-right font-semibold leading-3">
                                    <label class="btn btn-xs btn-ghost">
                                        {{ rupiah(pembelian_detail.ppn) }}
                                    </label>
                                </td>
                            </tr>
                            <tr>
                                <th class="text-md leading-3">Bayar</th>
                                <td class="text-right font-semibold leading-3">
                                    <label class="btn btn-xs btn-ghost">
                                        {{
                                            rupiah(pembelian_detail.total_bayar)
                                        }}
                                    </label>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </template>
        <!-- <template v-slot:action>
            <button
                class="btn btn-success"
                :disabled="pembelian.processing"
                :class="{ loading: pembelian.processing }"
                @click="submit_pembelian"
            >
                simpan
            </button>
        </template> -->
    </modal-lg>
</template>
<script>
import { useForm } from "@inertiajs/inertia-vue3";

export default {
    watch: {
        "pembelian.ppn.nilai"() {
            const { nilai } = this.pembelian.ppn;
            if (nilai > 0) {
                this.pembelian.ppn.final =
                    (nilai / 100) *
                    (this.pembelian.total_harga - this.pembelian.diskon.final);
            }
        },
        "pembelian.diskon.input_awal"() {
            const { tipe, input_awal } = this.pembelian.diskon;
            if (tipe == "persen") {
                if (input_awal == "" || input_awal < 1) {
                    this.pembelian.diskon.input_awal = "";
                } else if (input_awal > 100) {
                    this.pembelian.diskon.input_awal = 100;
                }

                this.pembelian.diskon.final =
                    (this.pembelian.total_harga *
                        (input_awal != "" ? input_awal : 0)) /
                    100;
            } else if (tipe == "rupiah") {
                if (input_awal == "" || input_awal < 1) {
                    this.pembelian.diskon.input_awal = "";
                } else if (input_awal > this.pembelian.total_harga) {
                    this.pembelian.diskon.input_awal =
                        this.pembelian.total_harga;
                }
                this.pembelian.diskon.final = input_awal != "" ? input_awal : 0;
            }
        },
        "pembelian.diskon.tipe"() {
            this.pembelian.diskon.input_awal = 0;
        },
    },
    setup(props) {
        const pembelian = useForm({
            supplier: {},
            produk: [],
            total_item: 0,
            total_harga: 0,
            diskon: {
                tipe: "persen",
                input_awal: 0,
                final: 0,
            },
            ppn: {
                nilai: 0,
                final: 0,
            },
            total_bayar: 0,
        });
        const pembelian_detail = useForm({
            supplier: {},
            produk: [],
            total_item: 0,
            total_harga: 0,
            diskon: {
                tipe: "persen",
                input_awal: 0,
                final: 0,
            },
            ppn: {
                nilai: 0,
                final: 0,
            },
            total_bayar: 0,
        });
        return {
            pembelian,
            pembelian_detail,
        };
    },
    methods: {
        get_data_pembelian(data) {
            this.pembelian_detail.supplier = data.supplier;
            this.pembelian_detail.total_bayar = data.total_bayar;
            this.pembelian_detail.total_harga = data.total_harga;
            this.pembelian_detail.diskon = data.diskon;
            this.pembelian_detail.ppn = data.ppn;
            this.pembelian_detail.produk = data.pembelian_detail;
        },
        submit_pembelian() {
            this.pembelian.post(route("pembelian.store"), {
                onSuccess: () => {
                    this.close_modal("menu_pembelian");
                    this.close_modal("tambah");
                    this.pembelian.reset();
                    this.notifikasi("Pembelian Berhasil Ditambahkan");
                },
            });
        },
        hapus_pembelian(id) {
            var index_produk;
            this.pembelian.produk.find((item, index) => {
                if (item.id == id) {
                    index_produk = index;
                }
            });
            this.pembelian.produk.splice(index_produk, 1);
        },
        async tambah_jumlah(data, status) {
            clearInterval(this.hold_produk);
            clearTimeout(this.cek);
            if (status) {
                this.cek = setTimeout(() => {
                    this.hold_produk = setInterval(() => {
                        data.jumlah += 2;
                    }, 100);
                }, 500);
            } else {
                clearInterval(this.hold_produk);
            }
        },
        async kurang_jumlah(data, status) {
            clearInterval(this.hold_produk);
            clearTimeout(this.cek);
            if (await status) {
                this.cek = setTimeout(() => {
                    this.hold_produk = setInterval(() => {
                        if (data.jumlah > 2) {
                            data.jumlah -= 2;
                        } else {
                            data.jumlah = 1;
                        }
                    }, 100);
                }, 500);
            } else {
                clearInterval(this.hold_produk);
            }
        },
        get_supplier(data) {
            this.pembelian.supplier = data;
        },
        push_produk(data, index) {
            var { produk } = this.pembelian;
            document.getElementById("pilih_produk").click();

            var cek = false;
            this.pembelian.produk.find((element) => {
                if (element.id == data.id) {
                    cek = true;
                    element.jumlah += 1;
                    element.subtotal = element.jumlah * element.harga_beli;
                    data.jumlah += 1;
                }
            });
            console.table(data);
            if (!cek) {
                var final = {
                    index: index,
                    id: data.id,
                    nama: data.nama,
                    satuan: data.satuan ? data.satuan.satuan : "",
                    jumlah: 1,
                    harga_beli: data.harga_beli,
                    subtotal: data.harga_beli,
                };
                data.jumlah += 1;
                this.pembelian.produk.push(final);
            }
        },
    },
    props: {
        supplier: Array,
        produk: Array,
        master_pembelian: Object,
        toko: Object,
    },
    data() {
        return {
            cari_supplier: "",
            cari_produk: "",
            data_produk: this.produk,
        };
    },
    computed: {
        list_supplier() {
            return this.supplier.filter((item) => {
                if (
                    item.nama
                        .toLowerCase()
                        .includes(this.cari_supplier.toLowerCase())
                ) {
                    return item;
                }
            });
        },
        list_produk() {
            return this.data_produk.filter((item) => {
                if (
                    item.nama
                        .toLowerCase()
                        .includes(this.cari_produk.toLowerCase())
                ) {
                    return item;
                }
            });
        },
        list_pembelian() {
            var total_harga = 0;
            var total_item = 0;
            var pembelian = this.pembelian;
            pembelian.produk.forEach((element) => {
                element.subtotal = element.jumlah * element.harga_beli;
                total_harga += element.subtotal;
                total_item += element.jumlah;
            });

            // total harga
            pembelian.total_harga = total_harga;

            // jumlah item
            pembelian.total_item = total_item;

            // ppn
            pembelian.ppn.final =
                (pembelian.ppn.nilai / 100) *
                (pembelian.total_harga - pembelian.diskon.final);

            // total bayar
            pembelian.total_bayar =
                pembelian.total_harga -
                pembelian.diskon.final +
                pembelian.ppn.final;
            return pembelian.produk;
        },
    },
};
</script>
<style lang=""></style>
