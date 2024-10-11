<template>
    <div v-if="isLoading" class="bg-black bg-opacity-70 flex justify-center items-center fixed inset-0 text-white">
        <div class="spinner"></div>
        <p class="ml-4">{{ message }}</p>
    </div>
</template>

<script>
export default {
    name: 'Loading',
    props: {
        message: 'Processing Request. Please wait...',
        isLoading: false
    }
};
</script>

<style scoped>
.spinner {
    border: 8px solid rgba(255, 255, 255, 0.3);
    animation: spin 1s linear infinite;
    border-top: 8px solid white;
    border-radius: 50%;
    height: 35px;
    width: 35px;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}
</style>