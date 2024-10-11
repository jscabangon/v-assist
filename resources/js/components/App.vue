<template>
    <Layout v-if="!isLoginPage">
        <router-view />
    </Layout>

    <router-view v-else />
</template>

<script>
import Layout from './layout/Layout.vue';
import { useRoute } from 'vue-router';
import { computed } from 'vue';

export default {
    name: 'App',
    components: {
        Layout
    },
    setup() {
        const route = useRoute();

        const isLoginPage = computed(() => route.name === 'Login');

        return {
            isLoginPage
        };
    }
};
</script>

<style scoped>

</style>