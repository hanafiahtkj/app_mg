<script setup>
import '@vendor/mazer/assets/extensions/datatables.net-bs5/css/dataTables.bootstrap5.min.css';
import '@vendor/mazer/assets/compiled/css/table-datatable-jquery.css';

import Swal from 'sweetalert2'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Modal } from 'momentum-modal'
import { Head, Link, router } from '@inertiajs/vue3';
import { ref, onMounted } from 'vue';

defineProps({

});

const users = ref();
let datatable;
let Swal2;

const setupEventListeners = () => {
  $(document).on('click', '.edit-link', function (e) {
    e.preventDefault();
    const userId = $(this).data('user-id');
    router.get(route('dashboard.users.edit', {id : userId}), {}, { preserveState: true })
  });

  $(document).on('click', '.delete-link', function (e) {
    e.preventDefault();
    const userId = $(this).data('user-id');

    Swal.fire({
        title: 'Yakin ingin menghapus?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'No, cancel!',
        cancelButtonColor: '#d33',
        reverseButtons: true,
    }).then((result) => {
        if (result.isConfirmed) {
            axios.delete(route('dashboard.users.destroy', { id: userId }))
                .then(response => {
                    Swal.fire('Berhasil dihapus!', '', 'success')
                    datatable.ajax.reload(null, false);
                })
                .catch(error => {
                    console.error('Failed to delete user:', error);
                });
        }
    })
  });
};

const redrawDataTable = () => {
    if (datatable) {
        datatable.ajax.reload(null, false);
    }
};

const loadUsersData = async () => {
    try {
        datatable = $("#table-users").DataTable({
            responsive: true,
            lengthMenu: [
                [5, 10, 50, -1],
                [5, 10, 50, 'All']
            ],
            ajax: {
                url: route('dashboard.users.loadUsers'),
            },
            columns: [
                { data: 'name' },
                { data: 'email' },
                { data: 'roles[0].display_name' },
                {
                    data: 'email_verified_at',
                    render: function (data, type, row) {
                        return data ? '<span class="badge bg-success">Confirmed</span>' : '<span class="badge bg-warning">Unconfirmed</span>';
                    },
                },
                {
                    data: null,
                    render: function (data, type, row) {
                        return `
                            <div class="dropdown">
                                <button class="btn btn-sm btn-icon btn-default me-1" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa-solid fa-ellipsis-vertical"></i>
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <a class="dropdown-item edit-link" href="#" data-user-id="${row.id}">Edit</a>
                                    <a class="dropdown-item delete-link" href="#" data-user-id="${row.id}">Delete</a>
                                </div>
                            </div>
                        `;
                    },
                },
            ],
        });

        setupEventListeners()
    } catch (error) {
        console.error('Gagal memuat data pengguna:', error);
    }
};

onMounted(() => {
    loadUsersData();
});
</script>

<template>
    <AuthenticatedLayout>
        <Head title="Users" />

        <div class="page-heading mb-2">
          <div class="page-title">
            <div class="row">
              <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Data User</h3>
                <p class="text-subtitle text-muted">
                    Daftar lengkap pengguna yang terdaftar dalam sistem.
                </p>
              </div>
              <div class="col-12 col-md-6 order-md-2 order-first">
                <nav
                  aria-label="breadcrumb"
                  class="breadcrumb-header float-start float-lg-end">
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <Link :href="route('dashboard.index')">Dashboard</Link>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                      Data User
                    </li>
                  </ol>
                </nav>
              </div>
            </div>
          </div>
        </div>
        <div class="page-content">
            <section class="row">
              <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between">
                            <h5 class="card-title">
                                Data User
                            </h5>
                            <Link :href="route('dashboard.users.create')" :preserve-state="true" class="btn icon btn-primary"><i class="fa-fw select-all fas"></i></Link>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive datatable-minimal">
                            <table class="table" id="table-users">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                        <th>Status</th>
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
