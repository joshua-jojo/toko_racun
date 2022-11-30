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
                </div>
            </div>
        </template>
    </Navbar>
</template>
<script>
export default {
    props: {
        user: Object,
        toko: Object,
        master: Object,
    },
};
</script>
<style lang=""></style>
