<script setup>

import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import NavLink from '@/Components/NavLink.vue';
import DarkButton from '@/Components/DarkButton.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import InputGroup from '@/Components/InputGroup.vue';
import InputError from '@/Components/InputError.vue';
import { ref } from 'vue';
import select2 from 'select2';
import $ from 'jquery';
window.$ = $;
window.jQuery = window.$;
select2();
import Select2 from 'vue3-select2-component';

// const props = defineProps({
//     authors: { type: Object },
//     book: { type: Object },
//     authorsOfBook: { type: Object }
// });

const props = defineProps({
    authors: { type: Object },
    book: { type: Object, default: () => ({}) },
    authorsOfBook: { type: Object }
});


const form = useForm({
    id: '', tarea: '', image: '', authors:[]
});

// const title_form = ref(
//     (props.book == null) ? 'Crear tarea' : 'Editar tarea'
// );

const title_form = ref(
    props.book && props.book.id ? 'Editar tarea' : 'Crear tarea'
);


const req = ref('required');
// const srcImg = ref('../../storage/img/example.png');
const srcImg = ref(
    props.book && props.book.image ? `/storage/${props.book.image}` : '/storage/img/example.png'
);


const msj = ref('');
const classMsj = ref('hidden');
const options = ref([]);

props.authors.map((row) => (
    options.value.push({'id': row.id, 'text': row.tarea})
));


if (props.book != null) {
    form.tarea = props.book.tarea;
    form.image = props.book.image;
    form.id = props.book.id;
    srcImg.value = '../../storage' + props.book.image;
    props.authorsOfBook.map((row) => (
    form.authors.push(row.id)
))

}


const save = () => {
    console.log('Método save ejecutado');
    console.log('Contenido del formulario:', form);
    if (props.book == null) {
        form.post(route('tareas.store'), {
            onSuccess: () => { ok('Tarea creada') }
        });
    } else {
        form.id = props.book.id || form.id;
        form.put(route('updateTareas'), {
            onSuccess: () => { ok('Tarea actualizada') }
        });
    }
}


const ok = (m) => {
    form.reset();
    msj.value = m;
    classMsj.value = 'block';
    setTimeout(() => {
        classMsj.value = 'hidden';
    }, 4000);
}


const showImg = (e) => {
    // form.image = e.target.files[0];
    // srcImg.value = URL.createObjectURL(e.target.files[0]);
    if (e.target.files[0]) {
        form.image = e.target.files[0];
        srcImg.value = URL.createObjectURL(e.target.files[0]);
    }
}


</script>

<template>
    <Head title="Tarea"/>
    <AuthenticatedLayout>
        <template #header>
            <div class="inline-flex overflow-hidden mb-4 w-full text-m">
                {{ title_form }}
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

            <!-- INPUT -->
        <div class="grid gap-6 bg-white mb-8 md:grid-cols-2 border rounded-lg">
            <div class="min-w-0 p-4 rounded-lg shadow-xs">
                <form class="mt-6 mb-6 space-y-6 max-w-xl" @submit.prevent="save">
                    <InputGroup :text="'Tarea'" :required="'required'" v-model="form.tarea" :type="'text'">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 0 0 .75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 0 0-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0 1 12 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 0 1-.673-.38m0 0A2.18 2.18 0 0 1 3 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 0 1 3.413-.387m7.5 0V5.25A2.25 2.25 0 0 0 13.5 3h-3a2.25 2.25 0 0 0-2.25 2.25v.894m7.5 0a48.667 48.667 0 0 0-7.5 0M12 12.75h.008v.008H12v-.008Z" />
                        </svg>
                    </InputGroup>
                    <InputError :message="form.errors.tarea" />

                    <InputGroup v-if="props.book == null" @change="showImg($event)" :text="'Imagen'" :required="'required'" :type="'file'" :accept="'image/*'">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M6.827 6.175A2.31 2.31 0 0 1 5.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 0 0-1.134-.175 2.31 2.31 0 0 1-1.64-1.055l-.822-1.316a2.192 2.192 0 0 0-1.736-1.039 48.774 48.774 0 0 0-5.232 0 2.192 2.192 0 0 0-1.736 1.039l-.821 1.316Z" />
                          <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 12.75a4.5 4.5 0 1 1-9 0 4.5 4.5 0 0 1 9 0ZM18.75 10.5h.008v.008h-.008V10.5Z" />
                        </svg>
                    </InputGroup>
                    <InputGroup v-else :text="'Imagen'" @change="showImg($event)" :type="'file'" :accept="'image/*'">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M6.827 6.175A2.31 2.31 0 0 1 5.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 0 0-1.134-.175 2.31 2.31 0 0 1-1.64-1.055l-.822-1.316a2.192 2.192 0 0 0-1.736-1.039 48.774 48.774 0 0 0-5.232 0 2.192 2.192 0 0 0-1.736 1.039l-.821 1.316Z" />
                          <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 12.75a4.5 4.5 0 1 1-9 0 4.5 4.5 0 0 1 9 0ZM18.75 10.5h.008v.008h-.008V10.5Z" />
                        </svg>
                    </InputGroup>
                    <InputError :message="form.errors.image" />

                    <span class="mt-2">Añadir Equipo</span>
                    <Select2 v-model="form.authors" :options="options"
                             :settings="{multiple: true, width: '100%'}" @change="form.authors = $event.target.value" />
                    <InputError :message="form.errors.authors" />

                    
                    <div class="flex justify-center">
                        <PrimaryButton>Guardar</PrimaryButton>
                    </div>
                    
                </form>
            </div>
            <div class="min-w-0 p-4 rounded-lg shadow-xs">
                <img :src="srcImg" width="500">
            </div>
        </div>

    </AuthenticatedLayout>
</template>
