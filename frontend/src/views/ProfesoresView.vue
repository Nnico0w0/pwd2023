<template>
  <div class="profesores-view">
    <div class="header">
      <h1>👨‍🏫 Profesores</h1>
      <p class="subtitle">Listado del cuerpo docente</p>
    </div>
    
    <div v-if="loading" class="loading">
      <div class="spinner"></div>
      <p>Cargando profesores...</p>
    </div>
    
    <div v-else-if="error" class="error-message">
      <p>{{ error }}</p>
    </div>
    
    <div v-else class="profesores-grid">
      <div v-for="profesor in profesores" :key="profesor.id" class="profesor-card">
        <div class="profesor-avatar">
          {{ getInitials(profesor.nombre, profesor.apellido) }}
        </div>
        <div class="profesor-info">
          <h3>{{ profesor.apellido }}, {{ profesor.nombre }}</h3>
          <p class="profesor-email" v-if="profesor.email">📧 {{ profesor.email }}</p>
        </div>
      </div>
    </div>
    
    <div v-if="!loading && profesores.length === 0" class="empty-state">
      <p>No hay profesores registrados</p>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'

const profesores = ref([])
const loading = ref(true)
const error = ref(null)

const getInitials = (nombre, apellido) => {
  const n = nombre?.charAt(0) || ''
  const a = apellido?.charAt(0) || ''
  return (n + a).toUpperCase()
}

const fetchProfesores = async () => {
  try {
    loading.value = true
    const response = await fetch('http://localhost:8000/index.php?r=apiv1/profesor')
    
    if (!response.ok) {
      throw new Error('Error al cargar los profesores')
    }
    
    const data = await response.json()
    profesores.value = data
  } catch (err) {
    error.value = err.message
    console.error('Error fetching profesores:', err)
  } finally {
    loading.value = false
  }
}

onMounted(() => {
  fetchProfesores()
})
</script>

<style scoped>
.profesores-view {
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

.profesores-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
  gap: 1.5rem;
}

.profesor-card {
  background: white;
  border-radius: 12px;
  box-shadow: var(--shadow-md);
  padding: 1.5rem;
  display: flex;
  align-items: center;
  gap: 1.5rem;
  transition: transform 0.2s, box-shadow 0.2s;
}

.profesor-card:hover {
  transform: translateY(-4px);
  box-shadow: var(--shadow-lg);
}

.profesor-avatar {
  width: 60px;
  height: 60px;
  border-radius: 50%;
  background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-secondary) 100%);
  color: white;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 1.5rem;
  font-weight: 600;
  flex-shrink: 0;
}

.profesor-info {
  flex: 1;
  min-width: 0;
}

.profesor-info h3 {
  margin: 0 0 0.5rem 0;
  font-size: 1.2rem;
  color: var(--color-text-primary);
}

.profesor-email {
  margin: 0;
  color: var(--color-text-secondary);
  font-size: 0.9rem;
  overflow: hidden;
  text-overflow: ellipsis;
  white-space: nowrap;
}

.empty-state {
  text-align: center;
  padding: 3rem;
  color: var(--color-text-secondary);
  font-size: 1.1rem;
}
</style>
