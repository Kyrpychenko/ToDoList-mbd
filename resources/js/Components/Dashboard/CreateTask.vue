<script setup lang="ts">
import { Button, Modal, TextInput, SelectInput, TextareaInput, RadioGroup, MultiSelectInput, DateInput } from 'custom-mbd-components';
import { useForm } from '@inertiajs/vue3';
import { TodoList, User } from '@/types';
import { getPriorityNumber, Priority } from '@/utility';
import { computed, ref } from 'vue';
import { toRefs } from 'vue';
import { watch } from 'vue';

const props = defineProps<{
    users: User[];
    currentLists: TodoList[];
}>();
const { users } = toRefs(props);

const itemModalOpen = ref(false);
watch(itemModalOpen, () => taskForm.reset());

function addListItem() {
    taskForm.transform(data => ({
        ...data,
        priority: getPriorityNumber(data.priority),
        assignedTo: taskForm.assignedTo.map(a => a.id),
    }));
    taskForm.post(route('storeTodo'));
}

const possibleUsers = computed(() => users.value.filter(u => u.todo_lists.filter(l => l.id == taskForm.selectedList).length != 0));

const taskForm = useForm<{ title: string; description: string; priority: Priority; assignedTo: User[]; selectedList: number; deadline: string }>({
    title: '',
    description: '',
    priority: 'Niedrig',
    assignedTo: [],
    selectedList: 0,
    deadline: '',
});
</script>
<template>
    <div class="list-group">
        <a href="#" class="list-group-item list-group-item-action list-group-item-secondary d-flex justify-content-between">
            Fügen Sie etwas zur Liste hinzu:
            <Modal
                v-model="itemModalOpen"
                :affirm="{ class: 'btn btn-success ', text: 'Hinzufügen', action: addListItem }"
                :negative="{ class: 'btn btn-danger', text: 'Abbrechen' }"
            >
                <!-- <form @submit="preve"></form> -->
                <TextInput placeholder="Titel" v-model="taskForm.title" min="10" required></TextInput>
                <TextareaInput placeholder="Beschreibung" v-model="taskForm.description"></TextareaInput>
                <div class="mt-2">Priorität:</div>
                <RadioGroup
                    :options="[
                        { text: 'Hoch', value: 'Hoch' },
                        { text: 'Mittel', value: 'Mittel' },
                        { text: 'Niedrig', value: 'Niedrig' },
                    ]"
                    v-model="taskForm.priority"
                ></RadioGroup>
                <div class="mt-2">Fertig bis:</div>
                <DateInput v-model="taskForm.deadline"></DateInput>
                <SelectInput
                    showAll
                    placeholder="Liste"
                    :options="currentLists"
                    @selectItem="e => (taskForm.selectedList = e.id)"
                    :optionProjection="e => e.name + ''"
                ></SelectInput>
                <div class="mt-2">Zugewiesene Benutzer:</div>

                <MultiSelectInput
                    v-model:selected="taskForm.assignedTo"
                    placeholder="Zuweisung"
                    :options="possibleUsers"
                    :optionProjection="e => e.name"
                ></MultiSelectInput>
                <template #button><Button>Hinzufügen</Button></template>
            </Modal>
        </a>
    </div>
</template>
