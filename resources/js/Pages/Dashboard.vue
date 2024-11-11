
<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { Bar, Pie } from 'vue-chartjs';
import { Chart as ChartJS, Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale, ArcElement } from 'chart.js';
import { ref } from 'vue';
ChartJS.register(Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale, ArcElement);

const props = defineProps({
    authors: { type: Object },
    books: { type: Number },
    countries: { type: Object },
});


const aut = ref([]);
const cou = ref([]);
const chartData1 = ref([]);
const charOptions1 = ref([]);
const chartData2 = ref([]);
const charOptions2 = ref([]);
const aut2 = ref([]);
const boo = ref([]);
const colors = ref([]);


const random = () => {
  return Math.floor(Math.random() * 256);
}

// Graphic1
props.countries.map((row) => (
    cou.value.push(row.country),
    aut.value.push(row.authors.length),
    colors.value.push('rgb(' + random() + ', ' + random() + ', ' + random() + ')')
))

charOptions1.value = { responsive: true };
chartData1.value = {
    labels: cou.value,
    datasets: [{
        label: 'Authors', data: aut.value, backgroundColor: colors
    }]
}


chartOptions1.value = {
  responsive: true,
  maintainAspectRatio: false,
  plugins: {
    legend: {
      position: 'right',
      labels: {
        font: {
          size: window.innerWidth < 768 ? 10 : 12, 
        },
        padding: 10,
        boxWidth: 20,
        boxHeight: 10,
      },
    },
    tooltip: {
      enabled: true,
    },
  },
  scales: {
    x: {
      ticks: {
        autoSkip: window.innerWidth < 768 ? true : false, 
        maxRotation: 45,
        minRotation: 45,
        font: {
          size: window.innerWidth < 768 ? 10 : 12,
        },
      },
    },
    y: {
      beginAtZero: true,
      ticks: {
        font: {
          size: window.innerWidth < 768 ? 10 : 12,
        },
      },
    },
  },
};
chartData1.value = {
  labels: reg.value,
  datasets: [
    {
      label: 'Protected Areas',
      data: areas.value,
      backgroundColor: colors,
    },
  ],
};
// Graphic2
props.protectedAreas.forEach((area, index) => {
    areas2.value.push(area.area_name);
    const speciesCount = area.species ? area.species.length : 0;
    spe.value.push(speciesCount);
    colors.value.push(`rgb(${random()}, ${random()}, ${random()})`);
});

chartOptions2.value = {
  responsive: true,
  maintainAspectRatio: false,
  plugins: {
    legend: {
      position: window.innerWidth < 768 ? 'bottom' : 'right', 
      labels: {
        font: {
          size: window.innerWidth < 768 ? 10 : 12, 
        },
        padding: 8,
        boxWidth: 15,
        boxHeight: 8,
      },
    },
    tooltip: {
      enabled: true,
    },
  },
};
chartData2.value = {
    labels: areas2.value, 
    datasets: [
        {
            label: 'Species Count per Protected Area',
            data: spe.value, 
            backgroundColor: colors.value,
        },
    ],
};
</script>

<template>
	<Head title="Dashboard" />
	<AuthenticatedLayout>
		<template #header>
			Dashboard
		</template>
		<div class="p-4 bg-white rounded-lg shadow-xs">
			<div class="grid gap-8 mb-8 md:grid-cols-3 xl:grid-cols-3">
              <!-- Card -->
              <div class="flex border items-center p-4 bg-white rounded-lg shadow-xs ">
                <div class="p-3 mr-4 text-purple-500 bg-purple-100 rounded-full d">
					<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
</svg>

                </div>
                <div>
                  <p class="mb-2 text-sm font-medium text-gray-600 ">
                    Equipo
                  </p>
                  <p class="text-lg font-semibold text-gray-700 ">
                    {{authors.length}}
                  </p>
                </div>
              </div>
              <!-- Card -->
              <div class="flex border items-center p-4 bg-white rounded-lg shadow-xs ">
                <div class="p-3 mr-4 text-pink-500 bg-pink-100 rounded-full ">
					<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 12h16.5m-16.5 3.75h16.5M3.75 19.5h16.5M5.625 4.5h12.75a1.875 1.875 0 0 1 0 3.75H5.625a1.875 1.875 0 0 1 0-3.75Z" />
</svg>

        
                </div>
                <div>
                  <p class="mb-2 text-sm font-medium text-gray-600 ">
                    Lista de Tareas
                  </p>
                  <p class="text-lg font-semibold text-gray-700 ">
                    {{ books }}
                  </p>
                </div>
              </div>
              <!-- Card -->
              	<div class="flex border items-center p-4 bg-white rounded-lg shadow-xs ">
                	<div class="p-3 mr-4 text-green-500 bg-green-100 rounded-full ">
						<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25ZM6.75 12h.008v.008H6.75V12Zm0 3h.008v.008H6.75V15Zm0 3h.008v.008H6.75V18Z" />
</svg>

                	</div>
                	<div>
                	  <p class="mb-2 text-sm font-medium text-gray-600 ">
                	    Tareas
                	  </p>
                	  <p class="text-lg font-semibold text-gray-700 ">
                	    {{ countries.length }}
                	  </p>
                	</div>
              	</div>
			</div>
			<div class="space-y-6 bg-white p-6 border rounded-lg">
			  <!-- Gráfico 1 -->
			  <div class="w-full p-6 rounded-lg shadow-md bg-gray-50 border">
			    <h2 class="text-lg md:text-xl font-semibold text-gray-700 mb-4 text-center">Lista de Tareas - Equipo</h2>
			    <div class="flex justify-center items-center h-[300px] md:h-[500px]">
			      <Bar :data="chartData1" :options="chartOptions1" class="w-full max-w-full md:max-w-3xl"></Bar>
			    </div>
			  </div>
			  <!-- Gráfico 2 -->
			  <div class="w-full p-6 rounded-lg shadow-md bg-gray-50 border">
			    <h2 class="text-lg md:text-xl font-semibold text-gray-700 mb-4 text-center">Tareas - Equipo</h2>
			    <div class="flex justify-center items-center h-[300px] md:h-[500px]">
			      <Pie :data="chartData2" :options="chartOptions2" class="w-full max-w-full md:max-w-3xl"></Pie>
			    </div>
			  </div>
			</div>
		</div>

		<div class="grid gap-6 bg-white mb-8 md:grid-cols-2 border rounded-lg">
            <div class="min-w-0 p-4 rounded-lg shadow-xs">
			</div>
		</div>

	</AuthenticatedLayout>
</template>
