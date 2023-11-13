<script setup lang="ts">
import ApplicationLogo from '@/Components/Defaults/ApplicationLogo.vue';

import DropdownLink from '@/Components/Defaults/DropdownLink.vue';
import NavLink from '@/Components/Defaults/NavLink.vue';
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <div style="min-height: 100vh" class="d-flex flex-column">
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
                                <NavLink :href="route('Dashboard')" :active="route().current('dashboard')" class="text-decoration-none">
                                    <i
                                        style="font-size: 1.5rem"
                                        class="bi bi-house-door-fill"
                                        :class="route().current('dashboard') ? 'text-light' : 'text-secondary'"
                                    />
                                </NavLink>
                                <NavLink :href="route('lists')" :active="route().current('lists')" class="text-decoration-none">
                                    <i
                                        style="font-size: 1.5rem"
                                        class="bi bi-clipboard"
                                        :class="route().current('lists') ? 'text-light' : 'text-secondary'"
                                    />
                                </NavLink>
                            </a>
                        </li>
                        <div class="flex-grow-1"></div>
                        <div class="nav-item dropdown d-flex justify-content-center align-items-center text-light">
                            {{ $page.props.auth.user.todo_lists }}
                        </div>
                        <li class="nav-item dropdown d-flex justify-content-center align-items-center">
                            <a
                                class="nav-link dropdown-toggle text-light"
                                href="#"
                                id="navbarDropdownMenuLink"
                                role="button"
                                data-bs-toggle="dropdown"
                                aria-expanded="false"
                            >
                                <i class="bi bi-person-circle" style="font-size: 1.5rem"></i>
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink" style="z-index: 9999">
                                <li>
                                    <DropdownLink :href="route('profile.edit')" class="dropdown-item">
                                        <b>
                                            {{
                                                $page.props.auth.user.name.slice(0, 1).toLocaleUpperCase() +
                                                $page.props.auth.user.name.slice(1).toLocaleLowerCase()
                                            }}
                                        </b>
                                        <br />
                                        {{ $page.props.auth.user.email }}
                                    </DropdownLink>
                                </li>
                                <li>
                                    <DropdownLink :href="route('logout')" method="post" class="dropdown-item">
                                        <i class="bi bi-box-arrow-in-right" />
                                        Abmelden
                                    </DropdownLink>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <main class="container pt-4 h-100">
            <slot />
        </main>
    </div>
</template>
