<script setup lang="ts">
import { Modal, MultiSelectInput } from 'custom-mbd-components';
import { useForm } from '@inertiajs/vue3';
import { TodoList, User } from '@/types';
import { Priority } from '@/utility';
import { computed, ref } from 'vue';
import { toRefs } from 'vue';

const props = defineProps<{
    // todo: TodoItem;
    currentUser: User;
    list: TodoList;
    users: User[];
}>();
const { users } = toRefs(props);

const assignUserForm = useForm<{ assignedTo: User[] }>({
    assignedTo: [],
});

const assignedUsers = computed(() => users.value.filter(u => u.todo_lists.filter(l => l.id == todoForm.selectedList).length != 0));

const todoForm = useForm<{ title: string; description: string; priority: Priority; assignedTo: User[]; selectedList: number; deadline: string }>({
    title: '',
    description: '',
    priority: 'Niedrig',
    assignedTo: [],
    selectedList: 0,
    deadline: '',
});

function syncUserList(list: TodoList) {
    assignUserForm.transform(data => ({
        ...data,
        assignedTo: assignUserForm.assignedTo.map(a => a.id),
    }));
    assignUserForm.post(route('syncUserList', list.id));
}
</script>

<template>
    <Modal
        :title="list.name"
        :affirm="{ class: 'btn btn-success ', text: 'Speichern', action: () => syncUserList(list) }"
        :negative="{ class: 'btn btn-danger', text: 'Abbrechen', action: () => assignUserForm.reset() }"
    >
        <div id="list">
            <div class="card-body">
                Zugewiesene Benutzer:
                <div v-for="user in users.filter(u => u.todo_lists.filter(l => l.id == list.id).length)">
                    <Modal
                        :title="user.name"
                        :affirm="{
                            class: 'btn btn-success ',
                            text: 'Entfernen',
                            action: () => console.log(user.name),
                        }"
                        :negative="{
                            class: 'btn btn-danger',
                            text: 'Abbrechen',
                        }"
                    >
                        <div class="card-body">Nutzer entfernen?</div>

                        <template #button>
                            <div class="my-3 card text-black text-center" style="background-color: #f1ede4">
                                <div class="card-header">
                                    <p class="card-text">{{ user.name }}</p>
                                </div>
                            </div>
                        </template>
                    </Modal>
                </div>
                <MultiSelectInput
                    v-model:selected="assignUserForm.assignedTo"
                    placeholder="+"
                    style="background-color: #f1ede4"
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
