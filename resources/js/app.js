import Alpine from 'alpinejs';
import { api, auth, getMe, toast } from './api';

window.Alpine = Alpine;
window.api = api;
window.auth = auth;
window.getMe = getMe;
window.toast = toast;

Alpine.start();