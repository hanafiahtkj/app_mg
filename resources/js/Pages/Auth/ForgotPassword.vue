<script setup>
import AuthLayout from '@/Layouts/AuthLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ref, onMounted, watch } from 'vue';

defineProps({
    status: {
        type: String,
    },
});

const form = useForm({
    email: '',
});

const submit = () => {
    form.post(route('password.email'));
};

onMounted(() => {
    const bodyHeight = document.documentElement.scrollHeight;;
    const contentWrapper = document.querySelector('#appCapsule');
    contentWrapper.style.minHeight = bodyHeight  + 'px';
});

</script>

<template>
    <AuthLayout>
        <Head title="Forgot Password" />

        <!-- loader -->
        <!-- <div id="loader">
            <img src="assets/img/loading-icon.png" alt="icon" class="loading-icon">
        </div> -->
        <!-- * loader -->

        <!-- App Header -->
        <div class="appHeader no-border transparent position-absolute">
            <div class="left">
                <Link :href="route('login')" class="headerButton goBack text-warning">
                    <ion-icon name="chevron-back-outline"></ion-icon>
                </Link>
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
                    <h1>Forgot password</h1>
                    <h4>Type your e-mail to reset your password</h4>
                </div>
                <div class="section mb-5 p-2">
                    <form @submit.prevent="submit" autocomplete="off" novalidate>
                        <div class="card">
                            <div class="card-body pb-2">
                                <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
                                    {{ status }}
                                </div>

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

                                <div class="transparent mt-4">
                                    <button type="submit" class="btn btn-warning btn-block" :disabled="form.processing">Reset Password</button>
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
