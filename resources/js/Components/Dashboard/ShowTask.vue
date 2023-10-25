<script setup lang="ts">
import { Modal } from 'custom-mbd-components';
import { TodoItem, User } from '@/types';

const props = defineProps<{
    todo: TodoItem;
    currentUser: User;
}>();

// const { users } = toRefs(props);
</script>

<template>
    <Modal
        :title="todo.title"
        :affirm="{
            class: 'btn btn-success ',
            text: 'Zuordnen',
            disabled: !!todo.assignedTo.find(e => e.id == currentUser.id),
        }"
        :negative="{
            class: 'btn btn-danger',
            text: 'Verlassen',
            disabled: !todo.assignedTo.find(e => e.id == currentUser.id),
        }"
    >
        <div id="task">
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
                    Zugewiesene Benutzer: {{ todo.assignedTo.map(a => a.name).join(', ') }}
                </div>
            </div>
        </template>
    </Modal>
</template>
