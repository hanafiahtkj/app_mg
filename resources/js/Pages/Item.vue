<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ref, reactive, onMounted, computed } from 'vue';
import accounting from 'accounting';
import CurrencyInput from '@/Components/CurrencyInput.vue';

const props = defineProps({
    investment: {
        type: Object
    },
});

let investmentActionSheet;
let toastBoxes;

const earningRate = ref(0);

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

const form = useForm({
    investment_id: props.investment.id,
});

const submit = () => {
    form.post(route('transaction.claimEarning'), {
        onFinish: () => {

        },
        onSuccess: () =>  {
            toastbox('toast-success', 2000)
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

    <!-- item -->
    <a href="#" class="item">
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
                <button type="button" class="btn btn-outline-warning btn-lg" @click="submit">CLAIM ${{ formatCurrency(investment.daily_earning) }}</button>
            </template>
            <template v-else>
                <button type="button" class="btn btn-outline-secondary btn-lg" disabled>CLAIM ${{ formatCurrency(investment.daily_earning) }}</button>
            </template>
        </div>
    </a>
    <!-- * item -->

    <div id="toast-success" class="toast-box toast-center">
        <div class="in">
            <ion-icon name="checkmark-circle" class="text-success"></ion-icon>
            <div class="text">
                Claim earning successful.!
            </div>
        </div>
    </div>

</template>

<style>

</style>
