<script setup lang="ts">
import { Button, Modal, TextInput, MultiSelectInput } from 'custom-mbd-components';
import { TodoItem, User } from '@/types';
import { ref, watch } from 'vue';
import { useForm } from '@inertiajs/vue3';

const props = defineProps<{
    currentUser: User;
    users: User[];
}>();

// const { users } = toRefs(props);
const listForm = useForm<{ name: string; assignedTo: User[] }>({
    name: '',
    assignedTo: [],
});

const listModalOpen = ref(false);
watch(listModalOpen, () => listForm.reset());

function addList() {
    listForm.transform(data => ({
        ...data,
        assignedTo: listForm.assignedTo.map(a => a.id),
    }));
    listForm.post(route('storeList'));
}
</script>

<template>
    <div v-if="currentUser.role == 'admin'" class="list-group my-3">
        <a href="#" class="list-group-item list-group-item-action list-group-item-secondary d-flex justify-content-between">
            Fügen Sie eine Liste hinzu:
            <Modal
                v-model="listModalOpen"
                :affirm="{ class: 'btn btn-success ', text: 'Hinzufügen', action: addList }"
                :negative="{ class: 'btn btn-danger', text: 'Abbrechen' }"
            >
                <TextInput placeholder="List Name" v-model="listForm.name"></TextInput>
                <div class="mt-2">Zugewiesene Benutzer:</div>
                <MultiSelectInput
                    v-model:selected="listForm.assignedTo"
                    placeholder="Zuweisung"
                    :options="users"
                    :optionProjection="e => e.name"
                ></MultiSelectInput>
                <template #button><Button>Hinzufügen</Button></template>
            </Modal>
        </a>
    </div>
</template>
