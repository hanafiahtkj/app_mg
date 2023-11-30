<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { ref, reactive, onMounted, computed } from 'vue';
import ClipboardJS from 'clipboard';

const props = defineProps({
    teams : {
        type : Object
    },
    referralCode : String,
    referralLink : String,
});

let toastBoxes;

const copyToClipboard = (value) => {
    const clipboard = new ClipboardJS('.copy-button', {
        text: function() {
            return value;
        }
    });

    clipboard.on('success', function(e) {
        toastbox('toast-copy');
        e.clearSelection();
    });

    clipboard.on('error', function(e) {
        console.error('Error copying to clipboard:', e.action);
    });
}

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
    const bodyHeight = document.documentElement.scrollHeight;
    const contentWrapper = document.querySelector('#appCapsule');
    contentWrapper.style.minHeight = bodyHeight  + 'px';

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
    <Head title="Notifications" />

    <GuestLayout>

    <!-- loader -->
    <!-- <div id="loader">
        <img src="assets/img/loading-icon.png" alt="icon" class="loading-icon">
    </div> -->
    <!-- * loader -->

    <!-- toast top -->
    <div id="toast-copy" class="toast-box toast-top">
        <div class="in">
            <div class="text">
                Copy to clipboard
            </div>
        </div>
        <button type="button" class="btn btn-sm btn-text-light close-button">OK</button>
    </div>
    <!-- * toast top -->

    <!-- App Header -->
    <div class="appHeader text-light">
        <div class="left">
            <Link :href="route('index')" class="headerButton goBack text-warning">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </Link>
        </div>
        <div class="pageTitle">
            Team
        </div>
        <div class="right">
            <!-- <Link :href="route('profile.edit')" class="headerButton">
                <img :src="route('index') + '/assets/img/customer.png'" alt="image" class="imaged w32">
            </Link> -->
        </div>
    </div>
    <!-- * App Header -->


    <div id="appCapsule">

        <div class="section mt-2">
            <blockquote class="blockquote my-3 bg-secondary">
                <p style="font-size: 15px;">Invite your friends using your referral code <mark>{{ referralCode }}</mark> and earn rewards!</p>
                <input type="text" class="form-control mb-2" :value="referralLink" placeholder="">
                <a href="#" class="btn btn-block btn-warning mb-0 copy-button" @click="copyToClipboard(referralLink)">
                    <ion-icon name="copy-outline" role="img" class="md hydrated" aria-label="share outline"></ion-icon> Copy Link Invitation
                </a>
            </blockquote>
        </div>

        <div class="section full mt-2">
            <!-- <div class="section-heading"> -->
                <div class="section-title">Your Teams</div>
            <!-- </div> -->
            <template v-for="team in teams" :key="team.id">
                <ul class="listview image-listview inset mb-1">
                    <li>
                        <div class="item">
                            <img :src="route('index') + '/assets/img/customer.png'" alt="image" class="image">
                            <div class="in">
                                <div>{{ team.user.email }}</div>
                            </div>
                        </div>
                    </li>
                </ul>
            </template>

        </div>

    </div>
    <!-- * App Capsule -->

    </GuestLayout>

</template>

<style>

</style>
