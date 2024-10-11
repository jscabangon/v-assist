<template>
    <div class="max-w-7xl mx-auto px-4 py-5 flex flex-wrap justify-between items-start">
        <div class="w-full">
            <h1><b>Todo</b></h1>
        </div>

        <div class="w-full md:w-1/2 md:px-2 mt-4">
            <div class="overflow-x-auto p-2 md:p-6 rounded shadow">
                <table class="min-w-full bg-white border border-gray-200">
                    <thead>
                        <tr>
                            <th class="px-4 py-2 border-b-2 bg-gray-100 text-left text-xs font-semibold text-gray-600">ID</th>
                            <th class="px-4 py-2 border-b-2 bg-gray-100 text-left text-xs font-semibold text-gray-600">Todo</th>
                            <th class="px-4 py-2 border-b-2 bg-gray-100 text-left text-xs font-semibold text-gray-600">Description</th>
                            <th class="px-4 py-2 border-b-2 bg-gray-100 text-left text-xs font-semibold text-gray-600">Status</th>
                            <th class="px-4 py-2 border-b-2 bg-gray-100 text-left text-xs font-semibold text-gray-600">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr class="hover:bg-gray-50 hover:cursor-pointer"
                            v-for="todo of todos.data" :key="todo.id"
                            :class="{'bg-teal-100': active == todo.id}"
                        >
                            <td class="px-4 text-xs py-2 border-b border-gray-200 text-gray-700">{{ todo.id }}</td>
                            <td class="px-4 text-xs py-2 border-b border-gray-200 text-gray-700">{{ todo.todo }}</td>
                            <td class="px-4 text-xs py-2 border-b border-gray-200 text-gray-700">{{ todo.description }}</td>
                            <td class="px-4 text-xs py-2 border-b border-gray-200 text-gray-700">{{ (todo.status) ? 'Active ': 'Inactive' }}</td>
                            <td class="px-4 text-xs py-2 border-b border-gray-200">
                                <span class="material-symbols-outlined text-base text-blue-700 mr-2" @click="toEdit(todo.id)">edit</span>
                                <span class="material-symbols-outlined text-base text-red-700" @click="deleteTodo(todo.id)">delete</span>
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
                        <label class="mb-2 text-xs" for="__todo">Todo</label>
                        <input type="text" id="__todo" class="w-full rounded shadow p-2 text-xs" v-model="form.todo" required>
                    </div>
                </div>

                <div class="w-full md:w-1/2 px-2 mb-2">
                    <div class="flex flex-wrap w-full">
                        <label class="mb-2 text-xs" for="__description">Description</label>
                        <input type="text" id="__description" class="w-full rounded shadow p-2 text-xs" v-model="form.description">
                    </div>
                </div>

                <div class="w-full md:w-1/2 px-2 mb-2">
                    <div class="flex flex-wrap w-full">
                        <label class="mb-2 text-xs" for="__usertype">User Type</label>
                        <select v-model="form.status" id="__usertype" class="w-full rounded shadow p-2 text-xs" required>
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>
                </div>

                <div class="w-full mt-4 md:text-end">
                    <button type="submit" class="bg-blue-600 text-white text-sm w-full md:w-auto rounded py-2 md:px-4" v-if="active == 0">Add Todo</button>

                    <button type="button" v-if="active != 0" @click="cancelEdit"
                        class="bg-gray-100 text-gray-700 text-sm w-full md:w-auto rounded py-2 md:px-4 md:mr-2"
                    >Cancel</button>

                    <button type="submit" class="bg-blue-600 text-white text-sm w-full md:w-auto rounded py-2 md:px-4" v-if="active != 0">Update Todo</button>
                </div>
            </form>
        </div>
    </div>

    <Loading :isLoading="isLoading" :message="loadingMessage"/>
    <Toast :visible="displayToast" :message="toastMessage" :toastType="toastType" />

    <Confirm
        :visible="displayAddConfirm"
        title="Add User"
        message="Do you want to proceed adding this item?"
        @confirm="proceedAdd"
        @cancel="cancelAdd"
    />

    <Confirm
        :visible="displayUpdateConfirm"
        title="Add User"
        message="Are you sure you want to update this item's record?"
        @confirm="proceedUpdate"
        @cancel="cancelUpdate"
    />

    <Confirm
        :visible="displayCancelConfirm"
        title="Add User"
        message="Do you want to proceed deleting this item?"
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
            todos: [],
            active: 0,
            form: {
                todo: '',
                description: '',
                status: 1,
            },

            isLoading: false,
            loadingMessage: '',

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

        this.loadTodos();
    },

    methods: {
        async loadTodos() {
            try {
                const response = await axios.get('/v1/todo/list');

                this.todos = response.data.data;

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

        toEdit(todoId) {
            const todo = this.todos.data.find(tdo => tdo.id == todoId);

            if (todo) {
                this.active = todoId;

                this.form = {
                    todo: todo.todo,
                    description: todo.description,
                    status: todo.status
                }
            } else {
                this.active = 0;
            }
        },

        cancelEdit() {
            this.active = 0;

            this.form = {
                todo: '',
                description: '',
                status: 1
            }
        },

        async proceedAdd() {
            this.displayAddConfirm = false

            this.showLoading('Processing request. Please wait...');

            try {
                const response = await axios.put('/v1/todo/store', this.form);

                this.hideLoading();

                this.showToast(response.data.message, 'success');

                this.loadTodos();

                this.cancelEdit();
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

            try {
                const response = await axios.patch('/v1/todo/update/' + this.active, this.form);

                this.hideLoading();

                this.showToast(response.data.message, 'success');

                this.loadTodos()

                this.cancelEdit()
            } catch (error) {
                this.hideLoading();

                this.showToast(error.response.data.message, 'error');
            }
        },

        cancelUpdate() {
            this.displayUpdateConfirm = false
        },

        deleteTodo() {
            this.displayCancelConfirm = true;
        },

        async proceedDelete() {
            this.displayCancelConfirm = false;

            this.showLoading('Processing request. Please wait...');

            try {
                const response = await axios.delete('/v1/todo/delete/' + this.active);

                this.hideLoading();

                this.showToast(response.data.message, 'success');

                this.loadTodos();

                this.cancelEdit();
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