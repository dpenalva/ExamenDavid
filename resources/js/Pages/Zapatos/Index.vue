<template>
    <Head title="Listado de Zapatos" />
    
    <ZapatosLayout>
        <h1 style="text-align: center; color: #2b72e6; margin-bottom: 15px; font-size: 32px;">Lista de Zapatos</h1>
        
        <div v-if="$page.props.flash && $page.props.flash.success" style="background-color: #d4edda; color: #155724; padding: 10px; border: 1px solid #c3e6cb; margin-bottom: 15px;">
            {{ $page.props.flash.success }}
        </div>
        
        <!-- Filtro por Categoría -->
        <div style="width: 100%; margin-bottom: 12px; padding: 10px;">
            <div style="display: flex; flex-wrap: wrap; gap: 8px; align-items: center;">
                <label for="categoria-select" style="min-width: 120px;">Filtrar por categoría:</label>
                <select 
                    id="categoria-select"
                    v-model="categoriaSeleccionada" 
                    style="flex-grow: 1; padding: 8px; border: 1px solid #767676;" 
                    @change="aplicarFiltros"
                    aria-label="Filtrar zapatos por categoría"
                >
                    <option value="">Todas las categorías</option>
                    <option v-for="categoria in categorias" :key="categoria.id" :value="categoria.id">
                        {{ categoria.nombre }}
                    </option>
                </select>
            </div>
        </div>
        
        <!-- Buscador -->
        <div style="width: 100%; margin-bottom: 18px; padding: 10px;">
            <div style="display: flex; flex-wrap: wrap; gap: 8px;">
                <label for="busqueda-input" style="position: absolute; width: 1px; height: 1px; padding: 0; margin: -1px; overflow: hidden; clip: rect(0, 0, 0, 0); white-space: nowrap; border: 0;">Buscar zapatos</label>
                <input 
                    id="busqueda-input"
                    type="text" 
                    v-model="busqueda" 
                    placeholder="Buscar zapatos..." 
                    style="flex-grow: 1; padding: 10px; border: 1px solid #767676;"
                    @input="buscarConDelay"
                    aria-label="Buscar zapatos por nombre, marca, talla, color, precio o stock"
                />
            </div>
        </div>
        
        <!-- Tabla Responsiva -->
        <div style="overflow-x: auto; margin-bottom: 20px; border: 1px solid #ddd;">
            <table style="width: 100%; border-collapse: collapse;" aria-label="Listado de zapatos">
                <caption style="position: absolute; width: 1px; height: 1px; padding: 0; margin: -1px; overflow: hidden; clip: rect(0, 0, 0, 0); white-space: nowrap; border: 0;">Listado de zapatos disponibles</caption>
                <thead style="background-color: white;">
                    <tr>
                        <th scope="col" style="border: 1px solid #ddd; padding: 8px; text-align: center; color: black;">ID</th>
                        <th scope="col" style="border: 1px solid #ddd; padding: 8px; text-align: center; color: black;">Nombre</th>
                        <th scope="col" style="border: 1px solid #ddd; padding: 8px; text-align: center; color: black;">Marca</th>
                        <th scope="col" style="border: 1px solid #ddd; padding: 8px; text-align: center; color: black;">Categoría</th>
                        <th scope="col" style="border: 1px solid #ddd; padding: 8px; text-align: center; color: black;">Talla</th>
                        <th scope="col" style="border: 1px solid #ddd; padding: 8px; text-align: center; color: black;">Color</th>
                        <th scope="col" style="border: 1px solid #ddd; padding: 8px; text-align: center; color: black;">Precio</th>
                        <th scope="col" style="border: 1px solid #ddd; padding: 8px; text-align: center; color: black;">Stock</th>
                        <th scope="col" style="border: 1px solid #ddd; padding: 8px; text-align: center; color: black;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(zapato, index) in zapatos.data" :key="zapato.id" style="border: 1px solid #ddd;" :style="index % 2 === 0 ? 'background-color: #f2f2f2;' : 'background-color: white;'">
                        <td style="border: 1px solid #ddd; padding: 8px; text-align: center;">{{ zapato.id }}</td>
                        <td style="border: 1px solid #ddd; padding: 8px;">{{ zapato.nombre }}</td>
                        <td style="border: 1px solid #ddd; padding: 8px;">{{ zapato.marca }}</td>
                        <td style="border: 1px solid #ddd; padding: 8px;">{{ zapato.categoria ? zapato.categoria.nombre : 'Sin categoría' }}</td>
                        <td style="border: 1px solid #ddd; padding: 8px; text-align: center;">{{ zapato.talla }}</td>
                        <td style="border: 1px solid #ddd; padding: 8px;">
                            <span style="display: inline-block; width: 15px; height: 15px; border-radius: 50%; margin-right: 8px; border: 1px solid #ccc;" :style="{ backgroundColor: zapato.color }"></span>
                            {{ zapato.color }}
                        </td>
                        <td style="border: 1px solid #ddd; padding: 8px; text-align: right; color: black;">{{ zapato.precio }} €</td>
                        <td style="border: 1px solid #ddd; padding: 8px; text-align: center;">{{ zapato.stock }}</td>
                        <td style="border: 1px solid #ddd; padding: 8px; text-align: center;">
                            <Link 
                                :href="route('zapatos.show', zapato.id)" 
                                style="background-color: #2b72e6; color: white; padding: 5px; text-decoration: none; margin-right: 3px; display: inline-block;"
                                aria-label="Ver detalles del zapato"
                            >
                                Ver
                            </Link>
                            <Link 
                                :href="route('zapatos.edit', zapato.id)" 
                                style="background-color: #c85200; color: white; padding: 5px; text-decoration: none; margin-right: 3px; display: inline-block;"
                                aria-label="Editar zapato"
                            >
                                Editar
                            </Link>
                            <button 
                                @click="eliminarZapato(zapato.id)" 
                                style="background-color: #e00; color: white; padding: 5px; border: none; cursor: pointer;"
                                aria-label="Eliminar zapato"
                            >
                                Eliminar
                            </button>
                        </td>
                    </tr>
                    <tr v-if="zapatos.data.length === 0">
                        <td colspan="9" style="border: 1px solid #ddd; padding: 15px; text-align: center; color: #666;">No se encontraron zapatos</td>
                    </tr>
                </tbody>
            </table>
        </div>
        
        <!-- Paginación Accesible -->
        <nav v-if="zapatos.links && zapatos.links.length > 3" style="display: flex; flex-direction: column; align-items: center; margin-bottom: 20px;" aria-label="Paginación de zapatos">
            <div style="display: flex; justify-content: center; margin: 10px 0;">
                <Link 
                    v-for="(link, i) in zapatos.links" 
                    :key="i"
                    :href="link.url ? link.url : '#'"
                    :style="{
                        padding: '8px 12px',
                        margin: '0 2px',
                        border: '1px solid #ccc',
                        backgroundColor: link.active ? '#2b72e6' : 'white',
                        color: link.active ? 'white' : '#2b72e6',
                        textDecoration: 'none',
                        cursor: link.url ? 'pointer' : 'not-allowed',
                        opacity: link.url ? '1' : '0.5'
                    }"
                    :aria-current="link.active ? 'page' : undefined"
                    :aria-disabled="!link.url"
                    :tabindex="link.url ? 0 : -1"
                    v-html="link.label"
                ></Link>
            </div>
            <div style="font-size: 14px; color: #666; margin-top: 8px;" aria-live="polite">
                Mostrando {{ zapatos.from }} a {{ zapatos.to }} de {{ zapatos.total }} zapatos
            </div>
        </nav>
        
        <div style="text-align: center; margin-top: 20px;">
            <Link 
                :href="route('zapatos.create')" 
                style="background-color: #008933; color: white; padding: 10px 15px; text-decoration: none; display: inline-block;"
                aria-label="Añadir un nuevo zapato"
            >
                Añadir Nuevo Zapato
            </Link>
        </div>
    </ZapatosLayout>
</template>

<script setup>
import { Head, Link } from '@inertiajs/vue3';
import ZapatosLayout from '@/Layouts/ZapatosLayout.vue';
import { router } from '@inertiajs/vue3';
import { ref, onMounted, onBeforeUnmount } from 'vue';

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
    
    // Añadir manejadores de eventos para accesibilidad por teclado
    document.addEventListener('keydown', manejarTeclas);
});

onBeforeUnmount(() => {
    document.removeEventListener('keydown', manejarTeclas);
});

// Manejar navegación por teclado
function manejarTeclas(e) {
    // Permitir navegar con Escape para cerrar el modal de confirmación
    if (e.key === 'Escape' && document.activeElement.tagName === 'BUTTON') {
        document.activeElement.blur();
    }
}

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

<style>
/* Mejoras de accesibilidad */
@media (prefers-reduced-motion: reduce) {
    * {
        animation-duration: 0.01ms !important;
        animation-iteration-count: 1 !important;
        transition-duration: 0.01ms !important;
        scroll-behavior: auto !important;
    }
}
</style> 