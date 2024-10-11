<template>
    <teleport to="body">
        <div v-if="visible" class="fixed inset-0 flex items-center justify-center bg-gray-500 bg-opacity-50 z-50">
            <div class="bg-white p-6 rounded-lg shadow-lg w-10/12 md:w-3/12 ">
                <h2 class="text-lg font-semibold">{{ title }}</h2>

                <p class="mt-2">{{ message }}</p>

                <div class="mt-6 flex justify-end">
                    <button @click="confirm" class="bg-teal-500 text-white px-4 py-2 rounded mr-2">Confirm</button>
                    <button @click="cancel" class="bg-gray-300 px-4 py-2 rounded">Cancel</button>
                </div>
            </div>
        </div>
    </teleport>
</template>

<script>
export default {
    name: 'Confirm',
    props: {
        title: 'Confirm Action',
        message:'Are you sure you want to proceed?',
        visible: false
    },
    emits: ['confirm', 'cancel'],
    methods: {
        confirm() {
            this.$emit('confirm');
        },

        cancel() {
            this.$emit('cancel');
        }
    }
}
</script>