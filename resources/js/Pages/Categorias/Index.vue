<template>
    <Head title="Listado de Categorías" />
    
    <ZapatosLayout>
        <h1 style="text-align: center; color: #2b72e6; margin-bottom: 15px; font-size: 32px;">Lista de Categorías</h1>
        
        <!-- Mensajes de la aplicación -->
        <div v-if="$page.props.flash && $page.props.flash.success" style="background-color: #d4edda; color: #155724; padding: 10px; border: 1px solid #c3e6cb; margin-bottom: 15px;">
            {{ $page.props.flash.success }}
        </div>
        
        <div v-if="$page.props.flash && $page.props.flash.error" style="background-color: #f8d7da; color: #721c24; padding: 10px; border: 1px solid #f5c6cb; margin-bottom: 15px;">
            {{ $page.props.flash.error }}
        </div>
        
        <!-- Mensaje de Axios -->
        <div v-if="mensaje.visible" 
             :style="{
                backgroundColor: mensaje.tipo === 'success' ? '#d4edda' : '#f8d7da',
                color: mensaje.tipo === 'success' ? '#155724' : '#721c24',
                padding: '10px', 
                border: `1px solid ${mensaje.tipo === 'success' ? '#c3e6cb' : '#f5c6cb'}`,
                marginBottom: '15px'
             }">
            {{ mensaje.texto }}
        </div>
        
        <!-- Tabla Responsiva -->
        <div style="overflow-x: auto; margin-bottom: 20px; border: 1px solid #ddd;">
            <table style="width: 100%; border-collapse: collapse;" aria-label="Listado de categorías">
                <caption style="position: absolute; width: 1px; height: 1px; padding: 0; margin: -1px; overflow: hidden; clip: rect(0, 0, 0, 0); white-space: nowrap; border: 0;">Listado de categorías disponibles</caption>
                <thead style="background-color: white;">
                    <tr>
                        <th scope="col" style="border: 1px solid #ddd; padding: 8px; text-align: center; color: black;">ID</th>
                        <th scope="col" style="border: 1px solid #ddd; padding: 8px; text-align: center; color: black;">Nombre</th>
                        <th scope="col" style="border: 1px solid #ddd; padding: 8px; text-align: center; color: black;">Descripción</th>
                        <th scope="col" style="border: 1px solid #ddd; padding: 8px; text-align: center; color: black;">Zapatos</th>
                        <th scope="col" style="border: 1px solid #ddd; padding: 8px; text-align: center; color: black;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(categoria, index) in categoriasList" :key="categoria.id" style="border: 1px solid #ddd;" :style="index % 2 === 0 ? 'background-color: #f2f2f2;' : 'background-color: white;'">
                        <td style="border: 1px solid #ddd; padding: 8px; text-align: center;">{{ categoria.id }}</td>
                        <td style="border: 1px solid #ddd; padding: 8px;">{{ categoria.nombre }}</td>
                        <td style="border: 1px solid #ddd; padding: 8px;">{{ categoria.descripcion || 'Sin descripción' }}</td>
                        <td style="border: 1px solid #ddd; padding: 8px; text-align: center;">{{ categoria.zapatos_count }}</td>
                        <td style="border: 1px solid #ddd; padding: 8px; text-align: center;">
                            <Link 
                                :href="route('categorias.show', categoria.id)" 
                                style="background-color: #2b72e6; color: white; padding: 5px; text-decoration: none; margin-right: 3px; display: inline-block;"
                                aria-label="Ver detalles de la categoría"
                            >
                                Ver
                            </Link>
                            <Link 
                                :href="route('categorias.edit', categoria.id)" 
                                style="background-color: #c85200; color: white; padding: 5px; text-decoration: none; margin-right: 3px; display: inline-block;"
                                aria-label="Editar categoría"
                            >
                                Editar
                            </Link>
                            <button 
                                @click="eliminarCategoria(categoria)" 
                                style="background-color: #e00; color: white; padding: 5px; border: none; cursor: pointer;"
                                aria-label="Eliminar categoría"
                            >
                                Eliminar
                            </button>
                        </td>
                    </tr>
                    <tr v-if="categoriasList.length === 0">
                        <td colspan="5" style="border: 1px solid #ddd; padding: 15px; text-align: center; color: #666;">No se encontraron categorías</td>
                    </tr>
                </tbody>
            </table>
        </div>
        
        <div style="text-align: center; margin-top: 20px;">
            <Link 
                :href="route('categorias.create')" 
                style="background-color: #008933; color: white; padding: 10px 15px; text-decoration: none; display: inline-block;"
                aria-label="Añadir nueva categoría"
            >
                Añadir Nueva Categoría
            </Link>
        </div>
    </ZapatosLayout>
</template>

<script setup>
import { Head, Link } from '@inertiajs/vue3';
import ZapatosLayout from '@/Layouts/ZapatosLayout.vue';
import { router } from '@inertiajs/vue3';
import { ref } from 'vue';
import axios from 'axios';

const props = defineProps({
    categorias: Array
});

// Estados para manejar mensajes
const mensaje = ref({
    texto: '',
    tipo: '', // 'success' o 'error'
    visible: false
});

const mostrarMensaje = (texto, tipo = 'success') => {
    mensaje.value = {
        texto,
        tipo,
        visible: true
    };
    
    // Ocultar el mensaje después de 3 segundos
    setTimeout(() => {
        mensaje.value.visible = false;
    }, 3000);
};

// Lista local de categorías para manejar la actualización sin recargar
const categoriasList = ref([...props.categorias]);

const eliminarCategoria = async (categoria) => {
    if (categoria.zapatos_count > 0) {
        mostrarMensaje('No se puede eliminar esta categoría porque tiene zapatos asociados.', 'error');
        return;
    }
    
    if (confirm('¿Estás seguro de que deseas eliminar esta categoría?')) {
        try {
            // Eliminar con Axios
            await axios.delete(route('categorias.destroy', categoria.id));
            
            // Actualizar la lista local eliminando la categoría
            categoriasList.value = categoriasList.value.filter(cat => cat.id !== categoria.id);
            
            // Mostrar mensaje de éxito
            mostrarMensaje('Categoría eliminada exitosamente');
        } catch (error) {
            console.error('Error al eliminar la categoría:', error);
            mostrarMensaje(
                error.response?.data?.error || 'Error al eliminar la categoría',
                'error'
            );
        }
    }
};
</script> 