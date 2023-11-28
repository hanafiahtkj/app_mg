<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ref, reactive, onMounted, computed } from 'vue';
import accounting from 'accounting';
import { format, parseISO } from 'date-fns';

const props = defineProps({
    uuid: String,
    transaction : {
        type: Object
    }
});

const copyToClipboard = (value) => {
    // Menggunakan Clipboard API untuk menyalin teks ke clipboard
    navigator.clipboard.writeText(value);
    // Menampilkan pesan notifikasi atau sejenisnya (misalnya menggunakan library toast)
    toastbox('toast-copy');
}

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

let toastBoxes;
let paymentConfirmationActionSheet;

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

const paymentConfirmation = useForm({
    uuid: props.uuid,
    txhash: ''
});

const submitPaymentConfirmation = () => {
    paymentConfirmation.post(route('transaction.paymentConfirmation'),{
        onFinish: () => {

        },
        onSuccess: () =>  {
            toastbox('toast-success', 2000)
            paymentConfirmationActionSheet.hide();
        }
    });
};

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

    paymentConfirmationActionSheet = new bootstrap.Modal(document.getElementById('paymentConfirmationActionSheet'));
})

</script>

<template>
    <Head title="Transaction Detail" />

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
            <Link :href="route('history')" class="headerButton goBack text-warning">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </Link>
        </div>
        <div class="pageTitle">
            Transaction Detail
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
    <div id="appCapsule" class="full-height">

        <div class="section mt-2 mb-2">


            <div class="listed-detail mt-3">
                <template v-if="transaction.type == 'deposit'">
                    <div class="icon-wrapper">
                        <div class="iconbox bg-success">
                            <ion-icon name="add-outline"></ion-icon>
                        </div>
                    </div>
                    <h3 class="text-center mt-2">{{ transaction.meta.description }}</h3>
                </template>
                <template v-if="transaction.type == 'withdraw'">
                    <div class="icon-wrapper">
                        <div class="iconbox bg-danger">
                            <ion-icon name="arrow-down-outline"></ion-icon>
                        </div>
                    </div>
                    <h3 class="text-center mt-2">{{ transaction.meta.description }}</h3>
                </template>
            </div>

            <ul class="listview flush transparent simple-listview no-space mt-3">
                <li>
                    <strong>Status</strong>
                    <template v-if="transaction.confirmed == 1">
                        <span class="text-success">Completed</span>
                    </template>
                    <template v-if="transaction.confirmed == 0">
                        <template v-if="!transaction.meta.txhash">
                            <span class="text-warning">Waiting for Payment</span>
                        </template>
                        <template v-else>
                            <span class="text-warning">Waiting for confirmation</span>
                        </template>
                    </template>
                </li>
                <li>
                    <strong>Date</strong>
                    <span>{{ formatDate(transaction.created_at) }}</span>
                </li>
                <li>
                    <strong>Amount</strong>
                    <h3 class="m-0">{{ formatCurrency(transaction.amount_float) }}</h3>
                </li>
            </ul>

        </div>

        <template v-if="transaction.confirmed == 0 && transaction.meta.description == 'Deposit' && !transaction.meta.txhash">
            <div class="section mb-4">
                <div class="splash-page mt-5 mb-5">
                    <h4 class="mb-3">Make the payment through the wallet ID below</h4>

                    <div class="mb-3">
                        <img :src="route('index') + '/vendor/finapp/assets/img/sample/qr.png'" alt="QR Code" class="imaged square w140">
                    </div>
                    <h2 class="mb-2">Scan the QR Code</h2>
                    <p class="mb-2">
                        9010001001234 <a href="javascript:void(0)" @click="copyToClipboard('9010001001234')"><ion-icon name="copy-outline"></ion-icon></a>
                    </p>
                    <p>
                        If you have already made the payment, please click the Payment Confirmation button below.
                    </p>
                </div>

                <div class="row">
                    <div class="col-12">
                        <a href="#" class="btn btn-lg btn-outline-secondary btn-block" data-bs-toggle="modal" data-bs-target="#paymentConfirmationActionSheet">Payment Confirmation</a>
                    </div>
                </div>
            </div>
        </template>
    </div>

    <div class="modal fade action-sheet" id="paymentConfirmationActionSheet" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Payment Confirmation</h5>
                </div>
                <div class="modal-body">
                    <div class="action-sheet-content">
                        <form @submit.prevent="submitPaymentConfirmation" autocomplete="off" novalidat>
                            <div class="form-group basic">
                                <label class="label">Enter txhash</label>
                                <div class="input-group mb-2">
                                    <input type="text" class="form-control" placeholder=""
                                    :class="{ 'is-invalid': paymentConfirmation.errors.txhash }"
                                    v-model="paymentConfirmation.txhash">
                                    <div class="invalid-feedback">{{ paymentConfirmation.errors.txhash }}</div>
                                </div>
                            </div>

                            <div class="form-group basic">
                                <button type="submit" class="btn btn-warning btn-block btn-lg"
                                :disabled="paymentConfirmation.processing">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="toast-success" class="toast-box toast-center">
        <div class="in">
            <ion-icon name="checkmark-circle" class="text-success"></ion-icon>
            <div class="text">
                Payment Confirmation Successful
            </div>
        </div>
    </div>

    <!-- * App Capsule -->

    </GuestLayout>

</template>

<style scoped>
#appCapsule {
    background-color: #161129;
}
</style>
