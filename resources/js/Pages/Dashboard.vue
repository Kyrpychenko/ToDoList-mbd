<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Button, Message, Modal } from 'custom-mbd-components';
import { Head, router } from '@inertiajs/vue3';
import { ref, toRefs } from 'vue';
import { User } from '@/types';

const props = defineProps<{
    user: User;
}>();

const { user } = toRefs(props);
</script>
<template>
    <Head title="Dashboard" />
    <AuthenticatedLayout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">You're logged in!</div>
                </div>
            </div>
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100"></div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
