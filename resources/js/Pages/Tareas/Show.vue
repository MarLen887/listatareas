<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import NavLink from '@/Components/NavLink.vue';
import DarkButton from '@/Components/DarkButton.vue';

const props = defineProps({
    book: { type: Object },
    authors: { type: Object }
    // countries: { type: Object }
});


</script>


<template>
    <Head title="Tarea"/>
    <AuthenticatedLayout>
        <template #header>
            <div class="inline-flex overflow-hidden mb-4 w-full text-m">
                {{ book.tarea }}
                <!-- {{ book ? book.tarea : 'No se encontró la tarea' }} -->
                <NavLink :href="route('tareas.index')">
                    <DarkButton>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="black" class="size-6">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M8.625 12a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H8.25m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H12m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0h-.375M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                    </DarkButton>
                </NavLink>
            </div>
        </template>

        <div class="grid gap-6 bg-white mb-8 md:grid-cols-2 border rounded-lg">
            <div class="min-w-0 p-4 rounded-lg shadow-xs">
                <p>Tarea:<span class="text-gray-900 font-semibold">{{ book.tarea }}</span></p>
                <!-- <p>Lista de tareas:
                    <span v-for="(c, i) in countries" :key="i" class="text-gray-900 font-semibold">
                        {{ c.title }}
                    </span>
                </p> -->
                <p class="mt-3">Equipo:
                    <span v-for="a, i in authors" class="text-gray-900 font-semibold">
                        <!-- {{ a.name+ }} -->
                        <a v-if="i == (authors.length - 1)">{{ a.name }}</a>
                        <a v-else>{{  a.name + ', ' }}</a>

                    </span>
                </p>
            </div>
            <div class="min-w-0 p-4 rounded-lg shadow-xs">
                <img :src="'../storage' + book.image" :alt="book.tarea" width="500">
            </div>
        </div>

    </AuthenticatedLayout>
</template>