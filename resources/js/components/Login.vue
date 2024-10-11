<template>
    <div class="fixed w-full h-screen mx-auto flex justify-center items-center bg-teal-300 inset-0">
        <form class="flex flex-wrap w-10/12 md:w-3/12 rounded shadow p-6 bg-white" @submit.prevent="login">
            <div class="flex flex-wrap w-full mb-4">
                <label class="mb-2" for="__username">Username</label>
                <input type="text" id="__username" class="w-full rounded shadow p-2" autofocus v-model="form.username" required>
            </div>

            <div class="flex flex-wrap w-full mb-4">
                <label class="mb-2" for="__upassword">Password</label>
                <input type="password" id="__password" class="w-full rounded shadow p-2" autofocus v-model="form.password" required>
            </div>

            <div class="flex flex-wrap w-full mt-4">
                <button type="submit" class="w-full py-2 text-center rounded bg-teal-600 text-white">Login</button>
            </div>
        </form>

        <Loading :isLoading="isLoading" :message="loadingMessage"/>
        <Toast :visible="displayToast" :message="toastMessage" :toastType="toastType" />
    </div>
</template>

<script>
import Loading from './shared/Loading.vue';
import Toast from './shared/Toast.vue';
import axios from 'axios';

export default {
    name: 'Login',
    components: {
        Loading,
        Toast
    },
    data () {
        return {
            form: {
                username: '',
                password: ''
            },
            isLoading: false,
            loadingMessage: 'Logging in. Please wait..',

            displayToast: false,
            toastMessage: '',
            toastType: 'info'
        }
    },
    methods: {
        async login() {
            this.isLoading = true;

            try {
                const response = await axios.post('/v1/auth/login', this.form);

                this.$store.commit('setToken', response.headers['x-access-token']);
                this.$store.commit('setUser', `${response.data.data.profile.details.firstname} ${response.data.data.profile.details.lastname}`);
                this.$store.commit('setUserType', response.data.data.profile.usertype);

                this.isLoading = false;

                this.showToast(response.data.message, 'success');

                this.$router.push({name: 'Main'});
            } catch (error) {
                this.isLoading = false;

                this.showToast(error.response.data.message, 'error');
            }
        },

        showToast(message, type) {
            this.displayToast = true
            this.toastMessage = message;
            this.toastType = type;

            // setTimeout(() => {
            //     this.displayToast = false;
            // }, 3000);
        }
    }
}
</script>