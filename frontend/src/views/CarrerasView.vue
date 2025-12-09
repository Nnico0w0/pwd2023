<template>
  <div class="carreras-view">
    <div class="header">
      <h1>🎓 Carreras</h1>
      <p class="subtitle">Listado de carreras y programas académicos</p>
    </div>
    
    <div v-if="loading" class="loading">
      <div class="spinner"></div>
      <p>Cargando carreras...</p>
    </div>
    
    <div v-else-if="error" class="error-message">
      <p>{{ error }}</p>
    </div>
    
    <div v-else class="carreras-grid">
      <div v-for="carrera in carreras" :key="carrera.id" class="carrera-card">
        <div class="carrera-header">
          <h3>{{ carrera.nombre }}</h3>
        </div>
        <div class="carrera-body">
          <p class="carrera-descripcion">{{ carrera.descripcion || 'Sin descripción' }}</p>
        </div>
      </div>
    </div>
    
    <div v-if="!loading && carreras.length === 0" class="empty-state">
      <p>No hay carreras registradas</p>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'

const carreras = ref([])
const loading = ref(true)
const error = ref(null)

const fetchCarreras = async () => {
  try {
    loading.value = true
    const response = await fetch('http://localhost:8000/index.php?r=apiv1/carrera')
    
    if (!response.ok) {
      throw new Error('Error al cargar las carreras')
    }
    
    const data = await response.json()
    carreras.value = data
  } catch (err) {
    error.value = err.message
    console.error('Error fetching carreras:', err)
  } finally {
    loading.value = false
  }
}

onMounted(() => {
  fetchCarreras()
})
</script>

<style scoped>
.carreras-view {
  padding: 2rem;
  max-width: 1200px;
  margin: 0 auto;
}

.header {
  margin-bottom: 2rem;
}

.header h1 {
  font-size: 2.5rem;
  color: var(--color-text-primary);
  margin-bottom: 0.5rem;
}

.subtitle {
  font-size: 1.1rem;
  color: var(--color-text-secondary);
}

.loading {
  text-align: center;
  padding: 3rem;
}

.spinner {
  width: 50px;
  height: 50px;
  border: 4px solid var(--color-gray-200);
  border-top-color: var(--color-primary);
  border-radius: 50%;
  animation: spin 1s linear infinite;
  margin: 0 auto 1rem;
}

@keyframes spin {
  to { transform: rotate(360deg); }
}

.error-message {
  background-color: #fee;
  color: #c33;
  padding: 1rem;
  border-radius: 8px;
  text-align: center;
}

.carreras-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
  gap: 1.5rem;
}

.carrera-card {
  background: white;
  border-radius: 12px;
  box-shadow: var(--shadow-md);
  overflow: hidden;
  transition: transform 0.2s, box-shadow 0.2s;
}

.carrera-card:hover {
  transform: translateY(-4px);
  box-shadow: var(--shadow-lg);
}

.carrera-header {
  background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-primary-dark) 100%);
  color: white;
  padding: 1.5rem;
}

.carrera-header h3 {
  margin: 0;
  font-size: 1.3rem;
  font-weight: 600;
}

.carrera-body {
  padding: 1.5rem;
}

.carrera-descripcion {
  color: var(--color-text-secondary);
  line-height: 1.6;
  margin: 0;
}

.empty-state {
  text-align: center;
  padding: 3rem;
  color: var(--color-text-secondary);
  font-size: 1.1rem;
}
</style>
