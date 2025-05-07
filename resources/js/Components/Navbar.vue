<template>
    <nav style="background-color: #343a40; color: white; padding: 16px;">
        <div style="width: 90%; max-width: 1200px; margin: 0 auto; display: flex; justify-content: space-between; align-items: center;">
            <Link :href="route('home')" style="font-size: 20px; font-weight: bold; color: white; text-decoration: none;">ZapatosApp</Link>
            <div style="display: flex; gap: 16px; align-items: center;">
                <Link :href="route('zapatos.index')" style="color: white; text-decoration: none; padding: 5px 10px; transition: opacity 0.3s;">Zapatos</Link>
                <Link :href="route('categorias.index')" style="color: white; text-decoration: none; padding: 5px 10px; transition: opacity 0.3s;">Categorías</Link>
                <Link :href="route('zapatos.create')" style="color: white; text-decoration: none; padding: 5px 10px; transition: opacity 0.3s;">Crear Zapato</Link>
                
                <!-- Usuario autenticado -->
                <template v-if="$page.props.auth.user">
                    <div style="position: relative;" @click.stop="showUserMenu = !showUserMenu">
                        <button style="background: none; border: none; color: white; padding: 5px 10px; cursor: pointer; display: flex; align-items: center; gap: 5px;">
                            {{ $page.props.auth.user.name }}
                            <span style="font-size: 12px;">▼</span>
                        </button>
                        
                        <!-- Menú desplegable -->
                        <div v-if="showUserMenu" style="position: absolute; top: 100%; right: 0; background-color: white; border-radius: 4px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); min-width: 150px; z-index: 100;">
                            <Link :href="route('profile.edit')" style="display: block; padding: 10px 15px; color: #333; text-decoration: none; border-bottom: 1px solid #eee;">
                                Perfil
                            </Link>
                            <Link :href="route('logout')" method="post" as="button" style="width: 100%; text-align: left; background: none; border: none; padding: 10px 15px; color: #333; cursor: pointer;">
                                Cerrar Sesión
                            </Link>
                        </div>
                    </div>
                </template>
                
                <!-- Usuario no autenticado -->
                <template v-else>
                    <Link v-if="route().has('login')" :href="route('login')" style="color: white; text-decoration: none; padding: 5px 10px; transition: opacity 0.3s; border: 1px solid white; border-radius: 4px;">
                        Iniciar Sesión
                    </Link>
                    <Link v-if="route().has('register')" :href="route('register')" style="color: white; text-decoration: none; padding: 5px 10px; transition: opacity 0.3s; background-color: #28a745; border-radius: 4px;">
                        Registrarse
                    </Link>
                </template>
            </div>
        </div>
    </nav>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
import { ref, onMounted, onBeforeUnmount } from 'vue';

const showUserMenu = ref(false);

// Función para cerrar el menú cuando se hace clic fuera
function handleClickOutside(event) {
    if (showUserMenu.value && !event.target.closest('button') && !event.target.closest('div[style*="position: relative"]')) {
        showUserMenu.value = false;
    }
}

// Agregar y eliminar el evento de clic global
onMounted(() => {
    document.addEventListener('click', handleClickOutside);
});

onBeforeUnmount(() => {
    document.removeEventListener('click', handleClickOutside);
});
</script> 