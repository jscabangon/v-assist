<template>
    <div class="max-w-7xl mx-auto px-4 py-5 flex justify-center items-center">
        <h1>Welcome {{this.user}}!</h1>
    </div>
</template>

<script>
import { mapGetters } from 'vuex';

export default {
    name: 'Main',

    data() {
        return {
            user: {}
        }
    },

    computed: {
        ...mapGetters(['getUser'])
    },

    mounted() {
        this.user = this.getUser;
    }
}
</script>