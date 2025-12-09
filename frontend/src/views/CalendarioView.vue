<template>
  <div class="calendario-view">
    <div class="header">
      <h1>📅 Calendario de Reservas</h1>
      <p class="subtitle">Visualización de reservas de aulas</p>
    </div>

    <div v-if="loading" class="loading">
      <div class="spinner"></div>
      <p>Cargando reservas...</p>
    </div>

    <div v-else-if="error" class="error-message">
      <p>{{ error }}</p>
      <button @click="fetchReservas" class="btn-retry">Reintentar</button>
    </div>

    <div v-else>
      <div class="calendar-controls">
        <button @click="previousWeek" class="btn-nav">← Semana Anterior</button>
        <h2>{{ currentWeekLabel }}</h2>
        <button @click="nextWeek" class="btn-nav">Semana Siguiente →</button>
      </div>

      <div class="calendar-grid">
        <div class="time-column">
          <div class="time-header">Hora</div>
          <div v-for="hour in hours" :key="hour" class="time-cell">
            {{ hour }}:00
          </div>
        </div>

        <div v-for="day in weekDays" :key="day.date" class="day-column">
          <div class="day-header">
            <div class="day-name">{{ day.name }}</div>
            <div class="day-date">{{ day.dateLabel }}</div>
          </div>
          <div class="day-cells">
            <div v-for="hour in hours" :key="`${day.date}-${hour}`" class="hour-cell">
              <div
                v-for="reserva in getReservasForDayHour(day.date, hour)"
                :key="reserva.id"
                class="reserva-card"
                :style="{ background: getReservaColor(reserva) }"
              >
                <div class="reserva-time">{{ formatTime(reserva.fh_desde) }} - {{ formatTime(reserva.fh_hasta) }}</div>
                <div class="reserva-aula">🏫 {{ reserva.aula?.descripcion || 'Aula' }}</div>
                <div class="reserva-profesor" v-if="reserva.profesor">
                  👨‍🏫 {{ reserva.profesor.nombre }} {{ reserva.profesor.apellido }}
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import api from '../services/api'

const reservas = ref([])
const loading = ref(true)
const error = ref(null)
const currentWeekStart = ref(new Date())

const hours = [7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21]

const dayNames = ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado']

const weekDays = computed(() => {
  const days = []
  const start = new Date(currentWeekStart.value)
  start.setDate(start.getDate() - start.getDay()) // Start from Sunday
  
  for (let i = 0; i < 7; i++) {
    const date = new Date(start)
    date.setDate(start.getDate() + i)
    days.push({
      date: date.toISOString().split('T')[0],
      name: dayNames[i],
      dateLabel: `${date.getDate()}/${date.getMonth() + 1}`
    })
  }
  return days
})

const currentWeekLabel = computed(() => {
  const start = weekDays.value[0]
  const end = weekDays.value[6]
  return `${start.dateLabel} - ${end.dateLabel}`
})

const getReservasForDayHour = (date, hour) => {
  return reservas.value.filter(reserva => {
    const fecha = (reserva.fh_desde || '').split('T')[0]
    if (fecha !== date) return false
    const horaInicio = parseInt((reserva.fh_desde || '').split('T')[1]?.split(':')[0] || 0)
    return horaInicio === hour
  })
}

const getReservaColor = (reserva) => {
  const colors = [
    'linear-gradient(135deg, #667eea 0%, #764ba2 100%)',
    'linear-gradient(135deg, #f093fb 0%, #f5576c 100%)',
    'linear-gradient(135deg, #4facfe 0%, #00f2fe 100%)',
    'linear-gradient(135deg, #43e97b 0%, #38f9d7 100%)',
    'linear-gradient(135deg, #fa709a 0%, #fee140 100%)',
  ]
  return colors[reserva.id % colors.length]
}

const formatTime = (time) => {
  if (!time) return ''
  // fh_desde formato ISO: YYYY-MM-DDTHH:mm:ss
  const parts = time.split('T')[1]
  return parts ? parts.substring(0, 5) : ''
}

const previousWeek = () => {
  const newDate = new Date(currentWeekStart.value)
  newDate.setDate(newDate.getDate() - 7)
  currentWeekStart.value = newDate
}

const nextWeek = () => {
  const newDate = new Date(currentWeekStart.value)
  newDate.setDate(newDate.getDate() + 7)
  currentWeekStart.value = newDate
}

const fetchReservas = async () => {
  try {
    loading.value = true
    const response = await api.getReservas()
    reservas.value = response.data
  } catch (err) {
    error.value = 'Error al cargar las reservas'
    console.error(err)
  } finally {
    loading.value = false
  }
}

onMounted(() => {
  fetchReservas()
})
</script>

<style scoped>
.calendario-view {
  padding: 2rem;
  max-width: 1400px;
  margin: 0 auto;
}

.header {
  margin-bottom: 2rem;
}

.header h1 {
  font-size: 2.5rem;
  color: #2c3e50;
  margin-bottom: 0.5rem;
}

.subtitle {
  font-size: 1.1rem;
  color: #7f8c8d;
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

.calendar-controls {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 2rem;
  padding: 1rem;
  background: white;
  border-radius: 12px;
  box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

.btn-nav {
  padding: 0.75rem 1.5rem;
  background: #667eea;
  color: white;
  border: none;
  border-radius: 8px;
  cursor: pointer;
  font-weight: 600;
  transition: all 0.3s ease;
}

.btn-nav:hover {
  background: #5568d3;
  transform: translateY(-2px);
}

.calendar-grid {
  display: grid;
  grid-template-columns: 80px repeat(7, 1fr);
  gap: 1px;
  background: #e0e0e0;
  border-radius: 12px;
  overflow: hidden;
}

.time-column,
.day-column {
  background: white;
}

.time-header,
.day-header {
  padding: 1rem;
  background: #667eea;
  color: white;
  font-weight: 600;
  text-align: center;
}

.day-header {
  display: flex;
  flex-direction: column;
  gap: 0.25rem;
}

.day-name {
  font-size: 1rem;
}

.day-date {
  font-size: 0.85rem;
  opacity: 0.9;
}

.time-cell {
  padding: 1rem 0.5rem;
  text-align: center;
  font-size: 0.9rem;
  color: #666;
  border-top: 1px solid #f0f0f0;
  height: 80px;
  display: flex;
  align-items: center;
  justify-content: center;
}

.day-cells {
  display: flex;
  flex-direction: column;
}

.hour-cell {
  min-height: 80px;
  padding: 0.5rem;
  border-top: 1px solid #f0f0f0;
  position: relative;
}

.reserva-card {
  padding: 0.75rem;
  border-radius: 8px;
  color: white;
  margin-bottom: 0.5rem;
  box-shadow: 0 2px 4px rgba(0,0,0,0.2);
  font-size: 0.85rem;
  line-height: 1.4;
}

.reserva-time {
  font-weight: 700;
  margin-bottom: 0.25rem;
}

.reserva-aula,
.reserva-profesor {
  font-size: 0.8rem;
  opacity: 0.95;
}

@media (max-width: 1024px) {
  .calendar-grid {
    grid-template-columns: 60px repeat(7, 1fr);
    font-size: 0.85rem;
  }
  
  .reserva-card {
    font-size: 0.75rem;
    padding: 0.5rem;
  }
}
</style>
