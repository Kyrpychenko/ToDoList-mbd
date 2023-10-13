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
const toDoList = ref<{ title: string; id?: string; priority: 'Hoch' | 'Mittel' | 'Niedrig'; assignedTo: string; state: 'done' | 'in work' | '' }[]>(
    []
);
const title = ref('');
const priority = ref('');
const assignedTo = ref('');
function addListItem() {
    toDoList.value.push({
        title: title.value,
        priority: priority.value as 'Hoch' | 'Mittel' | 'Niedrig',
        assignedTo: assignedTo.value,
        state: 'in work',
    });
}
</script>
<template>
    <Head title="Dashboard" />
    <AuthenticatedLayout>
        <div class="list-group">
            <a href="#" class="list-group-item list-group-item-action list-group-item-secondary d-flex justify-content-between">
                Add something to your list
                <Modal
                    :affirm="{ class: 'btn btn-success', text: 'Hinzufügen', action: () => addListItem() }"
                    :negative="{ class: 'btn btn-danger', text: 'Abbrechen' }"
                >
                    <TextInput placeholder="Titel" v-model="title"></TextInput>
                    <SelectInput showAll placeholder="Priorität" :options="['Hoch', 'Mittel', 'Niedrig']" v-model="priority"></SelectInput>
                    <SelectInput showAll placeholder="Zuweisung" :options="[$page.props.auth.user.name]" v-model="assignedTo"></SelectInput>
                    <template #button><Button>Add</Button></template>
                </Modal>
            </a>
        </div>
        <a
            href="#"
            v-for="todo in toDoList"
            class="my-3 list-group-item list-group-item d-flex rounded px-2 align-items-center fs-4"
            style="height: 7vh"
            :class="{
                'list-group-item-warning': todo.priority === 'Mittel',
                'list-group-item-success': todo.priority === 'Niedrig',
                'list-group-item-danger': todo.priority === 'Hoch',
            }"
        >
            <div class="text-decoration-none w-100 flex-row">
                {{ todo.state }}
                {{ todo.title }}
                {{ todo.assignedTo }}
            </div>
        </a>
    </AuthenticatedLayout>
</template>
