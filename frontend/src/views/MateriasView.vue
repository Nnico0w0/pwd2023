<template>
  <div class="materias-view">
    <div class="header">
      <h1>📚 Materias</h1>
      <p class="subtitle">Listado de materias y asignaturas</p>
    </div>
    
    <div v-if="loading" class="loading">
      <div class="spinner"></div>
      <p>Cargando materias...</p>
    </div>
    
    <div v-else-if="error" class="error-message">
      <p>{{ error }}</p>
    </div>
    
    <div v-else class="materias-list">
      <div v-for="materia in materias" :key="materia.id" class="materia-card">
        <div class="materia-icon">📖</div>
        <div class="materia-content">
          <h3>{{ materia.nombre }}</h3>
          <p class="materia-info">
            <span v-if="materia.carrera">🎓 {{ materia.carrera }}</span>
            <span v-if="materia.profesor">👨‍🏫 {{ materia.profesor }}</span>
          </p>
        </div>
      </div>
    </div>
    
    <div v-if="!loading && materias.length === 0" class="empty-state">
      <p>No hay materias registradas</p>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'

const materias = ref([])
const loading = ref(true)
const error = ref(null)

const fetchMaterias = async () => {
  try {
    loading.value = true
    const response = await fetch('http://localhost:8000/index.php?r=apiv1/materia')
    
    if (!response.ok) {
      throw new Error('Error al cargar las materias')
    }
    
    const data = await response.json()
    materias.value = data
  } catch (err) {
    error.value = err.message
    console.error('Error fetching materias:', err)
  } finally {
    loading.value = false
  }
}

onMounted(() => {
  fetchMaterias()
})
</script>

<style scoped>
.materias-view {
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

.materias-list {
  display: flex;
  flex-direction: column;
  gap: 1rem;
}

.materia-card {
  background: white;
  border-radius: 12px;
  box-shadow: var(--shadow-md);
  padding: 1.5rem;
  display: flex;
  align-items: center;
  gap: 1.5rem;
  transition: transform 0.2s, box-shadow 0.2s;
}

.materia-card:hover {
  transform: translateX(4px);
  box-shadow: var(--shadow-lg);
}

.materia-icon {
  font-size: 2.5rem;
  flex-shrink: 0;
}

.materia-content {
  flex: 1;
}

.materia-content h3 {
  margin: 0 0 0.5rem 0;
  font-size: 1.3rem;
  color: var(--color-text-primary);
}

.materia-info {
  display: flex;
  gap: 1.5rem;
  color: var(--color-text-secondary);
  font-size: 0.95rem;
  margin: 0;
}

.empty-state {
  text-align: center;
  padding: 3rem;
  color: var(--color-text-secondary);
  font-size: 1.1rem;
}
</style>
