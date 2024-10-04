<template>
    <div>
        <div v-if="hasErrors" class="alert alert-danger alert-dismissible fade show" role="alert">
            <small>Please correct the following error(s):</small>
            <ul class="list-unstyled">
                <li v-for="error in errors" :key="error">{{ error }}</li>
            </ul>
            <button @click="clearErrors" type="button" class="shadow-sm btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        errors: {
            type: Array,
            default: () => [],
        },
    },
    computed: {
        hasErrors() {
            return this.errors.length > 0;
        },
    },
    methods: {
        clearErrors() {
            this.$emit("update:errors", []);
        },
    },
};
</script>
