<template>
    <Head title="Detalles de Categoría" />
    
    <ZapatosLayout>
        <h1 style="text-align: center; color: blue; font-size: 24px; margin-bottom: 20px;">Detalles de la Categoría</h1>
        
        <div style="width: 80%; margin: 0 auto; background-color: #f9f9f9; padding: 20px; border: 1px solid #ddd;">
            <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 15px;">
                <div style="margin-bottom: 15px;">
                    <h3 style="font-size: 14px; font-weight: bold; color: #666; margin-bottom: 5px;">ID:</h3>
                    <p style="font-size: 18px;">{{ categoria.id }}</p>
                </div>
                
                <div style="margin-bottom: 15px;">
                    <h3 style="font-size: 14px; font-weight: bold; color: #666; margin-bottom: 5px;">Nombre:</h3>
                    <p style="font-size: 18px;">{{ categoria.nombre }}</p>
                </div>
                
                <div style="margin-bottom: 15px;">
                    <h3 style="font-size: 14px; font-weight: bold; color: #666; margin-bottom: 5px;">Descripción:</h3>
                    <p style="font-size: 18px;">{{ categoria.descripcion || 'Sin descripción' }}</p>
                </div>
                
                <div style="margin-bottom: 15px;">
                    <h3 style="font-size: 14px; font-weight: bold; color: #666; margin-bottom: 5px;">Zapatos en esta categoría:</h3>
                    <p style="font-size: 18px;">{{ categoria.zapatos_count }}</p>
                </div>
                
                <div style="margin-bottom: 15px;">
                    <h3 style="font-size: 14px; font-weight: bold; color: #666; margin-bottom: 5px;">Fecha de creación:</h3>
                    <p style="font-size: 18px;">{{ new Date(categoria.created_at).toLocaleString() }}</p>
                </div>
                
                <div style="margin-bottom: 15px;">
                    <h3 style="font-size: 14px; font-weight: bold; color: #666; margin-bottom: 5px;">Última actualización:</h3>
                    <p style="font-size: 18px;">{{ new Date(categoria.updated_at).toLocaleString() }}</p>
                </div>
            </div>
            
            <h2 style="font-size: 20px; margin-top: 30px; margin-bottom: 15px;">Zapatos en esta Categoría</h2>
            
            <table v-if="categoria.zapatos.length > 0" style="width: 100%; border-collapse: collapse; margin-bottom: 20px;">
                <thead>
                    <tr style="background-color: #f2f2f2;">
                        <th style="border: 1px solid #ddd; padding: 8px; text-align: left;">ID</th>
                        <th style="border: 1px solid #ddd; padding: 8px; text-align: left;">Nombre</th>
                        <th style="border: 1px solid #ddd; padding: 8px; text-align: left;">Marca</th>
                        <th style="border: 1px solid #ddd; padding: 8px; text-align: left;">Precio</th>
                        <th style="border: 1px solid #ddd; padding: 8px; text-align: left;">Stock</th>
                        <th style="border: 1px solid #ddd; padding: 8px; text-align: left;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="zapato in categoria.zapatos" :key="zapato.id" style="border: 1px solid #ddd;">
                        <td style="border: 1px solid #ddd; padding: 8px;">{{ zapato.id }}</td>
                        <td style="border: 1px solid #ddd; padding: 8px;">{{ zapato.nombre }}</td>
                        <td style="border: 1px solid #ddd; padding: 8px;">{{ zapato.marca }}</td>
                        <td style="border: 1px solid #ddd; padding: 8px;">{{ zapato.precio }} €</td>
                        <td style="border: 1px solid #ddd; padding: 8px;">{{ zapato.stock }}</td>
                        <td style="border: 1px solid #ddd; padding: 8px;">
                            <Link :href="route('zapatos.show', zapato.id)" style="background-color: #2b72e6; color: white; padding: 5px 10px; text-decoration: none; display: inline-block;">
                                Ver
                            </Link>
                        </td>
                    </tr>
                </tbody>
            </table>
            
            <p v-else style="text-align: center; padding: 15px; background-color: #f5f5f5;">
                No hay zapatos asociados a esta categoría.
            </p>
            
            <div style="text-align: center; margin-top: 20px;">
                <Link :href="route('categorias.index')" style="background-color: #767676; color: white; padding: 10px 15px; text-decoration: none; display: inline-block; margin-right: 10px;">
                    Volver
                </Link>
                <Link :href="route('categorias.edit', categoria.id)" style="background-color: #c85200; color: white; padding: 10px 15px; text-decoration: none; display: inline-block;">
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
    categoria: Object
});
</script> 