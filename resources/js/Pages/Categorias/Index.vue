<template>
    <Head title="Listado de Categorías" />
    
    <ZapatosLayout>
        <h1 style="text-align: center; color: blue; font-size: 24px; margin-bottom: 20px;">Lista de Categorías</h1>
        
        <div v-if="$page.props.flash && $page.props.flash.success" style="background-color: #d4edda; color: #155724; padding: 10px; border: 1px solid #c3e6cb; margin-bottom: 15px;">
            {{ $page.props.flash.success }}
        </div>
        
        <div v-if="$page.props.flash && $page.props.flash.error" style="background-color: #f8d7da; color: #721c24; padding: 10px; border: 1px solid #f5c6cb; margin-bottom: 15px;">
            {{ $page.props.flash.error }}
        </div>
        
        <table style="width: 100%; border-collapse: collapse; margin-bottom: 20px;">
            <thead>
                <tr style="background-color: #f2f2f2;">
                    <th style="border: 1px solid #ddd; padding: 8px; text-align: left;">ID</th>
                    <th style="border: 1px solid #ddd; padding: 8px; text-align: left;">Nombre</th>
                    <th style="border: 1px solid #ddd; padding: 8px; text-align: left;">Descripción</th>
                    <th style="border: 1px solid #ddd; padding: 8px; text-align: left;">Zapatos</th>
                    <th style="border: 1px solid #ddd; padding: 8px; text-align: left;">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="categoria in categorias" :key="categoria.id" style="border: 1px solid #ddd;">
                    <td style="border: 1px solid #ddd; padding: 8px;">{{ categoria.id }}</td>
                    <td style="border: 1px solid #ddd; padding: 8px;">{{ categoria.nombre }}</td>
                    <td style="border: 1px solid #ddd; padding: 8px;">{{ categoria.descripcion || 'Sin descripción' }}</td>
                    <td style="border: 1px solid #ddd; padding: 8px;">{{ categoria.zapatos_count }}</td>
                    <td style="border: 1px solid #ddd; padding: 8px;">
                        <Link :href="route('categorias.show', categoria.id)" style="background-color: blue; color: white; padding: 5px 10px; text-decoration: none; margin-right: 5px; display: inline-block;">
                            Ver
                        </Link>
                        <Link :href="route('categorias.edit', categoria.id)" style="background-color: orange; color: white; padding: 5px 10px; text-decoration: none; margin-right: 5px; display: inline-block;">
                            Editar
                        </Link>
                        <button @click="eliminarCategoria(categoria)" style="background-color: red; color: white; padding: 5px 10px; border: none; cursor: pointer;">
                            Eliminar
                        </button>
                    </td>
                </tr>
                <tr v-if="categorias.length === 0">
                    <td colspan="5" style="border: 1px solid #ddd; padding: 8px; text-align: center;">No se encontraron categorías</td>
                </tr>
            </tbody>
        </table>
        
        <div style="text-align: center; margin-top: 20px;">
            <Link :href="route('categorias.create')" style="background-color: green; color: white; padding: 10px 15px; text-decoration: none; display: inline-block;">
                Añadir Nueva Categoría
            </Link>
        </div>
    </ZapatosLayout>
</template>

<script setup>
import { Head, Link } from '@inertiajs/vue3';
import ZapatosLayout from '@/Layouts/ZapatosLayout.vue';
import { router } from '@inertiajs/vue3';

const props = defineProps({
    categorias: Array
});

const eliminarCategoria = (categoria) => {
    if (categoria.zapatos_count > 0) {
        alert('No se puede eliminar esta categoría porque tiene zapatos asociados.');
        return;
    }
    
    if (confirm('¿Estás seguro de que deseas eliminar esta categoría?')) {
        router.delete(route('categorias.destroy', categoria.id));
    }
};
</script> 