<template>
    <Head title="Editar Zapato" />
    
    <ZapatosLayout>
        <h1 style="text-align: center; color: orange; font-size: 24px; margin-bottom: 20px;">Editar Zapato</h1>
        
        <form @submit.prevent="submit" style="width: 80%; margin: 0 auto; background-color: #f9f9f9; padding: 20px; border: 1px solid #ddd;">
            <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 15px;">
                <!-- Nombre -->
                <div style="margin-bottom: 15px;">
                    <label for="nombre" style="display: block; margin-bottom: 5px; font-weight: bold;">Nombre:</label>
                    <input id="nombre" v-model="form.nombre" type="text" style="width: 100%; padding: 8px; border: 1px solid #ccc;" required />
                    <div v-if="form.errors.nombre" style="color: red; margin-top: 5px;">{{ form.errors.nombre }}</div>
                </div>
                
                <!-- Marca -->
                <div style="margin-bottom: 15px;">
                    <label for="marca" style="display: block; margin-bottom: 5px; font-weight: bold;">Marca:</label>
                    <input id="marca" v-model="form.marca" type="text" style="width: 100%; padding: 8px; border: 1px solid #ccc;" required />
                    <div v-if="form.errors.marca" style="color: red; margin-top: 5px;">{{ form.errors.marca }}</div>
                </div>
                
                <!-- Talla -->
                <div style="margin-bottom: 15px;">
                    <label for="talla" style="display: block; margin-bottom: 5px; font-weight: bold;">Talla:</label>
                    <input id="talla" v-model="form.talla" type="text" style="width: 100%; padding: 8px; border: 1px solid #ccc;" required />
                    <div v-if="form.errors.talla" style="color: red; margin-top: 5px;">{{ form.errors.talla }}</div>
                </div>
                
                <!-- Color -->
                <div style="margin-bottom: 15px;">
                    <label for="color" style="display: block; margin-bottom: 5px; font-weight: bold;">Color:</label>
                    <input id="color" v-model="form.color" type="text" style="width: 100%; padding: 8px; border: 1px solid #ccc;" required />
                    <div v-if="form.errors.color" style="color: red; margin-top: 5px;">{{ form.errors.color }}</div>
                </div>
                
                <!-- Precio -->
                <div style="margin-bottom: 15px;">
                    <label for="precio" style="display: block; margin-bottom: 5px; font-weight: bold;">Precio:</label>
                    <input id="precio" v-model="form.precio" type="number" step="0.01" style="width: 100%; padding: 8px; border: 1px solid #ccc;" required />
                    <div v-if="form.errors.precio" style="color: red; margin-top: 5px;">{{ form.errors.precio }}</div>
                </div>
                
                <!-- Stock -->
                <div style="margin-bottom: 15px;">
                    <label for="stock" style="display: block; margin-bottom: 5px; font-weight: bold;">Stock:</label>
                    <input id="stock" v-model="form.stock" type="number" style="width: 100%; padding: 8px; border: 1px solid #ccc;" required />
                    <div v-if="form.errors.stock" style="color: red; margin-top: 5px;">{{ form.errors.stock }}</div>
                </div>
            </div>
            
            <div style="text-align: center; margin-top: 20px;">
                <Link :href="route('zapatos.index')" style="background-color: #6c757d; color: white; padding: 10px 15px; text-decoration: none; display: inline-block; margin-right: 10px;">
                    Cancelar
                </Link>
                <button type="submit" style="background-color: #ffc107; color: black; padding: 10px 15px; border: none; cursor: pointer;">
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