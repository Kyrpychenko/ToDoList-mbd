<script setup lang="ts">
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { Button, CheckboxInput, EmailInput, Message, PasswordInput } from 'custom-mbd-components';
// import { Button } from "custom-mbd-components";

defineProps<{
    canResetPassword?: boolean;
    status?: string;
}>();

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => {
            form.reset('password');
        },
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Log in" />
        <Message :info="status" :dismissable="false" />
        <main class="card card-body p-5">
            <form @submit.prevent="submit">
                <h2>Login</h2>
                <div>
                    <div>
                        <EmailInput v-model="form.email" required autofocus autocomplete="username" placeholder="Email" :error="form.errors.email" />
                    </div>
                    <div>
                        <PasswordInput
                            v-model="form.password"
                            required
                            autofocus
                            autocomplete="password"
                            placeholder="Passwort"
                            :error="form.errors.password"
                        />
                    </div>
                    <div class="mt-3">
                        <CheckboxInput v-model="form.remember">Angemeldet bleiben</CheckboxInput>
                    </div>
                </div>
                <div class="d-flex justify-content-between mt-3">
                    <a :href="route('register')" class="p-2 g-col-6 text-dark">Registrieren</a>
                    <Button :loading="form.processing">Anmelden</Button>
                </div>
            </form>
        </main>
    </GuestLayout>
</template>
