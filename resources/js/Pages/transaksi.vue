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
                            <td>
                                <div class="flex justify-center gap-2">
                                    <label
                                        class="btn btn-sm btn-info"
                                        for="detail"
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
        <template v-slot:title>defaultcontent</template>
        <template v-slot:content>
            <div class="h-full w-full flex flex-col">
                <table class="w-max">
                    <tbody>
                        <tr>
                            <td>Kode Transaksi</td>
                            <td>: 2343</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </template>
    </modal-lg>
</template>
<script>
export default {
    props: {
        transaksi: Object,
    },
};
</script>
<style lang=""></style>
