<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { ref, reactive, onMounted, computed } from 'vue';
import accounting from 'accounting';
import { format, parseISO } from 'date-fns';

const props = defineProps({
    transactions : {
        type: Object
    }
});

console.log(props.transactions);

const formatDate = (dateString) => {
    const dateObject = parseISO(dateString);
    return format(dateObject, 'yyyy-MM-dd HH:mm:ss');
};

const formatCurrency = (value) => {
    const decimalCount = (value.toString().split('.')[1] || '').length;

    // Check if the number is negative
    const isNegative = value < 0;

    // Format the currency using accounting.formatMoney without specifying the symbol
    const formattedValue = accounting.formatMoney(value, {
        symbol: '',
        precision: decimalCount || 0,
        thousand: ',',
        decimal: '.',
    });

    // Add the dollar sign after the minus sign for negative numbers
    return isNegative ? `-$${formattedValue.substring(1)}` : '+$'+formattedValue;
};

onMounted(() => {
    const bodyHeight = document.documentElement.scrollHeight;
    const contentWrapper = document.querySelector('#appCapsule');
    contentWrapper.style.minHeight = bodyHeight  + 'px';
})

</script>

<template>
    <Head title="History" />

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
            History
        </div>
        <div class="right">
            <!-- <Link :href="route('notifications')" class="headerButton">
                <ion-icon class="icon" name="notifications-outline"></ion-icon>
                <span class="badge badge-danger">0</span>
            </Link> -->
            <!-- <Link :href="route('profile.edit')" class="headerButton">
                <img :src="route('index') + '/assets/img/customer.png'" alt="image" class="imaged w32">
            </Link> -->
        </div>
    </div>
    <!-- * App Header -->


    <!-- App Capsule -->
    <div id="appCapsule">

        <!-- Transactions -->
        <div class="section mt-2">
            <!-- <div class="section-title">Latest Transactions</div> -->
            <div class="transactions">
                <!-- item -->
                <Link :href="route('transaction.view', transaction.uuid)" v-for="transaction in transactions" :key="transaction.id" class="item">
                    <template v-if="transaction.type == 'deposit'">
                        <div class="detail">
                            <span class="text-success">
                                <ion-icon name="add-outline" style="font-size: 35px; margin-right: 15px;"></ion-icon>
                            </span>
                            <div>
                                <strong>{{ transaction.meta.description }}</strong>
                                <p>{{ formatDate(transaction.created_at) }}</p>
                                <template v-if="transaction.confirmed == 1">
                                    <p>Status: <span class="text-success">Completed</span></p>
                                </template>
                                <template v-if="transaction.confirmed == 0">
                                    <template v-if="!transaction.meta.txhash">
                                        <p>Status: <span class="text-warning">Waiting for Payment</span></p>
                                    </template>
                                    <template v-else>
                                        <p>Status: <span class="text-warning">Waiting for confirmation</span></p>
                                    </template>
                                </template>
                            </div>
                        </div>
                        <div class="right">
                            <div class="price text-success">{{ formatCurrency(transaction.amount_float) }}</div>
                        </div>
                    </template>
                    <template v-if="transaction.type == 'withdraw'">
                        <div class="detail">
                            <span class="text-danger">
                                <ion-icon name="arrow-down-outline" style="font-size: 35px; margin-right: 15px;"></ion-icon>
                            </span>
                            <div>
                                <strong>{{ transaction.meta.description }}</strong>
                                <p>{{ formatDate(transaction.created_at) }}</p>
                                <template v-if="transaction.confirmed == 1">
                                    <p>Status: <span class="text-success">Completed</span></p>
                                </template>
                                <template v-if="transaction.confirmed == 0">
                                    <p>Status: <span class="text-warning">Waiting for Payment</span></p>
                                </template>
                            </div>
                        </div>
                        <div class="right">
                            <div class="price text-danger">{{ formatCurrency(transaction.amount_float) }}</div>
                        </div>
                    </template>
                </Link>
                <!-- * item -->

                <!-- item -->
                <!-- <a href="app-transaction-detail.html" class="item">
                    <div class="detail">
                        <span class="text-warning">
                            <ion-icon name="trending-up-outline" style="font-size: 35px; margin-right: 15px;"></ion-icon>
                        </span>
                        <div>
                            <strong>Invest</strong>
                            <p>01 January 2022 10:32</p>
                        </div>
                    </div>
                    <div class="right">
                        <div class="price text-warning">$ 186</div>
                    </div>
                </a> -->
                <!-- * item -->
            </div>
        </div>
        <!-- * Transactions -->

        <!-- app footer -->
        <!-- <div class="appFooter">
            <div class="footer-title">
                Copyright © Finapp 2021. All Rights Reserved.
            </div>
            Bootstrap 5 based mobile template.
        </div> -->
        <!-- * app footer -->

    </div>
    <!-- * App Capsule -->

    <!-- App Sidebar -->
    <div class="modal fade panelbox panelbox-left" id="sidebarPanel" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body p-0">
                    <!-- profile box -->
                    <div class="profileBox pt-2 pb-2">
                        <div class="image-wrapper">
                            <img src="assets/img/sample/avatar/avatar1.jpg" alt="image" class="imaged  w36">
                        </div>
                        <div class="in">
                            <strong>Sebastian Doe</strong>
                            <div class="text-muted">4029209</div>
                        </div>
                        <a href="#" class="btn btn-link btn-icon sidebar-close" data-bs-dismiss="modal">
                            <ion-icon name="close-outline"></ion-icon>
                        </a>
                    </div>
                    <!-- * profile box -->
                    <!-- balance -->
                    <div class="sidebar-balance">
                        <div class="listview-title">Balance</div>
                        <div class="in">
                            <h1 class="amount">$ 2,562.50</h1>
                        </div>
                    </div>
                    <!-- * balance -->

                    <!-- action group -->
                    <div class="action-group">
                        <a href="index.html" class="action-button">
                            <div class="in">
                                <div class="iconbox">
                                    <ion-icon name="add-outline"></ion-icon>
                                </div>
                                Deposit
                            </div>
                        </a>
                        <a href="index.html" class="action-button">
                            <div class="in">
                                <div class="iconbox">
                                    <ion-icon name="arrow-down-outline"></ion-icon>
                                </div>
                                Withdraw
                            </div>
                        </a>
                        <a href="index.html" class="action-button">
                            <div class="in">
                                <div class="iconbox">
                                    <ion-icon name="arrow-forward-outline"></ion-icon>
                                </div>
                                Send
                            </div>
                        </a>
                        <a href="app-cards.html" class="action-button">
                            <div class="in">
                                <div class="iconbox">
                                    <ion-icon name="card-outline"></ion-icon>
                                </div>
                                My Cards
                            </div>
                        </a>
                    </div>
                    <!-- * action group -->

                    <!-- menu -->
                    <div class="listview-title mt-1">Menu</div>
                    <ul class="listview flush transparent no-line image-listview">
                        <li>
                            <a href="index.html" class="item">
                                <div class="icon-box bg-primary">
                                    <ion-icon name="pie-chart-outline"></ion-icon>
                                </div>
                                <div class="in">
                                    Overview
                                    <span class="badge badge-primary">10</span>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="app-pages.html" class="item">
                                <div class="icon-box bg-primary">
                                    <ion-icon name="document-text-outline"></ion-icon>
                                </div>
                                <div class="in">
                                    Pages
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="app-components.html" class="item">
                                <div class="icon-box bg-primary">
                                    <ion-icon name="apps-outline"></ion-icon>
                                </div>
                                <div class="in">
                                    Components
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="app-cards.html" class="item">
                                <div class="icon-box bg-primary">
                                    <ion-icon name="card-outline"></ion-icon>
                                </div>
                                <div class="in">
                                    My Cards
                                </div>
                            </a>
                        </li>
                    </ul>
                    <!-- * menu -->

                    <!-- others -->
                    <div class="listview-title mt-1">Others</div>
                    <ul class="listview flush transparent no-line image-listview">
                        <li>
                            <a href="app-settings.html" class="item">
                                <div class="icon-box bg-primary">
                                    <ion-icon name="settings-outline"></ion-icon>
                                </div>
                                <div class="in">
                                    Settings
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="component-messages.html" class="item">
                                <div class="icon-box bg-primary">
                                    <ion-icon name="chatbubble-outline"></ion-icon>
                                </div>
                                <div class="in">
                                    Support
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="app-login.html" class="item">
                                <div class="icon-box bg-primary">
                                    <ion-icon name="log-out-outline"></ion-icon>
                                </div>
                                <div class="in">
                                    Log out
                                </div>
                            </a>
                        </li>


                    </ul>
                    <!-- * others -->

                    <!-- send money -->
                    <div class="listview-title mt-1">Send Money</div>
                    <ul class="listview image-listview flush transparent no-line">
                        <li>
                            <a href="#" class="item">
                                <img src="assets/img/sample/avatar/avatar2.jpg" alt="image" class="image">
                                <div class="in">
                                    <div>Artem Sazonov</div>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="item">
                                <img src="assets/img/sample/avatar/avatar4.jpg" alt="image" class="image">
                                <div class="in">
                                    <div>Sophie Asveld</div>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="item">
                                <img src="assets/img/sample/avatar/avatar3.jpg" alt="image" class="image">
                                <div class="in">
                                    <div>Kobus van de Vegte</div>
                                </div>
                            </a>
                        </li>
                    </ul>
                    <!-- * send money -->

                </div>
            </div>
        </div>
    </div>
    <!-- * App Sidebar -->



    <!-- iOS Add to Home Action Sheet -->
    <div class="modal inset fade action-sheet ios-add-to-home" id="ios-add-to-home-screen" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add to Home Screen</h5>
                    <a href="#" class="close-button" data-bs-dismiss="modal">
                        <ion-icon name="close"></ion-icon>
                    </a>
                </div>
                <div class="modal-body">
                    <div class="action-sheet-content text-center">
                        <div class="mb-1"><img src="assets/img/icon/192x192.png" alt="image" class="imaged w64 mb-2">
                        </div>
                        <div>
                            Install <strong>Finapp</strong> on your iPhone's home screen.
                        </div>
                        <div>
                            Tap <ion-icon name="share-outline"></ion-icon> and Add to homescreen.
                        </div>
                        <div class="mt-2">
                            <button class="btn btn-primary btn-block" data-bs-dismiss="modal">CLOSE</button>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!-- * iOS Add to Home Action Sheet -->


    <!-- Android Add to Home Action Sheet -->
    <div class="modal inset fade action-sheet android-add-to-home" id="android-add-to-home-screen" tabindex="-1"
        role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add to Home Screen</h5>
                    <a href="#" class="close-button" data-bs-dismiss="modal">
                        <ion-icon name="close"></ion-icon>
                    </a>
                </div>
                <div class="modal-body">
                    <div class="action-sheet-content text-center">
                        <div class="mb-1">
                            <img src="assets/img/icon/192x192.png" alt="image" class="imaged w64 mb-2">
                        </div>
                        <div>
                            Install <strong>Finapp</strong> on your Android's home screen.
                        </div>
                        <div>
                            Tap <ion-icon name="ellipsis-vertical"></ion-icon> and Add to homescreen.
                        </div>
                        <div class="mt-2">
                            <button class="btn btn-primary btn-block" data-bs-dismiss="modal">CLOSE</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- * Android Add to Home Action Sheet -->

    </GuestLayout>

</template>

<style>

</style>
