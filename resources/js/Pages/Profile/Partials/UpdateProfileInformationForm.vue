<script setup lang="ts">
import { useForm, usePage } from '@inertiajs/vue3';
import { Button, TextInput } from 'custom-mbd-components';
defineProps<{
    mustVerifyEmail?: Boolean;
    status?: String;
}>();

const user = usePage().props.auth.user;

const form = useForm({
    name: user.name,
    email: user.email,
});
</script>

<template>
    <section>
        <header>
            <h2>Profil Informationen</h2>
        </header>

        <form @submit.prevent="form.patch(route('profile.update'))">
            <TextInput v-model="form.name" required autofocus autocomplete="name" placeholder="Name" :error="form.errors.name" />
            <TextInput v-model="form.email" required autocomplete="username" placeholder="Email" :error="form.errors.email" />

            <div class="d-flex align-items-center mt-3">
                <Button :loading="form.processing">Speichern</Button>
            </div>
        </form>
    </section>
</template>
