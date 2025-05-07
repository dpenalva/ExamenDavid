<template>
    <Head title="Editar Zapato" />
    
    <ZapatosLayout>
        <h1 class="text-2xl font-bold mb-6">Editar Zapato</h1>
        
        <form @submit.prevent="submit" class="bg-white shadow-md rounded-lg p-6 max-w-3xl mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Nombre -->
                <div>
                    <InputLabel for="nombre" value="Nombre" />
                    <TextInput id="nombre" v-model="form.nombre" type="text" class="mt-1 block w-full" required />
                    <InputError :message="form.errors.nombre" class="mt-2" />
                </div>
                
                <!-- Marca -->
                <div>
                    <InputLabel for="marca" value="Marca" />
                    <TextInput id="marca" v-model="form.marca" type="text" class="mt-1 block w-full" required />
                    <InputError :message="form.errors.marca" class="mt-2" />
                </div>
                
                <!-- Talla -->
                <div>
                    <InputLabel for="talla" value="Talla" />
                    <TextInput id="talla" v-model="form.talla" type="text" class="mt-1 block w-full" required />
                    <InputError :message="form.errors.talla" class="mt-2" />
                </div>
                
                <!-- Color -->
                <div>
                    <InputLabel for="color" value="Color" />
                    <TextInput id="color" v-model="form.color" type="text" class="mt-1 block w-full" required />
                    <InputError :message="form.errors.color" class="mt-2" />
                </div>
                
                <!-- Precio -->
                <div>
                    <InputLabel for="precio" value="Precio" />
                    <TextInput id="precio" v-model="form.precio" type="number" step="0.01" class="mt-1 block w-full" required />
                    <InputError :message="form.errors.precio" class="mt-2" />
                </div>
                
                <!-- Stock -->
                <div>
                    <InputLabel for="stock" value="Stock" />
                    <TextInput id="stock" v-model="form.stock" type="number" class="mt-1 block w-full" required />
                    <InputError :message="form.errors.stock" class="mt-2" />
                </div>
            </div>
            
            <div class="flex items-center justify-end mt-6 space-x-4">
                <Link :href="route('zapatos.index')" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                    Cancelar
                </Link>
                <PrimaryButton :disabled="form.processing">
                    Actualizar
                </PrimaryButton>
            </div>
        </form>
    </ZapatosLayout>
</template>

<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import ZapatosLayout from '@/Layouts/ZapatosLayout.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

const props = defineProps({
    zapato: Object
});

const form = useForm({
    nombre: props.zapato.nombre,
    marca: props.zapato.marca,
    talla: props.zapato.talla,
    color: props.zapato.color,
    precio: props.zapato.precio,
    stock: props.zapato.stock
});

const submit = () => {
    form.put(route('zapatos.update', props.zapato.id));
};
</script> 