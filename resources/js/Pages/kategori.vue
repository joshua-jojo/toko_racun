<template lang="">
    <title>123</title>
    <navbar header :success="success">
        <template v-slot:title>Kategori</template>
        <template v-slot:title_left>
            <label for="tambah" class="btn btn-sm btn-success">
                <i class="fa fa-plus"></i>
            </label>
        </template>
        <template v-slot:content>
            <table class="table table-compact table-zebra w-full text-center">
                <thead>
                    <tr>
                        <td>Kategori</td>
                        <td>Opsi</td>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(item, index) in kategori" :key="index">
                        <td>{{ item.kategori }}</td>
                        <td class="flex justify-center gap-2">
                            <label for="list" class="btn btn-sm btn-info" @click="get_kategori(item)">
                                <i class="fa fa-list"></i>
                            </label>
                            <label for="hapus" class="btn btn-sm btn-error" @click="get_kategori(item)">
                                <i class="fa fa-trash"></i>
                            </label>
                        </td>
                    </tr>
                </tbody>
            </table>
        </template>
    </navbar>
    
    <modal-md id="list">
        <template v-slot:title>Daftar Produk</template>
        <template v-slot:content>
            <table class="table table-compact table-zebra w-full text-center">
                <thead>
                    <tr>
                        <th>Produk</th>
                        <th>Kategori</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="item in hapus.produk">
                        <td>{{item.nama}}</td>
                        <td>{{item.kategori.kategori}}</td>
                    </tr>
                </tbody>
            </table>
        </template>
    </modal-md>

    <modal-md id="hapus">
        <template v-slot:title
            >Konfirmasi Penghapusan Kategori {{ hapus.kategori }}!</template
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
    <modal-md id="tambah">
        <template v-slot:title>Tambah Kategori</template>
        <template v-slot:content>
            <div class="form-control w-full">
                <label class="label">
                    <span class="label-text">Nama Kategori</span>
                </label>
                <input
                    type="text"
                    v-model="tambah.kategori"
                    placeholder="Kategori"
                    class="input input-bordered w-full"
                />
                <label class="label">
                    <span
                        class="label-text-alt text-error"
                        v-if="tambah.errors.kategori"
                        >{{ tambah.errors.kategori }}</span
                    >
                </label>
            </div>
        </template>
        <template v-slot:action>
            <button
                class="btn btn-success"
                :disabled="tambah.processing"
                :class="{ loading: tambah.processing }"
                @click="submit_tambah"
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
        kategori: Array,
    },
    setup(props) {
        const tambah = useForm({
            kategori: null,
        });
        const hapus = useForm({
            id: null,
            kategori: null,
            produk: null,
        });
        return {
            tambah,
            hapus,
        };
    },
    methods: {
        get_kategori(data){
            this.hapus.id = data.id
            this.hapus.kategori = data.kategori
            this.hapus.produk = data.produk
        },
        submit_hapus(){
            const {id} = this.hapus
            this.hapus.delete(route('kategori.destroy',{
                kategori:id
            }),{
                onSuccess: ()=>{
                    this.notifikasi('Kategori Berhasil Dihapus')
                    this.close_modal('hapus')
                    this.hapus.reset()
                }
            })
        },
        submit_tambah() {
            this.tambah.post(route("kategori.store"), {
                onSuccess: () => {
                    this.notifikasi("Kategori Berhasil Disimpan");
                    this.close_modal("tambah");
                    this.tambah.reset()
                },
            });
        },
    },
};
</script>
<style lang=""></style>
