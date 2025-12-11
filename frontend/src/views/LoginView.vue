<template>
  <div class="login-container">
    <div class="login-card">
      <div class="login-header">
        <h1>🔐 {{ isRegister ? 'Registro' : 'Iniciar Sesión' }}</h1>
        <p>{{ isRegister ? 'Crea tu cuenta' : 'Accede a tu cuenta' }}</p>
      </div>

      <form @submit.prevent="handleSubmit" class="login-form">
        <div v-if="error" class="error-alert">
          {{ error }}
        </div>

        <div class="form-group">
          <label for="username">Usuario</label>
          <input
            id="username"
            v-model="formData.username"
            type="text"
            placeholder="Tu usuario"
            required
          />
        </div>

        <div v-if="isRegister" class="form-group">
          <label for="name">Nombre completo</label>
          <input
            id="name"
            v-model="formData.name"
            type="text"
            placeholder="Tu nombre completo"
            required
          />
        </div>

        <div class="form-group">
          <label for="password">Contraseña</label>
          <input
            id="password"
            v-model="formData.password"
            type="password"
            placeholder="Tu contraseña"
            required
          />
        </div>

        <button type="submit" class="btn-submit" :disabled="loading">
          {{ loading ? 'Procesando...' : (isRegister ? 'Registrarse' : 'Iniciar Sesión') }}
        </button>
      </form>

      <div class="login-footer">
        <p>
          {{ isRegister ? '¿Ya tienes cuenta?' : '¿No tienes cuenta?' }}
          <a href="#" @click.prevent="toggleMode">
            {{ isRegister ? 'Inicia sesión' : 'Regístrate' }}
          </a>
        </p>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import { useRouter } from 'vue-router';
import { authService } from '../services/api.js';

const router = useRouter();
const isRegister = ref(false);
const loading = ref(false);
const error = ref('');

const formData = ref({
  username: '',
  password: '',
  name: '',
});

const toggleMode = () => {
  isRegister.value = !isRegister.value;
  error.value = '';
  formData.value = {
    username: '',
    password: '',
    name: '',
  };
};

const handleSubmit = async () => {
  try {
    loading.value = true;
    error.value = '';

    if (isRegister.value) {
      // TODO: Implementar registro cuando esté listo el endpoint
      error.value = 'Funcionalidad de registro próximamente disponible';
      loading.value = false;
      return;
    }

    // Login real usando la API
    const result = await authService.login(formData.value.username, formData.value.password);
    
    if (result.success) {
      // Redirigir al dashboard
      router.push('/');
    } else {
      // Mostrar error
      error.value = result.message || 'Error al iniciar sesión';
      if (result.errors && result.errors.password) {
        error.value = result.errors.password[0];
      }
    }

  } catch (err) {
    console.error('Error:', err);
    error.value = 'Error al conectar con el servidor';
  } finally {
    loading.value = false;
  }
};
</script>

<style scoped>
.login-container {
  min-height: 100vh;
  display: flex;
  align-items: center;
  justify-content: center;
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  padding: 20px;
}

.login-card {
  background: white;
  border-radius: 20px;
  box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
  padding: 40px;
  width: 100%;
  max-width: 450px;
}

.login-header {
  text-align: center;
  margin-bottom: 30px;
}

.login-header h1 {
  font-size: 2rem;
  color: #333;
  margin-bottom: 10px;
}

.login-header p {
  color: #666;
  font-size: 1rem;
}

.login-form {
  display: flex;
  flex-direction: column;
  gap: 20px;
}

.form-group {
  display: flex;
  flex-direction: column;
  gap: 8px;
}

.form-group label {
  font-weight: 600;
  color: #333;
  font-size: 0.9rem;
}

.form-group input {
  padding: 12px 16px;
  border: 2px solid #e0e0e0;
  border-radius: 10px;
  font-size: 1rem;
  transition: all 0.3s ease;
}

.form-group input:focus {
  outline: none;
  border-color: #667eea;
  box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
}

.error-alert {
  padding: 12px;
  background-color: #fee;
  border: 1px solid #fcc;
  border-radius: 8px;
  color: #c33;
  font-size: 0.9rem;
}

.btn-submit {
  padding: 14px;
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  color: white;
  border: none;
  border-radius: 10px;
  font-size: 1rem;
  font-weight: 600;
  cursor: pointer;
  transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.btn-submit:hover:not(:disabled) {
  transform: translateY(-2px);
  box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3);
}

.btn-submit:disabled {
  opacity: 0.6;
  cursor: not-allowed;
}

.login-footer {
  text-align: center;
  margin-top: 20px;
  padding-top: 20px;
  border-top: 1px solid #e0e0e0;
}

.login-footer p {
  color: #666;
  font-size: 0.9rem;
}

.login-footer a {
  color: #667eea;
  text-decoration: none;
  font-weight: 600;
}

.login-footer a:hover {
  text-decoration: underline;
}
</style>
