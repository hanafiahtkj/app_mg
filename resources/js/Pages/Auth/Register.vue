<script setup>
import AuthLayout from "@/Layouts/AuthLayout.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import ApplicationLogo from "@/Components/ApplicationLogo.vue";
import { Head, Link, useForm } from "@inertiajs/vue3";
import { ref, onMounted, watch } from "vue";

const props = defineProps({
    referralCode: String,
});

const showPassword = ref(false);
const showPasswordConfirmation = ref(false);

const form = useForm({
    name: "",
    username: "",
    email: "",
    password: "",
    password_confirmation: "",
    referral_code: props.referralCode ?? "",
    wallet_id: "",
});

const submit = () => {
    form.post(route("register"), {
        onFinish: () => form.reset("password", "password_confirmation"),
    });
};

onMounted(() => {
    const bodyHeight = document.documentElement.scrollHeight;
    const contentWrapper = document.querySelector("#appCapsule");
    contentWrapper.style.minHeight = bodyHeight + "px";
});
</script>

<template>
    <AuthLayout>
        <Head title="Register" />

        <!-- loader -->
        <!-- <div id="loader">
            <img src="assets/img/loading-icon.png" alt="icon" class="loading-icon">
        </div> -->
        <!-- * loader -->

        <!-- App Header -->
        <div class="appHeader no-border transparent position-absolute">
            <div class="left">
                <Link
                    :href="route('login')"
                    class="headerButton goBack text-warning"
                >
                    <ion-icon name="chevron-back-outline"></ion-icon>
                </Link>
            </div>
            <div class="pageTitle"></div>
            <div class="right">
                <Link :href="route('login')" class="headerButton text-warning">
                    Login
                </Link>
            </div>
        </div>
        <!-- * App Header -->

        <!-- App Capsule -->
        <div id="appCapsule">
            <div class="register-box">
                <div class="section mt-2 text-center">
                    <img
                        :src="route('index') + '/assets/img/logo-full.png'"
                        alt="logo"
                        class="logo"
                        style="height: 150px"
                    />
                    <h1>Register now</h1>
                    <h4>Create an account</h4>
                </div>
                <div class="section mb-5 p-2">
                    <form
                        @submit.prevent="submit"
                        autocomplete="off"
                        novalidate
                    >
                        <div class="card">
                            <div class="card-body pb-2">
                                <div class="form-group basic">
                                    <div class="input-wrapper">
                                        <label class="label" for="email1">
                                            Username
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input
                                            type="text"
                                            class="form-control"
                                            id="username"
                                            placeholder="Username"
                                            :class="{
                                                'is-invalid':
                                                    form.errors.username,
                                            }"
                                            v-model="form.username"
                                        />
                                        <i class="clear-input">
                                            <ion-icon
                                                name="close-circle"
                                            ></ion-icon>
                                        </i>
                                        <div class="invalid-feedback">
                                            {{ form.errors.username }}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group basic">
                                    <div class="input-wrapper">
                                        <label class="label" for="email1"
                                            >E-mail
                                            <span class="text-danger"
                                                >*</span
                                            ></label
                                        >
                                        <input
                                            type="email"
                                            class="form-control"
                                            id="email1"
                                            placeholder="Your e-mail"
                                            :class="{
                                                'is-invalid': form.errors.email,
                                            }"
                                            v-model="form.email"
                                        />
                                        <i class="clear-input">
                                            <ion-icon
                                                name="close-circle"
                                            ></ion-icon>
                                        </i>
                                        <div class="invalid-feedback">
                                            {{ form.errors.email }}
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group basic">
                                    <div class="input-wrapper">
                                        <label class="label"
                                            >Referral Code (Optional)</label
                                        >
                                        <input
                                            type="text"
                                            class="form-control"
                                            placeholder="Kode Referal"
                                            v-model="form.referral_code"
                                        />
                                        <i class="clear-input">
                                            <ion-icon
                                                name="close-circle"
                                            ></ion-icon>
                                        </i>
                                    </div>
                                </div>

                                <div class="form-group basic">
                                    <div class="input-wrapper">
                                        <label class="label"
                                            >Wallet Id (USDT Wallet)
                                            <span class="text-danger"
                                                >*</span
                                            ></label
                                        >
                                        <input
                                            type="text"
                                            class="form-control"
                                            placeholder="Wallet Id"
                                            :class="{
                                                'is-invalid':
                                                    form.errors.wallet_id,
                                            }"
                                            v-model="form.wallet_id"
                                        />
                                        <i class="clear-input">
                                            <ion-icon
                                                name="close-circle"
                                            ></ion-icon>
                                        </i>
                                        <div class="invalid-feedback">
                                            {{ form.errors.wallet_id }}
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group basic">
                                    <div class="input-wrapper">
                                        <label class="label" for="password1"
                                            >Password
                                            <span class="text-danger"
                                                >*</span
                                            ></label
                                        >
                                        <div class="input-group">
                                            <input
                                                :type="
                                                    showPassword
                                                        ? 'text'
                                                        : 'password'
                                                "
                                                class="form-control"
                                                id="password1"
                                                autocomplete="off"
                                                :class="{
                                                    'is-invalid':
                                                        form.errors.password,
                                                }"
                                                placeholder="Your password"
                                                v-model="form.password"
                                            />
                                            <span
                                                class="input-group-text"
                                                @click="
                                                    showPassword = !showPassword
                                                "
                                                style="font-size: 24px"
                                            >
                                                <ion-icon
                                                    name="eye"
                                                    v-if="!showPassword"
                                                ></ion-icon>
                                                <ion-icon
                                                    name="eye-off"
                                                    v-if="showPassword"
                                                ></ion-icon>
                                            </span>
                                            <div class="invalid-feedback">
                                                {{ form.errors.password }}
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group basic">
                                    <div class="input-wrapper">
                                        <label class="label" for="password2"
                                            >Password Again
                                            <span class="text-danger"
                                                >*</span
                                            ></label
                                        >
                                        <div class="input-group">
                                            <input
                                                :type="
                                                    showPasswordConfirmation
                                                        ? 'text'
                                                        : 'password'
                                                "
                                                class="form-control"
                                                id="password1"
                                                autocomplete="off"
                                                :class="{
                                                    'is-invalid':
                                                        form.errors
                                                            .password_confirmation,
                                                }"
                                                placeholder="Your password"
                                                v-model="
                                                    form.password_confirmation
                                                "
                                            />
                                            <span
                                                class="input-group-text"
                                                @click="
                                                    showPasswordConfirmation =
                                                        !showPasswordConfirmation
                                                "
                                                style="font-size: 24px"
                                            >
                                                <ion-icon
                                                    name="eye"
                                                    v-if="
                                                        !showPasswordConfirmation
                                                    "
                                                ></ion-icon>
                                                <ion-icon
                                                    name="eye-off"
                                                    v-if="
                                                        showPasswordConfirmation
                                                    "
                                                ></ion-icon>
                                            </span>
                                            <div class="invalid-feedback">
                                                {{
                                                    form.errors
                                                        .password_confirmation
                                                }}
                                            </div>
                                        </div>

                                        <!-- <input type="password" class="form-control" id="password2" autocomplete="off"
                                            placeholder="Type password again" v-model="form.password_confirmation">
                                        <i class="clear-input">
                                            <ion-icon name="close-circle"></ion-icon>
                                        </i> -->
                                    </div>
                                </div>

                                <!-- <div class="custom-control custom-checkbox mt-2 mb-1">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="customCheckb1">
                                        <label class="form-check-label" for="customCheckb1">
                                            I agree <a href="#" data-bs-toggle="modal" data-bs-target="#termsModal">terms and
                                                conditions</a>
                                        </label>
                                    </div>
                                </div> -->

                                <div class="transparent mt-4">
                                    <button
                                        type="submit"
                                        class="btn btn-warning btn-block"
                                        :disabled="form.processing"
                                    >
                                        Register
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- * App Capsule -->

        <!-- Terms Modal -->
        <div
            class="modal fade modalbox"
            id="termsModal"
            tabindex="-1"
            role="dialog"
        >
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Terms and Conditions</h5>
                        <a href="#" data-bs-dismiss="modal">Close</a>
                    </div>
                    <div class="modal-body">
                        <p>
                            Lorem ipsum dolor sit amet, consectetur adipiscing
                            elit. Nunc fermentum, urna eget finibus fermentum,
                            velit metus maximus erat, nec sodales elit justo
                            vitae sapien. Sed fermentum varius erat, et dictum
                            lorem. Cras pulvinar vestibulum purus sed hendrerit.
                            Praesent et auctor dolor. Ut sed ultrices justo.
                            Fusce tortor erat, scelerisque sit amet diam
                            rhoncus, cursus dictum lorem. Ut vitae arcu egestas,
                            congue nulla at, gravida purus.
                        </p>
                        <p>
                            Donec in justo urna. Fusce pretium quam sed viverra
                            blandit. Vivamus a facilisis lectus. Nunc non
                            aliquet nulla. Aenean arcu metus, dictum tincidunt
                            lacinia quis, efficitur vitae dui. Integer id nisi
                            sit amet leo rutrum placerat in ac tortor. Duis sed
                            fermentum mi, ut vulputate ligula.
                        </p>
                        <p>
                            Vivamus eget sodales elit, cursus scelerisque leo.
                            Suspendisse lorem leo, sollicitudin egestas interdum
                            sit amet, sollicitudin tristique ex. Class aptent
                            taciti sociosqu ad litora torquent per conubia
                            nostra, per inceptos himenaeos. Phasellus id
                            ultricies eros. Praesent vulputate interdum dapibus.
                            Duis varius faucibus metus, eget sagittis purus
                            consectetur in. Praesent fringilla tristique sapien,
                            et maximus tellus dapibus a. Quisque nec magna
                            dapibus sapien iaculis consectetur. Fusce in
                            vehicula arcu. Aliquam erat volutpat. Class aptent
                            taciti sociosqu ad litora torquent per conubia
                            nostra, per inceptos himenaeos.
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <!-- * Terms Modal -->
    </AuthLayout>
</template>

<style scoped>
#appCapsule {
    display: flex;
}
.register-box {
    width: 100%;
    margin: auto;
}
</style>
