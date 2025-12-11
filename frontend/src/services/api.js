import axios from 'axios';

const apiClient = axios.create({
  baseURL: 'http://localhost:8000/apiv1', // Backend API URL
  headers: {
    'Content-Type': 'application/json',
    'Accept': 'application/json',
  },
});

export const authService = {
  login(username, password) {
    // Mock login
    localStorage.setItem('token', 'dummy-token');
    localStorage.setItem('user', JSON.stringify({ username }));
    return Promise.resolve({ success: true, user: { username } });
  },
  logout() {
    localStorage.removeItem('token');
    localStorage.removeItem('user');
  },
  getCurrentUser() {
    const userStr = localStorage.getItem('user');
    return userStr ? JSON.parse(userStr) : null;
  },
  isAuthenticated() {
    return !!localStorage.getItem('token');
  }
};

export const aulaService = {
  getAll() {
    return apiClient.get('/aula').then(response => response.data);
  }
};

export const carreraService = {
  getAll() {
    return apiClient.get('/carrera').then(response => response.data);
  }
};

export const materiaService = {
  getAll() {
    return apiClient.get('/materia').then(response => response.data);
  }
};

export const profesorService = {
  getAll() {
    return apiClient.get('/profesor').then(response => response.data);
  }
};

export const reservaAulaService = {
  getAll() {
    return apiClient.get('/reserva-aula').then(response => response.data);
  }
};

// Mock component service functions for ComponentsView
export const listComponents = () => {
  return Promise.resolve([
    { name: 'AulaController.php' },
    { name: 'CarreraController.php' },
    { name: 'MateriaController.php' },
    { name: 'ProfesorController.php' },
    { name: 'ReservaAulaController.php' },
  ]);
};

export const getComponent = (name) => {
  return Promise.resolve({
    name,
    content: `// Contenido de ${name}\n// Este es un archivo de ejemplo`
  });
};

export default {
  getAulas() {
    return apiClient.get('/aula');
  },
  getCarreras() {
    return apiClient.get('/carrera');
  },
  getMaterias() {
    return apiClient.get('/materia');
  },
  getProfesores() {
    return apiClient.get('/profesor');
  },
  getReservas() {
    return apiClient.get('/reserva-aula');
  },
};
