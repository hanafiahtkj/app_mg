<script setup>

import Swal from 'sweetalert2'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { useModal } from "momentum-modal"
import { Head, Link, useForm, router, usePage } from '@inertiajs/vue3';
import { ref, onMounted } from 'vue';
import accounting from 'accounting';
// import { prettyPrintJson } from 'pretty-print-json';

const { show, close, redirect } = useModal()

const props = defineProps({
    balance: Number,
    amount: Number,
    transaction : {
        type : Object,
    },
    redrawDataTable: {
        type: Function,
    }
});

let modal;
let events;

const formatCurrency = (value) => {
    const decimalCount = (value.toString().split('.')[1] || '').length;
    return accounting.formatMoney(value, {
        symbol: '',   // Tidak menampilkan simbol mata uang
        precision: decimalCount || 0,  // Menampilkan 2 angka di belakang koma
        thousand: ',', // Menyusun ribuan dengan titik
        decimal: '.',  // Menyusun desimal dengan koma
    });
};

const form = useForm({
    uuid: props.transaction.uuid,
    txhash: ''
});

const submit = () => {
    form.post(route('admin.verifikasi.store'), {
        onFinish: () => {

        },
        onSuccess: () =>  {
            Swal.fire({
                title: 'Successful!',
                icon: 'success',
                showCloseButton: true})
            events.addEventListener('hidden.bs.modal', event => {
                props.redrawDataTable();
            })
            modal.hide()
        }
    });
};

onMounted(() => {

    const elem = document.getElementById('transaction');
    elem.innerHTML = prettyPrintJson.toHtml(props.transaction);

    modal = new bootstrap.Modal(document.getElementById('inlineForm'));
    modal.show();

    events = document.getElementById('inlineForm');
    events.addEventListener('hidden.bs.modal', redirect);
});
</script>

<template>
    <form @submit.prevent="submit" autocomplete="off" novalidate>
        <div class="modal fade text-left" id="inlineForm" tabindex="-1" aria-labelledby="myModalLabel33" aria-hidden="true" style="display: none;">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel33">Verifikasi</h4>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                        </button>
                    </div>
                    <div class="modal-body p-4">
                        <h5>#Balance : {{ formatCurrency(balance) }}</h5>
                        <h5>#Amount : {{ formatCurrency(amount) }}</h5>
                        <h5>#TXHASH : {{ transaction.meta.txhash ?? '-' }}</h5>
                        <template v-if="transaction.type == 'withdraw'">
                            <h6>Txhash</h6>
                            <div class="form-group">
                                <input id="name" type="text" placeholder="txhash" class="form-control"
                                :class="{ 'is-invalid': form.errors.txhash }" v-model="form.txhash" autocomplete="off">
                                <div class="invalid-feedback">{{ form.errors.txhash }}</div>
                            </div>
                        </template>
                        <div class="card m-0 mt-4" style="background-color: #f6f8fb;">
                            <div class="card-body">
                                <pre id="transaction" class="json-container mb-0"></pre>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer" style="background-color: #f6f8fb;">
                        <button type="button" class="btn bg-white btn-outline-default border me-auto" data-bs-dismiss="modal" aria-label="Close">
                            <i class="bx bx-x d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Close</span>
                        </button>
                        <button type="submit" class="btn btn-primary ms-1" :disabled="form.processing || (!transaction.meta.txhash && transaction.type == 'deposit')">
                            <i class="bx bx-check d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Verif</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</template>
