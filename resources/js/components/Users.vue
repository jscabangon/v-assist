<template>
    <div class="max-w-7xl mx-auto px-4 py-5 flex flex-wrap justify-between items-start">
        <div class="w-full">
            <h1><b>Users</b></h1>
        </div>

        <div class="w-full md:w-1/2 md:px-2 mt-4">
            <div class="overflow-x-auto p-2 md:p-6 rounded shadow">
                <table class="min-w-full bg-white border border-gray-200">
                    <thead>
                        <tr>
                            <th class="px-4 py-2 border-b-2 bg-gray-100 text-left text-xs font-semibold text-gray-600">ID</th>
                            <th class="px-4 py-2 border-b-2 bg-gray-100 text-left text-xs font-semibold text-gray-600">Username</th>
                            <th class="px-4 py-2 border-b-2 bg-gray-100 text-left text-xs font-semibold text-gray-600">Full Name</th>
                            <th class="px-4 py-2 border-b-2 bg-gray-100 text-left text-xs font-semibold text-gray-600">Email</th>
                            <th class="px-4 py-2 border-b-2 bg-gray-100 text-left text-xs font-semibold text-gray-600">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr class="hover:bg-gray-50 hover:cursor-pointer"
                            v-for="user of users.data" :key="user.id"
                            :class="{'bg-teal-100': active == user.id}"
                        >
                            <td class="px-4 text-xs py-2 border-b border-gray-200 text-gray-700">{{ user.id }}</td>
                            <td class="px-4 text-xs py-2 border-b border-gray-200 text-gray-700">{{ user.username }}</td>
                            <td class="px-4 text-xs py-2 border-b border-gray-200 text-gray-700">{{ user.details.firstname }} {{ user.details.lasstname }}</td>
                            <td class="px-4 text-xs py-2 border-b border-gray-200 text-gray-700">{{ user.details.email }}</td>
                            <td class="px-4 text-xs py-2 border-b border-gray-200">
                                <span class="material-symbols-outlined text-base text-blue-700" @click="toEdit(user.id)">edit</span>
                                <span class="material-symbols-outlined text-base text-red-700" @click="deleteUser(user.id)">delete</span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="w-full md:w-1/2 md:px-2 mt-4">
            <form @submit.prevent="sendForm" class="w-full flex flex-wrap p-2 md:p-6 rounded shadow">
                <div class="w-full md:w-1/2 px-2 mb-2">
                    <div class="flex flex-wrap w-full">
                        <label class="mb-2 text-xs" for="__firstname">Firstname</label>
                        <input type="text" id="__firstname" class="w-full rounded shadow p-2 text-xs" v-model="form.firstname" required>
                    </div>
                </div>

                <div class="w-full md:w-1/2 px-2 mb-2">
                    <div class="flex flex-wrap w-full">
                        <label class="mb-2 text-xs" for="__lastname">Lastname</label>
                        <input type="text" id="__lastname" class="w-full rounded shadow p-2 text-xs" v-model="form.lastname" required>
                    </div>
                </div>

                <div class="w-full md:w-1/2 px-2 mb-2">
                    <div class="flex flex-wrap w-full">
                        <label class="mb-2 text-xs" for="__email">Email</label>
                        <input type="email" id="__email" class="w-full rounded shadow p-2 text-xs" v-model="form.email" required>
                    </div>
                </div>

                <div class="w-full md:w-1/2 px-2 mb-2">
                    <div class="flex flex-wrap w-full">
                        <label class="mb-2 text-xs" for="__usertype">User Type</label>
                        <select v-model="form.usertype" id="__usertype" class="w-full rounded shadow p-2 text-xs" required>
                            <option value="admin">Admin</option>
                            <option value="user">User</option>
                        </select>
                    </div>
                </div>

                <div class="w-full md:w-1/2 px-2 mb-2">
                    <div class="flex flex-wrap w-full">
                        <label class="mb-2 text-xs" for="__username">Username</label>
                        <input type="text" id="__username" class="w-full rounded shadow p-2 text-xs" v-model="form.username" :disabled="active != 0" :required="active == 0">
                    </div>
                </div>

                <div class="w-full md:w-1/2 px-2 mb-2" v-if="active == 0">
                    <div class="flex flex-wrap w-full">
                        <label class="mb-2 text-xs" for="__password">Password</label>
                        <input type="text" id="__password" class="w-full rounded shadow p-2 text-xs" autocomplete="off" v-model="form.password" :required="active == 0">
                    </div>
                </div>

                <div class="w-full mt-4 md:text-end">
                    <button type="submit" class="bg-blue-600 text-white text-sm w-full md:w-auto rounded py-2 md:px-4" v-if="active == 0">Add User</button>

                    <button type="button" v-if="active != 0" @click="cancelEdit"
                        class="bg-gray-100 text-gray-700 text-sm w-full md:w-auto rounded py-2 md:px-4 md:mr-2"
                    >Cancel</button>

                    <button type="submit" class="bg-blue-600 text-white text-sm w-full md:w-auto rounded py-2 md:px-4" v-if="active != 0">Update User</button>
                </div>
            </form>
        </div>
    </div>

    <Loading :isLoading="isLoading" :message="loadingMessage"/>
    <Toast :visible="displayToast" :message="toastMessage" :toastType="toastType" />

    <Confirm
        :visible="displayAddConfirm"
        title="Add User"
        message="Do you want to proceed adding this user?"
        @confirm="proceedAdd"
        @cancel="cancelAdd"
    />

    <Confirm
        :visible="displayUpdateConfirm"
        title="Add User"
        message="Are you sure you want to update this user's record?"
        @confirm="proceedUpdate"
        @cancel="cancelUpdate"
    />

    <Confirm
        :visible="displayCancelConfirm"
        title="Add User"
        message="Do you want to proceed deleting this user?"
        @confirm="proceedDelete"
        @cancel="cancelDelete"
    />
</template>

<script>
import Confirm from './shared/Confirm.vue';
import Loading from './shared/Loading.vue';
import Toast from './shared/Loading.vue';
import axios from 'axios';

export default {
    name: 'Users',
    
    components: {
        Confirm,
        Loading,
        Toast
    },

    data() {
        return {
            users: [],
            active: 0,
            form: {
                firstname: '',
                lastname: '',
                email: '',
                usertype: 'user',
                username: '',
                password: ''
            },

            isLoading: false,
            loadingMessage: 'Logging in. Please wait..',

            displayAddConfirm: false,
            displayUpdateConfirm: false,
            displayCancelConfirm: false,

            displayToast: false,
            toastMessage: '',
            toastType: 'info'
        }
    },

    mounted() {
        this.showLoading('Loading Users. Please wait...')

        this.loadUsers();
    },

    methods: {
        async loadUsers() {
            try {
                const response = await axios.get('/v1/users/list');

                this.users = response.data.data;
                console.log('users list', this.users);

                this.hideLoading();

                this.showToast(response.data.message, 'success');

            } catch (error) {
                this.hideLoading();

                this.showToast(error.response.data.message, 'error');
            }
        },

        async sendForm() {
            if (this.active == 0) {
                this.displayAddConfirm = true;
            } else {
                this.displayUpdateConfirm = true;
            }
        },

        toEdit(userId) {
            const user = this.users.data.find(usr => usr.id == userId);

            if (user) {
                this.active = userId;

                this.form = {
                    firstname: user.details.firstname,
                    lastname: user.details.lastname,
                    email: user.details.email,
                    usertype: user.usertype,
                    username: user.username,
                }
            } else {
                this.active = 0;
            }
        },

        cancelEdit() {
            this.active = 0;

            this.form = {
                firstname: '',
                lastname: '',
                email: '',
                usertype: 'user',
                username: '',
                password: ''
            }
        },

        async proceedAdd() {
            this.displayAddConfirm = false

            this.showLoading('Processing request. Please wait...');

            try {
                const response = await axios.put('/v1/users/store', this.form);

                this.hideLoading();

                this.showToast(response.data.message, 'success');

                this.loadUsers()

                this.cancelEdit()
            } catch (error) {
                this.hideLoading();

                this.showToast(error.response.data.message, 'error');
            }
        },

        cancelAdd() {
            this.displayAddConfirm = false
        },

        async proceedUpdate() {
            this.displayUpdateConfirm = false

            this.showLoading('Processing request. Please wait...');

            const payload = {
                firstname: this.form.firstname,
                lastname: this.form.lastname,
                email: this.form.email,
                usertype: this.form.usertype,
            }

            try {
                const response = await axios.patch('/v1/users/update/' + this.active, payload);

                this.hideLoading();

                this.showToast(response.data.message, 'success');

                this.loadUsers()

                this.cancelEdit()
            } catch (error) {
                this.hideLoading();

                this.showToast(error.response.data.message, 'error');
            }
        },

        cancelUpdate() {
            this.displayUpdateConfirm = false
        },


        deleteUser() {
            this.displayCancelConfirm = true;
        },

        async proceedDelete() {
            this.displayCancelConfirm = false;

            this.showLoading('Processing request. Please wait...');

            try {
                const response = await axios.delete('/v1/users/delete/' + this.active);

                this.hideLoading();

                this.showToast(response.data.message, 'success');

                this.loadUsers()

                this.cancelEdit()
            } catch (error) {
                this.hideLoading();

                this.showToast(error.response.data.message, 'error');
            }
        },

        cancelDelete() {
            this.displayCancelConfirm = false;
        },

        showLoading(message) {
            this.isLoading = true;
            this.loadingMessage = message;
        },

        hideLoading() {
            this.isLoading = false;
        },

        showToast(message, type) {
            this.displayToast = true
            this.toastMessage = message;
            this.toastType = type;

            setTimeout(() => {
                this.displayToast = false;
            }, 3000);
        }
    }
}
</script>

