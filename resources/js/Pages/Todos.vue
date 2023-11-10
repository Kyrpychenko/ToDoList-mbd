<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Modal, TextInput, SelectInput } from 'custom-mbd-components';
import { Head } from '@inertiajs/vue3';
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
    const toDo = {
        title: title.value,
        priority: <'Hoch' | 'Mittel' | 'Niedrig'>priority.value,
        assignedTo: assignedTo.value,
        state: <'done' | 'in work' | ''>'in work',
    };
    toDoList.value.push(toDo);
}
</script>
<template>
    <Head title="Dashboard" />
    <AuthenticatedLayout>
        <div class="py-4">
            <div class="mx-auto">
                <div class="bg-white">You're logged in!</div>
            </div>
        </div>
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
                    <!-- <template #button><Button>Add</Button></template> -->
                </Modal>
            </a>
            <a
                href="#"
                v-for="todo in toDoList"
                class="list-group-item list-group-item-action"
                :class="{
                    'list-group-item-warning': todo.priority === 'Mittel',
                    'list-group-item-success': todo.priority === 'Niedrig',
                    'list-group-item-danger': todo.priority === 'Hoch',
                }"
            >
                {{ todo.title }}, {{ todo.assignedTo }}
            </a>
        </div>
    </AuthenticatedLayout>
</template>
