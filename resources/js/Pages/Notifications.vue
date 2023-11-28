<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { ref, reactive, onMounted, computed } from 'vue';
import { format, parseISO } from 'date-fns';

const props = defineProps({
    notifications : {
        type: Object
    }
});

console.log(props.notifications);

const formatDate = (dateString) => {
    const dateObject = parseISO(dateString);
    return format(dateObject, 'yyyy-MM-dd HH:mm:ss');
};

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
            Notifications
        </div>
        <div class="right">
            <!-- <Link :href="route('profile.edit')" class="headerButton">
                <img :src="route('index') + '/assets/img/customer.png'" alt="image" class="imaged w32">
            </Link> -->
        </div>
    </div>
    <!-- * App Header -->


    <div id="appCapsule">

        <div class="section full">

            <ul class="listview image-listview flush">
                <li v-for="notif in notifications" :key="notif.id">
                    <div class="item">
                        <div class="icon-box bg-warning">
                            <ion-icon name="chatbubble-outline"></ion-icon>
                        </div>
                        <div class="in">
                            <div>
                                <!-- <div class="mb-05"><strong>New Messages</strong></div> -->
                                <div class="mb-05">{{ notif.data.message }}</div>
                                <div class="text-xsmall">{{ formatDate(notif.created_at) }}</div>
                            </div>
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
