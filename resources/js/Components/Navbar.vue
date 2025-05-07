<template>
    <nav class="bg-gray-800 text-white p-4">
        <div class="container mx-auto flex justify-between items-center">
            <div class="text-xl font-bold">ZapatosApp</div>
            <div class="flex space-x-4">
                <Link :href="route('zapatos.index')" class="hover:text-gray-300">Zapatos</Link>
                <Link :href="route('zapatos.create')" class="hover:text-gray-300">Crear Zapato</Link>
            </div>
        </div>
    </nav>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
</script> 