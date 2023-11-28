<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { useForm } from '@inertiajs/vue3';
import { ref, onMounted } from 'vue';
import Swal from 'sweetalert2'

const passwordInput = ref(null);
const currentPasswordInput = ref(null);

const form = useForm({
    current_password: '',
    password: '',
    password_confirmation: '',
});

let toastBoxes;

const updatePassword = () => {
    form.put(route('password.update'), {
        preserveScroll: true,
        onSuccess: () =>  {
            form.reset()
            toastbox('toast-success', 2000)
        },
        onError: () => {
            if (form.errors.password) {
                form.reset('password', 'password_confirmation');
                passwordInput.value.focus();
            }
            if (form.errors.current_password) {
                form.reset('current_password');
                currentPasswordInput.value.focus();
            }
        },
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
            <h2 class="text-lg font-medium text-gray-900">Update Password</h2>

            <p class="mt-1 text-sm text-gray-600">
                Ensure your account is using a long, random password to stay secure.
            </p>
        </header>

        <form @submit.prevent="updatePassword" class="form form-horizontal">
            <div class="form-body">
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <h6>Current Password</h6>
                            <input type="password" class="form-control" v-model="form.current_password" :class="{ 'is-invalid': form.errors.current_password }">
                            <div class="invalid-feedback">{{ form.errors.current_password }}</div>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="form-group">
                            <h6>New Password</h6>
                            <input type="password" class="form-control" v-model="form.password" :class="{ 'is-invalid': form.errors.password }">
                            <div class="invalid-feedback">{{ form.errors.password }}</div>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="form-group">
                            <h6>Confirm Password</h6>
                            <input type="password" class="form-control" v-model="form.password_confirmation" :class="{ 'is-invalid': form.errors.password_confirmation }">
                            <div class="invalid-feedback">{{ form.errors.password_confirmation }}</div>

                        </div>
                    </div>
                    <div class="col-sm-12 d-flex justify-content-end">
                        <button type="submit" class="btn btn-success me-1 mb-1 mt-2" :disabled="form.processing">Update</button>
                        <Transition
                            enter-active-class="transition ease-in-out"
                            enter-from-class="opacity-0"
                            leave-active-class="transition ease-in-out"
                            leave-to-class="opacity-0"
                        >
                            <p v-if="form.recentlySuccessful" class="text-sm text-gray-600">Saved.</p>
                        </Transition>
                    </div>
                </div>
            </div>
        </form>

    </section> -->

    <form @submit.prevent="updatePassword" autocomplete="off" novalidate>
        <div class="card" style="margin-left: 16px; margin-right: 16px;">
            <div class="card-body pb-2">

                <div class="form-group basic">
                    <div class="input-wrapper">
                        <label class="label">Current Password</label>
                        <input type="password" class="form-control" autocomplete="off"
                            placeholder="Your password"
                            :class="{ 'is-invalid': form.errors.current_password }" v-model="form.current_password">
                        <i class="clear-input">
                            <ion-icon name="close-circle"></ion-icon>
                        </i>
                        <div class="invalid-feedback">{{ form.errors.current_password }}</div>
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

                <div class="transparent mt-4">
                    <button type="submit" class="btn btn-secondary btn-block" :disabled="form.processing">Update Password</button>
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
