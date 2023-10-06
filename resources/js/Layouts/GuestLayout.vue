<script setup lang="ts">
import ApplicationLogo from "@/Components/ApplicationLogo.vue";
import { Link } from "@inertiajs/vue3";
</script>

<template>
    <div
        class="d-flex justify-content-center align-items-center flex-column bg-light"
        style="height: 100vh"
    >
        <div class="mb-4" style="width: 150px; height: 150px">
            <Link :href="route('dashboard')">
                <ApplicationLogo />
            </Link>
        </div>
        <div>
            <slot />
        </div>
    </div>
</template>
