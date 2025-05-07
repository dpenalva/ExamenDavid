<script setup>
import { Head, Link } from '@inertiajs/vue3';
import Navbar from '@/Components/Navbar.vue';
import Footer from '@/Components/Footer.vue';

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
    laravelVersion: {
        type: String,
        required: true,
    },
    phpVersion: {
        type: String,
        required: true,
    },
});

function handleImageError() {
    document.getElementById('screenshot-container')?.classList.add('!hidden');
    document.getElementById('docs-card')?.classList.add('!row-span-1');
    document.getElementById('docs-card-content')?.classList.add('!flex-row');
    document.getElementById('background')?.classList.add('!hidden');
}
</script>

<template>
    <Head title="ZapatosApp - Inicio" />
    
    <div style="min-height: 100vh; display: flex; flex-direction: column;">
        <Navbar />
        
        <main style="flex-grow: 1; background-color: #f8f9fa; padding: 40px 20px;">
            <div style="max-width: 600px; margin: 0 auto; background-color: white; padding: 20px; border: 1px solid #ddd;">
                <h1 style="text-align: center; font-size: 24px; margin-bottom: 20px; color: #333;">Gestión de Zapatos</h1>
                
                <div style="margin: 30px 0;">
                    <!-- Opciones simples en forma de lista -->
                    <ul style="list-style: none; padding: 0;">
                        <li style="margin-bottom: 10px;">
                            <Link 
                                :href="route('zapatos.index')" 
                                style="display: block; padding: 8px 12px; background-color: #007bff; color: white; text-decoration: none; text-align: center;"
                            >
                                Ver Listado de Zapatos
                            </Link>
                        </li>
                        <li style="margin-bottom: 10px;">
                            <Link 
                                :href="route('zapatos.create')" 
                                style="display: block; padding: 8px 12px; background-color: #28a745; color: white; text-decoration: none; text-align: center;"
                            >
                                Añadir Nuevo Zapato
                            </Link>
                        </li>
                    </ul>
                </div>
            </div>
        </main>
        
        <Footer />
    </div>
</template>
