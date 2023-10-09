<script setup lang="ts">
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { Button, EmailInput, PasswordInput, TextInput } from 'custom-mbd-components';

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => {
            form.reset('password', 'password_confirmation');
        },
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Register" />
        <main class="card card-body p-5">
            <form @submit.prevent="submit">
                <h2>Register</h2>
                <div>
                    <TextInput v-model="form.name" required placeholder="Name" autocomplete="name" :error="form.errors.name" />
                </div>

                <div>
                    <EmailInput v-model="form.email" required placeholder="Email" autocomplete="email" :error="form.errors.email" />
                </div>

                <div>
                    <PasswordInput
                        v-model="form.password"
                        required
                        placeholder="Passwort"
                        autocomplete="new-password"
                        :error="form.errors.password"
                    />
                </div>

                <div>
                    <PasswordInput
                        v-model="form.password_confirmation"
                        required
                        autocomplete="new-password"
                        placeholder="Passwort bestätigen"
                        :error="form.errors.password"
                    />
                </div>

                <div class="d-flex align-items-center justify-content-between mt-4">
                    <a :href="route('login')" class="text-dark me-3">Bereits Registriert?</a>
                    <Button :loading="form.processing">Registrieren</Button>
                </div>
            </form>
        </main>
    </GuestLayout>
</template>
