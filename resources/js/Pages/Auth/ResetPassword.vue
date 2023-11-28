<script setup>
import AuthLayout from '@/Layouts/AuthLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { ref, onMounted, watch } from 'vue';

const props = defineProps({
    email: {
        type: String,
        required: true,
    },
    token: {
        type: String,
        required: true,
    },
});

const form = useForm({
    token: props.token,
    email: props.email,
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('password.store'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
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
        <Head title="Reset Password" />

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
                    <!-- <h1>Log in</h1>
                    <h4>Fill the form to log in</h4> -->
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
                                        <input type="password" class="form-control" id="password1" autocomplete="off"
                                            placeholder="Your password"
                                            :class="{ 'is-invalid': form.errors.password }" v-model="form.password">
                                        <i class="clear-input">
                                            <ion-icon name="close-circle"></ion-icon>
                                        </i>
                                        <div class="invalid-feedback">{{ form.errors.password }}</div>
                                    </div>
                                </div>

                                <div class="form-group basic">
                                    <div class="input-wrapper">
                                        <label class="label" for="password2">Password Again</label>
                                        <input type="password" class="form-control" id="password2" autocomplete="off"
                                            placeholder="Type password again" v-model="form.password_confirmation">
                                        <i class="clear-input">
                                            <ion-icon name="close-circle"></ion-icon>
                                        </i>
                                    </div>
                                </div>

                                <div class="transparent mt-4 mb-2">
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
