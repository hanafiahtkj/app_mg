<script setup>
import '@vendor/mazer/assets/extensions/@fortawesome/fontawesome-free/css/all.min.css';
import '@vendor/mazer/assets/extensions/flatpickr/flatpickr.min.css';

import Swal from 'sweetalert2'
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Head, Link, useForm, router, usePage } from '@inertiajs/vue3';
import { ref, onMounted } from 'vue';

const page = usePage()

const props = defineProps({
    stts_kepemilikan_perusahaan: {
        type: Object,
    },
    stts_pemodalan: {
        type: Object,
    },
    perusahaan: {
        type: Object,
    },
});

const form = useForm({
    nama: '',
    tanggal_berdiri: '',
    alamat: '',
    kode_pos: '',
    email: '',
    telp: '',
    fax: '',
    sektor: '',
    kbli_siup: '-',
    kbli_tdp: '-',
    status_kepemilikan_id: '',
    status_pemodalan_id: '',
    pemilik: '',
    alamat_pemilik: '',
    kode_pos_pemilik: '',
    email_pemilik: '',
    telp_pemilik: '',
    fax_pemilik: '',
    logo: null,
    ...props.perusahaan,
});

const submit = () => {
    form.post(route('profile.update'), {
        onFinish: () => {

        },
        onSuccess: () =>  {
            Swal.fire({
                title: 'Berhasil disimpan!',
                icon: 'success',
                showCloseButton: true,
            })
        }
    });
};

const handleFileChange = (event) => {
    const file = event.target.files[0];
    form.logo = file;
};

onMounted(() => {

    flatpickr('.flatpickr-no-config', {
        dateFormat: "Y-m-d",
    })

    if (props.perusahaan) {
        form.logo = null;
    }
});

</script>

<template>
    <Head title="Perusahaan" />

    <div class="card">
        <!-- <div class="card-header">
            <h4 class="card-title">Profil Perusahaan</h4>
        </div> -->
        <div class="card-content">
            <div class="card-body">
                <header class="mb-4">
                    <h2 class="text-lg font-medium text-gray-900">Profile Information</h2>

                    <p class="mt-1 text-sm text-gray-600">
                        Update your account's profile information and email address.
                    </p>
                </header>

                <form @submit.prevent="submit" autocomplete="off" novalidate>
                    <div class="row">
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <h6>Nama Perusahaan</h6>
                                <input type="text"  class="form-control" placeholder="Nama Perusahaan" v-model="form.nama" :class="{ 'is-invalid': form.errors.nama }">
                                <div class="invalid-feedback">{{ form.errors.nama }}</div>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <h6>Email</h6>
                                <input type="text"  class="form-control" v-model="form.email" placeholder="" :class="{ 'is-invalid': form.errors.email }">
                                <div class="invalid-feedback">{{ form.errors.email }}</div>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <h6>Alamat</h6>
                                <input type="text"  class="form-control" placeholder="Alamat" v-model="form.alamat" :class="{ 'is-invalid': form.errors.alamat }">
                                <div class="invalid-feedback">{{ form.errors.alamat }}</div>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <h6>Kode Pos</h6>
                                <input type="text"  class="form-control" placeholder="" v-model="form.kode_pos" :class="{ 'is-invalid': form.errors.kode_pos }">
                                <div class="invalid-feedback">{{ form.errors.kode_pos }}</div>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <h6>Telpon</h6>
                                <input type="text"  class="form-control" v-model="form.telp" placeholder="" :class="{ 'is-invalid': form.errors.telp }">
                                <div class="invalid-feedback">{{ form.errors.telp }}</div>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <h6>Fax</h6>
                                <input type="email"  class="form-control" v-model="form.fax" placeholder="" :class="{ 'is-invalid': form.errors.fax }">
                                <div class="invalid-feedback">{{ form.errors.fax }}</div>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <h6>Tanggal Berdiri</h6>
                                <input type="text"  class="form-control flatpickr-no-config flatpickr-input" v-model="form.tanggal_berdiri" placeholder="" :class="{ 'is-invalid': form.errors.tanggal_berdiri }">
                                <div class="invalid-feedback">{{ form.errors.tanggal_berdiri }}</div>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <h6>Jenis Usaha</h6>
                                <input type="email"  class="form-control" v-model="form.sektor" placeholder="" :class="{ 'is-invalid': form.errors.sektor }">
                                <div class="invalid-feedback">{{ form.errors.sektor }}</div>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <h6>No.KBLI sesuai SIUP</h6>
                                <input type="text"  class="form-control" v-model="form.kbli_siup" placeholder="" :class="{ 'is-invalid': form.errors.kbli_siup }">
                                <div class="invalid-feedback">{{ form.errors.kbli_siup }}</div>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <h6>No.KBLI sesuai TDP</h6>
                                <input type="text"  class="form-control" v-model="form.kbli_tdp" placeholder="" :class="{ 'is-invalid': form.errors.kbli_tdp }">
                                <div class="invalid-feedback">{{ form.errors.kbli_tdp }}</div>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <h6>Status Kepemilikan Perusahaan</h6>
                                <select class="form-select" id="role" v-model="form.status_kepemilikan_id"  :class="{ 'is-invalid': form.errors.status_kepemilikan_id }">
                                    <option value="">Pilih...</option>
                                    <option v-for="skp in stts_kepemilikan_perusahaan" :value="skp.id" :key="skp.id">{{ skp.nama }}</option>
                                </select>
                                <div class="invalid-feedback">{{ form.errors.status_kepemilikan_id }}</div>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <h6>Status Pemodalan</h6>
                                <select class="form-select" id="role" v-model="form.status_pemodalan_id"  :class="{ 'is-invalid': form.errors.status_pemodalan_id }">
                                    <option value="">Pilih...</option>
                                    <option v-for="sp in stts_pemodalan" :value="sp.id" :key="sp.id">{{ sp.nama }}</option>
                                </select>
                                <div class="invalid-feedback">{{ form.errors.status_pemodalan_id }}</div>
                            </div>
                        </div>
                        <hr class="my-4">
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <h6>Nama Pengurus</h6>
                                <input type="text"  class="form-control" v-model="form.pemilik" placeholder="Nama Pengurus" :class="{ 'is-invalid': form.errors.pemilik }">
                                <div class="invalid-feedback">{{ form.errors.pemilik }}</div>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <h6>Alamat Pengurus</h6>
                                <input type="email"  class="form-control" v-model="form.alamat_pemilik" placeholder="Alamat Pengurus" :class="{ 'is-invalid': form.errors.alamat_pemilik }">
                                <div class="invalid-feedback">{{ form.errors.alamat_pemilik }}</div>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <h6>Kode Pos</h6>
                                <input type="text"  class="form-control" v-model="form.kode_pos_pemilik" placeholder="" :class="{ 'is-invalid': form.errors.kode_pos_pemilik }">
                                <div class="invalid-feedback">{{ form.errors.kode_pos_pemilik }}</div>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <h6>Email</h6>
                                <input type="email"  class="form-control" v-model="form.email_pemilik" placeholder="" :class="{ 'is-invalid': form.errors.email_pemilik }">
                                <div class="invalid-feedback">{{ form.errors.email_pemilik }}</div>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <h6>Telpon</h6>
                                <input type="text"  class="form-control" v-model="form.telp_pemilik" placeholder="" :class="{ 'is-invalid': form.errors.telp_pemilik }">
                                <div class="invalid-feedback">{{ form.errors.telp_pemilik }}</div>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <h6>Fax</h6>
                                <input type="email"  class="form-control" v-model="form.fax_pemilik" placeholder="" :class="{ 'is-invalid': form.errors.fax_pemilik }">
                                <div class="invalid-feedback">{{ form.errors.fax_pemilik }}</div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <h6>Logo Perusahaan</h6>
                                <input class="form-control" type="file" @change="handleFileChange" placeholder="" :class="{ 'is-invalid': form.errors.logo }">
                                <div class="invalid-feedback">{{ form.errors.logo }}</div>
                            </div>
                        </div>
                        <!-- <div class="col-12 d-flex justify-content-end">
                            <button type="submit" class="btn btn-success me-1 mb-1 mt-2" :disabled="form.processing">Update</button>
                        </div> -->
                    </div>
                </form>
            </div>
        </div>
    </div>

</template>
