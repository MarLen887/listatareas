<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import DangerButton from '@/Components/DangerButton.vue';
import InputError from '@/Components/InputError.vue';
import Modal from '@/Components/Modal.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import WarningButton from '@/Components/WarningButton.vue';
import DarkButton from '@/Components/DarkButton.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import InputGroup from '@/Components/InputGroup.vue';
import SelectInput from '@/Components/SelectInput.vue';
import { ref } from 'vue';

const props = defineProps({
    authors: { type: Object },
    countries: { type: Object },
    modelValue: [String, Number]
});

const form = useForm({name:'',lead:'',members:'',fecha_entrega:'',country_id: ''});
const v = ref({id:'', name:'', lead:'',members:'',fecha_entrega:'',books:[]});

const showModalView = ref(false);
const showModalForm = ref(false);
const showModalDel = ref(false);
const title = ref('');
const operation = ref(1);
const msj = ref('');
const classMsj = ref('hidden');

const openModalView = (a) => {
    showModalView.value = true;
    v.value.name = a.name;
    v.value.lead = a.lead;
    v.value.members = a.members;
    v.value.fecha_entrega = a.fecha_entrega;
    v.value.country = a.country;
}

const openModalForm = (op,a) => {
    showModalForm.value = true;
    operation.value = op;
    if(op === 1) {
        title.value = 'Crear un equipo';
    } else {
        title.value = 'Editar un equipo';
        // form.name = a.name;
        // form.lead = a.lead;
        // form.members = a.members;
        // form.fecha_entrega = a.fecha_entrega;
        // form.country_id = a.country_id;
        form.name = a.name;
        form.lead = a.lead;
        form.members = a.members;
        form.fecha_entrega = a.fecha_entrega;
        form.country_id = a.country_id;
        v.value.id = a.id;
    }
}


const openModalDel = (a) => {
    showModalDel.value = true;
    v.value.id = a.id;
    v.value.name = a.name;
    v.value.lead = a.lead;
    v.value.members = a.members;
    v.value.fecha_entrega = a.fecha_entrega;
}


const closeModalView = () => {
    showModalView.value = false;
}

const closeModalForm = () => {
    showModalForm.value = false;
    form.reset();
}

const closeModalDel = () => {
    showModalDel.value = false;
}

const save = () => {
    if (operation.value == 1) {
    form.post(route('equipos.store'), {
        onSuccess: () => { ok('Equipo creado') }
        });
    } else {       
        form.put(route('equipos.update', v.value.id), {
            onSuccess: () => { ok('Equipo actualizado') }
        });
    }
}


const ok = (m) => {
    if (operation.value == 2) {
        closeModalForm();
    }
    closeModalDel();
    form.reset();
    msj.value = m;
    classMsj.value = 'block';
    setTimeout(() => {
    classMsj.value = 'hidden';
    }, 4000);
}

const deleteAuthor = () => {
    form.delete(route('equipos.destroy', v.value.id), {
        onSuccess: () => { ok('Equipo eliminado') }
    })
}


</script>

<template>
    <Head title="Equipos"/>
    <AuthenticatedLayout>
        <template #header>
            Equipos
            <DarkButton @click="openModalForm(1)">
                <svg class="h-5 w-5 text-neutral-500"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  
                stroke-linecap="round"  stroke-linejoin="round">  <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />  
                <circle cx="8.5" cy="7" r="4" />  <line x1="20" y1="8" x2="20" y2="14" />  <line x1="23" y1="11" x2="17" y2="11" /></svg>
            </DarkButton>
        </template>

        <!-- ALERTA -->
        <div class="inline-flex overflow-hidden mb-4 w-full bg-white rounded-lg shadow-md" :class="classMsj">
				<div class="flex justify-center items-center w-12 bg-green-300">
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
            <div class="w-full overflow-x-auto bg-white">
                <table class="w-full whitespace-no-wrap">
                    <thead>
                        <th class="px-4 py-3">#</th>
                        <th class="px-4 py-3">Nombre</th>
                        <th class="px-4 py-3">Líder</th>
                        <th class="px-4 py-3">Integrantes</th>
                        <th class="px-4 py-3">Lista de Tareas</th>
                        <th class="px-4 py-3">Fecha de entrega</th>
                        <th class="px-4 py-3">Detalle</th>
                        <th class="px-4 py-3">Editar</th>
                        <th class="px-4 py-3">Eliminar</th>
                    </thead>
                
                    <tbody class="bg-white white:bg-gray-800">
                        <tr v-for="a,i in authors" :key="a.id" class="text-gray-700">
                            <td class="px-4 pys-3 text-sm">{{ (i+1) }}</td>
                            <td class="px-4 pys-3 text-sm"> {{ a.name }} </td>
                            <td class="px-4 pys-3 text-sm"> {{ a.lead }} </td>
                            <td class="px-4 pys-3 text-sm"> {{ a.members }} </td>
                            <td class="px-4 pys-3 text-sm"> {{ a.country.title }} </td>
                            <td class="px-4 pys-3 text-sm text-center"> {{ a.fecha_entrega }} </td>
                            <td class="px-4 pys-3 text-sm">
                                <SecondaryButton @click="openModalView(a)">
                                    <svg class="h-5 w-5 text-neutral-500"  width="24" height="24" viewBox="0 0 24 24" stroke-width="2" 
                                    stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">  
                                    <path stroke="none" d="M0 0h24v24H0z"/>  <polyline points="16 4 20 4 20 8" />  
                                    <line x1="14" y1="10" x2="20" y2="4" />  <polyline points="8 20 4 20 4 16" />  
                                    <line x1="4" y1="20" x2="10" y2="14" />  <polyline points="16 20 20 20 20 16" />  
                                    <line x1="14" y1="14" x2="20" y2="20" />  <polyline points="8 4 4 4 4 8" />  
                                    <line x1="4" y1="4" x2="10" y2="10" /></svg>
                                </SecondaryButton>
                            </td>
                            <td class="px-4 pys-3 text-sm">
                                 <WarningButton @click="openModalForm(2,a)">
                                    <svg class="h-5 w-5 text-yellow-500"  width="24" height="24" viewBox="0 0 24 24" stroke-width="2" 
                                    stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">  
                                    <path stroke="none" d="M0 0h24v24H0z"/>  <path d="M3 21v-4a4 4 0 1 1 4 4h-4" />  
                                    <path d="M21 3a16 16 0 0 0 -12.8 10.2" />  <path d="M21 3a16 16 0 0 1 -10.2 12.8" />  
                                    <path d="M10.6 9a9 9 0 0 1 4.4 4.4" /></svg>
                                </WarningButton>
                            </td>
                            <td class="px-4 pys-3 text-sm">
                                <DangerButton @click="openModalDel(a)">
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
        </div>

                <!-- MODALES -->
            <!-- VISTA -->
            <Modal :show="showModalView" @close="closeModalView">
                <div class="p-6 font-medium">
                    <p class="text-gray-600">Equipo: <span class="text-m text-gray-900">{{ v.name }}</span></p>
                    <p class="text-gray-600 mt-2">Lider <span class="text-m text-gray-900">{{ v.lead }}</span></p>
                    <p class="text-gray-600 mt-2">Integrantes: <span class="text-m text-gray-900">{{ v.members }}</span></p>
                    <p class="text-gray-600 mt-2">Fecha de entrega: <span class="text-m text-gray-900">{{ v.fecha_entrega }}</span></p>
                    <p class="text-gray-600 mt-2">Lista de Tareas: <span class="text-m text-gray-900">{{ v.country.title }}</span></p>

                    <p class="text-gray-600 mt-2">Tareas: </p>
                    <ol>
                        <li class="text-lg font-medium text-gray-900" v-for="(b, i) in v.books">
                            {{ (i+1) + ') ' + b.title }}
                        </li>
                    </ol>


                    <!-- <p class="text-gray-600 mt-2">Lista de Tareas: </p>
                        <ul>
                            <li v-if="v.country" class="text-m font-medium text-gray-900 mt-1">
                                {{ v.country.id + ') ' + v.country.title }}
                            </li>
                        </ul> -->
                </div>
                <div class="mt-6 mb-2 me-2 flex justify-end">
                    <SecondaryButton @click="closeModalView">Cancel</SecondaryButton>
                </div>
            </Modal>

            <!-- FORMULARIO -->
        <Modal :show="showModalForm" @close="closeModalForm">
            <div class="p-6">
                <h2 class="text-lg font-medium text-gray-900">{{ title }}</h2>
                <div class="mt-6 mb-6 space-y-6 max-w-xl">
                        <!-- NOMBRE EQUIPO -->
                    <InputGroup :text="'Nombre'" :required="'required'" v-model="form.name" :type="'text'" :name="'name'" :id="'name'">
                        <svg class="h-5 w-5 text-neutral-500"  fill="none" viewBox="0 0 24 24" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </InputGroup>
                    <InputError class="mt-1" :message="form.errors.name"></InputError>
                        <!-- LIDER EQUIPO -->
                    <InputGroup :text="'Líder'" :required="'required'" v-model="form.lead" :type="'text'" :name="'lead'" :id="'lead'">
                    <svg class="h-5 w-5 text-neutral-500"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2" stroke-linecap="round"  stroke-linejoin="round">  <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />  
                    <circle cx="8.5" cy="7" r="4" />  <polyline points="17 11 19 13 23 9" /></svg>
                    </InputGroup>
                    <InputError class="mt-1" :message="form.errors.lead"></InputError>

                        <!-- INTEGRANTES EQUIPO -->
                    <InputGroup :text="'Integrantes'" :required="'required'" v-model="form.members" :type="'text'" :name="'members'" :id="'members'">
                    <svg class="h-5 w-5 text-neutral-500"  width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">  <path stroke="none" 
                    d="M0 0h24v24H0z"/>  <circle cx="9" cy="7" r="4" />  <path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" /><path d="M16 3.13a4 4 0 0 1 0 7.75" />  <path d="M21 21v-2a4 4 0 0 0 -3 -3.85" /></svg>
                    </InputGroup>
                    <InputError class="mt-1" :message="form.errors.members"></InputError>

                        <!-- OPCIONES PARA LISTA DE TAREAS -->
                        <SelectInput :text="'Lista de Tareas'" :required="'required'" v-model="form.country_id" :options="countries" :name="'country_id'" :id="'country_id'">
                            <svg class="h-5 w-5 text-neutral-500"  width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">  <path stroke="none" 
                            d="M0 0h24v24H0z"/>  <path d="M3.5 5.5l1.5 1.5l2.5 -2.5" />  <path d="M3.5 11.5l1.5 1.5l2.5 -2.5" /> <path d="M3.5 17.5l1.5 1.5l2.5 -2.5" />  <line x1="11" y1="6" x2="20" y2="6" />  <line x1="11" y1="12" x2="20" y2="12" />  <line x1="11" y1="18" x2="20" y2="18" /></svg>
                        </SelectInput>
                        <InputError class="mt-1" :message="form.errors.country_id"></InputError>

                        <!-- FECHA DE ENTREGA -->
                    <InputGroup :text="'Fecha de entrega'" :required="'required'" v-model="form.fecha_entrega" :type="'date'" :name="'fecha_entrega'" :id="'fecha_entrega'">
                    <svg class="h-5 w-5 text-neutral-500"  width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">  <path stroke="none" 
                    d="M0 0h24v24H0z"/>  <rect x="4" y="5" width="16" height="16" rx="2" />  <line x1="16" y1="3" x2="16" y2="7"/><line x1="8" y1="3" x2="8" y2="7" />  <line x1="4" y1="11" x2="20" y2="11" />  <line x1="10" y1="16" x2="14" y2="16"/></svg>
                    </InputGroup> 
                    <span class="flex justify-end text-xs text-gray-500 -mt-5">Coloca la fecha de entrega</span>
                    <InputError class="mt-1" :message="form.errors.fecha_entrega"></InputError>

                </div>

            </div>
            <div class="mb-5 flex justify-end">
                <div class="me-6">
                    <PrimaryButton @click="save">Guardar</PrimaryButton>
                </div>
                <div class="me-6">
                    <SecondaryButton @click="closeModalForm">Cancelar</SecondaryButton>
                </div>
            </div>
        </Modal>

            <!-- ELIMINAR -->
        <Modal :show="showModalDel" @close="closeModalDel">
            <div class="p-6">
                <p cclass="text-2xl text-gray-900">
                    ¿Estás seguro de eliminar    
                    <span class="text-xl text-gray-900">{{ v.name }}</span>
                    ?
                </p>

            </div>
            <div class="mb-6 me-5 flex justify-end">
                <PrimaryButton class="me-5" @click="deleteAuthor">Sí, eliminar</PrimaryButton>
                <SecondaryButton @click="closeModalDel">Cancelar</SecondaryButton>
            </div>
        </Modal>

    </AuthenticatedLayout>
</template>