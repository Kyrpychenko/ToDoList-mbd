<script setup lang="ts">
import { Button, Modal, TextInput, MultiSelectInput, DateInput } from 'custom-mbd-components';
import { TodoItem, TodoList, User } from '@/types';
import { router, useForm } from '@inertiajs/vue3';
import { toRefs } from 'vue';
import { Priority } from '@/utility';
import { Router } from 'ziggy-js';

const props = defineProps<{
    users: User[];
    todo: TodoItem;
    currentUser: User;
    // todoItems: TodoItem[];
}>();
const { todo, currentUser } = toRefs(props);

const assignedUserForm = useForm<{ assignedTo: User[] }>({
    assignedTo: todo.value.todo_item_user,
});

const syncTodoForm = useForm<{
    title: string;
    description: string;
    priority: Priority;
    assignedTo: User[];
    deadline: string;
}>({
    title: todo.value.title,
    description: todo.value.description,
    priority: todo.value.priority == 1 ? 'Niedrig' : todo.value.priority == 2 ? 'Mittel' : 'Hoch',
    assignedTo: todo.value.todo_item_user,
    deadline: todo.value.deadline,
});
const syncDataTodoForm = useForm<{
    title: string;
    description: string;
    deadline: string;
}>({
    title: todo.value.title,
    description: todo.value.description,
    deadline: todo.value.deadline,
});

function addUserToItem() {
    assignedUserForm.assignedTo.push(currentUser.value);
    assignedUserForm.transform(data => ({
        ...data,
        assignedTo: assignedUserForm.assignedTo.map(a => a.id),
    }));
    assignedUserForm.post(route('syncUserTodo', todo.value.id), { preserveScroll: true });
}

function delUserFromItem() {
    assignedUserForm.transform(data => ({
        ...data,
        assignedTo: assignedUserForm.assignedTo.filter(u => u.id !== currentUser.value.id).map(a => a.id),
    }));
    assignedUserForm.post(route('syncUserTodo', todo.value.id), { preserveScroll: true });
}

const syncStateTodoForm = useForm<{ state: 'Unstarted' | 'InWork' | 'Finished' }>({
    state: todo.value.state,
});

function syncStateTodo() {
    syncStateTodoForm.state =
        syncStateTodoForm.state == 'Unstarted'
            ? 'InWork'
            : syncStateTodoForm.state == 'InWork'
            ? 'Finished'
            : syncStateTodoForm.state == 'Finished'
            ? 'InWork'
            : 'Unstarted';

    syncStateTodoForm.post(route('syncStateTodo', todo.value.id), { preserveScroll: true });
}

function syncDataTodo() {
    if (currentUser.value.role === 'admin' || todo.value.user_id === currentUser.value.id) {
        syncDataTodoForm.post(route('syncDataTodo', todo.value.id), { preserveScroll: true });
    }
}
</script>

<template>
    <div>
        <!-- {{ assignedUserForm.assignedTo }} -->
        <Modal
            :title="todo.title"
            :affirm="{
                class: currentUser.id === todo.user_id ? 'btn btn-success ' : 'd-none',
                text: 'Speichern',
                disabled: !(syncDataTodoForm.title.length >= 5 && syncDataTodoForm.title.length <= 15),
                action: () => syncDataTodo(),
            }"
            :negative="{
                class: 'btn btn-danger',
                text: 'Löschen',
                action: () => router.post(route('deleteTodo', todo.id)),
            }"
        >
            <div id="todo">
                <div class="w-50">
                    <div>Todo erstellt von:</div>
                    <div class="ms-3">
                        {{ users.find(u => u.id === todo.user_id)?.name }}
                    </div>
                    <div>
                        <div v-if="currentUser.id === todo.user_id">
                            <TextInput placeholder="Titel" v-model="syncDataTodoForm.title" />
                        </div>
                    </div>
                    <div>
                        <div v-if="currentUser.id === todo.user_id">
                            <TextInput placeholder="Beschreibung" v-model="syncDataTodoForm.description" />
                        </div>
                        <div v-else>
                            <div class="mt-3">Ziel des Todos:</div>
                            <div class="ms-3">
                                {{ todo.description }}
                            </div>
                        </div>
                    </div>
                    <div>
                        <div v-if="currentUser.id === todo.user_id">
                            <DateInput placeholder="Abgabedatum" v-model="syncDataTodoForm.deadline" />
                        </div>
                        <div v-else>
                            <div class="mt-3">Abgabedatum:</div>
                            <div class="ms-3">
                                {{ todo.deadline }}
                            </div>
                        </div>
                    </div>
                </div>
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
                    <div class="card-header fw-bold d-flex justify-content-between align-items-center">
                        {{ todo.state == 'Finished' ? '✔️' : todo.state == 'InWork' ? '⚙️' : '❌' }}
                        {{ todo.title }}
                    </div>
                    <div class="card-body">
                        <span>
                            <p class="card-text">{{ todo.description }}</p>
                        </span>
                    </div>
                    <div class="card-footer d-flex justify-content-between align-items-center">
                        <span>
                            <b>Zugewiesene Benutzer:</b>
                            {{ todo.todo_item_user.map(a => a.name).join(', ') }}
                        </span>
                        <span>
                            <Button
                                v-if="todo.todo_item_user.find(e => e.id == currentUser.id)"
                                :class="!todo.todo_item_user.find(e => e.id == currentUser.id) ? 'btn btn-dark ' : 'btn btn-danger'"
                                @click.stop="syncStateTodo()"
                            >
                                {{
                                    todo.state == 'Unstarted'
                                        ? 'Start'
                                        : todo.state == 'InWork'
                                        ? 'Fertig'
                                        : todo.state == 'Finished'
                                        ? 'Weiter Arbeiten'
                                        : 'Fertig'
                                }}
                            </Button>
                            <Button
                                :class="!todo.todo_item_user.find(e => e.id == currentUser.id) ? 'btn btn-info ' : 'btn btn-danger'"
                                @click.stop="!todo.todo_item_user.find(e => e.id == currentUser.id) ? addUserToItem() : delUserFromItem()"
                                class="ms-2"
                            >
                                {{ !todo.todo_item_user.find(e => e.id == currentUser.id) ? 'Zuordnen' : 'Verlassen' }}
                            </Button>
                        </span>
                    </div>
                </div>
            </template>
        </Modal>
    </div>
</template>
