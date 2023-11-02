<script setup lang="ts">
import { Button, Modal, TextInput, SelectInput, TextareaInput, RadioGroup, MultiSelectInput, DateInput } from 'custom-mbd-components';
import { useForm } from '@inertiajs/vue3';
import { TodoList, User } from '@/types';
import { getPriorityNumber, Priority } from '@/utility';
import { computed, ref } from 'vue';
import { toRefs } from 'vue';
import { watch } from 'vue';

const props = defineProps<{
    lists: TodoList[];
    users: User[];
    currentLists: TodoList[];
    currentuser: User;
}>();
const { users, currentuser } = toRefs(props);

const itemModalOpen = ref(false);
watch(itemModalOpen, () => todoForm.reset());

function addListItem() {
    todoForm.transform(data => ({
        ...data,
        priority: getPriorityNumber(data.priority),
        assignedTo: todoForm.assignedTo.map(a => a.id),
    }));
    todoForm.post(route('storeTodo'), { preserveScroll: true });
    // console.log(todoForm);
}

const possibleUsers = computed(() => users.value.filter(u => u.todo_lists.filter(l => l.id == todoForm.selectedList).length != 0));

const todoForm = useForm<{
    title: string;
    description: string;
    priority: Priority;
    assignedTo: User[];
    selectedList: number;
    deadline: string;
    owner: string;
}>({
    title: '',
    description: '',
    owner: currentuser.value.name,
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
                :affirm="{
                    class: 'btn btn-success ',
                    text: 'Hinzufügen',
                    action: addListItem,
                    disabled: !todoForm.title || !todoForm.description || !todoForm.priority || !todoForm.deadline || !todoForm.selectedList,
                }"
                :negative="{ class: 'btn btn-danger', text: 'Abbrechen' }"
            >
                <!-- <form @submit="preve"></form> -->
                <TextInput placeholder="Titel" v-model="todoForm.title" min="10" required />
                <TextareaInput placeholder="Beschreibung" v-model="todoForm.description" />
                <div class="mt-2">Priorität:</div>
                <RadioGroup
                    :options="[
                        { text: 'Hoch', value: 'Hoch' },
                        { text: 'Mittel', value: 'Mittel' },
                        { text: 'Niedrig', value: 'Niedrig' },
                    ]"
                    v-model="todoForm.priority"
                ></RadioGroup>
                <div class="mt-2">Fertig bis:</div>
                <DateInput v-model="todoForm.deadline"></DateInput>
                <SelectInput
                    showAll
                    placeholder="Liste"
                    :options="currentuser.role === 'admin' ? lists : currentLists"
                    @selectItem="e => (todoForm.selectedList = e.id)"
                    :optionProjection="e => e.name + ''"
                ></SelectInput>
                <div class="mt-2">Zugewiesene Benutzer:</div>

                <MultiSelectInput
                    v-model:selected="todoForm.assignedTo"
                    placeholder="Zuweisung"
                    :options="possibleUsers"
                    :optionProjection="e => e.name"
                ></MultiSelectInput>
                <template #button><Button>Hinzufügen</Button></template>
            </Modal>
        </a>
    </div>
</template>
