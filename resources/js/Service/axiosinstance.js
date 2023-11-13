import axios from "axios";

const API_BASE_URL = "http://127.0.0.1:8000/api";

export const axiosPublic = axios.create({
    baseURL: API_BASE_URL,
    timeout: 60000,
});


export const axiosPrivate = axios.create({
    baseURL: API_BASE_URL,
    timeout: 60000,
});

export const setPrivateHeaders = () => {
    axios.defaults.headers.common['Authorization'] = localStorage.getItem('accessToken');
}