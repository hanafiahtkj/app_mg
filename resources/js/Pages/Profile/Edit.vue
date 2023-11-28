<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
// import DeleteUserForm from './Partials/DeleteUserForm.vue';
import UpdatePasswordForm from './Partials/UpdatePasswordForm.vue';
// import UpdatePerusahaanForm from './Partials/UpdatePerusahaanForm.vue';
import UpdateProfileInformationForm from './Partials/UpdateProfileInformationForm.vue';
import { Head, Link, usePage } from '@inertiajs/vue3';
import { ref, reactive, onMounted, computed } from 'vue';

const page = usePage()

defineProps({
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

onMounted(() => {
    const bodyHeight = document.documentElement.scrollHeight;
    const contentWrapper = document.querySelector('#appCapsule');
    contentWrapper.style.minHeight = bodyHeight  + 'px';
})
</script>

<template>
    <Head title="Profile" />

    <GuestLayout>
        <Head title="Profil" />

         <!-- loader -->
        <!-- <div id="loader">
            <img src="assets/img/loading-icon.png" alt="icon" class="loading-icon">
        </div> -->
        <!-- * loader -->

        <!-- App Header -->
        <div class="appHeader">
            <div class="left">
                <Link :href="route('index')" class="headerButton goBack text-warning">
                    <ion-icon name="chevron-back-outline"></ion-icon>
                </Link>
            </div>
            <div class="pageTitle">
                Profile
            </div>
            <div class="right">
                <Link :href="route('notifications')" class="headerButton">
                    <ion-icon class="icon" name="notifications-outline"></ion-icon>
                    <span class="badge badge-danger" v-if="page.props.auth.total_notification > 0">{{ page.props.auth.total_notification }}</span>
                </Link>
            </div>
        </div>
        <!-- * App Header -->

        <!-- App Capsule -->
        <div id="appCapsule">

            <div class="section mt-3 text-center">
                <div class="avatar-section">
                    <a href="#">
                        <img :src="route('index') + '/assets/img/customer.png'" alt="avatar" class="imaged w100 rounded">
                        <!-- <span class="button">
                            <ion-icon name="camera-outline"></ion-icon>
                        </span> -->
                    </a>
                </div>
            </div>


            <!-- <div class="listview-title mt-1">Theme</div>
            <ul class="listview image-listview text inset no-line">
                <li>
                    <div class="item">
                        <div class="in">
                            <div>
                                Dark Mode
                            </div>
                            <div class="form-check form-switch  ms-2">
                                <input class="form-check-input dark-mode-switch" type="checkbox" id="darkmodeSwitch">
                                <label class="form-check-label" for="darkmodeSwitch"></label>
                            </div>
                        </div>
                    </div>
                </li>
            </ul> -->

            <div class="listview-title mt-1">Profile Settings</div>

            <UpdateProfileInformationForm
                :must-verify-email="mustVerifyEmail"
                :status="status"
                class="max-w-xl"
            />

            <div class="listview-title mt-1">Password Settings</div>

            <UpdatePasswordForm class="max-w-xl" />

            <div class="listview-title mt-1">Security</div>
            <ul class="listview image-listview text mb-4 inset">
                <li>
                    <Link :href="route('logout')"
                        method="post"
                        class="item"><div class="in">
                    <div>Log out</div>
                    </div></Link>
                </li>
            </ul>


        </div>
        <!-- * App Capsule -->

    </GuestLayout>
</template>
