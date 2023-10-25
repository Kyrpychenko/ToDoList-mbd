<script setup lang="ts">
import { Modal, MultiSelectInput } from 'custom-mbd-components';
import { useForm } from '@inertiajs/vue3';
import { TodoList, User } from '@/types';
import { Priority } from '@/utility';
import { computed, ref } from 'vue';
import { toRefs } from 'vue';

const props = defineProps<{
    currentUser: User;
    list: TodoList;
    users: User[];
}>();
const { users, list } = toRefs(props);

const assignUserForm = useForm<{ assignedTo: User[] }>({
    assignedTo: users.value.filter(u => u.todo_lists.filter(l => l.id == list.value.id).length),
});

function syncUserList(list: TodoList) {
    assignUserForm.transform(data => ({
        ...data,
        assignedTo: assignUserForm.assignedTo.map(a => a.id),
    }));
    assignUserForm.post(route('syncUserList', list.id));
    // assignUserForm.reset();
}
</script>

<template>
    <Modal
        :title="list.name"
        :affirm="{ class: 'btn btn-success ', text: currentUser.role == 'admin' ? 'Speichern' : 'schließen', action: () => syncUserList(list) }"
        :negative="{ class: 'btn btn-danger', text: 'Abbrechen', action: () => assignUserForm.reset() }"
    >
        <div id="list">
            <div class="card-body">
                Zugewiesene Benutzer:
                <div v-for="user in users.filter(u => u.todo_lists.filter(l => l.id == list.id).length && u.role !== 'admin')">
                    <div class="my-3 card text-black text-center" style="background-color: #f1ede4">
                        <div class="card-header">
                            <p class="card-text">{{ user.name }}</p>
                        </div>
                    </div>
                </div>
                <MultiSelectInput
                    v-if="currentUser.role == 'admin'"
                    v-model:selected="assignUserForm.assignedTo"
                    :keyExtractor="e => e.id + ''"
                    :show-selected="false"
                    placeholder="+"
                    :options="users.filter(u => u.role !== 'admin')"
                    :optionProjection="e => e.name"
                ></MultiSelectInput>
            </div>
        </div>
        <template #button>
            <div class="my-3 card text-black text-center" style="background-color: #fd7e14">
                <div class="card-header">
                    <p class="card-text">-{{ list.name }}-</p>
                </div>
            </div>
        </template>
    </Modal>
</template>
