<script setup>

import Swal from 'sweetalert2'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { useModal } from "momentum-modal"
import { Head, Link, useForm, router, usePage } from '@inertiajs/vue3';
import { ref, onMounted } from 'vue';

const { show, close, redirect } = useModal()

const props = defineProps({
    transaction : {
        type : Object,
    },
    redrawDataTable: {
        type: Function,
    }
});

let modal;
let events;

const form = useForm({
    uuid: props.transaction.uuid,
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

    modal = new bootstrap.Modal(document.getElementById('inlineForm'));
    modal.show();

    events = document.getElementById('inlineForm');
    events.addEventListener('hidden.bs.modal', redirect);
});
</script>

<template>
    <form @submit.prevent="submit" autocomplete="off" novalidate>
        <div class="modal fade text-left" id="inlineForm" tabindex="-1" aria-labelledby="myModalLabel33" aria-hidden="true" style="display: none;">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel33">Verifikasi</h4>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                        </button>
                    </div>
                    <div class="modal-body">
                        <pre>{{ transaction }}</pre>
                    </div>
                    <div class="modal-footer" style="background-color: #f6f8fb;">
                        <button type="button" class="btn bg-white btn-outline-default border me-auto" data-bs-dismiss="modal" aria-label="Close">
                            <i class="bx bx-x d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Close</span>
                        </button>
                        <button type="submit" class="btn btn-primary ms-1" :disabled="form.processing">
                            <i class="bx bx-check d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Verif</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</template>
