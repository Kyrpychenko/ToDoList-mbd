<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { TodoList } from '@/types';
import { useForm } from '@inertiajs/vue3';
import { Button, Message, Modal, TextInput, SelectInput, TextareaInput, RadioGroup } from 'custom-mbd-components';
const props = defineProps<{ lists: TodoList[] }>();
const form = useForm({
    name: '',
});
function addList() {
    console.log('List schicken klappt');
    form.post(route('storeList'));
}
</script>
<template>
    <AuthenticatedLayout>
        <div class="list-group">
            <a href="#" class="list-group-item list-group-item-action list-group-item-secondary d-flex justify-content-between">
                Erstellen Sie eine neue Abteilung
                <Modal
                    :affirm="{ class: 'btn btn-success', text: 'Hinzufügen', action: addList }"
                    :negative="{ class: 'btn btn-danger', text: 'Abbrechen' }"
                >
                    <TextInput placeholder="Name" v-model="form.name"></TextInput>
                    <template #button><Button>Erstellen</Button></template>
                </Modal>
            </a>
        </div>
        <div class="list-group mt-3">
            <button type="button" class="list-group-item list-group-item-action" v-for="list of lists">{{ list.name }}</button>
        </div>
    </AuthenticatedLayout>
</template>
<style scoped lang="scss"></style>
