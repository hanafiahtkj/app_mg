<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <slot />

     <!-- App Bottom Menu -->
     <div class="appBottomMenu">
        <Link :href="route('index')" class="item" :class="{ 'active': $page.component === 'Welcome' }">
            <div class="col">
                <ion-icon name="home"></ion-icon>
                <strong>Home</strong>
            </div>
        </Link>
        <Link :href="route('investments')" class="item" :class="{ 'active': $page.component === 'Investments' }">
            <div class="col">
                <ion-icon name="trending-up-outline"></ion-icon>
                <strong>Investments</strong>
            </div>
        </Link>
        <Link :href="route('history')" class="item" :class="{ 'active': $page.component === 'History' }">
            <div class="col">
                <ion-icon name="time-outline"></ion-icon>
                <strong>History</strong>
            </div>
        </Link>
        <Link :href="route('profile.edit')" class="item" :class="{ 'active': $page.component === 'Profile/Edit' }">
            <div class="col">
                <ion-icon name="person-outline"></ion-icon>
                <strong>Profile</strong>
            </div>
        </Link>
    </div>
    <!-- * App Bottom Menu -->
</template>
