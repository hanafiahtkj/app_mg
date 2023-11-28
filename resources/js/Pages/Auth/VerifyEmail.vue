<script setup>
import { computed } from 'vue';
import AuthLayout from '@/Layouts/AuthLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ref, onMounted, watch } from 'vue';

const props = defineProps({
    status: {
        type: String,
    },
});

const form = useForm({});

const submit = () => {
    form.post(route('verification.send'));
};

const verificationLinkSent = computed(() => props.status === 'verification-link-sent');

onMounted(() => {
    const bodyHeight = document.documentElement.scrollHeight;;
    const contentWrapper = document.querySelector('#appCapsule');
    contentWrapper.style.minHeight = bodyHeight  + 'px';
});

</script>

<template>
    <AuthLayout>
        <Head title="Email Verification" />

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
                                <div class="mb-4 text-sm text-gray-600">
                                    Thanks for signing up! Before getting started, could you verify your email address by clicking on the link
                                    we just emailed to you? If you didn't receive the email, we will gladly send you another.
                                </div>

                                <div class="mb-4 font-medium text-sm text-green-600" v-if="verificationLinkSent">
                                    A new verification link has been sent to the email address you provided during registration.
                                </div>



                                <div class="transparent mt-4 mb-2">
                                    <button type="submit" class="btn btn-warning btn-block" :disabled="form.processing">Resend Verification Email</button>
                                </div>

                                <div class="transparent">
                                    <Link :href="route('logout')"
                                    method="post"
                                    as="button"
                                    class="btn btn-danger btn-block">Log Out</Link>
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
