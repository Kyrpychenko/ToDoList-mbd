<script setup lang="ts">
import { ref } from 'vue';
import ApplicationLogo from '@/Components/Defaults/ApplicationLogo.vue';
import Menu from '@/Components/Menu.vue';
import DropdownLink from '@/Components/Defaults/DropdownLink.vue';
import NavLink from '@/Components/Defaults/NavLink.vue';
import { Link, usePage } from '@inertiajs/vue3';

const showingNavigationDropdown = ref(false);
const user = usePage().props.auth.user;
</script>

<template>
    <nav class="navbar navbar-dark navbar-expand-lg" style="background-color: #001219">
        <div class="container d-flex">
            <Link :href="route('Dashboard')" class="me-3">
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
                            <NavLink :href="route('Dashboard')" :active="route().current('dashboard')" class="text-decoration-none text-light">
                                <i style="font-size: 1.5rem" class="bi bi-house-door-fill"></i>
                            </NavLink>
                            <NavLink :href="route('lists')" :active="route().current('lists')" class="text-decoration-none text-light">
                                <i style="font-size: 1.4rem" class="bi bi-clipboard"></i>
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
    <Menu></Menu>
</template>
