<template>
    <div>
        <h2 v-if="isNewEmployee">Add Patient</h2>
        <h2 v-else>Edit Patient</h2>
        <form @submit.prevent="submitForm">
            <div class="mb-3">
                <label for="name" class="form-label">Name:</label>
                <input class="form-control" type="text" id="name" v-model="employee.name" required />
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Patient condition:</label>
                <textarea class="form-control" id="description" v-model="employee.description" required></textarea>
            </div>
            <div class="mb-3">
                <label for="department" class="form-label">Phone Number:</label>
                <input class="form-control" type="text" id="department" v-model="employee.department" required />
            </div>
            <button type="submit" v-if="isNewEmployee" class="btn btn-primary">Add Patient</button>
            <button type="submit" v-else class="btn btn-primary">Update Patient</button>
        </form>
    </div>
</template>
<script>
import axios from 'axios';

export default {
    data() {
        return {
            employee: {
                id: '',
                name: '',
                description: '',
                department: ''
            }
        }
    },
    computed: {
        isNewEmployee() {
            return !this.$route.path.includes('edit');
        }
    },
    async created() {
        if (!this.isNewEmployee && this.$route.params.id) {
            // Fetch the employee data using the ID from the route parameters
            const response = await axios.get(`/api/products/${this.$route.params.id}`);
            this.employee = response.data;
            console.log(response.data)
        }
    },
    methods: {
        async submitForm() {
            try {
                if (this.isNewEmployee) {
                    await axios.post('/api/products', this.employee);
                } else {
                    await axios.put(`/api/products/${this.employee.id}`, this.employee);
                }
                this.$router.push('/');
            } catch (error) {
                console.error(error);
            }
        }
    }
}
</script>
