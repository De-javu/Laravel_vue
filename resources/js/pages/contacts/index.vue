<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, usePage, Link } from '@inertiajs/vue3';
import PlaceholderPattern from '@/components/PlaceholderPattern.vue';
import { route } from 'ziggy-js';
import { ref } from 'vue';

type Contact = {
    id: number;
    name: string;
    phone: string;
    privacity: string;
    vatar: string;
};

const page = usePage();

const contacts = ref(page.props.contacts as Contact[]);
const onDeleSucces = () => {
    console.log('Contact deleted successfully');
    contacts.value = page.props.contacts as Contact[]; // Update the contacts list after deletion 
};

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Contactos', href: '/dashboard/contacts' },
    { title: 'Crear Contacto', href: '/dashboard/contacts/create' },
    { title: 'Salir', href: '/dashboard/contacts/salir' },

];



</script>

<template>
    
    <Head title="Contactos" />
    <AppLayout :breadcrumbs="breadcrumbs">
         
        <div class="flex flex-1 flex-col gap-4 rounded-xl p-4">
            <div class="relative min-h-[100vh] flex-1 rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
            
                <div class="overflow-x-auto flex justify-center m-3">
                    <table class="w-[90vw] max-w-6xl min-w-[800px] divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-800">
                            <tr>
                                <th class="text-left text-sm font-medium text-gray-500 dark:text-gray-400 px-6 py-3">Nombre</th>
                                <th class="text-left text-sm font-medium text-gray-500 dark:text-gray-400 px-6 py-3">Teléfono</th>
                                <th class="text-left text-sm font-medium text-gray-500 dark:text-gray-400 px-6 py-3">Visibilidad</th>
                                <th class="text-left text-sm font-medium text-gray-500 dark:text-gray-400 px-6 py-3">Avatar</th>
                                <th class="text-left text-sm font-medium text-gray-500 dark:text-gray-400 px-6 py-3">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="contact in contacts" :key="contact.id">
                                <td class="text-sm text-gray-900 dark:text-gray-100 px-6 py-4 whitespace-nowrap">{{ contact.name }}</td>
                                <td class="text-sm text-gray-900 dark:text-gray-100 px-6 py-4 whitespace-nowrap">{{ contact.phone }}</td>
                                <td class="text-sm text-gray-900 dark:text-gray-100 px-6 py-4 whitespace-nowrap">{{ contact.privacity }}</td>
                                <td>
                                    <img :src="`/storage/${contact.vatar}`" alt="Avatar" class="w-10 h-10 rounded-full" v-if="contact.vatar">
                                </td>
                                <td>
                                    <div class="flex gap-2">                                
                                   <Link
                                        :href="route('contact.edit', contact.id)"
                                        class="inline-block px-6 py-2 bg-yellow-600 hover:bg-yellow-700 text-white font-semibold rounded shadow transition whitespace-nowrap">
                                        Editar
                                    </Link>
                                   <Link
                                        as="button"
                                        method="delete"
                                        @success="onDeleSucces" :href="route('contact.destroy', contact.id)"
                                        class="inline-block px-6 py-2 bg-red-600 hover:bg-red-700 text-white font-semibold rounded shadow transition"
                                        >
                                        Eliminar
                                    </Link>
                                      </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
       
    </AppLayout>

  
</template>