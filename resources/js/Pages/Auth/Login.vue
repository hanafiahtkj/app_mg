<script setup>
import Checkbox from '@/Components/Checkbox.vue';
import AuthLayout from '@/Layouts/AuthLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import PasswordInput from '@/Components/PasswordInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ref, onMounted, watch } from 'vue';

defineProps({
    canResetPassword: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const showPassword = ref(false);

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};

onMounted(() => {
    const bodyHeight = document.documentElement.scrollHeight;;
    const contentWrapper = document.querySelector('#appCapsule');
    contentWrapper.style.minHeight = bodyHeight  + 'px';
});

</script>

<template>
    <AuthLayout>
        <Head title="Login" />

        <!-- loader -->
        <!-- <div id="loader">
            <img src="assets/img/loading-icon.png" alt="icon" class="loading-icon">
        </div> -->
        <!-- * loader -->

        <!-- App Header -->
        <div class="appHeader no-border transparent position-absolute">
            <div class="left">
                <!-- <a href="#" class="headerButton goBack">
                    <ion-icon name="chevron-back-outline"></ion-icon>
                </a> -->
            </div>
            <div class="pageTitle"></div>
            <div class="right">
            </div>
        </div>
        <!-- * App Header -->

        <!-- App Capsule -->
        <div id="appCapsule">
            <div class="login-box">
                <div class="section mt-2 text-center">
                    <img :src="route('index') + '/assets/img/logo-full.png'" alt="logo" class="logo" style="height: 150px;">
                    <h1>Log in</h1>
                    <h4>Fill the form to log in</h4>
                </div>
                <div class="section mb-5 p-2">
                    <form @submit.prevent="submit" autocomplete="off" novalidate>
                        <div class="card">
                            <div class="card-body pb-2">
                                <div class="form-group basic">
                                    <div class="input-wrapper">
                                        <label class="label" for="email1">E-mail</label>
                                        <input type="email" class="form-control" id="email1" placeholder="Your e-mail"
                                        :class="{ 'is-invalid': form.errors.email }" v-model="form.email">
                                        <i class="clear-input">
                                            <ion-icon name="close-circle"></ion-icon>
                                        </i>
                                        <div class="invalid-feedback">{{ form.errors.email }}</div>
                                    </div>
                                </div>

                                <div class="form-group basic">
                                    <div class="input-wrapper">
                                        <label class="label" for="password1">Password</label>
                                        <div class="input-group">
                                            <input
                                            :type="showPassword ? 'text' : 'password'"
                                            class="form-control" id="password1" autocomplete="off"
                                            :class="{ 'is-invalid': form.errors.password }" placeholder="Your password" v-model="form.password">
                                            <span class="input-group-text" @click="showPassword = !showPassword" style="font-size: 24px;">
                                                <ion-icon name="eye" v-if="!showPassword"></ion-icon>
                                                <ion-icon name="eye-off" v-if="showPassword"></ion-icon>
                                            </span>
                                            <div class="invalid-feedback">{{ form.errors.password }}</div>
                                        </div>
                                    </div>
                                </div>

                                <div class="transparent mt-4">
                                    <button type="submit" class="btn btn-warning btn-block" :disabled="form.processing">Log in</button>
                                </div>

                                <div class="form-links mt-2">
                                    <div>
                                        <Link :href="route('register')" class="text-warning">Register Now</Link>
                                    </div>
                                    <div><Link :href="route('password.request')" class="text-muted">Forgot Password?</Link></div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>
        <!-- * App Capsule -->
    </AuthLayout>
</template>

<style scoped>
    #appCapsule {
        display: flex;
    }
    .login-box {
        width: 100%;
        margin: auto;
    }
</style>
