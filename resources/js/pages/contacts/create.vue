<!-- Importaciones necesrias para la creacion e interacion de la vista -->
<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import InputError from '@/components/InputError.vue';
import { AvatarImage } from 'reka-ui';
import { handleError } from 'vue';
import Avatar from '@/components/ui/avatar/Avatar.vue';
import { ref } from 'vue';

// Se define el tipo de BreadcrumbItem para el envio de los datos recopilado en el formulario
const breadcrumbs = [
    { title: 'Contactos', href: '/dashboard/contacts' },
    { title: 'Crear', href: '/dashboard/contacts/create' },
];
// Se define el formulario con los campos necesarios para la creacion de un contacto
const form = useForm<{
    name: string;
    phone: string;
    vatar: File | null;
    privacity: string;
}>({
    name: '',
    phone: '',
    vatar: null,
    privacity: 'private',
});

// Variable para previsualizar el avatar
const avatarPreview = ref<string | null>(null);

function handleAvatarChange(event: Event) {
    const file = (event.target as HTMLInputElement).files?.[0];
    if (file) {
        form.vatar = file;
        avatarPreview.value = URL.createObjectURL(file);
    } else {
        form.vatar = null;
        avatarPreview.value = null;
    }
}

// Se define la funcion submit para enviar el formulario
const submit = () => {
    form.post('/dashboard/contacts', {
        onFinish: () => {
            form.reset('vatar');
            avatarPreview.value = null;
    },
    forceFormData: true,
});
};
</script>

<!-- Se define el estilo de la vista -->
<template>
    <Head title="Crear Contacto" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="p-4 max-w-lg mx-auto">
            <h1 class="text-xl font-bold mb-4">Crear Contacto</h1>
            <form @submit.prevent="submit" class="space-y-4">
                <div>
                    <Label for="name" class="m-1">Nombre</Label>
                    <Input id="name" v-model="form.name" type="text" required autocomplete="off" placeholder="nombre"/>
                    <InputError :message="form.errors.name" />
                </div>
                <div>
                    <Label for="phone" class="m-1">Teléfono</Label>
                    <Input id="phone" v-model="form.phone" type="text"  class="" required autocomplete="off" placeholder="+571234567890"/>
                    <InputError :message="form.errors.phone" />
                </div>

                <!-- Campo para subir el avatar -->
                <div>
                  <Label for="vatar" class="mb-1 block">Avatar</Label>
                   <label
                     for="vatar"
                    class="inline-block px-1 py-2 bg-gray-900 text-white rounded cursor-pointer hover:bg-blue- transition"
    >
                     Seleccionar archivo
                  </label>
                    <span class="text-sm text-gray-700">
                        {{ form.vatar ? form.vatar.name : 'No se eligió ningún archivo' }}
                    </span>
                  <Input
                     id="vatar"
                     type="file"
                     accept="image/*"
                     @change="handleAvatarChange" 
                     placeholder="Selecciona una imagen"
                     class="hidden"
                     />
                  <InputError :message="form.errors.vatar" />
                     <div v-if="avatarPreview" class="mt-2">
                        <AvatarImage
                            :src="avatarPreview"
                            alt="Avatar Preview"
                            class="w-16 h-16 rounded-full"/>
                     </div>
                </div>
                <div>
                    <Label for="privacity">Privacidad</Label>
                    <select id="privacity" v-model="form.privacity" class="mt-1 block w-full border-gray-300 rounded-md">
                        <option value="public">Público</option>
                        <option value="private">Privado</option>
                    </select>
                    <InputError :message="form.errors.privacity" />
                </div>

                <!-- boton de envio -->
                 <div class="flex justify-center">
                    <Button type="submit" class="px-4 py-2 bg-blue-700 text-white rounded-md " >Crear Contacto</Button>

                 </div>
                
            </form>
        </div>
    </AppLayout>
</template>