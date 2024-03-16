<script setup>
import GuestLayout from "@/Layouts/GuestLayout.vue";
// import DeleteUserForm from './Partials/DeleteUserForm.vue';
import UpdatePasswordForm from "./Partials/UpdatePasswordForm.vue";
// import UpdatePerusahaanForm from './Partials/UpdatePerusahaanForm.vue';
import UpdateProfileInformationForm from "./Partials/UpdateProfileInformationForm.vue";
import { Head, Link, usePage } from "@inertiajs/vue3";
import { ref, reactive, onMounted, computed } from "vue";
import ClipboardJS from "clipboard";

const page = usePage();

defineProps({
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },
    referralCode: String,
    referralLink: String,
});

let toastBoxes;

const copyToClipboard = (value) => {
    const clipboard = new ClipboardJS(".copy-button", {
        text: function () {
            return value;
        },
    });

    clipboard.on("success", function (e) {
        toastbox("toast-copy");
        e.clearSelection();
    });

    clipboard.on("error", function (e) {
        console.error("Error copying to clipboard:", e.action);
    });
};

function closeToastBox() {
    toastBoxes.forEach(function (el) {
        el.classList.remove("show");
    });
}
function toastbox(target, time) {
    var a = document.getElementById(target);
    closeToastBox();
    setTimeout(() => {
        a.classList.add("show");
    }, 100);
    if (time) {
        time = time + 100;
        setTimeout(() => {
            closeToastBox();
        }, time);
    }
}

onMounted(() => {
    const bodyHeight = document.documentElement.scrollHeight;
    const contentWrapper = document.querySelector("#appCapsule");
    contentWrapper.style.minHeight = bodyHeight + "px";

    var toastCloseButton = document.querySelectorAll(
        ".toast-box .close-button"
    );
    var toastTaptoClose = document.querySelectorAll(".toast-box.tap-to-close");
    toastBoxes = document.querySelectorAll(".toast-box");

    // close button toast
    toastCloseButton.forEach(function (el) {
        el.addEventListener("click", function (e) {
            e.preventDefault();
            closeToastBox();
        });
    });
    // tap to close toast
    toastTaptoClose.forEach(function (el) {
        el.addEventListener("click", function (e) {
            closeToastBox();
        });
    });
});
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

        <!-- toast top -->
        <div id="toast-copy" class="toast-box toast-top">
            <div class="in">
                <div class="text">Copy to clipboard</div>
            </div>
            <button
                type="button"
                class="btn btn-sm btn-text-light close-button"
            >
                OK
            </button>
        </div>
        <!-- * toast top -->

        <!-- App Header -->
        <div class="appHeader">
            <div class="left">
                <Link
                    :href="route('index')"
                    class="headerButton goBack text-warning"
                >
                    <ion-icon name="chevron-back-outline"></ion-icon>
                </Link>
            </div>
            <div class="pageTitle">Profile</div>
            <div class="right">
                <Link :href="route('notifications')" class="headerButton">
                    <ion-icon
                        class="icon"
                        name="notifications-outline"
                    ></ion-icon>
                    <span
                        class="badge badge-danger"
                        v-if="page.props.auth.total_notification > 0"
                        >{{ page.props.auth.total_notification }}</span
                    >
                </Link>
            </div>
        </div>
        <!-- * App Header -->

        <!-- App Capsule -->
        <div id="appCapsule">
            <div class="section mt-3 text-center">
                <div class="avatar-section">
                    <a href="#">
                        <img
                            :src="route('index') + '/assets/img/customer.png'"
                            alt="avatar"
                            class="imaged w100 rounded"
                        />
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

            <div class="section mt-4">
                <blockquote class="blockquote my-3 bg-secondary">
                    <p style="font-size: 15px">
                        Invite your friends using your referral code
                        <mark>{{ referralCode }}</mark> and earn rewards!
                    </p>
                    <input
                        type="text"
                        class="form-control mb-2"
                        :value="referralLink"
                        placeholder=""
                    />
                    <a
                        href="#"
                        class="btn btn-block btn-warning mb-0 copy-button"
                        @click="copyToClipboard(referralLink)"
                    >
                        <ion-icon
                            name="copy-outline"
                            role="img"
                            class="md hydrated"
                            aria-label="share outline"
                        ></ion-icon>
                        Copy Link Invitation
                    </a>
                </blockquote>
            </div>

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
                    <Link :href="route('logout')" method="post" class="item"
                        ><div class="in">
                            <div>Log out</div>
                        </div></Link
                    >
                </li>
            </ul>
        </div>
        <!-- * App Capsule -->
    </GuestLayout>
</template>
