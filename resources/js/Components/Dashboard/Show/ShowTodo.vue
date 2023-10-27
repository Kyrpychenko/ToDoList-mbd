<script setup lang="ts">
import { Modal } from 'custom-mbd-components';
import { TodoItem, TodoList, User } from '@/types';
import { useForm } from '@inertiajs/vue3';
import { toRefs } from 'vue';

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

function addUserToItem() {
    console.log('test');
    assignedUserForm.assignedTo.push(currentUser.value);
    assignedUserForm.transform(data => ({
        ...data,
        assignedTo: assignedUserForm.assignedTo.map(a => a.id),
    }));
    assignedUserForm.post(route('syncUserTodo', todo.value.id), { preserveScroll: true });
}

function delUserFromItem() {
    console.log('test');
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
    console.log(syncStateTdoForm);
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
                class: 'btn btn-success ',
                text: 'Zuordnen',
                action: () => addUserToItem(),
                disabled: !!todo.todo_item_user.find(e => e.id == currentUser.id),
            }"
            :negative="{
                class: 'btn btn-danger',
                text: 'Verlassen',
                action: () => delUserFromItem(),
                disabled: !todo.todo_item_user.find(e => e.id == currentUser.id),
            }"
        >
            <div id="todo">
                <div class="w-50">
                    <div>Todo erstellt von:</div>
                    <div class="ms-3">
                        {{ todo.owner }}
                    </div>
                    <div class="mt-3">Ziel des Todos:</div>
                    <div class="ms-3">
                        {{ todo.description }}
                    </div>
                </div>
                <div class="mt-3">Abgabedatum:</div>
                <div class="ms-3">{{ todo.deadline }}</div>
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
