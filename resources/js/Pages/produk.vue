<template lang="">
    <navbar :toko="toko" header :success="success" :user="user">
        <template v-slot:title> Produk </template>
        <template v-slot:title_left>
            <label for="tambah" class="btn btn-sm btn-success">
                <i class="fa fa-plus"></i>
            </label>
        </template>
        <template v-slot:content>
            <div class="flex flex-col gap-2 w-full">
                <div class="flex justify-between w-full">
                    <div class="form-control">
                        <div class="input-group">
                            <input
                                type="text"
                                v-model="input_cari"
                                placeholder="Search…"
                                class="input input-bordered"
                            />
                            <button class="btn btn-square" @click="get_data()">
                                <i class="fa fa-search"></i>
                            </button>
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                        <h1>Tampilkan</h1>
                        <select
                            class="select select-bordered"
                            v-model="input_show"
                            @change="get_data()"
                        >
                            <option value="5">5</option>
                            <option value="10">10</option>
                            <option value="20">20</option>
                        </select>
                        <h1>Baris</h1>
                    </div>
                </div>
                <table
                    class="table table-compact w-full text-center table-zebra capitalize"
                >
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>kategori</th>
                            <th>harga beli</th>
                            <th>harga jual</th>
                            <th>stok</th>
                            <th>satuan</th>
                            <th>opsi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="item in produk.data">
                            <th>{{ item.nama }}</th>
                            <td>
                                {{
                                    item.kategori ? item.kategori.kategori : ""
                                }}
                            </td>
                            <td>{{ rupiah(item.harga_beli) }}</td>
                            <td>{{ rupiah(item.harga_jual) }}</td>
                            <td>{{ item.stok }}</td>
                            <td>{{ item.satuan ? item.satuan.satuan : "" }}</td>
                            <td class="flex justify-center gap-2">
                                <label
                                    for="edit"
                                    class="btn btn-sm btn-info"
                                    @click="get_edit(item)"
                                >
                                    <i class="fa fa-pen"></i>
                                </label>
                                <label
                                    for="hapus"
                                    class="btn btn-sm btn-error"
                                    @click="get_hapus(item)"
                                >
                                    <i class="fa fa-trash"></i>
                                </label>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="btn-group gap-1 flex justify-center">
                    <template v-for="item in produk.links">
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
        <template v-slot:title>Tambah Produk</template>
        <template v-slot:content>
            <div class="form-control w-full">
                <label class="label">
                    <span class="label-text">Nama</span>
                </label>
                <input
                    type="text"
                    v-model="tambah.nama"
                    placeholder="Nama Produk"
                    class="input input-bordered w-full"
                />
                <label class="label">
                    <span
                        class="label-text-alt text-error"
                        v-if="tambah.errors.nama"
                        >{{ tambah.errors.nama }}</span
                    >
                </label>
            </div>
            <div class="grid grid-cols-2 gap-2">
                <div class="form-control w-full">
                    <label class="label">
                        <span class="label-text">Kategori</span>
                    </label>
                    <select
                        class="select select-bordered w-full"
                        v-model="tambah.kategori_id"
                    >
                        <option :value="item.id" v-for="item in kategori">
                            {{ item.kategori }}
                        </option>
                    </select>
                    <label class="label">
                        <span
                            class="label-text-alt text-error"
                            v-if="tambah.errors.kategori_id"
                            >{{ tambah.errors.kategori_id }}</span
                        >
                    </label>
                </div>
                <div class="form-control w-full">
                    <label class="label">
                        <span class="label-text">Satuan</span>
                    </label>
                    <select
                        class="select select-bordered w-full"
                        v-model="tambah.satuan_id"
                    >
                        <option :value="item.id" v-for="item in satuan">
                            {{ item.satuan }}
                        </option>
                    </select>
                    <label class="label">
                        <span
                            class="label-text-alt text-error"
                            v-if="tambah.errors.satuan_id"
                            >{{ tambah.errors.satuan_id }}</span
                        >
                    </label>
                </div>
            </div>
            <div class="form-control w-full">
                <label class="label">
                    <span class="label-text"
                        >Harga Beli : {{ rupiah(tambah.harga_beli) }}</span
                    >
                </label>
                <input
                    type="number"
                    v-model="tambah.harga_beli"
                    placeholder="Harga Beli..."
                    class="input input-bordered w-full"
                />
                <label class="label">
                    <span
                        class="label-text-alt text-error"
                        v-if="tambah.errors.harga_beli"
                        >{{ tambah.errors.harga_beli }}</span
                    >
                </label>
            </div>
            <div class="form-control w-full">
                <label class="label">
                    <span class="label-text"
                        >Harga Jual : {{ rupiah(tambah.harga_jual) }}</span
                    >
                </label>
                <input
                    type="number"
                    v-model="tambah.harga_jual"
                    placeholder="Harga Jual..."
                    class="input input-bordered w-full"
                />
                <label class="label">
                    <span
                        class="label-text-alt text-error"
                        v-if="tambah.errors.harga_jual"
                        >{{ tambah.errors.harga_jual }}</span
                    >
                </label>
            </div>
            <div class="form-control w-full">
                <label class="label">
                    <span class="label-text">Stok</span>
                </label>
                <input
                    type="number"
                    v-model="tambah.stok"
                    placeholder="Stok..."
                    class="input input-bordered w-full"
                />
                <label class="label">
                    <span
                        class="label-text-alt text-error"
                        v-if="tambah.errors.stok"
                        >{{ tambah.errors.stok }}</span
                    >
                </label>
            </div>
        </template>
        <template v-slot:action>
            <button
                class="btn btn-success"
                :class="{ loading: tambah.processing }"
                :disabled="tambah.processing"
                @click="submit_tambah"
            >
                Tambah
            </button>
        </template>
    </modal-md>

    <modal-md id="edit">
        <template v-slot:title>Edit Produk</template>
        <template v-slot:content>
            <div class="form-control w-full">
                <label class="label">
                    <span class="label-text">Nama</span>
                </label>
                <input
                    type="text"
                    v-model="edit.nama"
                    placeholder="Nama Produk"
                    class="input input-bordered w-full"
                />
                <label class="label">
                    <span
                        class="label-text-alt text-error"
                        v-if="edit.errors.nama"
                        >{{ edit.errors.nama }}</span
                    >
                </label>
            </div>
            <div class="grid grid-cols-2 gap-2">
                <div class="form-control w-full">
                    <label class="label">
                        <span class="label-text">Kategori</span>
                    </label>
                    <select
                        class="select select-bordered w-full"
                        v-model="edit.kategori_id"
                    >
                        <option :value="item.id" v-for="item in kategori">
                            {{ item.kategori }}
                        </option>
                    </select>
                    <label class="label">
                        <span
                            class="label-text-alt text-error"
                            v-if="edit.errors.kategori_id"
                            >{{ edit.errors.kategori_id }}</span
                        >
                    </label>
                </div>
                <div class="form-control w-full">
                    <label class="label">
                        <span class="label-text">Satuan</span>
                    </label>
                    <select
                        class="select select-bordered w-full"
                        v-model="edit.satuan_id"
                    >
                        <option :value="item.id" v-for="item in satuan">
                            {{ item.satuan }}
                        </option>
                    </select>
                    <label class="label">
                        <span
                            class="label-text-alt text-error"
                            v-if="edit.errors.satuan_id"
                            >{{ edit.errors.satuan_id }}</span
                        >
                    </label>
                </div>
            </div>
            <div class="form-control w-full">
                <label class="label">
                    <span class="label-text"
                        >Harga : {{ rupiah(edit.harga_beli) }}</span
                    >
                </label>
                <input
                    type="number"
                    v-model="edit.harga_beli"
                    placeholder="Harga Beli..."
                    class="input input-bordered w-full"
                />
                <label class="label">
                    <span
                        class="label-text-alt text-error"
                        v-if="edit.errors.harga_beli"
                        >{{ edit.errors.harga_beli }}</span
                    >
                </label>
            </div>
            <div class="form-control w-full">
                <label class="label">
                    <span class="label-text"
                        >Harga : {{ rupiah(edit.harga_jual) }}</span
                    >
                </label>
                <input
                    type="number"
                    v-model="edit.harga_jual"
                    placeholder="Harga Jual..."
                    class="input input-bordered w-full"
                />
                <label class="label">
                    <span
                        class="label-text-alt text-error"
                        v-if="edit.errors.harga_jual"
                        >{{ edit.errors.harga_jual }}</span
                    >
                </label>
            </div>
            <div class="form-control w-full">
                <label class="label">
                    <span class="label-text">Stok</span>
                </label>
                <input
                    type="number"
                    v-model="edit.stok"
                    placeholder="Stok..."
                    class="input input-bordered w-full"
                />
                <label class="label">
                    <span
                        class="label-text-alt text-error"
                        v-if="edit.errors.stok"
                        >{{ edit.errors.stok }}</span
                    >
                </label>
            </div>
        </template>
        <template v-slot:action>
            <button
                class="btn btn-success"
                :class="{ loading: edit.processing }"
                :disabled="edit.processing"
                @click="submit_edit"
            >
                edit
            </button>
        </template>
    </modal-md>

    <modal-md id="hapus">
        <template v-slot:title
            >Konfirmasi penghapusan produk {{ hapus.nama }}</template
        >
        <template v-slot:action>
            <button
                class="btn btn-error"
                :class="{ loading: hapus.processing }"
                :disabled="hapus.processing"
                @click="submit_hapus"
            >
                Konfirmasi
            </button>
        </template>
    </modal-md>
</template>
<script>
import { useForm } from "@inertiajs/inertia-vue3";

export default {
    props: {
        produk: Object,
        kategori: Object,
        satuan: Object,
        toko: Object,
    },
    setup() {
        const hapus = useForm({
            id: null,
            nama: null,
        });
        const tambah = useForm({
            nama: null,
            kategori_id: null,
            harga_beli: null,
            harga_jual: null,
            stok: null,
            satuan_id: null,
        });
        const edit = useForm({
            id: null,
            nama: null,
            kategori_id: null,
            harga_beli: null,
            harga_jual: null,
            stok: null,
            satuan_id: null,
        });
        return {
            hapus,
            tambah,
            edit,
        };
    },
    methods: {
        submit_tambah() {
            this.tambah.post(route("produk.store"), {
                onSuccess: () => {
                    this.close_modal("tambah");
                    this.notifikasi("Produk Berhasil Ditambahkan");
                    this.tambah.reset();
                },
            });
        },
        get_hapus(data) {
            this.hapus.id = data.id;
            this.hapus.nama = data.nama;
        },
        get_edit(data) {
            this.edit.id = data.id;
            this.edit.nama = data.nama;
            this.edit.kategori_id = data.kategori_id;
            this.edit.satuan_id = data.satuan_id;
            this.edit.stok = data.stok;
            this.edit.harga_beli = data.harga_beli;
            this.edit.harga_jual = data.harga_jual;
        },
        submit_hapus() {
            const { id } = this.hapus;
            this.hapus.delete(
                route("produk.destroy", {
                    produk: id,
                }),
                {
                    onSuccess: () => {
                        this.close_modal("hapus");
                        this.hapus.reset();
                        this.notifikasi("Produk berhasil dihapus");
                    },
                }
            );
        },
        submit_edit() {
            const { id } = this.edit;
            this.edit.put(
                route("produk.update", {
                    produk: id,
                }),
                {
                    onSuccess: () => {
                        this.close_modal("edit");
                        this.edit.reset();
                        this.notifikasi("Produk berhasil diedit");
                    },
                }
            );
        },
    },
};
</script>
<style lang=""></style>
