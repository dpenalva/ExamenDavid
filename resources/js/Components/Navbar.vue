<template>
    <nav style="background-color: #343a40; color: white; padding: 16px;">
        <div style="width: 90%; max-width: 1200px; margin: 0 auto; display: flex; justify-content: space-between; align-items: center;">
            <Link :href="route('/')" style="font-size: 20px; font-weight: bold; color: white; text-decoration: none;">ZapatosApp</Link>
            <div style="display: flex; gap: 16px;">
                <Link :href="route('zapatos.index')" style="color: white; text-decoration: none; padding: 5px 10px; transition: opacity 0.3s;">Zapatos</Link>
                <Link :href="route('zapatos.create')" style="color: white; text-decoration: none; padding: 5px 10px; transition: opacity 0.3s;">Crear Zapato</Link>
            </div>
        </div>
    </nav>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
</script> 