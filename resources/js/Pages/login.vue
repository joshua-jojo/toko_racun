<template lang="">
    <Header>
    <title>{{$inertia.page.component}}</title>
    </Header>
    <div class="hero min-h-screen bg-base-200 overflow-hidden">
        <div
            class="hero-content flex-col"
            data-aos="zoom-out-up"
            data-aos-duration="800"
        >
            <div class="text-center">
                <h1 class="text-5xl font-bold">Login now!</h1>
            </div>
            <div
                class="card flex-shrink-0 w-full max-w-sm shadow-2xl bg-base-100"
            >
                <div class="card-body">
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Email</span>
                        </label>
                        
                        <input
                            type="text"
                            placeholder="email"
                            v-model="login.email"
                            class="input input-bordered"
                        />
                        <label class="label">
                            <span class="label-text-alt text-error" v-if="login.errors.email">{{login.errors.email}}</span>
                        </label>
                    </div>
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Password</span>
                        </label>
                        <input
                            type="password"
                            placeholder="password"
                            v-model="login.password"
                            class="input input-bordered"
                        />
                        <label class="label">
                            <span class="label-text-alt text-error" v-if="login.errors.password">{{login.errors.password}}</span>
                        </label>
                    </div>
                    <div class="form-control mt-6">
                        <button class="btn btn-primary" :class="{'loading' : login.processing}" :disabled="login.processing" @click="submit">Login</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import { useForm } from '@inertiajs/inertia-vue3';

export default {
    setup() {
        const login = useForm({
            email : null,
            password : null,
        })

        function submit(){
            login.post(route('cek-login'))
        }
        return{
            login,
            submit
        }
    }
};
</script>
<style lang=""></style>
