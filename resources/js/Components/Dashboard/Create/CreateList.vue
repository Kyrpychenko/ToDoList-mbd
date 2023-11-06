<script setup lang="ts">
import { Modal, TextInput, MultiSelectInput } from 'custom-mbd-components';
import { User } from '@/types';
import { ref, toRefs, watch } from 'vue';
import { useForm } from '@inertiajs/vue3';

const props = defineProps<{
    currentUser: User;
    users: User[];
}>();

const { users } = toRefs(props);
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
    listForm.post(route('storeList'), { preserveScroll: true });
}
</script>

<template>
    <div v-if="currentUser.role == 'admin'" class="list-group my-3">
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
                :options="users.filter(u => u.role !== 'admin')"
                :optionProjection="e => e.name"
            ></MultiSelectInput>
            <template #button>
                <div class="list-group">
                    <a href="#" class="list-group-item list-group-item-action list-group-item-secondary d-flex justify-content-between">
                        <span>
                            <i class="bi bi-plus-circle"></i>
                            Liste erstellen:
                        </span>
                    </a>
                </div>
            </template>
        </Modal>
    </div>
</template>
