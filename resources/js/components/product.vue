<template>
    <div>
        <h5 id="associating-form-text-with-form-controls">Name:</h5>
        <h6>{{ employee.name }}</h6>
        <h5 id="associating-form-text-with-form-controls">Patient Condition:</h5>
        <p>{{ employee.description }}</p>
        <h5 id="associating-form-text-with-form-controls">phone Number:</h5>
        <p> {{ employee.department }}</p>
        <router-link :to="`/products/${employee.id}/edit`" class="btn btn-primary">Edit</router-link>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            employee: {} // Initialize as an empty object
        }
    },
    async created() {
        try {
            const response = await axios.get(`/api/products/${this.$route.params.id}`);
            this.employee = response.data;
            console.log(this.employee); // Access name property of employee object
        } catch (error) {
            console.error(error);
        }
    }
}
</script>
