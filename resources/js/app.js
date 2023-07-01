import './bootstrap';

import Alpine from 'alpinejs';
require('dotenv').config();
require('laravel-mix');

window.Alpine = Alpine;

Alpine.start();
