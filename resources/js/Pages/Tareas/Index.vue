<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import NavLink from '@/Components/NavLink.vue';
import Pagination from '@/Components/Pagination.vue';
import Modal from '@/Components/Modal.vue';
import DangerButton from '@/Components/DangerButton.vue';
import InputError from '@/Components/InputError.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import WarningButton from '@/Components/WarningButton.vue';
import DarkButton from '@/Components/DarkButton.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { ref } from 'vue';

const props = defineProps({
    books: { type: Object },
    flash: { type: Object }
});

const form = useForm({id: '', tarea: ''});
const showModalDel = ref(false);
const msj = ref((props.flash.success != null) ? props.flash.success : '');
const classMsj = ref((props.flash.success != null) ? '' : 'hidden');

const openModalDel = (b) => {
    form.id = b.id;
    form.tarea = b.tarea;
    showModalDel.value = true;
}

const closeModalDel = () => {
    showModalDel.value = false;
}

const deleteBook = () => {
    form.delete(route('tareas.destroy', form.id), {
        onSuccess: () => { ok('Tarea eliminada') }
    });
}

const ok = (m) => {
    closeModalDel();
    form.reset();
    msj.value = m;
    classMsj.value = 'block';
    setTimeout(() => {
        classMsj.value = 'hidden';
    }, 4000);
}



</script>

<template>
    <Head title="Tareas"/>
    <AuthenticatedLayout>
        <template #header>
            Tareas
        </template>

        <!-- ALERTA -->
        <div class="inline-flex overflow-hidden mb-4 w-full bg-white rounded-lg shadow-md" :class="classMsj">
				<div class="flex justify-center items-center w-12 bg-green-300 me-2">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="green" class="size-6">
                      <path d="M7.493 18.5c-.425 0-.82-.236-.975-.632A7.48 7.48 0 0 1 6 15.125c0-1.75.599-3.358 1.602-4.634.151-.192.373-.309.6-.397.473-.183.89-.514 1.212-.924a9.042 9.042 0 0 1 2.861-2.4c.723-.384 1.35-.956 1.653-1.715a4.498 4.498 0 0 0 .322-1.672V2.75A.75.75 0 0 1 15 2a2.25 2.25 0 0 1 2.25 2.25c0 1.152-.26 2.243-.723 3.218-.266.558.107 1.282.725 1.282h3.126c1.026 0 1.945.694 2.054 1.715.045.422.068.85.068 1.285a11.95 11.95 0 0 1-2.649 7.521c-.388.482-.987.729-1.605.729H14.23c-.483 0-.964-.078-1.423-.23l-3.114-1.04a4.501 4.501 0 0 0-1.423-.23h-.777ZM2.331 10.727a11.969 11.969 0 0 0-.831 4.398 12 12 0 0 0 .52 3.507C2.28 19.482 3.105 20 3.994 20H4.9c.445 0 .72-.498.523-.898a8.963 8.963 0 0 1-.924-3.977c0-1.708.476-3.305 1.302-4.666.245-.403-.028-.959-.5-.959H4.25c-.832 0-1.612.453-1.918 1.227Z" />
                    </svg>
				</div>
				
				<div class="px-4 py-2 -mx-3">
					<div class="mx-3">
						<span class="font-semibold text-green-600">Exitoso</span>
						<p class="text-sm text-gray-600"> {{ msj }} </p>
					</div>
				</div>
			</div>

            <!-- TABLA  -->
        <div class="w-full overflow-hidden rounded-lg border shadow-md">

            <!-- TABLA -->
            <div class="w-full overflow-x-auto bg-white">
                <table class="w-full whitespace-no-wrap">
                    <thead>
                        <th class="px-4 py-3">#</th>
                        <th class="px-4 py-3">Tarea</th>
                        <th class="px-4 py-3">Imagen</th>
                        <th class="px-4 py-3">Detalle</th>
                        <th class="px-4 py-3">Editar</th>
                        <th class="px-4 py-3">Eliminar</th>
                    </thead>
                
                    <tbody class="bg-white white:bg-gray-800">
                        <tr v-for="b,i in books.data" :key="b.id" class="text-gray-700">
                            <td class="px-4 pys-3 text-sm">{{ (i+1) }}</td>
                            <td class="px-4 pys-3 text-sm"> {{ b.tarea }} </td>
                            <td class="px-4 pys-3 text-sm">  <img :src="'/storage/' + b.image" width="60"> </td>
                            <td class="px-4 pys-3 text-sm">
                                <NavLink :href="route('tareas.show',b.id)">
                                    <SecondaryButton>
                                        <svg class="h-5 w-5 text-neutral-500"  width="24" height="24" viewBox="0 0 24 24" stroke-width="2" 
                                        stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">  
                                        <path stroke="none" d="M0 0h24v24H0z"/>  <polyline points="16 4 20 4 20 8" />  
                                        <line x1="14" y1="10" x2="20" y2="4" />  <polyline points="8 20 4 20 4 16" />  
                                        <line x1="4" y1="20" x2="10" y2="14" />  <polyline points="16 20 20 20 20 16" />  
                                        <line x1="14" y1="14" x2="20" y2="20" />  <polyline points="8 4 4 4 4 8" />  
                                        <line x1="4" y1="4" x2="10" y2="10" /></svg>
                                    </SecondaryButton>
                                </NavLink>
                            </td>
                            <td class="px-4 pys-3 text-sm">
                                <NavLink :href="route('tareas.edit',b.id)">
                                     <WarningButton>
                                        <svg class="h-5 w-5 text-yellow-500"  width="24" height="24" viewBox="0 0 24 24" stroke-width="2" 
                                        stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">  
                                        <path stroke="none" d="M0 0h24v24H0z"/>  <path d="M3 21v-4a4 4 0 1 1 4 4h-4" />  
                                        <path d="M21 3a16 16 0 0 0 -12.8 10.2" />  <path d="M21 3a16 16 0 0 1 -10.2 12.8" />  
                                        <path d="M10.6 9a9 9 0 0 1 4.4 4.4" /></svg>
                                    </WarningButton>
                                </NavLink>
                            </td>
                            <td class="px-4 pys-3 text-sm">
                                <DangerButton @click="openModalDel(b)">
                                    <svg class="h-5 w-5 text-red-500"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  
                                    stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round">  
                                    <polygon points="7.86 2 16.14 2 22 7.86 22 16.14 16.14 22 7.86 22 2 16.14 2 7.86 7.86 2" />  
                                    <line x1="15" y1="9" x2="9" y2="15" />  <line x1="9" y1="9" x2="15" y2="15" /></svg>
                                </DangerButton>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- PAGINACIÓN -->
            <div
				class="px-4 py-3 text-xs font-semibold tracking-wide text-gray-500 uppercase bg-gray-50 border-t sm:grid-cols-9">
				<pagination :links="books.links" />
			</div>

        </div>

                <!-- MODALES -->

            <!-- ELIMINAR -->
        <Modal :show="showModalDel" @close="closeModalDel">
            <div class="p-6">
                <p cclass="text-2xl text-gray-900">
                    ¿Estás seguro de eliminar    
                    <span class="text-xl text-gray-900">{{ form.tarea }}</span>
                    ?
                </p>

            </div>
            <div class="mb-6 me-5 flex justify-end">
                <PrimaryButton class="me-5" @click="deleteBook">Sí, eliminar</PrimaryButton>
                <SecondaryButton @click="closeModalDel">Cancelar</SecondaryButton>
            </div>
        </Modal>

    </AuthenticatedLayout>
</template>