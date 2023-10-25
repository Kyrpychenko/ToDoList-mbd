<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import ShowTodo from '@//Components/Dashboard/Show/ShowTodo.vue';
import ShowList from '@/Components/Dashboard/Show/ShowList.vue';
import CreateList from '@/Components/Dashboard/Create/CreateList.vue';
import CreateTodo from '@/Components/Dashboard/Create/CreateTodo.vue';
import { Head } from '@inertiajs/vue3';
import { TodoList, User } from '@/types';
import { toRefs } from 'vue';

const props = defineProps<{
    users: User[];
    currentUser: User;
    currentLists: TodoList[];
    lists: TodoList[];
}>();
const { users } = toRefs(props);
</script>
<template>
    <Head title="Dashboard" />
    <AuthenticatedLayout>
        <CreateTodo :users="users" :current-lists="currentLists" />
        <CreateList :users="users" :current-user="currentUser" />
        <template v-for="list of currentLists">
            <ShowList :list="list" :current-user="currentUser" :users="users" />
            <ShowTodo v-for="todo of list.todos" :todo="todo" :current-user="currentUser" class="my-3" style="max-height: max-content" />
        </template>
    </AuthenticatedLayout>
</template>
