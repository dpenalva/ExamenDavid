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
                <select v-model="categoriaSeleccionada" style="flex-grow: 1; padding: 8px; border: 1px solid #ccc;" @change="aplicarFiltros">
                    <option value="">Todas las categorías</option>
                    <option v-for="categoria in categorias" :key="categoria.id" :value="categoria.id">
                        {{ categoria.nombre }}
                    </option>
                </select>
                <button @click="limpiarFiltros" style="background-color: gray; color: white; padding: 8px 15px; border: none; cursor: pointer;">
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
                    placeholder="Buscar por nombre, marca, talla, color, precio o stock..." 
                    style="flex-grow: 1; padding: 8px; border: 1px solid #ccc;"
                    @input="buscarConDelay"
                />
                <button 
                    @click="limpiarFiltros" 
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
                <tr v-for="zapato in zapatos.data" :key="zapato.id" style="border: 1px solid #ddd;">
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
                <tr v-if="zapatos.data.length === 0">
                    <td colspan="9" style="border: 1px solid #ddd; padding: 8px; text-align: center;">No se encontraron zapatos</td>
                </tr>
            </tbody>
        </table>
        
        <!-- Paginación -->
        <div v-if="zapatos.links && zapatos.links.length > 3" style="margin-bottom: 20px;">
            <div style="display: flex; justify-content: center; gap: 5px;">
                <Link 
                    v-for="(link, i) in zapatos.links" 
                    :key="i"
                    :href="link.url ? link.url : '#'"
                    :style="{
                        padding: '5px 10px',
                        border: '1px solid #ddd',
                        backgroundColor: link.active ? '#007bff' : 'white',
                        color: link.active ? 'white' : '#007bff',
                        textDecoration: 'none',
                        cursor: link.url ? 'pointer' : 'default',
                        opacity: link.url ? '1' : '0.5'
                    }"
                    v-html="link.label"
                ></Link>
            </div>
            <p style="text-align: center; margin-top: 10px; font-size: 14px; color: #666;">
                Mostrando {{ zapatos.from }} a {{ zapatos.to }} de {{ zapatos.total }} zapatos
            </p>
        </div>
        
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
import { ref, onMounted } from 'vue';

const props = defineProps({
    zapatos: Object,
    categorias: Array,
    filters: Object
});

// Estado para el buscador y filtros
const busqueda = ref('');
const categoriaSeleccionada = ref('');
let timeoutId = null;

// Inicializar los filtros desde props si existen
onMounted(() => {
    if (props.filters) {
        busqueda.value = props.filters.search || '';
        categoriaSeleccionada.value = props.filters.categoria || '';
    }
});

// Aplicar filtros
function aplicarFiltros() {
    router.get(
        route('zapatos.index'),
        {
            search: busqueda.value,
            categoria: categoriaSeleccionada.value
        },
        {
            preserveState: true,
            preserveScroll: true,
            only: ['zapatos']
        }
    );
}

// Buscar con delay para evitar muchas peticiones
function buscarConDelay() {
    // Cancelar el timeout anterior si existe
    if (timeoutId) {
        clearTimeout(timeoutId);
    }
    
    // Crear un nuevo timeout de 300ms
    timeoutId = setTimeout(() => {
        aplicarFiltros();
    }, 300);
}

// Limpiar filtros
function limpiarFiltros() {
    busqueda.value = '';
    categoriaSeleccionada.value = '';
    router.get(route('zapatos.index'));
}

// Eliminar zapato
function eliminarZapato(id) {
    if (confirm('¿Estás seguro de que deseas eliminar este zapato?')) {
        router.delete(route('zapatos.destroy', id));
    }
}
</script> 