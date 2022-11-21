<template lang="">
    <navbar header :success="success">
        <template v-slot:title>Pengeluaran</template>
        <template v-slot:title_left>
            <label for="tambah" class="btn btn-sm btn-success">
                <i class="fa fa-plus"></i>
            </label>
        </template>
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
                                @click="get_pengeluaran()"
                            >
                                <i class="fa fa-search"></i>
                            </button>
                        </div>
                    </div>
                    <div class="flex gap-2">
                        <div class="flex gap-1">
                            <label class="label">Dari</label>
                            <input
                                @change="get_pengeluaran"
                                type="date"
                                class="input input-bordered"
                                v-model="input_range.dari"
                            />
                        </div>
                        <div class="flex gap-1">
                            <label class="label">Sampai</label>
                            <input
                                @change="get_pengeluaran"
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
                            @change="get_pengeluaran()"
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
                            <td>Nominal</td>
                            <td>Keterangan</td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr
                            v-for="(item, index) in pengeluaran.data"
                            :key="index"
                        >
                            <td>{{ item.waktu }}</td>
                            <td>{{ rupiah(item.nominal) }}</td>
                            <td>
                                <div class="flex justify-center gap-2">
                                    <label class="btn btn-sm btn-info">
                                        <i class="fa fa-list"></i>
                                    </label>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="btn-group gap-1 flex justify-center">
                    <template v-for="item in pengeluaran.links">
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
        <template v-slot:title>Tambah Pengeluaran</template>
        <template v-slot:content>
            <div class="flex gap-2">
                <div class="form-control w-max">
                    <label class="label"> Tanggal </label>
                    <input
                        type="date"
                        class="input input-bordered"
                        v-model="tambah.tanggal"
                    />
                    <label
                        v-if="tambah.errors.tanggal"
                        class="label-text text-red-500"
                    >
                        {{ tambah.errors.tanggal }}</label
                    >
                </div>
                <div class="form-control w-full">
                    <label class="label">
                        Nominal : {{ rupiah(tambah.nominal) }}</label
                    >
                    <input
                        type="number"
                        class="input input-bordered"
                        placeholder="nominal..."
                        v-model="tambah.nominal"
                    />
                    <label
                        v-if="tambah.errors.nominal"
                        class="label-text text-red-500"
                    >
                        {{ tambah.errors.nominal }}</label
                    >
                </div>
            </div>
            <div class="form-control">
                <label class="label"> Keterangan</label>
                <textarea
                    v-model="tambah.keterangan"
                    class="textarea textarea-bordered"
                    placeholder="keterangan"
                ></textarea>
                <label
                    v-if="tambah.errors.keterangan"
                    class="label-text text-red-500"
                >
                    {{ tambah.errors.keterangan }}</label
                >
            </div>
        </template>
        <template v-slot:action>
            <button
                class="btn btn-success"
                @click="submit_tambah"
                :disabled="tambah.processing"
                :class="{ loading: tambah.processing }"
            >
                Simpan
            </button>
        </template>
    </modal-md>
</template>
<script>
import { useForm } from "@inertiajs/inertia-vue3";

export default {
    props: {
        pengeluaran: Object,
    },
    setup() {
        const tambah = useForm({
            tanggal: null,
            nominal: null,
            keterangan: null,
        });
        return {
            tambah,
        };
    },
    methods: {
        submit_tambah() {
            this.tambah.post(route("pengeluaran.store"), {
                onSuccess: () => {
                    this.close_modal("tambah");
                    this.notifikasi("Pengeluaran Berhasil Ditambahkan");
                    this.tambah.reset();
                },
            });
        },
    },
};
</script>
<style lang=""></style>
