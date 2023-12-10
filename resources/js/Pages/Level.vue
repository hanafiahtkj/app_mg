<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ref, reactive, onMounted, computed } from 'vue';
import accounting from 'accounting';
import CurrencyInput from '@/Components/CurrencyInput.vue';

const props = defineProps({
    investments: {
        type: Object
    },
    durations: {
        type: Object
    },
    userLevels: {
        type: Object
    },
    level : String,
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
    <Head title="Level" />

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
            Level
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

        <div class="section mt-2">
            <blockquote class="blockquote my-3 bg-secondary">
                <p style="font-size: 15px;">Your current level is <mark>{{ level }}</mark></p>
            </blockquote>
        </div>

        <div class="section inset mt-2 mb-2">
            <!-- <div class="section-title">Level List</div> -->

            <div class="accordion" id="accordionExample5">
                <template v-for="item in userLevels" :key="item.id">
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" :data-bs-target="'#accordiond' + item.id" aria-expanded="false" :style="{ backgroundColor: item.color + ' !important' }">
                                {{ item.name }}
                            </button>
                        </h2>
                        <div :id="'accordiond' + item.id" class="accordion-collapse collapse show" data-bs-parent="#accordionExample5" style="">
                            <div class="accordion-body">
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent at augue eleifend,
                                lacinia ex quis, condimentum erat. Nullam a ipsum lorem.
                            </div>
                        </div>
                    </div>
                </template>
            </div>
        </div>

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
