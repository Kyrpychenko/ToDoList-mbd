<script setup lang="ts">
import { Button, PasswordInput } from 'custom-mbd-components';
import { useForm } from '@inertiajs/vue3';

const form = useForm({
    current_password: '',
    password: '',
    password_confirmation: '',
});

const updatePassword = () => {
    form.put(route('password.update'), {
        preserveScroll: true,
        onSuccess: () => {
            form.reset();
        },
        onError: () => {
            if (form.errors.password) {
                form.reset('password', 'password_confirmation');
            }
            if (form.errors.current_password) {
                form.reset('current_password');
            }
        },
    });
};
</script>

<template>
    <section>
        <header>
            <h2>Neues Passwort</h2>
            <p>Stellen Sie sicher, dass Ihr Account ein langes und sicheres Passwort nutzt.</p>
        </header>

        <form @submit.prevent="updatePassword">
            <PasswordInput
                v-model="form.current_password"
                required
                autofocus
                autocomplete="current-password"
                placeholder="Passwort"
                :errors="form.errors.current_password"
            />
            <PasswordInput v-model="form.password" required placeholder="Neues Passwort" :errors="form.errors.password" />
            <PasswordInput
                v-model="form.password_confirmation"
                required
                placeholder="Passwort bestätigen"
                :errors="form.errors.password_confirmation"
            />

            <div class="mt-3">
                <Button :loading="form.processing">Speichern</Button>
            </div>
        </form>
    </section>
</template>
