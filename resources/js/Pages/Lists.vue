<script setup lang="ts">
import ShowTodo from '@/Components/Dashboard/Show/ShowTodo.vue';
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
            <div v-for="todo of list.todo_items.filter(t => t.todo_item_user.filter(u => (u.id = currentUser.id)))">
                <ShowTodo
                    v-if="todo.todo_item_user.find(e => e.id == currentUser.id)"
                    :todo="todo"
                    :users="users"
                    :current-user="currentUser"
                    :list="list"
                    class="my-3"
                    style="max-height: max-content"
                />
            </div>
        </template>
    </AuthenticatedLayout>
</template>
<style scoped lang="scss"></style>
