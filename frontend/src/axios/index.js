import axios from 'axios';

const instance = axios.create({
    
  baseURL: 'http://localhost:8000/api', // Replace with your base URL
});

export default instance;
