import { createStore } from 'vuex';

const store = createStore({
    state: {
        user: localStorage.getItem('x-user') || null,
        userType: localStorage.getItem('x-user-type') || null,
        token: localStorage.getItem('x-access-token') || null
    },
    mutations: {
        setUser(state, user) {
            state.user = user;
            localStorage.setItem('x-user', user)
        },

        setUserType(state, type) {
            state.userType = type;

            localStorage.setItem('x-user-type', type)
        },

        setToken(state, token) {
            state.token = token;
            localStorage.setItem('x-access-token', token)
        },

        clearAuth(state) {
            state.user = null;
            state.userType = null;
            state.token = null;

            localStorage.removeItem('x-user')
            localStorage.removeItem('x-user-type')
            localStorage.removeItem('x-access-token')
        },
    },
    getters: {
        isAuthenticated(state) {
            return !!state.token;
        },

        getUser(state) {
            return state.user;
        },

        getUserType(state) {
            return state.userType;
        },
    },
})

export default store;