<template>
    <Head title="Editar Categoría" />
    
    <ZapatosLayout>
        <h1 style="text-align: center; color: orange; font-size: 24px; margin-bottom: 20px;">Editar Categoría</h1>
        
        <form @submit.prevent="submit" style="width: 80%; margin: 0 auto; background-color: #f9f9f9; padding: 20px; border: 1px solid #ddd;">
            <div style="display: grid; grid-template-columns: repeat(1, 1fr); gap: 15px;">
                <!-- Nombre -->
                <div style="margin-bottom: 15px;">
                    <label for="nombre" style="display: block; margin-bottom: 5px; font-weight: bold;">Nombre:</label>
                    <input id="nombre" v-model="form.nombre" type="text" style="width: 100%; padding: 8px; border: 1px solid #ccc;" required />
                    <div v-if="form.errors.nombre" style="color: red; margin-top: 5px;">{{ form.errors.nombre }}</div>
                </div>
                
                <!-- Descripción -->
                <div style="margin-bottom: 15px;">
                    <label for="descripcion" style="display: block; margin-bottom: 5px; font-weight: bold;">Descripción:</label>
                    <textarea id="descripcion" v-model="form.descripcion" style="width: 100%; padding: 8px; border: 1px solid #ccc; min-height: 80px;"></textarea>
                    <div v-if="form.errors.descripcion" style="color: red; margin-top: 5px;">{{ form.errors.descripcion }}</div>
                </div>
            </div>
            
            <div style="text-align: center; margin-top: 20px;">
                <Link :href="route('categorias.index')" style="background-color: #767676; color: white; padding: 10px 15px; text-decoration: none; display: inline-block; margin-right: 10px;">
                    Cancelar
                </Link>
                <button type="submit" style="background-color: #c85200; color: white; padding: 10px 15px; border: none; cursor: pointer;">
                    Actualizar
                </button>
            </div>
        </form>
    </ZapatosLayout>
</template>

<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import ZapatosLayout from '@/Layouts/ZapatosLayout.vue';

const props = defineProps({
    categoria: Object
});

const form = useForm({
    nombre: props.categoria.nombre,
    descripcion: props.categoria.descripcion || ''
});

const submit = () => {
    form.put(route('categorias.update', props.categoria.id));
};
</script> 