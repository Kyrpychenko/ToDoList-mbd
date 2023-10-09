<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Button, Message, Modal, TextInput, SelectInput } from 'custom-mbd-components';
import { Head, router } from '@inertiajs/vue3';
import { ref, toRefs } from 'vue';
import { User } from '@/types';

const props = defineProps<{
    user: User;
}>();

const { user } = toRefs(props);
const toDoList = ref<{ todo: string; id: string; priority: 'high' | 'mid' | 'low'; assignedTo: string; state: 'done' | 'in work' | '' }[]>([]);
function addListItem() {}
</script>
<template>
    <Head title="Dashboard" />
    <AuthenticatedLayout>
        <div class="py-4">
            <div class="mx-auto">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">You're logged in!</div>
                </div>
            </div>
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-2">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100"></div>
                </div>
            </div>
        </div>
        <div class="list-group">
            <a href="#" class="list-group-item list-group-item-action list-group-item-secondary d-flex justify-content-between">
                Add something to your list
                <Modal
                    :affirm="{ class: 'btn btn-success', text: 'Hinzufügen', action: () => addListItem() }"
                    :negative="{ class: 'btn btn-danger', text: 'Abbrechen' }"
                >
                    <TextInput placeholder="Titel"></TextInput>
                    <SelectInput showAll placeholder="Priorität" :options="['Hoch', 'Mittel', 'Niedrig']"></SelectInput>
                    <SelectInput showAll placeholder="Zuweisung" :options="[$page.props.auth.user.name]"></SelectInput>
                    <template #button><Button>Add</Button></template>
                </Modal>
            </a>
            <!-- <a href="#" class="list-group-item list-group-item-action list-group-item-warning">A simple secondary list group item</a>
            <a href="#" class="list-group-item list-group-item-action list-group-item-success">A simple success list group item</a>
            <a href="#" class="list-group-item list-group-item-action list-group-item-danger">A simple danger list group item</a> -->
        </div>
    </AuthenticatedLayout>
</template>
