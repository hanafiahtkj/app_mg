<script setup>
import '@vendor/mazer/assets/compiled/css/iconly.css';
import '@vendor/mazer/assets/extensions/choices.js/public/assets/styles/choices.css';
import '@vendor/mazer/assets/extensions/datatables.net-bs5/css/dataTables.bootstrap5.min.css';
import '@vendor/mazer/assets/compiled/css/table-datatable-jquery.css';

import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, usePage, useForm, router } from '@inertiajs/vue3';
import { ref, onMounted, watch } from 'vue';
import accounting from 'accounting';
import { format, parseISO } from 'date-fns';
import { Modal } from 'momentum-modal'

const page = usePage()

defineProps({
    deposit : Number,
    withdraw : Number,
    user : Number
});

let datatable;

const setupEventListeners = () => {
  $(document).on('click', '.verif-link', function (e) {
    e.preventDefault();
    const userId = $(this).data('user-id');
    router.get(route('admin.verifikasi', {id : userId}), {}, { preserveState: true })
  });
};

const formatDate = (dateString) => {
    const dateObject = parseISO(dateString);
    return format(dateObject, 'yyyy-MM-dd HH:mm:ss');
};

const formatCurrency = (value) => {
    const decimalCount = (value.toString().split('.')[1] || '').length;
    return accounting.formatMoney(value, {
        symbol: '',   // Tidak menampilkan simbol mata uang
        precision: decimalCount || 0,  // Menampilkan 2 angka di belakang koma
        thousand: ',', // Menyusun ribuan dengan titik
        decimal: '.',  // Menyusun desimal dengan koma
    });
};

const redrawDataTable = () => {
    if (datatable) {
        datatable.ajax.reload(null, false);
    }
};

const loadData = async () => {
    try {
        datatable = $("#table-data").DataTable({
            responsive: true,
            ordering: false,
            lengthMenu: [
                [5, 10, 50, -1],
                [5, 10, 50, 'All']
            ],
            ajax: {
                url: route('admin.loadTransactions'),
                data: function (d) {
                    // d.custom_form_id = $('#custom_form_id').val();
                }
            },
            columns: [
                { data: 'payable.email' },
                { data: 'meta.description' },
                { data: 'amount_float' },
                {
                    data: 'confirmed',
                    render: function (data, type, row) {
                        return data ? '<span class="badge bg-success">Confirmed</span>' : '<span class="badge bg-warning">Unconfirmed</span>';
                    },
                },
                {
                    data: 'created_at',
                    render: function (data, type, row) {
                        return formatDate(data);
                    },
                },
                {
                    data: null,
                    render: function (data, type, row) {
                        if (row.confirmed) {
                            return `-`;
                        }
                        else {
                            return `<a class="btn btn-primary verif-link" href="#" data-user-id="${row.id}">Verifikasi</a>`;
                        }
                    },
                },
            ],
        });

        setupEventListeners()
    } catch (error) {
        console.error('Gagal memuat data:', error);
    }
};

onMounted(() => {

    loadData();

    const squareBoxes = document.querySelectorAll('.square-box');
    squareBoxes.forEach((box) => {
        const width = box.clientWidth;
        box.style.height = width * 0.75 + 'px';
    });

    let choices = document.querySelectorAll(".choices")
    let initChoice
    for (let i = 0; i < choices.length; i++) {
        if (choices[i].classList.contains("multiple-remove")) {
            initChoice = new Choices(choices[i], {
            delimiter: ",",
            editItems: true,
            maxItemCount: -1,
            removeItemButton: true,
            })
        } else {
            initChoice = new Choices(choices[i])
        }
    }
});

</script>

<template>
    <AuthenticatedLayout>
        <Head title="Dashboard" />

        <div class="page-heading">
            <div class="page-title">
            <div class="row">
              <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Dashboard</h3>
                <!-- <p class="text-subtitle text-muted">
                    Update your account's profile information and email address.
                </p> -->
              </div>
            </div>
          </div>
        </div>
        <div class="page-content">

            <div class="row">
                <div class="col-6 col-lg-3 col-md-6">
                    <div class="card">
                        <div class="card-body px-4 py-4-5">
                            <div class="row">
                                <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                                    <div class="stats-icon green mb-2">
                                        <i class="iconly-boldShow"></i>
                                    </div>
                                </div>
                                <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                    <h6 class="text-muted font-semibold">Total Deposit</h6>
                                    <h6 class="font-extrabold mb-0">{{ formatCurrency(deposit) }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-lg-3 col-md-6">
                    <div class="card">
                        <div class="card-body px-4 py-4-5">
                            <div class="row">
                                <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                                    <div class="stats-icon red mb-2">
                                        <i class="iconly-boldShow"></i>
                                    </div>
                                </div>
                                <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                    <h6 class="text-muted font-semibold">Total Withdraw</h6>
                                    <h6 class="font-extrabold mb-0">{{ formatCurrency(withdraw) }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-lg-3 col-md-6">
                    <div class="card">
                        <div class="card-body px-4 py-4-5">
                            <div class="row">
                                <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                                    <div class="stats-icon purple mb-2">
                                        <i class="iconly-boldShow"></i>
                                    </div>
                                </div>
                                <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                    <h6 class="text-muted font-semibold">User</h6>
                                    <h6 class="font-extrabold mb-0">{{ user }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-lg-3 col-md-6">
                    <div class="card">
                        <div class="card-body px-4 py-4-5">
                            <div class="row">
                                <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                                    <div class="stats-icon purple mb-2">
                                        <i class="iconly-boldShow"></i>
                                    </div>
                                </div>
                                <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                    <h6 class="text-muted font-semibold">###</h6>
                                    <h6 class="font-extrabold mb-0">0</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <section class="row">
              <div class="col-12">

                <!-- <form class="row g-3 mb-3">
                    <div class="col-md-3">
                        <select class="choices" name="custom_form_id" id="custom_form_id" v-model="customFormId" @change="redrawDataTable">
                            <option value="">Pilih Jenis Buku Administrasi</option>
                            <option v-for="(prsh, index) in customForm" :value="prsh.id" :key="prsh.id" :selected="index === 0">{{ prsh.name }}</option>
                        </select>
                    </div>
                </form> -->

                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between">
                            <h5 class="card-title">
                                Transactions
                            </h5>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive datatable-minimal">
                            <table class="table" id="table-data">
                                <thead>
                                    <tr>
                                        <th>User</th>
                                        <th>Type</th>
                                        <th>Amount</th>
                                        <th>Status</th>
                                        <th>Created At</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
              </div>
            </section>

        </div>

        <Modal :redrawDataTable="redrawDataTable" />
    </AuthenticatedLayout>
</template>

<style scoped>
    .square-box {
        display: flex;
        align-items: center; /* Vertikal center */
        justify-content: center;
        font-size: calc(1.275rem + .3vw)!important;
        color: #25396f;
    }

    .selected {
        background-color: #445ebe;
        color: #fff;
    }
</style>

