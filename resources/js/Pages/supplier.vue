<template lang="">
    <navbar header :success="success">
        <template v-slot:title> Supplier </template>
        <template v-slot:title_left>
            <label for="tambah" class="btn btn-sm btn-success">
                <i class="fa fa-plus"></i>
            </label>
            <modal-md id="tambah">
                <template v-slot:title> Tambah Supplier </template>
                <template v-slot:content>
                    <div class="flex gap-2">
                        <div class="form-control">
                            <label class="label">
                                <span class="label-text">Nama</span>
                            </label>
                            <input
                                type="text"
                                placeholder="Nama"
                                v-model="tambah.nama"
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
                        <div class="form-control">
                            <label class="label">
                                <span class="label-text">Telp</span>
                            </label>
                            <input
                                type="text"
                                placeholder="Telp"
                                v-model="tambah.telp"
                                class="input input-bordered w-full"
                            />
                            <label class="label">
                                <span
                                    class="label-text-alt text-error"
                                    v-if="tambah.errors.telp"
                                    >{{ tambah.errors.telp }}</span
                                >
                            </label>
                        </div>
                    </div>
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Alamat</span>
                        </label>
                        <input
                            type="text"
                            placeholder="Alamat"
                            v-model="tambah.alamat"
                            class="input input-bordered w-full"
                        />
                        <label class="label">
                            <span
                                class="label-text-alt text-error"
                                v-if="tambah.errors.alamat"
                                >{{ tambah.errors.alamat }}</span
                            >
                        </label>
                    </div>
                </template>
                <template v-slot:action>
                    <button
                        class="btn btn-success"
                        @click="submit_tambah"
                        :disabled="tambah.processing"
                        :class="{ loading: tambah.processing }"
                    >
                        tambah
                    </button>
                </template>
            </modal-md>
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
                                @click="get_supplier()"
                            >
                                <i class="fa fa-search"></i>
                            </button>
                        </div>
                    </div>
                    <div class="flex gap-1">
                        <label class="label">Tampilkan </label>
                        <select
                            class="w-max select select-bordered"
                            v-model="input_show"
                            @change="get_supplier()"
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
                            <td>Nama</td>
                            <td>Alamat</td>
                            <td>Telp</td>
                            <td>aksi</td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(item, index) in supplier.data" :key="index">
                            <td>{{ item.nama }}</td>
                            <td>{{ item.alamat }}</td>
                            <td>{{ item.telp }}</td>
                            <td>
                                <div class="flex justify-center gap-2">
                                    <label
                                        @click="edit_supplier(item)"
                                        class="btn btn-sm btn-info"
                                        for="edit"
                                    >
                                        <i class="fa fa-pen"></i>
                                    </label>
                                    <label
                                        @click="hapus_supplier(item)"
                                        class="btn btn-sm btn-error"
                                        for="hapus"
                                    >
                                        <i class="fa fa-trash"></i>
                                    </label>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="btn-group gap-1 flex justify-center">
                    <template v-for="item in supplier.links">
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
    <modal-md id="edit">
        <template v-slot:title> Edit Supplier {{ edit.nama }}</template>
        <template v-slot:content>
            <div class="flex gap-2">
                <div class="form-control">
                    <label class="label">
                        <span class="label-text">Nama</span>
                    </label>
                    <input
                        type="text"
                        placeholder="Nama"
                        v-model="edit.nama"
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
                <div class="form-control">
                    <label class="label">
                        <span class="label-text">Telp</span>
                    </label>
                    <input
                        type="text"
                        placeholder="Telp"
                        v-model="edit.telp"
                        class="input input-bordered w-full"
                    />
                    <label class="label">
                        <span
                            class="label-text-alt text-error"
                            v-if="edit.errors.telp"
                            >{{ edit.errors.telp }}</span
                        >
                    </label>
                </div>
            </div>
            <div class="form-control">
                <label class="label">
                    <span class="label-text">Alamat</span>
                </label>
                <input
                    type="text"
                    placeholder="Alamat"
                    v-model="edit.alamat"
                    class="input input-bordered w-full"
                />
                <label class="label">
                    <span
                        class="label-text-alt text-error"
                        v-if="edit.errors.alamat"
                        >{{ edit.errors.alamat }}</span
                    >
                </label>
            </div>
        </template>
        <template v-slot:action>
            <button
                class="btn btn-success"
                @click="submit_edit"
                :disabled="edit.processing"
                :class="{ loading: edit.processing }"
            >
                edit
            </button>
        </template>
    </modal-md>
    <modal-md id="hapus">
        <template v-slot:title>
            Konfirmasi hapus supplier {{ hapus.nama }}
        </template>
        <template v-slot:action>
            <button
                class="btn btn-error"
                :disabled="hapus.processing"
                :class="{ loading: hapus.processing }"
                @click="submit_hapus()"
            >
                konfirmasi
            </button>
        </template>
    </modal-md>
</template>
<script>
import { useForm } from "@inertiajs/inertia-vue3";

export default {
    props: {
        supplier: Object,
    },
    setup(props) {
        const tambah = useForm({
            nama: null,
            alamat: null,
            telp: null,
        });
        const edit = useForm({
            id: null,
            nama: null,
            alamat: null,
            telp: null,
        });
        const hapus = useForm({
            id: null,
            nama: null,
            alamat: null,
            telp: null,
        });
        return {
            tambah,
            edit,
            hapus,
        };
    },
    methods: {
        submit_tambah() {
            this.tambah.post(route("supplier.store"), {
                onSuccess: () => {
                    this.close_modal("tambah");
                    this.tambah.reset();
                    this.notifikasi("supplier berhasil ditambahkan");
                },
            });
        },
        edit_supplier(data) {
            this.edit.nama = data.nama;
            this.edit.alamat = data.alamat;
            this.edit.telp = data.telp;
            this.edit.id = data.id;
        },
        submit_edit() {
            const { id } = this.edit;
            this.edit.put(
                route("supplier.update", {
                    supplier: id,
                }),
                {
                    onSuccess: () => {
                        this.close_modal("edit");
                        this.edit.reset();
                        this.notifikasi("supplier berhasil diedit");
                    },
                }
            );
        },
        hapus_supplier(data) {
            this.hapus.nama = data.nama;
            this.hapus.alamat = data.alamat;
            this.hapus.telp = data.telp;
            this.hapus.id = data.id;
        },
        submit_hapus() {
            const { id } = this.hapus;
            this.hapus.delete(
                route("supplier.destroy", {
                    supplier: id,
                }),
                {
                    onSuccess: () => {
                        this.close_modal("hapus");
                        this.hapus.reset();
                        this.notifikasi("supplier berhasil dihapus");
                    },
                }
            );
        },
    },
};
</script>
<style lang=""></style>
