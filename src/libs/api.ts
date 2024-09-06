import axios from 'axios';

export const api = axios.create({
	baseURL: 'http://82.180.136.148:3341/',
	headers: {
		'Content-Type': 'application/json',
	},
	httpsAgent: {
		rejectUnauthorized: false,
	},
});

api.interceptors.request.use((req) => {
	const token = localStorage.getItem('auth');
	if (token) {
		req.headers['Authorization'] = `Bearer ${token.toString()}`;
	}
	return req;
});
