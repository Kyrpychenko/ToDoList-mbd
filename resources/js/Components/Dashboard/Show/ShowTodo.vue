<script setup lang="ts">
import { Button, Modal, TextInput, DateInput, TextareaInput } from 'custom-mbd-components';
import { TodoItem, User } from '@/types';
import { router, useForm } from '@inertiajs/vue3';
import { toRefs } from 'vue';

const props = defineProps<{
    users: User[];
    todo: TodoItem;
    currentUser: User;
}>();
const { todo, currentUser } = toRefs(props);

const assignedUserForm = useForm<{ assignedTo: User[] }>({
    assignedTo: todo.value.todo_item_user,
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

const syncStateTodoForm = useForm<{ state: 'unfinished' | 'finished' }>({
    state: todo.value.state,
});

function syncStateTodo() {
    syncStateTodoForm.state = syncStateTodoForm.state == 'unfinished' ? 'finished' : 'unfinished';

    syncStateTodoForm.post(route('syncStateTodo', todo.value.id), {
        preserveScroll: true,
        onSuccess() {
            router.reload({ only: ['currentLists'] });
        },
    });
}

function syncDataTodo() {
    if (currentUser.value.role === 'admin' || todo.value.user_id === currentUser.value.id) {
        syncDataTodoForm.post(route('syncDataTodo', todo.value.id), {
            preserveScroll: true,
            onSuccess() {
                router.reload({ only: ['currentLists'] });
            },
        });
    }
    // router.reload({ only: ['todo_items'] });
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
                disabled: !(syncDataTodoForm.title.length >= 5 && syncDataTodoForm.title.length <= 25),
                action: () => syncDataTodo(),
            }"
            :negative="{
                class: currentUser.id === todo.user_id ? 'btn btn-danger' : 'd-none',
                text: 'Löschen',
                action: () => router.post(route('deleteTodo', todo.id)),
            }"
        >
            <div>
                <div class="w-50">
                    <div>Todo erstellt von:</div>
                    <div class="ms-3">
                        {{ users.find(u => u.id === todo.user_id)?.name }}
                    </div>
                    <div>
                        <div v-if="currentUser.id === todo.user_id">
                            <TextInput placeholder="Titel" v-model="syncDataTodoForm.title" />
                            <div v-if="!(syncDataTodoForm.title.length >= 5 && syncDataTodoForm.title.length <= 15)">
                                Der Name muss zwischen Fünf und Fünfzehn zeichen haben.
                            </div>
                        </div>
                    </div>
                    <div>
                        <div v-if="currentUser.id === todo.user_id">
                            <TextareaInput placeholder="Beschreibung" v-model="syncDataTodoForm.description" />
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
                    class="card text-dark border border-2"
                    :class="{
                        'border-warning': todo.priority == 2,
                        'border-success': todo.priority == 1,
                        ' border-danger': todo.priority == 3,
                    }"
                >
                    <div class="card-header fw-bold d-flex justify-content-between align-items-center">
                        <span>
                            <i class="bi bi-check-circle-fill text-success" v-if="syncStateTodoForm.state == 'finished'"></i>
                            <i class="bi bi-x-circle-fill text-danger" v-if="syncStateTodoForm.state == 'unfinished'"></i>

                            {{ todo.title }}
                        </span>
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
                                class="btn btn-primary"
                                @click.stop="syncStateTodo()"
                            >
                                {{ todo.state == 'unfinished' ? 'Fertig' : 'Nicht Fertig' }}
                            </Button>
                            <Button
                                :class="!todo.todo_item_user.find(e => e.id == currentUser.id) ? 'btn btn-success ' : 'btn btn-danger'"
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
