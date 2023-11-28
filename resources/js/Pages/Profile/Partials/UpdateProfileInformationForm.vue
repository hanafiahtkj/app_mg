<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Link, useForm, usePage } from '@inertiajs/vue3';
import Swal from 'sweetalert2'
import { ref, reactive, onMounted, computed } from 'vue';

defineProps({
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const user = usePage().props.auth.user;
let toastBoxes;

const form = useForm({
    nama: user.email,
    email: user.email,
    wallet_id: user.wallet_id
});

const submit = () => {
    form.post(route('profile.update'), {
        onFinish: () => {

        },
        onSuccess: () =>  {
            toastbox('toast-success', 2000)
        }
    });
};

function closeToastBox() {
    toastBoxes.forEach(function (el) {
        el.classList.remove("show")
    })
}
function toastbox(target, time) {
    var a = document.getElementById(target);
    closeToastBox()
    setTimeout(() => {
        a.classList.add("show")
    }, 100);
    if (time) {
        time = time + 100;
        setTimeout(() => {
            closeToastBox()
        }, time);
    }
}

onMounted(() => {
    var toastCloseButton = document.querySelectorAll(".toast-box .close-button");
    var toastTaptoClose = document.querySelectorAll(".toast-box.tap-to-close");
    toastBoxes = document.querySelectorAll(".toast-box");

    // close button toast
    toastCloseButton.forEach(function (el) {
        el.addEventListener("click", function (e) {
            e.preventDefault();
            closeToastBox();
        })
    })
    // tap to close toast
    toastTaptoClose.forEach(function (el) {
        el.addEventListener("click", function (e) {
            closeToastBox();
        })
    })
})
</script>

<template>
    <!-- <section>
        <header>
            <h2 class="text-lg font-medium text-gray-900">Profile Information</h2>

            <p class="mt-1 text-sm text-gray-600">
                Update your account's profile information and email address.
            </p>
        </header>

        <form @submit.prevent="submit" autocomplete="off" novalidate>
            <div class="form-body">
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <h6>Nama</h6>
                            <input type="text"  class="form-control" placeholder="Nama" v-model="form.nama" :class="{ 'is-invalid': form.errors.nama }">
                            <div class="invalid-feedback">{{ form.errors.nama }}</div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <h6>Email</h6>
                            <input type="text"  class="form-control" v-model="form.email" placeholder="" :class="{ 'is-invalid': form.errors.email }">
                            <div class="invalid-feedback">{{ form.errors.email }}</div>
                        </div>
                    </div>
                    <div class="col-sm-12 d-flex justify-content-end">
                        <button type="submit" class="btn btn-success me-1 mb-1 mt-2" :disabled="form.processing">Update</button>
                    </div>
                </div>
            </div>
        </form>

    </section> -->

    <form @submit.prevent="submit" autocomplete="off" novalidate>
        <div class="card" style="margin-left: 16px; margin-right: 16px;">
            <div class="card-body pb-2">

                <div class="form-group basic">
                    <div class="input-wrapper">
                        <label class="label" for="email1">E-mail</label>
                        <input type="email" class="form-control" id="email1" placeholder="Your e-mail"
                        :class="{ 'is-invalid': form.errors.email }" v-model="form.email" disabled>
                        <i class="clear-input">
                            <ion-icon name="close-circle"></ion-icon>
                        </i>
                        <div class="invalid-feedback">{{ form.errors.email }}</div>
                    </div>
                </div>

                <div class="form-group basic">
                    <div class="input-wrapper">
                        <label class="label">Wallet Id (USDT Wallet)</label>
                        <input type="text" class="form-control" placeholder="Kode Referal"
                        :class="{ 'is-invalid': form.errors.wallet_id }" v-model="form.wallet_id">
                        <i class="clear-input">
                            <ion-icon name="close-circle"></ion-icon>
                        </i>
                        <div class="invalid-feedback">{{ form.errors.wallet_id }}</div>
                    </div>
                </div>

                <div class="transparent mt-4">
                    <button type="submit" class="btn btn-secondary btn-block" :disabled="form.processing">Update Profile</button>
                </div>
            </div>
        </div>
    </form>

    <div id="toast-success" class="toast-box toast-center">
        <div class="in">
            <ion-icon name="checkmark-circle" class="text-success"></ion-icon>
            <div class="text">
                Update successful!
            </div>
        </div>
    </div>
</template>
