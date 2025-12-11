<template>
  <div class="reservas-view">
    <div class="header">
      <h1>📅 Reservas de Aulas</h1>
      <p class="subtitle">Listado de reservaciones y ocupación de espacios</p>
    </div>
    
    <div v-if="loading" class="loading">
      <div class="spinner"></div>
      <p>Cargando reservas...</p>
    </div>
    
    <div v-else-if="error" class="error-message">
      <p>{{ error }}</p>
    </div>
    
    <div v-else class="reservas-grid">
      <div v-for="reserva in reservas" :key="reserva.id" class="reserva-card">
        <div class="reserva-header">
          <h3>{{ reserva.aula?.descripcion || `Aula ${reserva.id_aula}` }}</h3>
          <span class="reserva-id">#{{ reserva.id }}</span>
        </div>
        <div class="reserva-body">
          <div class="reserva-info">
            <div class="info-item">
              <span class="label">📍 Ubicación:</span>
              <span class="value">{{ reserva.aula?.ubicacion || 'No especificada' }}</span>
            </div>
            <div class="info-item">
              <span class="label">🕐 Desde:</span>
              <span class="value">{{ formatDateTime(reserva.fh_desde) }}</span>
            </div>
            <div class="info-item">
              <span class="label">🕑 Hasta:</span>
              <span class="value">{{ formatDateTime(reserva.fh_hasta) }}</span>
            </div>
            <div class="info-item" v-if="reserva.materias && reserva.materias.length > 0">
              <span class="label">📚 Materias:</span>
              <span class="value">
                <div class="materias-list">
                  <span v-for="materia in reserva.materias" :key="materia.id" class="materia-tag">
                    {{ materia.nombre }}
                  </span>
                </div>
              </span>
            </div>
            <div class="info-item" v-if="reserva.observacion">
              <span class="label">📝 Observación:</span>
              <span class="value">{{ reserva.observacion }}</span>
            </div>
          </div>
        </div>
      </div>
    </div>
    
    <div v-if="!loading && reservas.length === 0" class="empty-state">
      <p>No hay reservas registradas</p>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { reservaAulaService } from '../services/api'

const reservas = ref([])
const loading = ref(true)
const error = ref(null)

const formatDateTime = (dateTimeString) => {
  if (!dateTimeString) return 'No especificado'
  
  const date = new Date(dateTimeString)
  const options = {
    year: 'numeric',
    month: 'short',
    day: 'numeric',
    hour: '2-digit',
    minute: '2-digit',
    hour12: true
  }
  
  return date.toLocaleString('es-ES', options)
}

const fetchReservas = async () => {
  try {
    loading.value = true
    error.value = null
    const data = await reservaAulaService.getAll()
    reservas.value = data
  } catch (err) {
    error.value = 'Error al cargar las reservas'
    console.error('Error fetching reservas:', err)
  } finally {
    loading.value = false
  }
}

onMounted(() => {
  fetchReservas()
})
</script>

<style scoped>
.reservas-view {
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
  color: var(--color-text-secondary, #6c757d);
  margin: 0;
}

.loading {
  display: flex;
  flex-direction: column;
  align-items: center;
  padding: 3rem;
  color: var(--color-text-secondary, #6c757d);
}

.spinner {
  width: 40px;
  height: 40px;
  border: 4px solid #f3f3f3;
  border-top: 4px solid var(--color-primary, #007bff);
  border-radius: 50%;
  animation: spin 1s linear infinite;
  margin-bottom: 1rem;
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}

.error-message {
  background: #fff5f5;
  border: 1px solid #fed7d7;
  color: #c53030;
  padding: 1rem;
  border-radius: 0.5rem;
  margin: 2rem 0;
}

.reservas-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
  gap: 2rem;
  margin-top: 2rem;
}

.reserva-card {
  background: white;
  border-radius: 12px;
  padding: 1.5rem;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
  transition: transform 0.2s, box-shadow 0.2s;
  border-left: 4px solid var(--color-primary, #007bff);
}

.reserva-card:hover {
  transform: translateY(-2px);
  box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
}

.reserva-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 1rem;
  padding-bottom: 0.5rem;
  border-bottom: 1px solid #eee;
}

.reserva-header h3 {
  margin: 0;
  color: var(--color-text-primary, #2c3e50);
  font-size: 1.25rem;
}

.reserva-id {
  background: var(--color-primary, #007bff);
  color: white;
  padding: 0.25rem 0.5rem;
  border-radius: 4px;
  font-size: 0.875rem;
  font-weight: bold;
}

.reserva-info {
  display: flex;
  flex-direction: column;
  gap: 0.75rem;
}

.info-item {
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.label {
  font-weight: 600;
  color: var(--color-text-secondary, #6c757d);
  font-size: 0.9rem;
}

.value {
  color: var(--color-text-primary, #2c3e50);
  font-weight: 500;
  text-align: right;
}

.materias-list {
  display: flex;
  flex-direction: column;
  gap: 0.25rem;
}

.materia-tag {
  background: #e3f2fd;
  color: #1976d2;
  padding: 0.2rem 0.5rem;
  border-radius: 12px;
  font-size: 0.8rem;
  font-weight: 500;
  display: inline-block;
}

.empty-state {
  text-align: center;
  color: var(--color-text-secondary, #6c757d);
  padding: 4rem 2rem;
  font-size: 1.1rem;
}
</style>