<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Button, Message, Modal, TextInput, SelectInput, TextareaInput, RadioGroup, MultiSelectInput } from 'custom-mbd-components';
import { Head, router, useForm } from '@inertiajs/vue3';
import { ref, toRefs } from 'vue';
import { TodoItem, TodoList, User } from '@/types';
import { getPriorityNumber, getPriorityString, Priority } from '@/utility';
const props = defineProps<{
    users: User[];
    currentUser: User;
    currentLists: TodoList[];
    lists: TodoList[];
    // todo: ToDo;
}>();

type ToDo = {
    title: string;
    id?: string;
    priority: 3 | 2 | 1;
    assignedTo: string;
    state: 'done' | 'in work' | '';
    description: string;
};
const toDoList = ref<ToDo[]>([]);
const title = ref('');
const priority = ref<Priority>('Niedrig');
const assignedTo = ref('');
const description = ref('');
const form = useForm({
    title: '',
    description: '',
    priority: 'Niedrig',
    assignedTo: [] as User[],
    selectedList: 0,
});

function addListItem() {
    // toDoList.value.push({
    //     title: title.value,
    //     priority: getPriorityNumber(priority.value),
    //     assignedTo: assignedTo.value,
    //     state: 'in work',
    //     description: description.value,
    // });
    console.log('klappt');
    form.transform(data => ({ ...data, priority: getPriorityNumber(data.priority), assignedTo: form.assignedTo.map(a => a.id) }));
    form.post(route('storeTodo'));
}
</script>
<template>
    <Head title="Dashboard" />
    <AuthenticatedLayout>
        <div class="list-group">
            <a href="#" class="list-group-item list-group-item-action list-group-item-secondary d-flex justify-content-between">
                Fügen Sie etwas zur Liste hinzu:
                <Modal
                    :affirm="{ class: 'btn btn-success', text: 'Hinzufügen', action: addListItem }"
                    :negative="{ class: 'btn btn-danger', text: 'Abbrechen' }"
                >
                    <TextInput placeholder="Titel" v-model="form.title"></TextInput>
                    <div>Priorität:</div>
                    <RadioGroup
                        :options="[
                            { text: 'Hoch', value: 'Hoch' },
                            { text: 'Mittel', value: 'Mittel' },
                            { text: 'Niedrig', value: 'Niedrig' },
                        ]"
                        v-model="form.priority"
                    ></RadioGroup>
                    {{ form.assignedTo }}
                    <MultiSelectInput
                        v-model:selected="form.assignedTo"
                        placeholder="Zuweisung"
                        :options="users"
                        :optionProjection="e => e.name"
                    ></MultiSelectInput>
                    <TextareaInput placeholder="Beschreibung" v-model="form.description"></TextareaInput>
                    <SelectInput
                        showAll
                        placeholder="Welche Liste"
                        :options="lists"
                        @selectItem="e => (form.selectedList = e.id)"
                        :optionProjection="e => e.name + ''"
                    ></SelectInput>
                    <template #button><Button>Hinzufügen</Button></template>
                </Modal>
            </a>
        </div>
        <template v-for="list of currentLists">
            <Modal v-for="todo of list.todos">
                <div>
                    <h3>{{ todo.title }}</h3>
                    <div class="w-50">{{ todo.description }}</div>
                    <div>Abgabedatum:</div>
                </div>
                <template #button>
                    <a
                        href="#"
                        class="my-3 list-group-item d-flex justify-content-center rounded align-items-center fs-4"
                        :class="{
                            'list-group-item-warning': todo.priority == 2,
                            'list-group-item-success': todo.priority == 1,
                            'list-group-item-danger': todo.priority == 3,
                        }"
                    >
                        <div class="row g-0 ps-0 w-100 h-100 d-flex justify-content-center align-items-center">
                            <div class="col-1 p-2 border-end border-black h-100 d-flex justify-content-center align-items-center">
                                {{ todo.state }}
                            </div>
                            <div class="col-10 p-2 px-3 h-100 d-flex align-items-center">
                                {{ todo.title }}
                            </div>
                            <div
                                class="col-1 d-flex p-2 align-items-center justify-content-center border-start border-black flex-column"
                                v-if="todo.assignedTo.length > 0"
                            >
                                <div v-for="user of todo.assignedTo">{{ user.name }}</div>
                            </div>
                            <div v-else class="col-1"></div>
                        </div>
                    </a>
                </template>
            </Modal>
        </template>
    </AuthenticatedLayout>
</template>
