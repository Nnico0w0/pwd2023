<script setup>
import { RouterLink, RouterView } from 'vue-router'
</script>

<template>
  <header>
    <div class="wrapper">
      <div class="logo">
        <span class="logo-icon">🎓</span>
        <span class="logo-text">SGU</span>
      </div>
      <nav>
        <RouterLink to="/" class="nav-link">🏠 Inicio</RouterLink>
      </nav>
    </div>
  </header>

  <main>
    <RouterView />
  </main>
</template>

<style scoped>
header {
  background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-primary-dark) 100%);
  padding: 1rem 2rem;
  box-shadow: var(--shadow-lg);
  position: sticky;
  top: 0;
  z-index: 100;
}

.wrapper {
  max-width: 1200px;
  margin: 0 auto;
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.logo {
  display: flex;
  align-items: center;
  gap: 0.75rem;
}

.logo-icon {
  font-size: 2rem;
}

.logo-text {
  font-size: 1.75rem;
  font-weight: 800;
  color: white;
  letter-spacing: -0.5px;
  text-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

nav {
  display: flex;
  gap: 1.5rem;
  flex: 1;
  justify-content: center;
}

.nav-link {
  color: white;
  font-weight: 600;
  font-size: 1rem;
  padding: 0.5rem 1rem;
  border-radius: 8px;
  transition: all 0.3s ease;
  background: rgba(255, 255, 255, 0.1);
  backdrop-filter: blur(10px);
}

.nav-link:hover {
  background: rgba(255, 255, 255, 0.2);
  transform: translateY(-2px);
}

.nav-link.router-link-exact-active {
  background: rgba(255, 255, 255, 0.25);
  box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

main {
  max-width: 1200px;
  margin: 0 auto;
  padding: 2rem;
}

@media (max-width: 768px) {
  header {
    padding: 1rem;
  }
  
  .wrapper {
    flex-direction: column;
    gap: 1rem;
  }
  
  .logo-text {
    font-size: 1.5rem;
  }
  
  nav {
    width: 100%;
    justify-content: center;
  }
}
</style>
