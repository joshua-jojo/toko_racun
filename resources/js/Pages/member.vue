<template lang="">
    <navbar :toko="toko" header :success="success" :user="user">
        <template v-slot:title> Member </template>
        <template v-slot:title_left>
            <label for="tambah" class="btn btn-sm btn-success">
                <i class="fa fa-plus"></i>
            </label>
            <modal-md id="tambah">
                <template v-slot:title> Tambah Member </template>
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
                                @click="get_member()"
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
                            @change="get_member()"
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
                        <tr v-for="(item, index) in member.data" :key="index">
                            <td>{{ item.nama }}</td>
                            <td>{{ item.alamat }}</td>
                            <td>{{ item.telp }}</td>
                            <td>
                                <div class="flex justify-center gap-2">
                                    <label
                                        @click="edit_member(item)"
                                        class="btn btn-sm btn-info"
                                        for="edit"
                                    >
                                        <i class="fa fa-pen"></i>
                                    </label>
                                    <label
                                        @click="hapus_member(item)"
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
                    <template v-for="item in member.links">
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
        <template v-slot:title> Edit Member {{ edit.nama }}</template>
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
            Konfirmasi hapus member {{ hapus.nama }}
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
        member: Object,
        toko: Object,
    },
    setup(props) {
        const tambah = useForm({
            nama: null,
            alamat: null,
            telp: null,
            diskon: null,
        });
        const edit = useForm({
            id: null,
            nama: null,
            alamat: null,
            telp: null,
            diskon: null,
        });
        const hapus = useForm({
            id: null,
            nama: null,
            alamat: null,
            telp: null,
            diskon: null,
        });
        return {
            tambah,
            edit,
            hapus,
        };
    },
    methods: {
        submit_tambah() {
            this.tambah.post(route("member.store"), {
                onSuccess: () => {
                    this.close_modal("tambah");
                    this.tambah.reset();
                    this.notifikasi("Member berhasil ditambahkan");
                },
            });
        },
        edit_member(data) {
            this.edit.nama = data.nama;
            this.edit.alamat = data.alamat;
            this.edit.telp = data.telp;
            this.edit.diskon = data.diskon;
            this.edit.id = data.id;
        },
        submit_edit() {
            const { id } = this.edit;
            this.edit.put(
                route("member.update", {
                    member: id,
                }),
                {
                    onSuccess: () => {
                        this.close_modal("edit");
                        this.edit.reset();
                        this.notifikasi("Member berhasil diedit");
                    },
                }
            );
        },
        hapus_member(data) {
            this.hapus.nama = data.nama;
            this.hapus.alamat = data.alamat;
            this.hapus.telp = data.telp;
            this.hapus.diskon = data.diskon;
            this.hapus.id = data.id;
        },
        submit_hapus() {
            const { id } = this.hapus;
            this.hapus.delete(
                route("member.destroy", {
                    member: id,
                }),
                {
                    onSuccess: () => {
                        this.close_modal("hapus");
                        this.hapus.reset();
                        this.notifikasi("Member berhasil dihapus");
                    },
                }
            );
        },
    },
};
</script>
<style lang=""></style>
