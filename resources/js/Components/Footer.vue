<template>
    <footer class="bg-gray-800 text-white py-6 mt-auto" role="contentinfo">
        <div class="w-11/12 max-w-6xl mx-auto">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="mb-4 md:mb-0">
                    <p class="text-center md:text-left text-gray-300">
                        &copy; {{ new Date().getFullYear() }} ZapatosApp. Todos los derechos reservados.
                    </p>
                </div>
                <div class="flex flex-col sm:flex-row gap-4 text-center md:text-right">
                    <a 
                        href="#" 
                        class="text-gray-300 hover:text-white transition-colors focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-offset-2 focus:ring-offset-gray-800 rounded px-2 py-1"
                        aria-label="Política de privacidad"
                    >
                        Política de privacidad
                    </a>
                    <a 
                        href="#" 
                        class="text-gray-300 hover:text-white transition-colors focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-offset-2 focus:ring-offset-gray-800 rounded px-2 py-1"
                        aria-label="Términos y condiciones"
                    >
                        Términos y condiciones
                    </a>
                    <a 
                        href="#" 
                        class="text-gray-300 hover:text-white transition-colors focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-offset-2 focus:ring-offset-gray-800 rounded px-2 py-1"
                        aria-label="Contacto"
                    >
                        Contacto
                    </a>
                </div>
            </div>
        </div>
    </footer>
</template>

<script setup>
// No se requieren imports específicos
</script> 