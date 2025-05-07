<template>
    <Head title="Listado de Zapatos" />
    
    <ZapatosLayout>
        <h1 style="text-align: center; color: blue; font-size: 24px; margin-bottom: 20px;">Lista de Zapatos</h1>
        
        <div v-if="$page.props.flash && $page.props.flash.success" style="background-color: #d4edda; color: #155724; padding: 10px; border: 1px solid #c3e6cb; margin-bottom: 15px;">
            {{ $page.props.flash.success }}
        </div>
        
        <!-- Filtro por Categoría -->
        <div style="width: 100%; margin-bottom: 10px; background-color: #f8f9fa; padding: 15px; border: 1px solid #ddd;">
            <div style="display: flex; gap: 10px; align-items: center;">
                <label style="min-width: 120px; font-weight: bold;">Filtrar por Categoría:</label>
                <select v-model="categoriaSeleccionada" style="flex-grow: 1; padding: 8px; border: 1px solid #ccc;" @change="filtrarPorCategoria">
                    <option value="">Todas las categorías</option>
                    <option v-for="categoria in categorias" :key="categoria.id" :value="categoria.id">
                        {{ categoria.nombre }}
                    </option>
                </select>
                <button @click="limpiarFiltroCategoria" style="background-color: gray; color: white; padding: 8px 15px; border: none; cursor: pointer;">
                    Limpiar Filtro
                </button>
            </div>
        </div>
        
        <!-- Buscador -->
        <div style="width: 100%; margin-bottom: 20px; background-color: #f8f9fa; padding: 15px; border: 1px solid #ddd;">
            <div style="display: flex; gap: 10px;">
                <input 
                    type="text" 
                    v-model="busqueda" 
                    placeholder="Buscar por ID, nombre, marca, talla, color, precio o stock..." 
                    style="flex-grow: 1; padding: 8px; border: 1px solid #ccc;"
                    @input="buscarZapatos"
                />
                <button 
                    @click="limpiarBusqueda" 
                    style="background-color: gray; color: white; padding: 8px 15px; border: none; cursor: pointer;"
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
                    <th style="border: 1px solid #ddd; padding: 8px; text-align: left;">Categoría</th>
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
                    <td style="border: 1px solid #ddd; padding: 8px;">{{ zapato.categoria ? zapato.categoria.nombre : 'Sin categoría' }}</td>
                    <td style="border: 1px solid #ddd; padding: 8px;">{{ zapato.talla }}</td>
                    <td style="border: 1px solid #ddd; padding: 8px;">{{ zapato.color }}</td>
                    <td style="border: 1px solid #ddd; padding: 8px;">{{ zapato.precio }} €</td>
                    <td style="border: 1px solid #ddd; padding: 8px;">{{ zapato.stock }}</td>
                    <td style="border: 1px solid #ddd; padding: 8px;">
                        <Link :href="route('zapatos.show', zapato.id)" style="background-color: blue; color: white; padding: 5px 10px; text-decoration: none; margin-right: 5px; display: inline-block;">
                            Ver
                        </Link>
                        <Link :href="route('zapatos.edit', zapato.id)" style="background-color: orange; color: white; padding: 5px 10px; text-decoration: none; margin-right: 5px; display: inline-block;">
                            Editar
                        </Link>
                        <button @click="eliminarZapato(zapato.id)" style="background-color: red; color: white; padding: 5px 10px; border: none; cursor: pointer;">
                            Eliminar
                        </button>
                    </td>
                </tr>
                <tr v-if="zapatosFiltrados.length === 0">
                    <td colspan="9" style="border: 1px solid #ddd; padding: 8px; text-align: center;">No se encontraron zapatos</td>
                </tr>
            </tbody>
        </table>
        
        <div style="text-align: center; margin-top: 20px;">
            <Link :href="route('zapatos.create')" style="background-color: green; color: white; padding: 10px 15px; text-decoration: none; display: inline-block;">
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
    zapatos: Array,
    categorias: Array
});

// Estado para el buscador y filtros
const busqueda = ref('');
const todosLosZapatos = ref([]);
const zapatosFiltrados = ref([]);
const categoriaSeleccionada = ref('');

// Inicializar los zapatos
onMounted(() => {
    todosLosZapatos.value = [...props.zapatos];
    zapatosFiltrados.value = [...props.zapatos];
});

// Filtrar por categoría
const filtrarPorCategoria = () => {
    if (!categoriaSeleccionada.value) {
        // Si no hay categoría seleccionada, mostrar todos los zapatos
        zapatosFiltrados.value = todosLosZapatos.value;
    } else {
        // Filtrar por la categoría seleccionada
        zapatosFiltrados.value = todosLosZapatos.value.filter(zapato => 
            zapato.categoria_id === parseInt(categoriaSeleccionada.value)
        );
    }
    
    // Si hay una búsqueda activa, aplicarla a los resultados ya filtrados por categoría
    if (busqueda.value.trim() !== '') {
        buscarLocalmente();
    }
};

// Limpiar el filtro de categoría
const limpiarFiltroCategoria = () => {
    categoriaSeleccionada.value = '';
    zapatosFiltrados.value = [...todosLosZapatos.value];
    
    // Si hay una búsqueda activa, aplicarla a todos los zapatos
    if (busqueda.value.trim() !== '') {
        buscarLocalmente();
    }
};

// Debounce para la función de búsqueda para evitar demasiadas llamadas
const buscarZapatos = debounce(() => {
    if (busqueda.value.trim() === '') {
        // Si no hay búsqueda, mostrar los zapatos según el filtro de categoría
        filtrarPorCategoria();
        return;
    }
    
    buscarLocalmente();
}, 300);

// Método para buscar localmente
const buscarLocalmente = () => {
    const terminoBusqueda = busqueda.value.toLowerCase().trim();
    
    // Filtrar primero por categoría si hay una seleccionada
    let zapatosBase = todosLosZapatos.value;
    if (categoriaSeleccionada.value) {
        zapatosBase = zapatosBase.filter(zapato => 
            zapato.categoria_id === parseInt(categoriaSeleccionada.value)
        );
    }
    
    // Luego aplicar la búsqueda textual
    zapatosFiltrados.value = zapatosBase.filter(zapato => 
        zapato.id.toString().includes(terminoBusqueda) ||
        zapato.nombre.toLowerCase().includes(terminoBusqueda) ||
        zapato.marca.toLowerCase().includes(terminoBusqueda) ||
        (zapato.categoria && zapato.categoria.nombre.toLowerCase().includes(terminoBusqueda)) ||
        zapato.talla.toString().toLowerCase().includes(terminoBusqueda) ||
        zapato.color.toLowerCase().includes(terminoBusqueda) ||
        zapato.precio.toString().includes(terminoBusqueda) ||
        zapato.stock.toString().includes(terminoBusqueda)
    );
};

// Limpiar la búsqueda
const limpiarBusqueda = () => {
    busqueda.value = '';
    // Mantener el filtro por categoría si está activo
    filtrarPorCategoria();
};

const eliminarZapato = (id) => {
    if (confirm('¿Estás seguro de que deseas eliminar este zapato?')) {
        router.delete(route('zapatos.destroy', id));
    }
};
</script> 