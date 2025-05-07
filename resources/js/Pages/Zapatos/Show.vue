<template>
    <Head title="Detalles de Zapato" />
    
    <ZapatosLayout>
        <h1 class="text-2xl font-bold mb-6">Detalles del Zapato</h1>
        
        <div class="bg-white shadow-md rounded-lg p-6 max-w-3xl mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="mb-4">
                    <h3 class="text-sm font-semibold text-gray-600">ID:</h3>
                    <p class="text-lg">{{ zapato.id }}</p>
                </div>
                
                <div class="mb-4">
                    <h3 class="text-sm font-semibold text-gray-600">Nombre:</h3>
                    <p class="text-lg">{{ zapato.nombre }}</p>
                </div>
                
                <div class="mb-4">
                    <h3 class="text-sm font-semibold text-gray-600">Marca:</h3>
                    <p class="text-lg">{{ zapato.marca }}</p>
                </div>
                
                <div class="mb-4">
                    <h3 class="text-sm font-semibold text-gray-600">Talla:</h3>
                    <p class="text-lg">{{ zapato.talla }}</p>
                </div>
                
                <div class="mb-4">
                    <h3 class="text-sm font-semibold text-gray-600">Color:</h3>
                    <p class="text-lg">{{ zapato.color }}</p>
                </div>
                
                <div class="mb-4">
                    <h3 class="text-sm font-semibold text-gray-600">Precio:</h3>
                    <p class="text-lg">{{ zapato.precio }} €</p>
                </div>
                
                <div class="mb-4">
                    <h3 class="text-sm font-semibold text-gray-600">Stock:</h3>
                    <p class="text-lg">{{ zapato.stock }}</p>
                </div>
                
                <div class="mb-4">
                    <h3 class="text-sm font-semibold text-gray-600">Fecha de creación:</h3>
                    <p class="text-lg">{{ new Date(zapato.created_at).toLocaleString() }}</p>
                </div>
                
                <div class="mb-4">
                    <h3 class="text-sm font-semibold text-gray-600">Última actualización:</h3>
                    <p class="text-lg">{{ new Date(zapato.updated_at).toLocaleString() }}</p>
                </div>
            </div>
            
            <div class="flex items-center justify-end mt-6 space-x-4">
                <Link :href="route('zapatos.index')" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                    Volver
                </Link>
                <Link :href="route('zapatos.edit', zapato.id)" class="inline-flex items-center px-4 py-2 bg-yellow-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-yellow-600">
                    Editar
                </Link>
            </div>
        </div>
    </ZapatosLayout>
</template>

<script setup>
import { Head, Link } from '@inertiajs/vue3';
import ZapatosLayout from '@/Layouts/ZapatosLayout.vue';

const props = defineProps({
    zapato: Object
});
</script> 