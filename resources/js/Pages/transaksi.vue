<template lang="">
    <navbar header>
        <template v-slot:title> Transaksi </template>
        <template v-slot:content>
            <div class="flex flex-col w-full gap-5">
                <div class="flex justify-between">
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
                                @click="get_transaksi()"
                            >
                                <i class="fa fa-search"></i>
                            </button>
                        </div>
                    </div>
                    <div class="flex gap-2">
                        <div class="flex gap-1">
                            <label class="label">Dari</label>
                            <input
                                @change="get_transaksi"
                                type="date"
                                class="input input-bordered"
                                v-model="input_range.dari"
                            />
                        </div>
                        <div class="flex gap-1">
                            <label class="label">Sampai</label>
                            <input
                                @change="get_transaksi"
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
                            @change="get_transaksi()"
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
                            <td>Tanggal</td>
                            <td>Kode Transaksi</td>
                            <td>Jenis Pembayaran</td>
                            <td>Total pembayaran</td>
                            <td>Member</td>
                            <td>Status</td>
                            <td>Action</td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr
                            v-for="(item, index) in transaksi.data"
                            :key="index"
                        >
                            <td>{{ item.waktu }}</td>
                            <td>{{ item.kode_transaksi }}</td>
                            <td>{{ item.jenis_pembayaran }}</td>
                            <td>{{ rupiah(item.grand_total) }}</td>
                            <td>{{ item.nama_member }}</td>
                            <td>
                                <div
                                    class="badge badge-info gap-2"
                                    :class="{
                                        'badge-info': item.status == 'lunas',
                                        'badge-error':
                                            item.status == 'belum lunas',
                                    }"
                                >
                                    {{ item.status }}
                                </div>
                            </td>
                            <td>
                                <div class="flex justify-center gap-2">
                                    <label
                                        class="btn btn-sm btn-info"
                                        for="detail"
                                        @click="edit_transkasi(item)"
                                    >
                                        <i class="fa fa-list"></i>
                                    </label>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="btn-group gap-1 flex justify-center">
                    <template v-for="item in transaksi.links">
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
    <modal-lg id="detail">
        <template v-slot:title>Detail Transaksi</template>
        <template v-slot:content>
            <div class="h-full w-full flex flex-col gap-4">
                <div class="grid grid-cols-3">
                    <table class="w-max">
                        <tbody>
                            <tr>
                                <td>Kode Transaksi</td>
                                <td>: {{ edit.kode_transaksi }}</td>
                            </tr>
                            <tr>
                                <td>Member</td>
                                <td>: {{ edit.nama_member }}</td>
                            </tr>
                        </tbody>
                    </table>
                    <table class="w-max">
                        <tbody>
                            <tr>
                                <td>Status Pembayaran</td>
                                <td>
                                    :
                                    <div
                                        class="badge badge-info gap-2"
                                        :class="{
                                            'badge-info':
                                                edit.status == 'lunas',
                                            'badge-error':
                                                edit.status == 'belum lunas',
                                        }"
                                    >
                                        {{ edit.status }}
                                    </div>
                                </td>
                            </tr>
                            <tr v-if="edit.bayar - edit.grand_total < 0">
                                <td>Sisa pembayaran</td>
                                <td>
                                    :
                                    {{ rupiah(edit.bayar - edit.grand_total) }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="flex justify-end gap-2">
                        <label
                            for="bayar"
                            class="btn"
                            v-if="edit.bayar - edit.grand_total < 0"
                        >
                            Bayar
                        </label>
                        <button class="btn btn-info gap-2">
                            <i class="fa fa-print"></i>Cetak
                        </button>
                    </div>
                </div>
                <table
                    class="w-full table table-compact table-zebra text-center"
                >
                    <thead>
                        <tr>
                            <td>No</td>
                            <td>Nama</td>
                            <td>Harga</td>
                            <td>Jumlah</td>
                            <td>Subtotal</td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr
                            v-for="(item, index) in edit.transaksi_detail"
                            :key="index"
                        >
                            <td>{{ index + 1 }}</td>
                            <td>{{ item.nama }}</td>
                            <td>{{ rupiah(item.harga_jual) }}</td>
                            <td>{{ item.jumlah }}</td>
                            <td>{{ rupiah(item.subtotal) }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </template>
    </modal-lg>
    <modal-md id="bayar">
        <template v-slot:title>Pembayaran </template>
        <template v-slot:content>
            <div class="form-control">
                <div class="grid grid-cols-12 gap-2">
                    <select
                        class="select select-bordered w-full col-span-3"
                        v-model="edit.lunas.jenis_pembayaran"
                    >
                        <option value="tunai">Tunai</option>
                        <option value="debit">Debit</option>
                    </select>
                    <input
                        type="text"
                        class="input input-bordered col-span-9"
                        v-model="edit.lunas.no_transaksi"
                        placeholder="No Transaksi..."
                        v-if="edit.lunas.jenis_pembayaran != 'tunai'"
                    />
                </div>
            </div>
            <div class="flex flex-col gap-2 border-2 rounded-xl py-5 mt-2 px-2">
                <div class="flex justify-center text-4xl font-bold">
                    {{ rupiah(edit.lunas.nominal) }}
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
                :disabled="edit.lunas.nominal <= 0"
                @click="push_pesanan"
            >
                Proses
            </button>
        </template>
    </modal-md>
</template>
<script>
import { Inertia } from "@inertiajs/inertia";
import { useForm } from "@inertiajs/inertia-vue3";

export default {
    props: {
        transaksi: Object,
    },
    watch: {
        "edit.lunas.jenis_pembayaran"() {
            this.edit.lunas.no_transaksi = null;
        },
    },
    setup(props) {
        const edit = useForm({
            id: null,
            kode_transaksi: null,
            jumlah: null,
            total: null,
            diskon: null,
            ppn: null,
            ppn_total: null,
            grand_total: null,
            jenis_pembayaran: null,
            no_transaksi: null,
            bayar: null,
            kembalian: null,
            nama_member: null,
            status: null,
            transaksi_detail: [],
            lunas: {
                jenis_pembayaran: "tunai",
                nominal: 0,
                no_transaksi: null,
                final: null,
            },
        });
        return { edit };
    },
    methods: {
        push_pesanan() {
            this.edit.put(
                route("transaksi.update", {
                    transaksi: this.edit.id,
                }),
                {
                    onSuccess: () => {
                        this.$swal({
                            icon: "success",
                            title:
                                "Kembalian " +
                                this.rupiah(
                                    this.edit.kembalian +
                                        this.edit.lunas.nominal
                                ),
                            text: "Transaksi berhasil disimpan",
                            confirmButtonText:
                                '<i class="fa fa-print"></i> Print!',
                            cancelButtonText: "Close",
                            showCancelButton: true,
                        });
                        Inertia.visit(route("transaksi.index"));
                    },
                }
            );
        },
        edit_transkasi(data) {
            this.edit.id = data.id;
            this.edit.kode_transaksi = data.kode_transaksi;
            this.edit.jumlah = data.jumlah;
            this.edit.total = data.total;
            this.edit.diskon = data.diskon;
            this.edit.ppn = data.ppn;
            this.edit.ppn_total = data.ppn_total;
            this.edit.grand_total = data.grand_total;
            this.edit.jenis_pembayaran = data.jenis_pembayaran;
            this.edit.no_transaksi = data.no_transaksi;
            this.edit.bayar = data.bayar;
            this.edit.kembalian = data.kembalian;
            this.edit.nama_member = data.nama_member;
            this.edit.transaksi_detail = data.transaksi_detail;
            this.edit.status = data.status;
        },
        button(data) {
            if (data == "pas") {
                this.edit.lunas.nominal = Math.abs(
                    this.edit.grand_total - this.edit.bayar
                );
            } else if (data == "clear") {
                this.edit.lunas.nominal = 0;
            } else if (data == "delete") {
                if (String(this.edit.lunas.nominal).length > 1) {
                    this.edit.lunas.nominal = parseInt(
                        String(this.edit.lunas.nominal).slice(
                            this.edit.lunas.nominal.length,
                            -1
                        )
                    );
                } else {
                    this.edit.lunas.nominal = 0;
                }
            } else {
                var bayar = String(this.edit.lunas.nominal);
                if (bayar == 0) {
                    this.edit.lunas.nominal = parseInt(data);
                } else {
                    this.edit.lunas.nominal = parseInt(
                        String(this.edit.lunas.nominal) + String(data)
                    );
                }
            }
        },
    },
};
</script>
<style lang=""></style>
