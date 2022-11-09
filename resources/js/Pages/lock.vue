<template lang="">
    <div class="min-h-screen bg-base-100 flex justify-center items-center">
        <div class="modal-box w-11/12 max-w-5xl">
            <h3 class="font-bold text-3xl text-center">LOCK MODE</h3>
            <p class="py-4 flex flex-col gap-2">
                <input
                    type="password"
                    v-model="unlock.password"
                    class="input input-bordered w-full text-center"
                    placeholder="Password ..."
                />
                <button class="btn" @click="submit_unlock">Unlock</button>
            </p>
        </div>
    </div>
</template>
<script>
import { useForm } from "@inertiajs/inertia-vue3";

export default {
    setup(props) {
        const unlock = useForm({
            password: null,
        });

        return {
            unlock,
        };
    },
    methods: {
        submit_unlock() {
            this.unlock.post(route("unlock"), {
                onError: (errors) => {
                    this.$swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: "Password salah",
                    });
                },
            });
        },
    },
};
</script>
<style lang=""></style>
