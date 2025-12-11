<template>
  <div class="home">
    <div class="hero-section">
      <h1 class="gradient-text">Sistema de Gestión Universitaria</h1>
      <p class="subtitle">Bienvenido al panel de visualización de reservas y recursos académicos</p>
    </div>
    
    <div class="dashboard-grid">
      <router-link to="/carreras" class="card card-carreras">
        <div class="card-icon">🎓</div>
        <h3>Carreras</h3>
        <p>Gestión de carreras y programas académicos</p>
        <div class="card-footer">Ver más →</div>
      </router-link>
      
      <router-link to="/materias" class="card card-materias">
        <div class="card-icon">📚</div>
        <h3>Materias</h3>
        <p>Administración de asignaturas y cursos</p>
        <div class="card-footer">Ver más →</div>
      </router-link>
      
      <router-link to="/profesores" class="card card-profesores">
        <div class="card-icon">👨‍🏫</div>
        <h3>Profesores</h3>
        <p>Registro y control de docentes</p>
        <div class="card-footer">Ver más →</div>
      </router-link>
      
      <router-link to="/aulas" class="card card-aulas">
        <div class="card-icon">🏫</div>
        <h3>Aulas</h3>
        <p>Gestión de espacios físicos</p>
        <div class="card-footer">Ver más →</div>
      </router-link>
      
      <router-link to="/reservas" class="card card-reservas">
        <div class="card-icon">📅</div>
        <h3>Reservas</h3>
        <p>Gestión de reservas de aulas</p>
        <div class="card-footer">Ver más →</div>
      </router-link>
    </div>
  </div>
</template>

<script setup>
// Logic can be added here later
</script>

<style scoped>
.home {
  padding: 2rem 0;
}

.hero-section {
  text-align: center;
  margin-bottom: 4rem;
  padding: 3rem 1rem;
  background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-secondary) 100%);
  border-radius: 24px;
  color: white;
  box-shadow: var(--shadow-xl);
}

.gradient-text {
  font-size: 3rem;
  font-weight: 800;
  margin-bottom: 1rem;
  text-shadow: 0 2px 10px rgba(0,0,0,0.2);
}

.subtitle {
  font-size: 1.25rem;
  opacity: 0.95;
  color: white;
  max-width: 600px;
  margin: 0 auto;
}

.dashboard-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
  gap: 2rem;
}

.card {
  background: var(--color-white);
  border-radius: 16px;
  padding: 2rem;
  box-shadow: var(--shadow-md);
  transition: all 0.3s ease;
  cursor: pointer;
  position: relative;
  overflow: hidden;
  border: 2px solid transparent;
  text-decoration: none;
  color: inherit;
  display: block;
}

.card::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 4px;
  background: linear-gradient(90deg, var(--color-primary), var(--color-secondary));
  transform: scaleX(0);
  transition: transform 0.3s ease;
}

.card:hover::before {
  transform: scaleX(1);
}

.card:hover {
  transform: translateY(-8px);
  box-shadow: var(--shadow-xl);
  border-color: var(--color-primary-light);
}

.card-icon {
  font-size: 3rem;
  margin-bottom: 1rem;
  display: inline-block;
  transition: transform 0.3s ease;
}

.card:hover .card-icon {
  transform: scale(1.1) rotate(5deg);
}

.card h3 {
  color: var(--color-gray-900);
  margin-bottom: 0.75rem;
  font-size: 1.5rem;
}

.card p {
  color: var(--color-text-secondary);
  line-height: 1.6;
  margin-bottom: 1.5rem;
}

.card-footer {
  color: var(--color-primary);
  font-weight: 600;
  font-size: 0.95rem;
  opacity: 0;
  transform: translateX(-10px);
  transition: all 0.3s ease;
}

.card:hover .card-footer {
  opacity: 1;
  transform: translateX(0);
}

/* Color accents for each card */
.card-carreras:hover {
  border-color: #6366f1;
}

.card-materias:hover {
  border-color: #ec4899;
}

.card-profesores:hover {
  border-color: #14b8a6;
}

.card-aulas:hover {
  border-color: #f59e0b;
}

.card-reservas:hover {
  border-color: #8b5cf6;
}

.card-horarios:hover {
  border-color: #06b6d4;
}

@media (max-width: 768px) {
  .gradient-text {
    font-size: 2rem;
  }
  
  .subtitle {
    font-size: 1rem;
  }
  
  .dashboard-grid {
    grid-template-columns: 1fr;
  }
}
</style>
