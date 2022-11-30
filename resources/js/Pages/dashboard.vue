<template lang="">
    <Navbar :toko="toko" :user="user" header>
        <template v-slot:title>Dahsboard</template>
        <template v-slot:content>
            <div class="flex flex-col w-full p-4">
                <div class="grid grid-cols-4 gap-8 uppercase">
                    <div
                        class="w-full shadow-lg p-4 border flex justify-center items-center flex-col rounded-[1rem]"
                    >
                        <div
                            class="text-content text-sm font-bold drop-shadow-lg"
                        >
                            total produk
                        </div>
                        <div
                            class="text-content text-2xl font-extrabold drop-shadow-lg"
                        >
                            {{ master.jumlah_produk }} item
                        </div>
                    </div>
                    <div
                        class="w-full shadow-lg p-4 border flex justify-center items-center flex-col rounded-[1rem]"
                    >
                        <div
                            class="text-content text-sm font-bold drop-shadow-lg"
                        >
                            total transaksi
                        </div>
                        <div
                            class="text-content text-2xl font-extrabold drop-shadow-lg"
                        >
                            {{ rupiah(master.total_transaksi) }}
                        </div>
                    </div>
                    <div
                        class="w-full shadow-lg p-4 border flex justify-center items-center flex-col rounded-[1rem]"
                    >
                        <div
                            class="text-content text-sm font-bold drop-shadow-lg"
                        >
                            total pengeluaran
                        </div>
                        <div
                            class="text-content text-2xl font-extrabold drop-shadow-lg"
                        >
                            {{ rupiah(master.total_pengeluaran) }}
                        </div>
                    </div>
                    <div
                        class="w-full shadow-lg p-4 border flex justify-center items-center flex-col rounded-[1rem]"
                    >
                        <div
                            class="text-content text-sm font-bold drop-shadow-lg"
                        >
                            hutang member
                        </div>
                        <div
                            class="text-content text-2xl font-extrabold drop-shadow-lg"
                        >
                            {{ rupiah(master.hutang_member) }}
                        </div>
                    </div>
                    <div class="col-span-4 p-5 flex flex-col shadow-lg border">
                        <div class="text-center font-bold text-2xl">
                            Statistik Penjualan
                        </div>
                        <div class="w-max flex gap-2">
                            <div class="flex gap-2 items-center">
                                <div class="font-semibold">Dari</div>
                                <div class="">
                                    <input
                                        type="date"
                                        v-model="transaksi.transaksi_start"
                                        class="input input-bordered input-sm"
                                    />
                                </div>
                            </div>
                            <div class="flex gap-2 items-center">
                                <div class="font-semibold">sampai</div>
                                <div class="">
                                    <input
                                        type="date"
                                        v-model="transaksi.transaksi_end"
                                        class="input input-bordered input-sm"
                                    />
                                </div>
                            </div>
                        </div>
                        <apexchart
                            width="100%"
                            height="250"
                            type="bar"
                            :options="transaksi.options"
                            :series="transaksi.series"
                        ></apexchart>
                    </div>
                </div>
            </div>
        </template>
    </Navbar>
</template>
<script>
import { Inertia } from "@inertiajs/inertia";

export default {
    props: {
        user: Object,
        toko: Object,
        master: Object,
    },
    data() {
        return {
            transaksi: {
                options: {
                    chart: {
                        id: "transaksi",
                    },
                    xaxis: {
                        type: "datetime",
                        categories: this.master.chart_transaksi.categories,
                    },
                },
                series: [
                    {
                        name: "Penjualan",
                        data: this.master.chart_transaksi.chart_data,
                    },
                ],
                transaksi_start: this.master.chart_transaksi.transaksi_start,
                transaksi_end: this.master.chart_transaksi.transaksi_end,
            },
        };
    },
    watch: {
        "transaksi.transaksi_start"() {
            Inertia.visit(
                route("dashboard.index", {
                    transaksi_start: this.transaksi.transaksi_start,
                    transaksi_end: this.transaksi.transaksi_end,
                }),
                {
                    preserveScroll: true,
                }
            );
        },
        "transaksi.transaksi_end"() {
            Inertia.visit(
                route("dashboard.index", {
                    transaksi_start: this.transaksi.transaksi_start,
                    transaksi_end: this.transaksi.transaksi_end,
                }),
                {
                    preserveScroll: true,
                }
            );
        },
    },
};
</script>
