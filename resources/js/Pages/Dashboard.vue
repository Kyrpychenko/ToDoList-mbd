<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import ShowTodo from '@//Components/Dashboard/Show/ShowTodo.vue';
import ShowList from '@/Components/Dashboard/Show/ShowList.vue';
import CreateList from '@/Components/Dashboard/Create/CreateList.vue';
import CreateTodo from '@/Components/Dashboard/Create/CreateTodo.vue';
import { Head } from '@inertiajs/vue3';
import { TodoList, User } from '@/types';
import { toRefs } from 'vue';
import { computed } from 'vue';

const props = defineProps<{
    users: User[];
    currentUser: User;
    currentLists: TodoList[];
    lists: TodoList[];
}>();
const { users, currentUser, currentLists, lists } = toRefs(props);
const displateLists = computed(() => (currentUser.value.role === 'admin' ? lists.value : currentLists.value));
</script>
<template>
    <Head title="Dashboard" />
    <AuthenticatedLayout>
        <CreateTodo :users="users" :current-lists="currentLists" />
        <CreateList :users="users" :current-user="currentUser" />
        <template v-for="list of displateLists">
            <ShowList :list="list" :current-user="currentUser" :users="users" />
            <!-- {{ list.todo_items[0] }} -->
            <ShowTodo v-for="todo of list.todo_items" :todo="todo" :current-user="currentUser" class="my-3" style="max-height: max-content" />
        </template>
    </AuthenticatedLayout>
</template>
