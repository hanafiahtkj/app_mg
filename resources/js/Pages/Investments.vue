<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ref, reactive, onMounted, computed } from 'vue';
import accounting from 'accounting';
import CurrencyInput from '@/Components/CurrencyInput.vue';
import Item from './Item.vue';

const props = defineProps({
    balance : Number,
    currentInvestments : Number,
    investments: {
        type: Object
    },
    durations: {
        type: Object
    },
    level : {
        type: Object
    }
});

let investmentActionSheet;
let toastBoxes;

const earningRate = ref(0);

const form = useForm({
    duration: '',
    amount: 0,
});
const formatCurrency = (value) => {
    const decimalCount = (value.toString().split('.')[1] || '').length;
    return accounting.formatMoney(value, {
        symbol: '',   // Tidak menampilkan simbol mata uang
        precision: decimalCount || 0,  // Menampilkan 2 angka di belakang koma
        thousand: ',', // Menyusun ribuan dengan titik
        decimal: '.',  // Menyusun desimal dengan koma
    });
};

const updateEarningRate = () => {
    const selectedDuration = props.durations.find(duration => duration.id === form.duration);
    earningRate.value = selectedDuration ? (selectedDuration.earning_rate * 100) + '%' : '0%';
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

const submit = () => {
    form.post(route('transaction.investment'), {
        onFinish: () => {

        },
        onSuccess: () =>  {
            toastbox('toast-success', 2000)
            investmentActionSheet.hide();
        }
    });
};

onMounted(() => {
    const bodyHeight = document.documentElement.scrollHeight;
    const contentWrapper = document.querySelector('#appCapsule');
    contentWrapper.style.minHeight = bodyHeight  + 'px';

    investmentActionSheet = new bootstrap.Modal(document.getElementById('investmentActionSheet'));

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
    <Head title="Investments" />

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
            Investments
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

        <template v-if="balance <= 0">
            <div class="section mt-2">
                <blockquote class="blockquote my-3 bg-secondary">
                    <p class="my-0" style="font-size: 15px;">Sorry, you cannot add an investment because your balance is {{ balance }}. Please deposit funds first.</p>
                </blockquote>
            </div>
        </template>
        <template v-if="balance > 0">
            <div class="section mt-2">
                <blockquote class="blockquote my-3 bg-secondary">
                    <p class="my-0" style="font-size: 15px;">Your current level is <mark>{{ level.name }}</mark> You can only make a maximum of {{ level.max_investment }} investments.For more information, click on the following link: <Link :href="route('level')"><strong>Level</strong></Link></p>
                    <div class="transparent mt-4" v-show="currentInvestments < level.max_investment">
                        <button type="buttom" class="btn btn-warning btn-block" data-bs-toggle="modal" data-bs-target="#investmentActionSheet"><ion-icon name="add-outline"></ion-icon> Add investment</button>
                    </div>
                </blockquote>
            </div>
        </template>

        <!-- Transactions -->
        <div class="section mt-2">
            <!-- <div class="section-title">Yours Invests</div> -->
            <div class="transactions">
                <!-- item -->
                <template v-for="investment in investments" :key="investment.id">
                    <Item :investment="investment" />
                </template>
                <!-- <a href="#" class="item" v-for="investment in investments" :key="investment.id">
                    <div class="detail">
                        <span class="text-warning">
                            <ion-icon name="trending-up-outline" style="font-size: 35px; margin-right: 15px;"></ion-icon>
                        </span>
                        <div>
                            <strong>{{ investment.duration.name }} days</strong>
                            <p class="text-warning">Amount : ${{ formatCurrency(investment.amount) }}</p>
                            <p>Earning Rate : {{ investment.duration.earning_rate * 100 }}%</p>
                            <template v-if="investment.status == 'Active'">
                                <p>Start Date : <span class="text-success">{{ investment.start_date }}</span></p>
                            </template>
                            <template v-else>
                                <p>Status : <span class="text-danger">{{ investment.status }}</span></p>
                            </template>
                        </div>
                    </div>
                    <div class="right">
                        <template v-if="investment.can_claim">
                            <button type="button" class="btn btn-outline-warning btn-lg">CLAIM ${{ formatCurrency(investment.daily_earning) }}</button>
                        </template>
                        <template v-else>
                            <button type="button" class="btn btn-outline-secondary btn-lg" disabled>CLAIM ${{ formatCurrency(investment.daily_earning) }}</button>
                        </template>
                    </div>
                </a> -->
                <!-- * item -->
            </div>
        </div>
        <!-- * Transactions -->

        <div class="modal fade action-sheet" id="investmentActionSheet" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Investment</h5>
                    </div>
                    <div class="modal-body">
                        <div class="action-sheet-content">
                            <form @submit.prevent="submit" autocomplete="off" novalidat>
                                <div class="form-group basic">
                                    <div class="input-wrapper">
                                        <label class="label">Duration</label>
                                        <select class="form-control custom-select" v-model="form.duration" @change="updateEarningRate" :class="{ 'is-invalid': form.errors.duration }">
                                            <option value="">Duration...</option>
                                            <option v-for="duration in durations" :key="duration.id" :value="duration.id">{{ duration.name }} days</option>
                                        </select>
                                        <div class="invalid-feedback">{{ form.errors.duration }}</div>
                                    </div>
                                </div>

                                <div class="form-group basic">
                                    <label class="label">Earning Rate</label>
                                    <div class="input-group mb-2">
                                        <input type="text" v-model="earningRate" class="form-control" disabled/>
                                        <!-- <span class="input-group-text">%</span> -->
                                    </div>
                                </div>

                                <div class="form-group basic">
                                    <label class="label">Enter Amount</label>
                                    <div class="input-group mb-2">
                                        <span class="input-group-text" id="basic-addona1">$</span>
                                        <CurrencyInput class="form-control" :class="{ 'is-invalid': form.errors.amount }" v-model="form.amount" placeholder="Enter an amount" />
                                        <div class="invalid-feedback">{{ form.errors.amount }}</div>
                                    </div>
                                </div>

                                <div class="form-group basic">
                                    <button type="submit" class="btn btn-warning btn-block btn-lg" :disabled="form.processing">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

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

    <div id="toast-success" class="toast-box toast-center">
        <div class="in">
            <ion-icon name="checkmark-circle" class="text-success"></ion-icon>
            <div class="text">
                Investment successful!
            </div>
        </div>
    </div>

    </GuestLayout>

</template>

<style>

</style>
