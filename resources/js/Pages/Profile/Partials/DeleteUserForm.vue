<script setup lang="ts">
import { useForm } from '@inertiajs/vue3';
import { Button, Modal, PasswordInput } from 'custom-mbd-components';
import { nextTick, ref } from 'vue';

const confirmingUserDeletion = ref(false);
const passwordInput = ref<HTMLInputElement | null>(null);

const form = useForm({
    password: '',
});

const confirmUserDeletion = () => {
    confirmingUserDeletion.value = true;

    nextTick(() => passwordInput.value?.focus());
};

const deleteUser = () => {
    form.delete(route('profile.destroy'), {
        preserveScroll: true,
        onSuccess: () => closeModal(),
        onError: () => passwordInput.value?.focus(),
        onFinish: () => {
            form.reset();
        },
    });
};

const closeModal = () => {
    confirmingUserDeletion.value = false;

    form.reset();
};
</script>

<template>
    <Modal
        :title="'Sind sie sicher das sie ihren Account löschen wollen?'"
        :show="confirmingUserDeletion"
        @close="closeModal"
        :affirm="{
            class: 'btn btn-danger',
            text: 'Account Löschen',
            action: () => deleteUser,
        }"
        :negative="{
            class: 'btn btn-primary',
            text: 'Abbrechen',
            action: () => closeModal,
        }"
    >
        <template #button>
            <header>
                <h2>Account Löschen</h2>
                <p>Sobald ihr Account gelöscht ist, gehen all ihre daten unwiederruflich verloren.</p>
            </header>

            <Button @click="confirmUserDeletion" class="btn btn-danger">Delete Account</Button>
        </template>

        <div class="p-6">
            <p>Sobald ihr Account gelöscht ist, gehen all ihre daten unwiederruflich verloren.</p>
            <PasswordInput
                id="password"
                ref="passwordInput"
                v-model="form.password"
                type="password"
                placeholder="Password"
                @keyup.enter="deleteUser"
            />
        </div>
    </Modal>
</template>
