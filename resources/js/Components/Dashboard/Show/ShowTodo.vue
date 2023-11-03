<script setup lang="ts">
import { Button, Modal, TextInput, MultiSelectInput, DateInput } from 'custom-mbd-components';
import { TodoItem, TodoList, User } from '@/types';
import { useForm } from '@inertiajs/vue3';
import { toRefs } from 'vue';
import { Priority } from '@/utility';

const props = defineProps<{
    users: User[];
    todo: TodoItem;
    currentUser: User;
    list: TodoList;
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

const syncStateTdoForm = useForm<{ state: 'Unstarted' | 'InWork' | 'Finished' }>({
    state: todo.value.state,
});

function syncStateTodo() {
    syncStateTdoForm.state =
        syncStateTdoForm.state == 'Unstarted'
            ? 'InWork'
            : syncStateTdoForm.state == 'InWork'
            ? 'Finished'
            : syncStateTdoForm.state == 'Finished'
            ? 'InWork'
            : 'Unstarted';

    syncStateTdoForm.post(route('syncStateTodo', todo.value.id), { preserveScroll: true });
}

function syncTodo() {
    syncTodoForm.post(route('syncTodo', todo.value.id), { preserveScroll: true });
}
</script>

<template>
    <div>
        <!-- {{ assignedUserForm.assignedTo }} -->
        <Modal
            :title="todo.title"
            :affirm-alt="{
                text:
                    todo.state == 'Unstarted' ? 'Start' : todo.state == 'InWork' ? 'Fertig' : todo.state == 'Finished' ? 'Weiter Arbeiten' : 'Fertig',
                action: () => syncStateTodo(),
                class: 'btn btn-dark ',
            }"
            :affirm="{
                class: !todo.todo_item_user.find(e => e.id == currentUser.id) ? 'btn btn-success ' : 'btn btn-danger',
                text: !todo.todo_item_user.find(e => e.id == currentUser.id) ? 'Zuordnen' : 'Verlassen',
                action: !todo.todo_item_user.find(e => e.id == currentUser.id) ? () => addUserToItem() : () => delUserFromItem(),
            }"
            :negative="{
                class: currentUser.id === todo.user_id ? 'btn btn-success ' : 'd-none',
                text: 'Speichern',
                disabled: !(todo.title.length >= 5 && todo.title.length <= 15),
                action: () => syncTodo(),
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
                            <TextInput placeholder="Titel" v-model="syncTodoForm.title" />
                        </div>
                    </div>
                    <div>
                        <div v-if="currentUser.id === todo.user_id">
                            <TextInput placeholder="Beschreibung" v-model="syncTodoForm.description" />
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
                            <DateInput placeholder="Abgabedatum" v-model="syncTodoForm.deadline" />
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
                    <div class="card-header fw-bold">
                        {{ todo.state == 'Finished' ? '✔️' : todo.state == 'InWork' ? '⚙️' : '❌' }}
                        {{ todo.title }}
                    </div>
                    <div class="card-body">
                        <p class="card-text">{{ todo.description }}{{ todo.description }}</p>
                    </div>
                    <div class="card-footer" v-if="todo.todo_item_user.length > 0">
                        Zugewiesene Benutzer: {{ todo.todo_item_user.map(a => a.name).join(', ') }}
                    </div>
                </div>
            </template>
        </Modal>
    </div>
</template>
