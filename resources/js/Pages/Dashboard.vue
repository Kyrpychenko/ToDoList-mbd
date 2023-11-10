<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import ShowTodo from '@//Components/Dashboard/Show/ShowTodo.vue';
import ShowList from '@/Components/Dashboard/Show/ShowList.vue';
import CreateList from '@/Components/Dashboard/Create/CreateList.vue';
import CreateTodo from '@/Components/Dashboard/Create/CreateTodo.vue';
import { Head } from '@inertiajs/vue3';
import { TodoList, User } from '@/types';
import { toRefs } from 'vue';
import { displayedLists, allLists, currentUser as menuUser } from '@/Components/Menu/menu';
import { watchEffect } from 'vue';

const props = defineProps<{
    users: User[];
    currentUser: User;
    currentLists: TodoList[];
}>();
const { users, currentUser, currentLists } = toRefs(props);
watchEffect(() => (allLists.value = currentLists.value));
menuUser.value = currentUser.value;
</script>
<template>
    <Head title="Dashboard" />
    <AuthenticatedLayout>
        <!-- {{ currentLists.flatMap(e => e.todo_items) }} -->
        <CreateTodo :users="users" :current-lists="currentLists" :currentUser="currentUser" :lists="currentLists" />
        <CreateList :users="users" :current-user="currentUser" />

        <template v-for="list of displayedLists">
            <div style="background-color: #ddd; border-radius: 15px 15px 15px 15px">
                <ShowList :list="list" :current-user="currentUser" :users="users" />
                <TransitionGroup name="todo">
                    <ShowTodo
                        v-for="todo of list.todo_items"
                        :key="todo.id"
                        :todo="todo"
                        :users="users"
                        :current-user="currentUser"
                        :list="list"
                        class="my-2"
                        style="max-height: max-content"
                    />
                </TransitionGroup>
            </div>
        </template>
        <template v-if="!displayedLists.filter(l => l.todo_items).length">
            <div class="text-center mt-5">
                <h4>Alle aufgaben sind erledigt, {{ currentUser.name.slice(0, 1).toLocaleUpperCase() + currentUser.name.slice(1) }}!</h4>
                <p>Genieße den Rest deiner Freizeit.</p>
            </div>
        </template>
    </AuthenticatedLayout>
</template>
<style scoped>
.todo-move,
.todo-enter-active,
.todo-leave-active {
    transition: all 0.1s ease;
}

.todo-enter-from,
.todo-leave-to {
    opacity: 0;
}

.todo-leave-active .todo-enter-active {
    position: relative;
}
</style>
