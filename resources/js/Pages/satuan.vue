<template lang="">
    <Navbar :toko="toko" header :user="user" :success="success">
        <template v-slot:title> satuan </template>
        <template v-slot:title_left>
            <label for="tambah" class="btn btn-sm btn-success">
                <i class="fa fa-plus"></i>
            </label>
        </template>
        <template v-slot:content>
            <table class="table table-zebra w-full text-center table-compact">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Opsi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr
                        v-for="(item, index) in satuan"
                        :key="index"
                        v-if="satuan.length"
                    >
                        <td>{{ item.satuan }}</td>
                        <td class="flex justify-center gap-2">
                            <label
                                @click="get_satuan(item)"
                                for="list"
                                class="btn btn-sm btn-info"
                            >
                                <i class="fa fa-list"></i>
                            </label>
                            <label
                                @click="get_satuan(item)"
                                for="hapus"
                                class="btn btn-sm btn-error"
                            >
                                <i class="fa fa-trash"></i>
                            </label>
                        </td>
                    </tr>
                    <tr v-else>
                        <td colspan="2" class="capitalize">tidak ada data</td>
                    </tr>
                </tbody>
            </table>
        </template>
    </Navbar>

    <modal-md id="list">
        <template v-slot:title>Daftar Produk</template>
        <template v-slot:content>
            <table class="table table-compact table-zebra w-full text-center">
                <thead>
                    <tr>
                        <th>Produk</th>
                        <th>Satuan</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="item in hapus.produk">
                        <td>{{ item.nama }}</td>
                        <td>{{ item.satuan.satuan }}</td>
                    </tr>
                </tbody>
            </table>
        </template>
    </modal-md>

    <!-- modal hapus -->
    <modal-md id="hapus">
        <template v-slot:title
            >Konfirmasi Penghapusan Satuan {{ hapus.satuan }}!</template
        >
        <template v-slot:action>
            <button
                class="btn btn-error"
                @click="submit_hapus"
                :class="{ loading: hapus.processing }"
                :disabled="hapus.processing"
            >
                Konfirmasi
            </button>
        </template>
    </modal-md>
    <!-- modal tambah -->
    <modal-md id="tambah">
        <template v-slot:title>Tambah Satuan</template>
        <template v-slot:content>
            <div class="form-control">
                <label class="label">
                    <span class="label-text">Nama Satuan</span>
                </label>
                <input
                    type="text"
                    placeholder="satuan"
                    v-model="tambah.satuan"
                    class="input input-bordered w-full"
                />
                <label class="label">
                    <span
                        class="label-text-alt text-error"
                        v-if="tambah.errors.satuan"
                        >{{ tambah.errors.satuan }}</span
                    >
                </label>
            </div>
        </template>
        <template v-slot:action>
            <button
                class="btn btn-success"
                @click="submit_tambah"
                :class="{ loading: tambah.processing }"
                :disabled="tambah.processing"
            >
                simpan
            </button>
        </template>
    </modal-md>
</template>
<script>
import { useForm } from "@inertiajs/inertia-vue3";

export default {
    props: {
        satuan: Array,
        toko: Object,
    },
    setup() {
        const tambah = useForm({
            satuan: null,
        });
        const hapus = useForm({
            id: null,
            satuan: null,
            produk: null,
        });
        return {
            tambah,
            hapus,
        };
    },
    methods: {
        submit_tambah() {
            this.tambah.post(route("satuan.store"), {
                onSuccess: () => {
                    this.close_modal("tambah");
                    this.notifikasi("Satuan berhasil ditambahkan");
                    this.tambah.reset();
                },
            });
        },
        get_satuan(data) {
            this.hapus.id = data.id;
            this.hapus.satuan = data.satuan;
            this.hapus.produk = data.produk;
        },
        submit_hapus() {
            const { id } = this.hapus;
            this.hapus.delete(
                route("satuan.destroy", {
                    satuan: id,
                }),
                {
                    onSuccess: () => {
                        this.close_modal("hapus");
                        this.notifikasi("Satuan berhasil dihapus");
                    },
                }
            );
        },
    },
};
</script>
<style lang=""></style>
