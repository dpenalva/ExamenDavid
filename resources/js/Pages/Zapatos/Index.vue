<template>
    <Head title="Listado de Zapatos" />
    
    <ZapatosLayout>
        <h1 style="text-align: center; color: blue; font-size: 24px; margin-bottom: 20px;">Lista de Zapatos</h1>
        
        <div v-if="$page.props.flash && $page.props.flash.success" style="background-color: #d4edda; color: #155724; padding: 10px; border: 1px solid #c3e6cb; margin-bottom: 15px;">
            {{ $page.props.flash.success }}
        </div>
        
        <table style="width: 100%; border-collapse: collapse; margin-bottom: 20px;">
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
            <tr v-for="zapato in zapatos" :key="zapato.id" style="border: 1px solid #ddd;">
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
            <tr v-if="zapatos.length === 0">
                <td colspan="8" style="border: 1px solid #ddd; padding: 8px; text-align: center;">No hay zapatos registrados</td>
            </tr>
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

const props = defineProps({
    zapatos: Array
});

const eliminarZapato = (id) => {
    if (confirm('¿Estás seguro de que deseas eliminar este zapato?')) {
        router.delete(route('zapatos.destroy', id));
    }
};
</script> 