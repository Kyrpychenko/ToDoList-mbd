<script setup lang="ts">
import { Modal, TextInput, SelectInput, TextareaInput, RadioGroup, MultiSelectInput, DateInput } from 'custom-mbd-components';
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
    currentUser: User;
}>();
const { users, currentUser } = toRefs(props);

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
    user_id: number;
}>({
    title: '',
    description: '',
    user_id: currentUser.value.id,
    priority: 'Niedrig',
    assignedTo: [],
    selectedList: 0,
    deadline: '',
});
</script>
<template>
    <Modal
        v-model="itemModalOpen"
        :affirm="{
            class: 'btn btn-success ',
            text: 'Hinzufügen',
            action: addListItem,
            disabled:
                todoForm.title.length > 35 ||
                todoForm.title.length < 5 ||
                !todoForm.description ||
                !todoForm.priority ||
                !todoForm.deadline ||
                !todoForm.selectedList,
        }"
        :negative="{ class: 'btn btn-danger', text: 'Abbrechen' }"
    >
        <!-- <form @submit="preve"></form> -->
        <TextInput placeholder="Titel" v-model="todoForm.title" min="5" max="35" required />
        <div v-if="!(todoForm.title.length >= 5 && todoForm.title.length <= 35)">Der Name muss zwischen 5 und 35 zeichen haben.</div>
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
        <!-- <div class="mt-2">Fertig bis:</div> -->
        <DateInput v-model="todoForm.deadline" placeholder="Fälligkeitsdatum" />
        <SelectInput
            showAll
            placeholder="Liste"
            :options="currentUser.role === 'admin' ? lists : currentLists"
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
        <template #button>
            <div class="list-group">
                <a href="#" class="list-group-item list-group-item-action list-group-item-secondary d-flex justify-content-between">
                    <span>
                        <i class="bi bi-plus-circle"></i>
                        Aufgabe erstellen
                    </span>
                </a>
            </div>
        </template>
    </Modal>
</template>
