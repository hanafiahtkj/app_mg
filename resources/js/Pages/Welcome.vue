<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { Head, Link, usePage, useForm } from '@inertiajs/vue3';
import { ref, reactive, onMounted, computed } from 'vue';
import accounting from 'accounting';
import CurrencyInput from '@/Components/CurrencyInput.vue';

const page = usePage()

const props = defineProps({
    referallCount : Number,
    balance : Number,
    earning : Number,
    income : Number,
    withdraw : Number,
    level : String,
    coinsMarkets : {
        type : Object,
    }
});

// const coinsMarkets = ref([]);

const loadCoinsMarkets = async () => {
    let url = route('coins.markets');
    const response = await axios.get(url);
    if (response.status === 200) {
        const data = response.data;
        coinsMarkets.value = data;
        console.log(data)
    }
}

const formatCurrency = (value) => {
    const decimalCount = (value.toString().split('.')[1] || '').length;
    return accounting.formatMoney(value, {
        symbol: '',   // Tidak menampilkan simbol mata uang
        precision: decimalCount || 0,  // Menampilkan 2 angka di belakang koma
        thousand: ',', // Menyusun ribuan dengan titik
        decimal: '.',  // Menyusun desimal dengan koma
    });
};

const formatCurrencyCoin = (value) => {
    const decimalCount = (value.toString().split('.')[1] || '').length;
    return accounting.formatMoney(value, {
        symbol: '',   // Tidak menampilkan simbol mata uang
        precision: 4,  // Menampilkan 2 angka di belakang koma
        thousand: ',', // Menyusun ribuan dengan titik
        decimal: '.',  // Menyusun desimal dengan koma
    });
};

let depositActionSheet;
let withdrawActionSheet;

const deposit = useForm({
    amount: 0,
});

const submitDeposit = () => {
    deposit.post(route('transaction.deposit'), {
        onFinish: () => {

        },
        onSuccess: () =>  {
            depositActionSheet.hide();
        }
    });
};

const withdraw = useForm({
    amount: 0,
});

const submitWithdraw = () => {
    withdraw.post(route('transaction.withdraw'), {
        onFinish: () => {

        },
        onSuccess: () =>  {
            withdrawActionSheet.hide();
        }
    });
};

onMounted(() => {
    console.log('balance', props.balance);
    // loadCoinsMarkets();

    const bodyHeight = document.documentElement.scrollHeight;
    const contentWrapper = document.querySelector('#appCapsule');
    contentWrapper.style.minHeight = bodyHeight  + 'px';

    depositActionSheet = new bootstrap.Modal(document.getElementById('depositActionSheet'));
    withdrawActionSheet = new bootstrap.Modal(document.getElementById('withdrawActionSheet'));
})

</script>

<template>
    <Head title="Welcome" />

    <GuestLayout>

    <!-- loader -->
    <!-- <div id="loader">
        <img src="assets/img/loading-icon.png" alt="icon" class="loading-icon">
    </div> -->
    <!-- * loader -->

    <!-- App Header -->
    <div class="appHeader text-light">
        <div class="left">
            <img :src="route('index') + '/assets/img/logo.png'" alt="logo" class="logo" style="height: 30px; margin-right: 5px;">
            <span class="text-warning"><b>InfiniteGold</b></span>
        </div>
        <!-- <div class="pageTitle">
            <img src="assets/img/logo.png" alt="logo" class="logo">
        </div> -->
        <div class="right">
            <Link :href="route('notifications')" class="headerButton">
                <ion-icon class="icon" name="notifications-outline"></ion-icon>
                <span class="badge badge-danger" v-if="page.props.auth.total_notification > 0">{{ page.props.auth.total_notification }}</span>
            </Link>
            <Link :href="route('profile.edit')" class="headerButton">
                <img :src="route('index') + '/assets/img/customer.png'" alt="image" class="imaged w32">
                <!-- <span class="badge badge-danger">6</span> -->
            </Link>
        </div>
    </div>
    <!-- * App Header -->


    <!-- App Capsule -->
    <div id="appCapsule">

        <!-- Wallet Card -->
        <div class="section wallet-card-section pt-2">
            <div class="wallet-card">


                <div class="balance">
                    <div class="left">
                        <span class="title">Earning</span>
                        <h1 class="total text-warning">$ {{ formatCurrency(earning) }}</h1>
                    </div>
                    <div class="right">

                    </div>
                </div>
                <hr/>
                <!-- Balance -->
                <div class="balance">
                    <div class="left" style="width: 50%;">
                        <span class="title">Total Balance</span>
                        <h1 class="total">$ {{ formatCurrency(balance) }}</h1>
                    </div>
                    <div class="right">
                        <div class="wallet-footer">
                            <div class="item me-2">
                                <a href="#" data-bs-toggle="modal" data-bs-target="#depositActionSheet">
                                    <div class="icon-wrapper bg-success">
                                        <ion-icon name="add-outline"></ion-icon>
                                    </div>
                                    <strong>Deposit</strong>
                                </a>
                            </div>
                            <div class="item">
                                <a href="#" data-bs-toggle="modal" data-bs-target="#withdrawActionSheet">
                                    <div class="icon-wrapper bg-danger">
                                        <ion-icon name="arrow-down-outline"></ion-icon>
                                    </div>
                                    <strong>Withdraw</strong>
                                </a>
                            </div>
                        </div>
                        <!-- <a href="#" class="button" data-bs-toggle="modal" data-bs-target="#depositActionSheet">
                            <ion-icon name="add-outline"></ion-icon>
                        </a> -->
                    </div>
                    <!-- <div class="right" style="width: 50%;">
                        <span class="title">Earning</span>
                        <h1 class="total">$ 2,562</h1>
                    </div> -->
                </div>
                <!-- * Balance -->
                <!-- Wallet Footer -->
                <!-- <div class="wallet-footer">
                    <div class="item">
                        <a href="#" data-bs-toggle="modal" data-bs-target="#withdrawActionSheet">
                            <div class="icon-wrapper bg-danger">
                                <ion-icon name="arrow-down-outline"></ion-icon>
                            </div>
                            <strong>Withdraw</strong>
                        </a>
                    </div>
                    <div class="item">
                        <a href="#" data-bs-toggle="modal" data-bs-target="#sendActionSheet">
                            <div class="icon-wrapper">
                                <ion-icon name="arrow-forward-outline"></ion-icon>
                            </div>
                            <strong>Send</strong>
                        </a>
                    </div>
                    <div class="item">
                        <a href="app-cards.html">
                            <div class="icon-wrapper bg-success">
                                <ion-icon name="card-outline"></ion-icon>
                            </div>
                            <strong>Cards</strong>
                        </a>
                    </div>
                    <div class="item">
                        <a href="#" data-bs-toggle="modal" data-bs-target="#exchangeActionSheet">
                            <div class="icon-wrapper bg-warning">
                                <ion-icon name="swap-vertical"></ion-icon>
                            </div>
                            <strong>Exchange</strong>
                        </a>
                    </div>

                </div> -->
                <!-- * Wallet Footer -->
            </div>
        </div>
        <!-- Wallet Card -->

        <!-- Deposit Action Sheet -->
        <div class="modal fade action-sheet" id="depositActionSheet" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Balance</h5>
                    </div>
                    <div class="modal-body">
                        <div class="action-sheet-content">
                            <form @submit.prevent="submitDeposit" autocomplete="off" novalidat>
                                <div class="form-group basic">
                                    <div class="input-wrapper">
                                        <label class="label" for="account1">From (USDT Wallet)</label>
                                        <select class="form-control custom-select" id="account1">
                                            <option value="0">{{ page.props.auth.user.wallet_id }}</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group basic">
                                    <label class="label">Enter Amount</label>
                                    <div class="input-group mb-2">
                                        <span class="input-group-text" id="basic-addona1">$</span>
                                        <CurrencyInput class="form-control" :class="{ 'is-invalid': deposit.errors.amount }" v-model="deposit.amount" placeholder="Enter an amount" />
                                        <div class="invalid-feedback">{{ deposit.errors.amount }}</div>
                                    </div>
                                </div>

                                <div class="form-group basic">
                                    <button type="submit" class="btn btn-warning btn-block btn-lg" :disabled="deposit.processing">Deposit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- * Deposit Action Sheet -->

        <!-- Withdraw Action Sheet -->
        <div class="modal fade action-sheet" id="withdrawActionSheet" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Withdraw Money</h5>
                    </div>
                    <div class="modal-body">
                        <div class="action-sheet-content">
                            <form @submit.prevent="submitWithdraw" autocomplete="off" novalidat>
                                <div class="form-group basic">
                                    <div class="input-wrapper">
                                        <label class="label" for="account1">To (USDT Wallet)</label>
                                        <select class="form-control custom-select" id="account1">
                                            <option value="0">{{ page.props.auth.user.wallet_id }}</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group basic">
                                    <label class="label">Enter Amount</label>
                                    <div class="input-group mb-2">
                                        <span class="input-group-text" id="basic-addona1">$</span>
                                        <CurrencyInput class="form-control" :class="{ 'is-invalid': withdraw.errors.amount }" v-model="withdraw.amount" placeholder="Enter an amount" />
                                        <div class="invalid-feedback">{{ withdraw.errors.amount }}</div>
                                    </div>
                                </div>

                                <div class="form-group basic">
                                    <button type="submit" class="btn btn-warning btn-block btn-lg" :disabled="withdraw.processing">Withdraw</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- * Withdraw Action Sheet -->

        <!-- Send Action Sheet -->
        <div class="modal fade action-sheet" id="sendActionSheet" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Send Money</h5>
                    </div>
                    <div class="modal-body">
                        <div class="action-sheet-content">
                            <form>
                                <div class="form-group basic">
                                    <div class="input-wrapper">
                                        <label class="label" for="account2">From</label>
                                        <select class="form-control custom-select" id="account2">
                                            <option value="0">Savings (*** 5019)</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group basic">
                                    <div class="input-wrapper">
                                        <label class="label" for="text11">To</label>
                                        <input type="email" class="form-control" id="text11"
                                            placeholder="Enter bank ID">
                                        <i class="clear-input">
                                            <ion-icon name="close-circle"></ion-icon>
                                        </i>
                                    </div>
                                </div>

                                <div class="form-group basic">
                                    <label class="label">Enter Amount</label>
                                    <div class="input-group mb-2">
                                        <span class="input-group-text" id="basic-addon1">$</span>
                                        <input type="text" class="form-control" placeholder="Enter an amount"
                                            value="100">
                                    </div>
                                </div>

                                <div class="form-group basic">
                                    <button type="button" class="btn btn-primary btn-block btn-lg"
                                        data-bs-dismiss="modal">Send</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- * Send Action Sheet -->

        <!-- Exchange Action Sheet -->
        <div class="modal fade action-sheet" id="exchangeActionSheet" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Exchange Money</h5>
                    </div>
                    <div class="modal-body">
                        <div class="action-sheet-content">
                            <form>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group basic">
                                            <div class="input-wrapper">
                                                <label class="label" for="currency1">From</label>
                                                <select class="form-control custom-select" id="currency1">
                                                    <option value="1">EUR</option>
                                                    <option value="2">USD</option>
                                                    <option value="3">AUD</option>
                                                    <option value="4">CAD</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group basic">
                                            <div class="input-wrapper">
                                                <label class="label" for="currency2">To</label>
                                                <select class="form-control custom-select" id="currency2">
                                                    <option value="1">USD</option>
                                                    <option value="1">EUR</option>
                                                    <option value="2">AUD</option>
                                                    <option value="3">CAD</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group basic">
                                    <label class="label">Enter Amount</label>
                                    <div class="input-group mb-2">
                                        <span class="input-group-text" id="basic-addon2">$</span>
                                        <input type="text" class="form-control" placeholder="Enter an amount"
                                            value="100">
                                    </div>
                                </div>



                                <div class="form-group basic">
                                    <button type="button" class="btn btn-primary btn-block btn-lg"
                                        data-bs-dismiss="modal">Exchange</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- * Exchange Action Sheet -->

        <!-- Stats -->
        <div class="section pt-2">
            <div class="row mt-2">
                <div class="col-6">
                    <div class="stat-box">
                        <div class="title">Income</div>
                        <div class="value text-success">$ {{ formatCurrency(income) }}</div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="stat-box">
                        <div class="title">Withdraw</div>
                        <div class="value text-danger">$ {{ formatCurrency(withdraw) }}</div>
                    </div>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-6">
                    <Link :href="route('level')">
                        <div class="stat-box">
                            <div class="title">Level</div>
                            <div class="value text-warning">{{ level }}</div>
                        </div>
                    </Link>
                </div>
                <div class="col-6">
                    <Link :href="route('teams')">
                        <div class="stat-box">
                            <div class="title">Team</div>
                            <div class="value">{{ referallCount }}</div>
                        </div>
                    </Link>
                </div>
            </div>
        </div>
        <!-- * Stats -->

        <!-- Transactions -->
        <div class="section my-4">
            <div class="section-heading">
                <div class="section-title">Market Price($)</div>
                <!-- <Link :href="route('history')" class="link">View All</Link> -->
            </div>
            <div class="transactions">
                <!-- item -->
                <a v-for="coin in coinsMarkets" :key="coin.id" class="item">
                    <div class="detail" style="min-width: 40%;">
                        <img :src="coin.image" alt="img" class="image-block imaged w48">
                        <div>
                            <strong>{{ coin.symbol.toUpperCase() }} / <span class="text-secondary">USD</span></strong>
                            <!-- <p>01 January 2022 10:32</p> -->
                        </div>
                    </div>
                    <div class="text-white text-end" style="min-width: 30%;">
                        <strong>{{ formatCurrencyCoin(coin.current_price) }}</strong>
                    </div>
                    <div class="right text-end" style="min-width: 30%;">
                        <span class="badge badge-success" :class="{ 'badge-danger': coin.price_change_percentage_24h < 0, 'badge-success': coin.price_change_percentage_24h >= 0 }">
                            {{ coin.price_change_percentage_24h }}%
                        </span>
                        <!-- <div class="price text-small" :class="{ 'text-danger': coin.price_change_percentage_24h < 0, 'text-success': coin.price_change_percentage_24h >= 0 }">
                            {{ coin.price_change_percentage_24h }}%
                        </div> -->
                    </div>
                </a>
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
.wallet-card .balance {
    height: 80px;
}
.wallet-card-section:before {
    /* background: #3b2402; */
    height: 275px;
    background-image: linear-gradient(-208deg, #4a2d02 38%, #8a69ff 100%);
}
body.dark-mode .wallet-card {
    background: #161129d6;
}
.wallet-card .wallet-footer {
    border-top: 0px;
    padding-top: 0px;
}
</style>
