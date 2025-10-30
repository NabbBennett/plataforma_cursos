// Chart.js
import Chart from 'chart.js/auto';
window.Chart = Chart;

// Vue.js (opcional, si lo usas en componentes)
import { createApp } from 'vue';

// Ejemplo de componente (solo si decides usar Vue)
const app = createApp({});

// app.component('example-component', require('./components/ExampleComponent.vue').default);
// app.mount('#app');

// JS nativo adicional
document.addEventListener('DOMContentLoaded', () => {
    console.log("Frontend JS cargado correctamente.");
});
