<script setup lang="ts">
import { Modal, MultiSelectInput, TextInput } from 'custom-mbd-components';
import { useForm } from '@inertiajs/vue3';
import { TodoList, User } from '@/types';
import { toRefs } from 'vue';

const props = defineProps<{
    currentUser: User;
    list: TodoList;
    users: User[];
}>();
const { users, list, currentUser } = toRefs(props);

const listForm = useForm<{ assignedTo: User[]; name: string }>({
    assignedTo: users.value.filter(u => u.todo_lists.filter(l => l.id == list.value.id).length),
    name: list.value.name,
});

function syncList() {
    if (currentUser.value.role === 'admin') {
        console.log('f');
        listForm.transform(data => ({
            ...data,
            assignedTo: listForm.assignedTo.map(a => a.id),
        }));
        listForm.post(route('syncList', list.value.id), { preserveScroll: true });
    }
}
</script>

<template>
    <Modal
        :title="'Liste: ' + list.name"
        :affirm="{ class: 'btn btn-success ', text: currentUser.role == 'admin' ? 'Speichern' : 'schließen', action: () => syncList() }"
        :negative="{ class: 'btn btn-danger', text: 'Abbrechen', action: () => listForm.reset() }"
    >
        <div id="list">
            <div class="card-body">
                <TextInput placeholder="Name" v-if="currentUser.role == 'admin'" v-model="listForm.name" />
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
                    v-model:selected="listForm.assignedTo"
                    :keyExtractor="e => e.id + ''"
                    :show-selected="false"
                    placeholder="+"
                    :options="users.filter(u => u.role !== 'admin')"
                    :optionProjection="e => e.name"
                ></MultiSelectInput>
            </div>
        </div>
        <template #button>
            <div class="mt-4 card text-black text-center" style="background-color: rgba(134, 179, 252, 0.549) 129, 129, 0.549)">
                <div class="card-header">
                    <p class="card-text">-{{ list.name }}-</p>
                </div>
            </div>
        </template>
    </Modal>
</template>
