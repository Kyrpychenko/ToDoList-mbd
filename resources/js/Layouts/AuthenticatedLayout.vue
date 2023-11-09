<script setup lang="ts">
import ApplicationLogo from '@/Components/Defaults/ApplicationLogo.vue';
import Menu from '@/Components/Menu/Menu.vue';
import DropdownLink from '@/Components/Defaults/DropdownLink.vue';
import NavLink from '@/Components/Defaults/NavLink.vue';
import { Link } from '@inertiajs/vue3';
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
                    <div class="nav-item dropdown d-flex justify-content-center align-items-center text-light">
                        {{ $page.props.auth.user.todo_lists }}
                        <!-- {{
                            $page.props.auth.user.todo_lists.filter(i =>
                                i.todo_items.filter(t => t.todo_item_user.filter(u => u.id === $page.props.auth.user.id))
                            ).length
                        }} -->
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
                            <!-- {{ $page.props.auth.user.name }} -->
                            <i class="bi bi-person-circle" style="font-size: 1.5rem"></i>
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
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
                                    <!-- {{ $page.props.auth.user.todo_lists }} -->
                                </DropdownLink>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <Menu />
    <main class="container pt-4">
        <slot />
    </main>
</template>
