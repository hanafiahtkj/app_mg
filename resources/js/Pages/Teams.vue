<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { ref, reactive, onMounted, computed } from 'vue';

const props = defineProps({
    teams : {
        type : Object
    },
    referralCode : String,
    referralLink : String,
});

onMounted(() => {
    const bodyHeight = document.documentElement.scrollHeight;
    const contentWrapper = document.querySelector('#appCapsule');
    contentWrapper.style.minHeight = bodyHeight  + 'px';
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
                <a href="#" class="btn btn-block btn-warning mb-0" data-bs-toggle="modal" data-bs-target="#actionSheetShare">
                    <ion-icon name="copy-outline" role="img" class="md hydrated" aria-label="share outline"></ion-icon> Copy Link Invitation
                </a>
            </blockquote>
        </div>

        <div class="section full mt-2">
            <!-- <div class="section-heading"> -->
                <div class="section-title">Your Teams</div>
            <!-- </div> -->
            <ul class="listview image-listview inset">
                <li v-for="team in teams" :key="team.id">
                    <div class="item">
                        <img :src="route('index') + '/assets/img/customer.png'" alt="image" class="image">
                        <div class="in">
                            <div>{{ team.user.email }}</div>
                        </div>
                    </div>
                </li>
            </ul>

        </div>

    </div>
    <!-- * App Capsule -->

    </GuestLayout>

</template>

<style>

</style>
