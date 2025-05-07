<template>
    <Head title="Listado de Zapatos" />
    
    <ZapatosLayout>
        <h1 style="text-align: center; color: blue; font-size: 24px; margin-bottom: 20px;">Lista de Zapatos</h1>
        
        <div v-if="$page.props.flash && $page.props.flash.success" style="background-color: #d4edda; color: #155724; padding: 10px; border: 1px solid #c3e6cb; margin-bottom: 15px;">
            {{ $page.props.flash.success }}
        </div>
        
        <!-- Buscador -->
        <div style="width: 100%; margin-bottom: 20px; background-color: #f8f9fa; padding: 15px; border: 1px solid #ddd;">
            <div style="display: flex; gap: 10px;">
                <input 
                    type="text" 
                    v-model="busqueda" 
                    placeholder="Buscar por ID, nombre, marca, talla, color, precio o stock..." 
                    style="flex-grow: 1; padding: 8px; border: 1px solid #ccc; border-radius: 4px;"
                    @input="buscarZapatos"
                />
                <button 
                    @click="limpiarBusqueda" 
                    style="background-color: #6c757d; color: white; padding: 8px 15px; border: none; border-radius: 4px; cursor: pointer;"
                >
                    Limpiar
                </button>
            </div>
        </div>
        
        <table style="width: 100%; border-collapse: collapse; margin-bottom: 20px;">
            <thead>
                <tr style="background-color: #f2f2f2;">
                    <th style="border: 1px solid #ddd; padding: 8px; text-align: left;">ID</th>
                    <th style="border: 1px solid #ddd; padding: 8px; text-align: left;">Nombre</th>
                    <th style="border: 1px solid #ddd; padding: 8px; text-align: left;">Marca</th>
                    <th style="border: 1px solid #ddd; padding: 8px; text-align: left;">Talla</th>
                    <th style="border: 1px solid #ddd; padding: 8px; text-align: left;">Color</th>
                    <th style="border: 1px solid #ddd; padding: 8px; text-align: left;">Precio</th>
                    <th style="border: 1px solid #ddd; padding: 8px; text-align: left;">Stock</th>
                    <th style="border: 1px solid #ddd; padding: 8px; text-align: left;">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="zapato in zapatosFiltrados" :key="zapato.id" style="border: 1px solid #ddd;">
                    <td style="border: 1px solid #ddd; padding: 8px;">{{ zapato.id }}</td>
                    <td style="border: 1px solid #ddd; padding: 8px;">{{ zapato.nombre }}</td>
                    <td style="border: 1px solid #ddd; padding: 8px;">{{ zapato.marca }}</td>
                    <td style="border: 1px solid #ddd; padding: 8px;">{{ zapato.talla }}</td>
                    <td style="border: 1px solid #ddd; padding: 8px;">{{ zapato.color }}</td>
                    <td style="border: 1px solid #ddd; padding: 8px;">{{ zapato.precio }} €</td>
                    <td style="border: 1px solid #ddd; padding: 8px;">{{ zapato.stock }}</td>
                    <td style="border: 1px solid #ddd; padding: 8px;">
                        <Link :href="route('zapatos.show', zapato.id)" style="background-color: #007bff; color: white; padding: 5px 10px; text-decoration: none; margin-right: 5px; display: inline-block;">
                            Ver
                        </Link>
                        <Link :href="route('zapatos.edit', zapato.id)" style="background-color: #ffc107; color: black; padding: 5px 10px; text-decoration: none; margin-right: 5px; display: inline-block;">
                            Editar
                        </Link>
                        <button @click="eliminarZapato(zapato.id)" style="background-color: #dc3545; color: white; padding: 5px 10px; border: none; cursor: pointer;">
                            Eliminar
                        </button>
                    </td>
                </tr>
                <tr v-if="zapatosFiltrados.length === 0">
                    <td colspan="8" style="border: 1px solid #ddd; padding: 8px; text-align: center;">No se encontraron zapatos</td>
                </tr>
            </tbody>
        </table>
        
        <div style="text-align: center; margin-top: 20px;">
            <Link :href="route('zapatos.create')" style="background-color: #28a745; color: white; padding: 10px 15px; text-decoration: none; display: inline-block;">
                Añadir Nuevo Zapato
            </Link>
        </div>
    </ZapatosLayout>
</template>

<script setup>
import { Head, Link } from '@inertiajs/vue3';
import ZapatosLayout from '@/Layouts/ZapatosLayout.vue';
import { router } from '@inertiajs/vue3';
import { ref, computed, onMounted, watch } from 'vue';
import axios from 'axios';
import { debounce } from 'lodash';

const props = defineProps({
    zapatos: Array
});

// Estado para el buscador
const busqueda = ref('');
const todosLosZapatos = ref([]);
const zapatosFiltrados = ref([]);

// Inicializar los zapatos
onMounted(() => {
    todosLosZapatos.value = [...props.zapatos];
    zapatosFiltrados.value = [...props.zapatos];
});

// Debounce para la función de búsqueda para evitar demasiadas llamadas
const buscarZapatos = debounce(async () => {
    if (busqueda.value.trim() === '') {
        zapatosFiltrados.value = [...todosLosZapatos.value];
        return;
    }
    
    try {
        const respuesta = await axios.get(`/zapatos/buscar?q=${busqueda.value}`);
        zapatosFiltrados.value = respuesta.data;
    } catch (error) {
        console.error('Error al buscar zapatos:', error);
        // Alternativa: hacer búsqueda local si la API falla
        buscarLocalmente();
    }
}, 300); // Esperar 300ms después de que el usuario deje de escribir

// Método para buscar localmente (alternativa a la API)
const buscarLocalmente = () => {
    const terminoBusqueda = busqueda.value.toLowerCase().trim();
    zapatosFiltrados.value = todosLosZapatos.value.filter(zapato => 
        zapato.id.toString().includes(terminoBusqueda) ||
        zapato.nombre.toLowerCase().includes(terminoBusqueda) ||
        zapato.marca.toLowerCase().includes(terminoBusqueda) ||
        zapato.talla.toString().toLowerCase().includes(terminoBusqueda) ||
        zapato.color.toLowerCase().includes(terminoBusqueda) ||
        zapato.precio.toString().includes(terminoBusqueda) ||
        zapato.stock.toString().includes(terminoBusqueda)
    );
};

// Limpiar la búsqueda
const limpiarBusqueda = () => {
    busqueda.value = '';
    zapatosFiltrados.value = [...todosLosZapatos.value];
};

const eliminarZapato = (id) => {
    if (confirm('¿Estás seguro de que deseas eliminar este zapato?')) {
        router.delete(route('zapatos.destroy', id));
    }
};
</script> 