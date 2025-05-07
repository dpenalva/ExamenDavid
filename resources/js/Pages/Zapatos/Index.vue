<template>
    <Head title="Listado de Zapatos" />
    
    <ZapatosLayout>
        <h1 class="text-2xl font-bold mb-6">Listado de Zapatos</h1>
        
        <div v-if="$page.props.flash.success" class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4">
            {{ $page.props.flash.success }}
        </div>
        
        <div class="overflow-x-auto bg-white shadow-md rounded-lg">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Marca</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Talla</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Color</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Precio</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Stock</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <tr v-for="zapato in zapatos" :key="zapato.id">
                        <td class="px-6 py-4 whitespace-nowrap">{{ zapato.id }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ zapato.nombre }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ zapato.marca }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ zapato.talla }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ zapato.color }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ zapato.precio }} €</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ zapato.stock }}</td>
                        <td class="px-6 py-4 whitespace-nowrap space-x-2">
                            <Link :href="route('zapatos.show', zapato.id)" class="inline-flex items-center px-4 py-2 bg-blue-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-600">
                                Ver
                            </Link>
                            <Link :href="route('zapatos.edit', zapato.id)" class="inline-flex items-center px-4 py-2 bg-yellow-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-yellow-600">
                                Editar
                            </Link>
                            <Link :href="route('zapatos.destroy', zapato.id)" method="delete" as="button" type="button" class="inline-flex items-center px-4 py-2 bg-red-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-600" @click.prevent="eliminarZapato(zapato.id)">
                                Eliminar
                            </Link>
                        </td>
                    </tr>
                    <tr v-if="zapatos.length === 0">
                        <td class="px-6 py-4 whitespace-nowrap text-center" colspan="8">No hay zapatos registrados</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </ZapatosLayout>
</template>

<script setup>
import { Head, Link } from '@inertiajs/vue3';
import ZapatosLayout from '@/Layouts/ZapatosLayout.vue';
import { router } from '@inertiajs/vue3';

const props = defineProps({
    zapatos: Array
});

const eliminarZapato = (id) => {
    if (confirm('¿Estás seguro de que deseas eliminar este zapato?')) {
        router.delete(route('zapatos.destroy', id));
    }
};
</script> 