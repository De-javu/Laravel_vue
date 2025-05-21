<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Head } from '@inertiajs/vue3';

const breadcrumbs = [
    { title: 'Contactos', href: '/dashboard/contacts' },
    { title: 'Crear', href: '/dashboard/contacts/create' },
];
</script>

<template>
    <Head title="Crear Contacto" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="p-4">
            <h1 class="text-xl font-bold mb-4">Crear Contacto</h1>
            <!-- Aquí va tu formulario -->
        </div>
    </AppLayout>
</template>