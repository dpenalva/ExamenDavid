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
    
    <div class="min-h-screen flex flex-col">
        <Navbar />
        
        <main class="flex-grow flex items-center justify-center bg-gray-100">
            <div class="max-w-md w-full p-6 bg-white rounded-lg shadow-md">
                <h1 class="text-2xl font-bold text-center text-gray-800 mb-6">Gestión de Zapatos</h1>
                
                <div class="space-y-4">
                    <!-- Ver listado de zapatos -->
                    <Link 
                        :href="route('zapatos.index')" 
                        class="block w-full p-3 text-center bg-blue-500 hover:bg-blue-600 text-white font-semibold rounded-md transition"
                    >
                        Ver Zapatos
                    </Link>
                    
                    <!-- Añadir nuevo zapato -->
                    <Link 
                        :href="route('zapatos.create')" 
                        class="block w-full p-3 text-center bg-green-500 hover:bg-green-600 text-white font-semibold rounded-md transition"
                    >
                        Añadir Zapato
                    </Link>
                </div>
            </div>
        </main>
        
        <Footer />
    </div>
</template>
