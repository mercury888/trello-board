require('./bootstrap');

import { createApp } from 'vue'

import './../scss/index.scss';

import Home from './components/Home'

import { vfmPlugin } from 'vue-final-modal'

const app = createApp({})

app.use(vfmPlugin)

app.component('home', Home)

app.mount('#app')
