<template>
    <div class="fixed bottom-5 md:bottom-auto md:top-5 md:right-5 px-5 text-xs py-2 rounded text-white text-lg cursor-pointer opacity-90 transition-opacity duration-300 ease-in-out" 
        v-if="visible"
        :class="[toastType]"
        @click="dismissToast"
    >
        <p>{{ message }}</p>
    </div>
</template>

<script>
export default {
    name: 'Toast',
    props: {
        visible: false,
        message: '',
        toastType: 'info',
    }
};
</script>

<style scoped>
.info {
  background-color: #22d3ee;
}
.success {
  background-color: #10b981;
}
.error {
  background-color: #ef4444;
}
.warning {
  background-color: #eab308;
}
</style>