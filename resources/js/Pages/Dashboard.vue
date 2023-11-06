<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import ShowTodo from '@//Components/Dashboard/Show/ShowTodo.vue';
import ShowList from '@/Components/Dashboard/Show/ShowList.vue';
import CreateList from '@/Components/Dashboard/Create/CreateList.vue';
import CreateTodo from '@/Components/Dashboard/Create/CreateTodo.vue';
import { Head } from '@inertiajs/vue3';
import { TodoList, User } from '@/types';
import { toRefs } from 'vue';
import { displayedLists, allLists } from '@/Components/Menu/menu';

const props = defineProps<{
    users: User[];
    currentUser: User;
    currentLists: TodoList[];
}>();
const { users, currentUser, currentLists } = toRefs(props);
allLists.value = currentLists.value;
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
                <ShowTodo
                    v-for="todo of list.todo_items"
                    :todo="todo"
                    :users="users"
                    :current-user="currentUser"
                    :list="list"
                    class="my-2"
                    style="max-height: max-content"
                />
            </div>
        </template>
    </AuthenticatedLayout>
</template>
