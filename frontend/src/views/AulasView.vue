<template>
  <div class="aulas-view">
    <div class="header">
      <h1>🏫 Aulas</h1>
      <p class="subtitle">Gestión de aulas y espacios</p>
    </div>
    
    <div v-if="loading" class="loading">
      <div class="spinner"></div>
      <p>Cargando aulas...</p>
    </div>
    
    <div v-else-if="error" class="error-message">
      <p>{{ error }}</p>
      <button @click="fetchAulas" class="btn-retry">Reintentar</button>
    </div>
    
    <div v-else class="aulas-grid">
      <div v-for="aula in aulas" :key="aula.id" class="aula-card">
        <div class="aula-header">
          <h3>{{ aula.descripcion }}</h3>
          <span class="aula-capacidad">👥 {{ aula.aforo }} personas</span>
        </div>
        <div class="aula-body">
          <p v-if="aula.ubicacion" class="aula-ubicacion">📍 {{ aula.ubicacion }}</p>
          <p class="aula-info">
            <span>🎥 {{ aula.cant_proyector }} proyector(es)</span>
            <span v-if="aula.es_climatizada"> • ❄️ Climatizada</span>
          </p>
        </div>
      </div>
    </div>
    
    <div v-if="!loading && aulas.length === 0" class="empty-state">
      <p>No hay aulas registradas</p>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { aulaService } from '../services/api'

const aulas = ref([])
const loading = ref(true)
const error = ref(null)

const fetchAulas = async () => {
  try {
    loading.value = true
    error.value = null
    const data = await aulaService.getAll()
    aulas.value = data
  } catch (err) {
    error.value = 'NetworkError when attempting to fetch resource.'
    console.error('Error fetching aulas:', err)
  } finally {
    loading.value = false
  }
}

onMounted(() => {
  fetchAulas()
})
</script>

<style scoped>
.aulas-view {
  padding: 2rem;
  max-width: 1200px;
  margin: 0 auto;
}

.header {
  margin-bottom: 2rem;
}

.header h1 {
  font-size: 2.5rem;
  color: var(--color-text-primary, #2c3e50);
  margin-bottom: 0.5rem;
}

.subtitle {
  font-size: 1.1rem;
  color: var(--color-text-secondary, #7f8c8d);
}

.loading {
  text-align: center;
  padding: 3rem;
}

.spinner {
  width: 50px;
  height: 50px;
  border: 4px solid #f3f3f3;
  border-top-color: #667eea;
  border-radius: 50%;
  animation: spin 1s linear infinite;
  margin: 0 auto 1rem;
}

@keyframes spin {
  to { transform: rotate(360deg); }
}

.error-message {
  background: #fee;
  color: #c33;
  padding: 2rem;
  border-radius: 12px;
  text-align: center;
  border-left: 4px solid #c33;
}

.btn-retry {
  margin-top: 1rem;
  padding: 0.75rem 1.5rem;
  background: #667eea;
  color: white;
  border: none;
  border-radius: 8px;
  cursor: pointer;
  font-weight: 600;
}

.aulas-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
  gap: 1.5rem;
}

.aula-card {
  background: white;
  border-radius: 12px;
  padding: 1.5rem;
  box-shadow: 0 2px 8px rgba(0,0,0,0.1);
  transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.aula-card:hover {
  transform: translateY(-4px);
  box-shadow: 0 4px 16px rgba(0,0,0,0.15);
}

.aula-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 1rem;
  padding-bottom: 1rem;
  border-bottom: 2px solid #f0f0f0;
}

.aula-header h3 {
  font-size: 1.25rem;
  color: #2c3e50;
  margin: 0;
}

.aula-capacidad {
  background: #e8f5e9;
  color: #2e7d32;
  padding: 0.25rem 0.75rem;
  border-radius: 20px;
  font-size: 0.85rem;
  font-weight: 600;
}

.aula-body p {
  margin: 0.5rem 0;
  color: #666;
  font-size: 0.95rem;
}

.aula-info {
  display: flex;
  gap: 0.5rem;
  flex-wrap: wrap;
}

.empty-state {
  text-align: center;
  padding: 3rem;
  color: #999;
  font-size: 1.1rem;
}
</style>
