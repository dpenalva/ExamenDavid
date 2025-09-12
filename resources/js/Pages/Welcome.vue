<script setup>
import { Head, Link } from '@inertiajs/vue3';
import Navbar from '@/Components/Navbar.vue';
import Footer from '@/Components/Footer.vue';
import { router } from '@inertiajs/vue3';
import { ref, onMounted, computed, onBeforeUnmount } from 'vue';

const props = defineProps({
    zapatosDestacados: {
        type: Array,
        default: () => [],
    },
});

// Para el carrusel
const indiceActual = ref(0);
const totalSlides = computed(() => props.zapatosDestacados.length || 1);

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
    
    // Añadir manejadores de eventos para teclado (accesibilidad)
    document.addEventListener('keydown', manejarTeclado);
});

onBeforeUnmount(() => {
    // Limpiar intervalo y eventos cuando el componente se desmonta
    clearInterval(intervalo);
    document.removeEventListener('keydown', manejarTeclado);
});

// Manejar eventos de teclado para accesibilidad
function manejarTeclado(e) {
    // Navegación del carrusel con flechas
    if (e.key === 'ArrowLeft') {
        anteriorSlide();
    } else if (e.key === 'ArrowRight') {
        siguienteSlide();
    }
}

const irAListadoZapatos = () => {
    router.visit(route('zapatos.index'));
};

const irACrearZapato = () => {
    router.visit(route('zapatos.create'));
};

const irAListadoCategorias = () => {
    router.visit(route('categorias.index'));
};

const irACrearCategoria = () => {
    router.visit(route('categorias.create'));
};
</script>

<template>
    <Head title="ZapatosApp - Inicio" />
    
    <div style="min-height: 100vh; display: flex; flex-direction: column;">
        <Navbar />
        
        <main style="flex-grow: 1;">
            <!-- Carrusel de imágenes -->
            <div style="position: relative; height: 300px; overflow: hidden; border-bottom: 1px solid #0066cc;">
                <!-- Alerta para lectores de pantalla solo para el carrusel -->
                <div class="sr-only" aria-live="polite">
                    <p v-if="zapatosDestacados.length > 0">
                        Mostrando zapato {{ indiceActual + 1 }} de {{ totalSlides }}: 
                        {{ zapatosDestacados[indiceActual]?.nombre }} - 
                        {{ zapatosDestacados[indiceActual]?.marca }} - 
                        Precio: {{ zapatosDestacados[indiceActual]?.precio }}€
                    </p>
                            </div>

                <!-- Contenedor del carrusel -->
                <div 
                    style="display: flex; height: 100%;" 
                    :style="{ transform: `translateX(-${indiceActual * 100}%)` }"
                >
                    <!-- Slides del carrusel con imágenes estáticas y datos de la BD -->
                    <div v-for="(zapato, index) in zapatosDestacados" 
                            :key="index" 
                            style="min-width: 100%; height: 100%; position: relative;"
                    >
                        <!-- Imágenes estáticas de ejemplo -->
                        <img 
                            :src="`https://placehold.co/600x300/0066cc/FFFFFF?text=Zapato+${index + 1}`" 
                            style="width: 100%; height: 100%; object-fit: cover;"
                            :alt="`Imagen de zapato`"
                        />
                        <!-- Información del zapato desde la base de datos -->
                        <div style="position: absolute; bottom: 0; left: 0; right: 0; background-color: white; color: #0066cc; padding: 10px; border-top: 1px solid #0066cc;">
                            <h3 style="font-size: 18px; margin: 0 0 5px 0;">{{ zapato.nombre }}</h3>
                            <p style="margin: 0;">
                                Marca: {{ zapato.marca }} | 
                                Precio: {{ zapato.precio }}€
                                        </p>
                                    </div>
                                </div>
                            </div>

                <!-- Controles del carrusel -->
                <button 
                    @click="anteriorSlide" 
                    style="position: absolute; left: 5px; top: 50%; transform: translateY(-50%); background-color: #0066cc; color: white; border: 1px solid white; width: 30px; height: 30px; cursor: pointer;"
                >
                    &lt;
                </button>
                <button 
                    @click="siguienteSlide" 
                    style="position: absolute; right: 5px; top: 50%; transform: translateY(-50%); background-color: #0066cc; color: white; border: 1px solid white; width: 30px; height: 30px; cursor: pointer;"
                >
                    &gt;
                </button>
                            </div>

            <!-- Sección de Zapatos -->
            <div style="background-color: #d1d1d1; text-align: center; color: black; padding: 20px;">
                Zapatos:
                <div style="margin-top: 10px;">
                    <button @click="irACrearZapato" style="background-color: white; color: black; font-weight: bold; padding: 8px 15px; border: 1px solid black; margin-right: 10px; cursor: pointer;">
                        Crear Zapato
                    </button>
                    <button @click="irAListadoZapatos" style="background-color: white; color: black; font-weight: bold; padding: 8px 15px; border: 1px solid black; cursor: pointer;">
                        Ver Lista Zapatos
                    </button>
                            </div>
                            </div>

            <!-- Sección de Categorías -->
            <div style="background-color: #e5e5e5; text-align: center; color: black; padding: 20px;">
                Categorías:
                <div style="margin-top: 10px;">
                    <button @click="irACrearCategoria" style="background-color: white; color: black; font-weight: bold; padding: 8px 15px; border: 1px solid black; margin-right: 10px; cursor: pointer;">
                        Crear Categoría
                    </button>
                    <button @click="irAListadoCategorias" style="background-color: white; color: black; font-weight: bold; padding: 8px 15px; border: 1px solid black; cursor: pointer;">
                        Ver Lista Categorías
                    </button>
                        </div>
                    </div>
                </main>

        <Footer />
    </div>
</template>

<style>
/* Ajustes de accesibilidad */
@media (prefers-reduced-motion: reduce) {
    * {
        animation-duration: 0.01ms !important;
        animation-iteration-count: 1 !important;
        transition-duration: 0.01ms !important;
        scroll-behavior: auto !important;
    }
}
</style>
