<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Button, Modal, TextInput, SelectInput, TextareaInput, RadioGroup, MultiSelectInput, DateInput } from 'custom-mbd-components';
import { Head, useForm } from '@inertiajs/vue3';
import { TodoList, User } from '@/types';
import { getPriorityNumber, Priority } from '@/utility';

defineProps<{
    users: User[];
    currentUser: User;
    currentLists: TodoList[];
    lists: TodoList[];
}>();

const form = useForm<{ title: string; description: string; priority: Priority; assignedTo: User[]; selectedList: number; deadline: string }>({
    title: '',
    description: '',
    priority: 'Niedrig',
    assignedTo: [],
    selectedList: 0,
    deadline: '',
});

function addListItem() {
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
                    <DateInput v-model="form.deadline"></DateInput>
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
        <!-- <div class="row"> -->
        <template v-for="list of currentLists">
            <div class="my-3" style="max-height: max-content" v-for="todo of list.todos">
                <Modal :title="todo.title">
                    <div>
                        <div class="w-50">{{ todo.description }}</div>
                        <div>Abgabedatum: {{ todo.deadline }}</div>
                    </div>
                    <template #button>
                        <div
                            class="card text-white"
                            :class="{
                                'bg-warning': todo.priority == 2,
                                'bg-success': todo.priority == 1,
                                'bg-danger': todo.priority == 3,
                            }"
                        >
                            <div class="card-header fw-bold">
                                {{ todo.state == 'Finished' ? '✔️' : todo.state == 'InWork' ? '⚙️' : '❌' }}
                                {{ todo.title }}
                            </div>
                            <div class="card-body">
                                <p class="card-text">{{ todo.description }}{{ todo.description }}</p>
                            </div>
                            <div class="card-footer" v-if="todo.assignedTo.length > 0">
                                Zugewiesene Benutzer*in: {{ todo.assignedTo.map(a => a.name).join(', ') }}
                            </div>
                        </div>
                    </template>
                </Modal>
            </div>
        </template>

        <!-- </div> -->
    </AuthenticatedLayout>
</template>
