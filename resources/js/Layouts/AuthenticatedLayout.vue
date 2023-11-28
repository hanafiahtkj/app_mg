<script setup>

import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import { Link, usePage } from '@inertiajs/vue3';
import { ref, onMounted } from 'vue';

const page = usePage()

onMounted(() => {
    // Responsive burger btn onclick
    document.querySelector(".burger-btn").addEventListener("click", (e) => {
    e.preventDefault()
    let navbar = document.querySelector(".main-navbar")

    navbar.classList.toggle('active')
    })

    window.onload = () => checkWindowSize()
    window.addEventListener("resize", (event) => {
    checkWindowSize()
    })

    function checkWindowSize() {
    if (window.innerWidth < 1200) listener()
    if (window.innerWidth > 1200)
        document.querySelector(".main-navbar").style.display = ""
    }

    function listener() {
    let menuItems = document.querySelectorAll(".menu-item.has-sub")
    menuItems.forEach((menuItem) => {
        menuItem.querySelector(".menu-link").addEventListener("click", (e) => {
        e.preventDefault()
        let submenu = menuItem.querySelector(".submenu")
        submenu.classList.toggle("active")
        })
    })

    // Three level menu event listener
    let submenuItems = document.querySelectorAll(".submenu-item.has-sub")

    submenuItems.forEach((submenuItem) => {
        submenuItem
        .querySelector(".submenu-link")
        .addEventListener("click", (e) => {
            e.preventDefault()
            submenuItem.querySelector(".subsubmenu").classList.toggle("active")
        })
    })
    }

});
</script>

<template>
    <div id="main" class="layout-horizontal">
        <header class="mb-5">
            <div class="header-top">
                <div class="container">
                    <div class="logo">
                        <a :href="route('index')">
                            <ApplicationLogo class="w-20 h-20 fill-current text-gray-500 me-2" />
                            <!-- <span class="fs-5 fw-bold">LOGO</span> -->
                        </a>
                    </div>
                    <div class="header-top-right">
                        <div class="dropdown">
                            <a
                                href="#"
                                id="topbarUserDropdown"
                                class="user-dropdown d-flex align-items-center dropend dropdown-toggle"
                                data-bs-toggle="dropdown"
                                aria-expanded="false"
                            >
                                <div class="avatar avatar-md2">
                                    <img
                                        :src="page.props.auth.user.avatar"
                                        alt="Avatar"
                                    />
                                </div>
                                <div class="text">
                                    <h6 class="user-dropdown-name">
                                        {{ page.props.auth.user.name }}
                                    </h6>
                                    <p
                                        class="user-dropdown-status text-sm text-muted"
                                    >
                                    {{ page.props.auth.user.roles[0].display_name }}
                                    </p>
                                </div>
                            </a>
                            <ul
                                class="dropdown-menu dropdown-menu-end shadow-lg"
                                aria-labelledby="topbarUserDropdown"
                            >
                                <li><hr class="dropdown-divider" /></li>
                                <li>
                                    <a :href="route('profile.edit')" class="dropdown-item">Profile</a>
                                </li>
                            </ul>
                        </div>

                        <!-- Burger button responsive -->
                        <a
                            href="#"
                            class="burger-btn d-block d-xl-none"
                        >
                            <i class="bi bi-justify fs-3"></i>
                        </a>
                    </div>
                </div>
            </div>
            <nav class="main-navbar">
                <div class="container">
                    <ul>
                        <li class="menu-item">
                            <Link
                                :href="route('admin.index')" class="menu-link">
                                <span
                                    ><i class="bi bi-grid-fill"></i>
                                    Dashboard</span
                                >
                            </Link>
                        </li>


                    </ul>
                </div>
            </nav>
        </header>

        <div class="content-wrapper container">
            <slot />
        </div>

        <footer>
            <div class="container">
                <div class="footer clearfix mb-0 text-muted">
                    <div class="float-start">
                        <p>2023 &copy;. All Rights Reserved.</p>
                    </div>
                    <div class="float-end">
                        <!-- <p>
                            Crafted with
                            <span class="text-danger"
                                ><i class="bi bi-heart"></i
                            ></span>
                            by <a href="https://saugi.me">Saugi</a>
                        </p> -->
                    </div>
                </div>
            </div>
        </footer>
    </div>
</template>

<style scoped>
    .layout-horizontal .header-top .logo img {
        height: 40px;
    }
    .layout-horizontal .header-top .logo a {
        color: #25396f;
    }
</style>
