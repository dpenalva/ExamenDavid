<template>
    <Head title="Detalles de Zapato" />
    
    <ZapatosLayout>
        <h1 style="text-align: center; color: purple; font-size: 24px; margin-bottom: 20px;">Detalles del Zapato</h1>
        
        <div style="width: 80%; margin: 0 auto; background-color: #f9f9f9; padding: 20px; border: 1px solid #ddd;">
            <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 15px;">
                <div style="margin-bottom: 15px;">
                    <h3 style="font-size: 14px; font-weight: bold; color: #666; margin-bottom: 5px;">ID:</h3>
                    <p style="font-size: 18px;">{{ zapato.id }}</p>
                </div>
                
                <div style="margin-bottom: 15px;">
                    <h3 style="font-size: 14px; font-weight: bold; color: #666; margin-bottom: 5px;">Nombre:</h3>
                    <p style="font-size: 18px;">{{ zapato.nombre }}</p>
                </div>
                
                <div style="margin-bottom: 15px;">
                    <h3 style="font-size: 14px; font-weight: bold; color: #666; margin-bottom: 5px;">Marca:</h3>
                    <p style="font-size: 18px;">{{ zapato.marca }}</p>
                </div>
                
                <div style="margin-bottom: 15px;">
                    <h3 style="font-size: 14px; font-weight: bold; color: #666; margin-bottom: 5px;">Talla:</h3>
                    <p style="font-size: 18px;">{{ zapato.talla }}</p>
                </div>
                
                <div style="margin-bottom: 15px;">
                    <h3 style="font-size: 14px; font-weight: bold; color: #666; margin-bottom: 5px;">Color:</h3>
                    <p style="font-size: 18px;">{{ zapato.color }}</p>
                </div>
                
                <div style="margin-bottom: 15px;">
                    <h3 style="font-size: 14px; font-weight: bold; color: #666; margin-bottom: 5px;">Precio:</h3>
                    <p style="font-size: 18px;">{{ zapato.precio }} €</p>
                </div>
                
                <div style="margin-bottom: 15px;">
                    <h3 style="font-size: 14px; font-weight: bold; color: #666; margin-bottom: 5px;">Stock:</h3>
                    <p style="font-size: 18px;">{{ zapato.stock }}</p>
                </div>
                
                <div style="margin-bottom: 15px;">
                    <h3 style="font-size: 14px; font-weight: bold; color: #666; margin-bottom: 5px;">Fecha de creación:</h3>
                    <p style="font-size: 18px;">{{ new Date(zapato.created_at).toLocaleString() }}</p>
                </div>
                
                <div style="margin-bottom: 15px;">
                    <h3 style="font-size: 14px; font-weight: bold; color: #666; margin-bottom: 5px;">Última actualización:</h3>
                    <p style="font-size: 18px;">{{ new Date(zapato.updated_at).toLocaleString() }}</p>
                </div>
            </div>
            
            <div style="text-align: center; margin-top: 20px;">
                <Link :href="route('zapatos.index')" style="background-color: #6c757d; color: white; padding: 10px 15px; text-decoration: none; display: inline-block; margin-right: 10px;">
                    Volver
                </Link>
                <Link :href="route('zapatos.edit', zapato.id)" style="background-color: #ffc107; color: black; padding: 10px 15px; text-decoration: none; display: inline-block;">
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