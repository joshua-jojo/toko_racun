<template lang="">
    <Navbar header :user="user" :toko="toko" :success="success">
        <template v-slot:title>Settings</template>
        <template v-slot:content>
            <div class="flex justify-center w-full">
                <div class="grid w-max grid-cols-3 gap-5 justify-items-center">
                    <label
                        for="toko"
                        @click="get_toko(toko)"
                        class="w-[20rem] h-[8rem] bg-primary rounded-[2rem] hover:scale-105 transition-all ease-in-out duration-300 flex justify-center items-center text-white uppercase font-bold text-2xl gap-3 shadow-sm drop-shadow-lg select-none"
                    >
                        <i class="fa fa-gear"></i>
                        Toko
                    </label>
                    <label
                        for="profil"
                        @click="get_user(user)"
                        class="w-[20rem] h-[8rem] bg-primary rounded-[2rem] hover:scale-105 transition-all ease-in-out duration-300 flex justify-center items-center text-white uppercase font-bold text-2xl gap-3 shadow-sm drop-shadow-lg select-none"
                    >
                        <i class="fa fa-user"></i>
                        Profil
                    </label>
                    <label
                        for="laporan"
                        class="w-[20rem] h-[8rem] bg-primary rounded-[2rem] hover:scale-105 transition-all ease-in-out duration-300 flex justify-center items-center text-white uppercase font-bold text-xl gap-3 shadow-sm drop-shadow-lg select-none"
                    >
                        <i class="fa fa-list"></i>
                        Laporan Penjualan
                    </label>
                </div>
            </div>
        </template>
    </Navbar>
    <modal-md id="toko">
        <template v-slot:title>Settings Toko</template>
        <template v-slot:content>
            <div class="grid grid-cols-2 gap-2">
                <div class="form-control">
                    <label class="label">
                        <span class="label-text">Nama Toko</span>
                    </label>
                    <input
                        type="text"
                        class="input input-bordered"
                        placeholder="Nama Toko ..."
                        v-model="toko_update.nama"
                    />
                    <label class="label">
                        <span
                            class="label-text text-error"
                            v-if="toko_update.errors.nama"
                            >{{ toko_update.errors.nama }}</span
                        >
                    </label>
                </div>
                <div class="form-control">
                    <label class="label">
                        <span class="label-text">Telp Toko</span>
                    </label>
                    <input
                        type="text"
                        class="input input-bordered"
                        placeholder="Telp Toko ..."
                        v-model="toko_update.telp"
                    />
                    <label class="label">
                        <span
                            class="label-text text-error"
                            v-if="toko_update.errors.telp"
                            >{{ toko_update.errors.telp }}</span
                        >
                    </label>
                </div>
            </div>
            <div class="form-control">
                <label class="label">
                    <span class="label-text">Alamat Toko</span>
                </label>
                <input
                    type="text"
                    class="input input-bordered"
                    placeholder="Alamat Toko ..."
                    v-model="toko_update.alamat"
                />
                <label class="label">
                    <span
                        class="label-text text-error"
                        v-if="toko_update.errors.alamat"
                        >{{ toko_update.errors.alamat }}</span
                    >
                </label>
            </div>
            <div class="form-control">
                <label class="label">
                    <span class="label-text">Keterangan Toko</span>
                </label>
                <textarea
                    class="textarea textarea-bordered"
                    v-model="toko_update.keterangan"
                >
                </textarea>
                <label class="label">
                    <span
                        class="label-text text-error"
                        v-if="toko_update.errors.keterangan"
                        >{{ toko_update.errors.keterangan }}</span
                    >
                </label>
            </div>
        </template>
        <template v-slot:action
            ><button
                class="btn btn-success"
                :disabled="toko_update.processing"
                :class="{ loading: toko_update.processing }"
                @click="submit_toko"
            >
                Simpan
            </button></template
        >
    </modal-md>
    <modal-md id="profil">
        <template v-slot:title>Settings Profil</template>
        <template v-slot:content>
            <div class="grid grid-cols-2 gap-2">
                <div class="form-control">
                    <label class="label">
                        <span class="label-text">Nama</span>
                    </label>
                    <input
                        type="text"
                        class="input input-bordered"
                        placeholder="Nama"
                        v-model="user_update.name"
                    />
                    <label class="label">
                        <span
                            class="label-text text-error"
                            v-if="user_update.errors.name"
                            >{{ user_update.errors.name }}</span
                        >
                    </label>
                </div>
                <div class="form-control">
                    <label class="label">
                        <span class="label-text">Email</span>
                    </label>
                    <input
                        type="text"
                        class="input input-bordered"
                        placeholder="Nama"
                        v-model="user_update.email"
                    />
                    <label class="label">
                        <span
                            class="label-text text-error"
                            v-if="user_update.errors.email"
                            >{{ user_update.errors.email }}</span
                        >
                    </label>
                </div>
                <div class="form-control">
                    <label class="label">
                        <span class="label-text">Password</span>
                    </label>
                    <input
                        type="password"
                        class="input input-bordered"
                        placeholder="Password..."
                        v-model="user_update.password"
                    />
                    <label class="label">
                        <span
                            class="label-text text-error"
                            v-if="user_update.errors.password"
                            >{{ user_update.errors.password }}</span
                        >
                    </label>
                </div>
                <div class="form-control">
                    <label class="label">
                        <span class="label-text">Konfirmasi Password</span>
                    </label>
                    <input
                        type="password"
                        class="input input-bordered"
                        placeholder="Konfirmasi Password"
                        v-model="user_update.repassword"
                    />
                    <label class="label">
                        <span
                            class="label-text text-error"
                            v-if="user_update.errors.repassword"
                            >{{ user_update.errors.repassword }}</span
                        >
                    </label>
                </div>
            </div>
            <div class="form-control">
                <label class="label">
                    <span class="label-text">Foto</span>
                </label>
                <input
                    type="file"
                    @input="user_update.foto = $event.target.files[0]"
                    class="file-input file-input-bordered"
                    ref="file"
                />
                <label class="label">
                    <span
                        class="label-text text-error"
                        v-if="user_update.errors.foto"
                        >{{ user_update.errors.foto }}</span
                    >
                </label>
                <div class="flex flex-col" v-if="user_update.progress">
                    <label class="label">
                        <span class="label-text"
                            >{{ user_update.progress.percentage }}%</span
                        >
                    </label>
                    <progress
                        class="progress bg-info w-full"
                        :value="user_update.progress.percentage"
                        max="100"
                    ></progress>
                </div>
            </div>
        </template>
        <template v-slot:action>
            <button
                class="btn btn-success"
                :disabled="user_update.processing"
                :class="{ loading: user_update.processing }"
                @click="submit_user"
            >
                Simpan
            </button>
        </template>
    </modal-md>
    <modal-lg id="laporan">
        <template v-slot:title>Laporan Penjualan</template>
    </modal-lg>
</template>
<script>
import { useForm } from "@inertiajs/inertia-vue3";

export default {
    props: {
        user: Object,
        toko: Object,
    },
    setup(props) {
        const toko_update = useForm({
            id: null,
            nama: null,
            alamat: null,
            telp: null,
            keterangan: null,
        });
        const user_update = useForm({
            id: null,
            _method: "put",
            name: null,
            email: null,
            password: null,
            repassword: null,
            foto: null,
            url_foto: null,
        });
        return {
            toko_update,
            user_update,
        };
    },
    methods: {
        get_user(data) {
            this.user_update.id = data.id;
            this.user_update.name = data.name;
            this.user_update.email = data.email;
        },
        submit_user() {
            this.user_update.post(
                route("settings.user.update", {
                    user: this.user_update.id,
                }),
                {
                    onSuccess: () => {
                        this.notifikasi("Data User Berhasi Di Simpan");
                        this.close_modal("profil");
                        this.$refs.file.type = "text";
                        this.$refs.file.type = "file";
                        this.user_update.reset();
                    },
                }
            );
        },
        get_toko(data) {
            this.toko_update.id = data.id;
            this.toko_update.nama = data.nama;
            this.toko_update.alamat = data.alamat;
            this.toko_update.telp = data.telp;
            this.toko_update.keterangan = data.keterangan;
        },
        submit_toko() {
            this.toko_update.put(
                route("settings.toko.update", {
                    toko: this.toko_update.id,
                }),
                {
                    onSuccess: () => {
                        this.notifikasi("Data Toko Berhasi Di Simpan");
                        this.close_modal("toko");
                    },
                }
            );
        },
    },
};
</script>
<style lang=""></style>
