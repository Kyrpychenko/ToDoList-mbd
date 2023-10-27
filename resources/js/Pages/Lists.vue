<script setup lang="ts">
import ShowList from '@/Components/Dashboard/Show/ShowList.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { TodoList, User } from '@/types';
import { computed, toRefs } from 'vue';

const props = defineProps<{
    users: User[];
    currentUser: User;
    currentLists: TodoList[];
    lists: TodoList[];
}>();
const { users, currentUser, currentLists, lists } = toRefs(props);

const displateLists = computed(() => (currentUser.value.role == 'admin' ? lists.value : currentLists.value));
</script>

<template>
    <AuthenticatedLayout>
        <template v-for="list of displateLists">
            <ShowList :list="list" :current-user="currentUser" :users="users" />
            <!-- {{ list.todo_items[0] }} -->
            <ShowTodo
                v-for="todo of list.todo_items"
                :todo="todo"
                :users="users"
                :current-user="currentUser"
                :list="list"
                class="my-3"
                style="max-height: max-content"
            />
        </template>
    </AuthenticatedLayout>
</template>
<style scoped lang="scss"></style>
