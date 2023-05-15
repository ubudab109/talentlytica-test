import axios from 'axios';

var method = axios.create({
  headers: {
    "Authorization" : `Bearer ${localStorage.getItem('token')}`
  }
});

export default method;