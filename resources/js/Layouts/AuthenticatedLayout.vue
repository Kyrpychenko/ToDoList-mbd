<script setup lang="ts">
import { ref } from 'vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import { Link } from '@inertiajs/vue3';

const showingNavigationDropdown = ref(false);
</script>

<template>
    <nav class="navbar navbar-dark bg-dark navbar-expand-lg">
        <div class="container d-flex">
            <Link :href="route('dashboard')" class="me-3">
                <ApplicationLogo style="height: 2.25rem; fill: currentColor; color: rgb(31 41 55); filter: invert(1)" />
            </Link>
            <button
                class="navbar-toggler"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navbarNavDropdown"
                aria-controls="navbarNavDropdown"
                aria-expanded="false"
                aria-label="Toggle navigation"
            >
                <span class="navbar-toggler-icon" style="filter: invert(1)"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav d-flex w-100">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">
                            <NavLink :href="route('dashboard')" :active="route().current('dashboard')" class="text-decoration-none text-light">
                                Startseite
                            </NavLink>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">
                            <NavLink :href="route('history', user.id)" :active="route().current('history')" class="text-decoration-none text-light">
                                Chronik
                            </NavLink>
                        </a>
                    </li>
                    <li class="nav-itemd-md-block d-none d-lg-block d-xl-block" v-if="user.role === 'admin'">
                        <a class="nav-link" href="#">
                            <NavLink
                                :href="route('administration')"
                                :active="route().current('administration')"
                                class="text-decoration-none text-light"
                            >
                                Verwaltung
                            </NavLink>
                        </a>
                    </li>
                    <li class="nav-item" v-if="user.role === 'admin'">
                        <a class="nav-link" href="#">
                            <NavLink :href="route('qrcode')" :active="route().current('qrcode')" class="text-decoration-none text-light">
                                QR-Code
                            </NavLink>
                        </a>
                    </li>

                    <div class="flex-grow-1"></div>

                    <li class="nav-item dropdown">
                        <a
                            class="nav-link dropdown-toggle text-light"
                            href="#"
                            id="navbarDropdownMenuLink"
                            role="button"
                            data-bs-toggle="dropdown"
                            aria-expanded="false"
                        >
                            {{ $page.props.auth.user.name }}
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <li>
                                <DropdownLink :href="route('profile.edit')" class="dropdown-item">Profil</DropdownLink>
                            </li>
                            <li>
                                <DropdownLink :href="route('logout')" method="post" class="dropdown-item">Abmelden</DropdownLink>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <main class="container pt-4">
        <slot />
    </main>
</template>
