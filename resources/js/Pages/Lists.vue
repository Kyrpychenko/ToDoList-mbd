<script setup lang="ts">
import ShowTodo from '@/Components/Dashboard/Show/ShowTodo.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { TodoList, User } from '@/types';
import { toRefs, watchEffect } from 'vue';
import { displayedTodos, allLists } from '@/Components/Menu/menu';

const props = defineProps<{
    users: User[];
    currentUser: User;
    currentLists: TodoList[];
}>();
const { users, currentUser, currentLists } = toRefs(props);
watchEffect(() => (allLists.value = currentLists.value));
allLists.value = currentLists.value;
</script>

<template>
    <AuthenticatedLayout>
        <ShowTodo
            v-for="todo of displayedTodos.filter(e => e.todo_item_user.find(e => e.id == currentUser.id))"
            :todo="todo"
            :users="users"
            :current-user="currentUser"
            class="my-3"
            style="max-height: max-content"
        />
    </AuthenticatedLayout>
</template>
<style scoped lang="scss"></style>
