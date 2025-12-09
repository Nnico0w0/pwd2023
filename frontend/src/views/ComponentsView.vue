<template>
  <div class="components-view">
    <h1>Componentes del Sistema</h1>
    
    <div v-if="loading" class="loading">Cargando componentes...</div>
    <div v-else-if="error" class="error">{{ error }}</div>
    
    <div v-else class="content-container">
      <div class="component-list">
        <h3>Lista de Archivos</h3>
        <ul>
          <li 
            v-for="comp in components" 
            :key="comp.name"
            :class="{ active: selectedComponent && selectedComponent.name === comp.name }"
            @click="selectComponent(comp.name)"
          >
            {{ comp.name }}
          </li>
        </ul>
      </div>
      
      <div class="component-viewer">
        <div v-if="selectedComponent">
          <h3>{{ selectedComponent.name }}</h3>
          <pre><code>{{ selectedComponent.content }}</code></pre>
        </div>
        <div v-else class="placeholder">
          Selecciona un componente para ver su código
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { listComponents, getComponent } from '../services/api';

const components = ref([]);
const selectedComponent = ref(null);
const loading = ref(true);
const error = ref('');

onMounted(async () => {
  try {
    components.value = await listComponents();
  } catch (e) {
    error.value = 'Error al cargar la lista de componentes: ' + e.message;
  } finally {
    loading.value = false;
  }
});

const selectComponent = async (name) => {
  try {
    loading.value = true;
    const data = await getComponent(name);
    selectedComponent.value = data;
  } catch (e) {
    error.value = 'Error al cargar el componente: ' + e.message;
  } finally {
    loading.value = false;
  }
};
</script>

<style scoped>
.components-view {
  padding: 20px;
}

.content-container {
  display: flex;
  gap: 20px;
  margin-top: 20px;
}

.component-list {
  width: 250px;
  border-right: 1px solid #ccc;
  padding-right: 20px;
}

.component-list ul {
  list-style: none;
  padding: 0;
}

.component-list li {
  padding: 10px;
  cursor: pointer;
  border-bottom: 1px solid #eee;
}

.component-list li:hover {
  background-color: #f5f5f5;
}

.component-list li.active {
  background-color: #e0e0e0;
  font-weight: bold;
}

.component-viewer {
  flex: 1;
  background-color: #f9f9f9;
  padding: 20px;
  border-radius: 5px;
  overflow-x: auto;
}

pre {
  background-color: #2d2d2d;
  color: #f8f8f2;
  padding: 15px;
  border-radius: 5px;
  overflow: auto;
}

.placeholder {
  color: #888;
  text-align: center;
  margin-top: 50px;
}

.error {
  color: red;
  margin: 10px 0;
}
</style>
