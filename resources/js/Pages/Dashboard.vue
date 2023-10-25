<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import ShowTask from '@//Components/Dashboard/ShowTask.vue';
import ShowList from '@/Components/Dashboard/ShowList.vue';
import CreateList from '@/Components/Dashboard/CreateList.vue';
import CreateTask from '@/Components/Dashboard/CreateTask.vue';
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

// console.log(users);
</script>
<template>
    <Head title="Dashboard" />
    <AuthenticatedLayout>
        <CreateTask :users="users" :current-lists="currentLists"></CreateTask>
        <CreateList :users="users" :current-user="currentUser"></CreateList>
        <template v-for="list of currentLists">
            <ShowList :list="list" :current-user="currentUser" :users="users"></ShowList>
            <div v-for="todo of list.todos" class="my-3" style="max-height: max-content">
                <ShowTask :todo="todo" :current-user="currentUser"></ShowTask>
            </div>
        </template>
        <!-- </div> -->
    </AuthenticatedLayout>
</template>
