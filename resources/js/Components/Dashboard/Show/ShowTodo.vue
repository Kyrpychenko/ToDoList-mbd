<script setup lang="ts">
import { Modal } from 'custom-mbd-components';
import { TodoItem, User } from '@/types';

const props = defineProps<{
    todo: TodoItem;
    currentUser: User;
}>();
</script>

<template>
    <div>
        <Modal
            :title="todo.title"
            :affirm="{
                class: 'btn btn-success ',
                text: 'Zuordnen',
                disabled: !!todo.todo_item_user.find(e => e.id == currentUser.id),
            }"
            :negative="{
                class: 'btn btn-danger',
                text: 'Verlassen',
                disabled: !todo.todo_item_user.find(e => e.id == currentUser.id),
            }"
        >
            <div id="todo">
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
                    <div class="card-footer" v-if="todo.todo_item_user.length > 0">
                        Zugewiesene Benutzer: {{ todo.todo_item_user.map(a => a.name).join(', ') }}
                    </div>
                </div>
            </template>
        </Modal>
    </div>
</template>
