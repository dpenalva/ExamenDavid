<script setup>
import { Head, Link } from '@inertiajs/vue3';
import Navbar from '@/Components/Navbar.vue';
import Footer from '@/Components/Footer.vue';
import { ref, onMounted } from 'vue';

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
    zapatosDestacados: {
        type: Array,
        default: () => [],
    },
});

// Para el carrusel
const indiceActual = ref(0);
const totalSlides = ref(5); // Igual al número de imágenes estáticas que vamos a usar

function siguienteSlide() {
    indiceActual.value = (indiceActual.value + 1) % totalSlides.value;
}

function anteriorSlide() {
    indiceActual.value = (indiceActual.value - 1 + totalSlides.value) % totalSlides.value;
}

// Iniciar carrusel automático
let intervalo;
onMounted(() => {
    intervalo = setInterval(siguienteSlide, 5000); // Cambiar slide cada 5 segundos
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
            <div style="max-width: 800px; margin: 0 auto; background-color: white; padding: 20px; border: 1px solid #ddd;">
                <h1 style="text-align: center; font-size: 24px; margin-bottom: 20px; color: #333;">Gestión de Zapatos</h1>
                
                <!-- Carrusel de imágenes -->
                <div style="position: relative; margin: 30px 0; overflow: hidden; border: 1px solid #ddd; height: 300px;">
                    <!-- Contenedor del carrusel -->
                    <div 
                        style="display: flex; transition: transform 0.5s ease;" 
                        :style="{ transform: `translateX(-${indiceActual * 100}%)` }"
                    >
                        <!-- Slides del carrusel con imágenes estáticas y datos de la BD -->
                        <div v-for="(zapato, index) in zapatosDestacados" :key="index" style="min-width: 100%; height: 300px; position: relative;">
                            <!-- Imágenes estáticas de ejemplo -->
                            <img 
                                :src="`https://placehold.co/600x300/007bff/FFFFFF?text=Zapato+${index + 1}`" 
                                style="width: 100%; height: 100%; object-fit: cover;"
                                alt="Imagen de zapato"
                            />
                            <!-- Información del zapato desde la base de datos -->
                            <div style="position: absolute; bottom: 0; left: 0; right: 0; background-color: rgba(0,0,0,0.7); color: white; padding: 15px;">
                                <h3 style="margin: 0 0 5px 0; font-size: 18px;">{{ zapato.nombre }}</h3>
                                <p style="margin: 0 0 5px 0;">
                                    <span style="font-weight: bold;">Marca:</span> {{ zapato.marca }} | 
                                    <span style="font-weight: bold;">Color:</span> {{ zapato.color }} | 
                                    <span style="font-weight: bold;">Talla:</span> {{ zapato.talla }}
                                </p>
                                <p style="margin: 0; font-size: 18px; font-weight: bold; color: #ffc107;">
                                    Precio: {{ zapato.precio }}€
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Controles del carrusel -->
                    <button 
                        @click="anteriorSlide" 
                        style="position: absolute; left: 10px; top: 50%; transform: translateY(-50%); background-color: rgba(0,0,0,0.5); color: white; border: none; border-radius: 50%; width: 40px; height: 40px; font-size: 18px; cursor: pointer;"
                    >
                        &lt;
                    </button>
                    <button 
                        @click="siguienteSlide" 
                        style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); background-color: rgba(0,0,0,0.5); color: white; border: none; border-radius: 50%; width: 40px; height: 40px; font-size: 18px; cursor: pointer;"
                    >
                        &gt;
                    </button>
                    
                    <!-- Indicadores del carrusel -->
                    <div style="position: absolute; bottom: 10px; left: 0; right: 0; display: flex; justify-content: center; z-index: 10;">
                        <span 
                            v-for="(_, index) in zapatosDestacados" 
                            :key="index" 
                            @click="indiceActual = index"
                            :style="{
                                width: '12px',
                                height: '12px',
                                backgroundColor: index === indiceActual ? '#007bff' : '#ddd',
                                borderRadius: '50%',
                                margin: '0 5px',
                                cursor: 'pointer',
                                display: 'inline-block'
                            }"
                        ></span>
                    </div>
                </div>
                
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
