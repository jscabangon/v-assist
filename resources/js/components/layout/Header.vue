<template>
    <header class="bg-teal-500 text-white">
        <div class="max-w-7xl mx-auto px-4 py-5 flex justify-between items-center">
            <div class="flex items-center">
                <h1 class="text-2xl font-bold">V-Assist</h1>
            </div>

            <nav class="hidden md:flex space-x-4 items-center">
                <router-link to="/" class="hover:text-gray-300">Home</router-link>
                <router-link to="/users" class="hover:text-gray-300" v-if="userType == 'admin'">Users</router-link>
                <router-link to="/todo" class="hover:text-gray-300" v-if="userType == 'user'">Todo</router-link>
                <button type="button" class="px-2 py-1 bg-teal-800 text-white rounded text-sm" @click="logoutConfirm">Logout</button>
            </nav>

            <div class="md:hidden">
                <button @click="toggleMenu" class="focus:outline-none">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
                    </svg>
                </button>
            </div>
        </div>

        <div v-if="isOpen" class="md:hidden">
            <nav class="flex flex-col px-4 py-2 bg-teal-500">
                <router-link to="/" class="block hover:text-gray-300 mb-3">Home</router-link>
                <router-link to="/users" class="block hover:text-gray-300 mb-3" v-if="userType == 'admin'">Users</router-link>
                <router-link to="/todo" class="block hover:text-gray-300 mb-4" v-if="userType == 'user'">Todo</router-link>
                <button type="button" class="w-1/2 py-1 block bg-teal-800 text-white rounded" @click="logoutConfirm">Logout</button>
            </nav>
        </div>

        <Confirm
            :visible="displayConfirm"
            title="Logout"
            message="Are you sure you want to logout your account?"
            @confirm="proceedLogout"
            @cancel="cancelLogout"
        />

        <Loading :isLoading="isLoading" :message="loadingMessage"/>
  </header>
</template>

<script>
import Confirm from '../shared/Confirm.vue';
import Loading from '../shared/Loading.vue';
import { mapGetters } from 'vuex';
import axios from 'axios';

export default {
    name: 'Header',
    components: {
        Confirm,
        Loading
    },
    data() {
        return {
            isOpen: false,
            displayConfirm: false,
            isLoading: false,
            loadingMessage: 'Logging out. Please wait..',
            userType: null
        };
    },

    computed: {
        ...mapGetters(['getUserType'])
    },

    mounted() {
        this.userType = this.getUserType;
    },

    methods: {
        toggleMenu() {
            this.isOpen = !this.isOpen;
        },

        logoutConfirm() {
            this.displayConfirm = true;
        },

        async proceedLogout() {
            this.isLoading = true;
            this.displayConfirm = false;

            try {
                const response = await axios.post('/v1/auth/logout', this.form);

                this.$store.commit('clearAuth');

                this.isLoading = false;

                this.$router.replace({name: 'Login'});
            } catch (error) {
                console.log('login error', error);

                this.isLoading = false;
            }
        },

        cancelLogout() {
            this.displayConfirm = false;
        }
    },
}
</script>