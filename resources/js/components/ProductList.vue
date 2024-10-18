<template>
    <div>
        <!-- Search Input -->
        <div style="color: white" class="search-container mb-3">
            <label for="search" class="form-label">Search:</label>
            <input v-model="search" type="text" class="form-control"  id="search" placeholder="Search by name, Patient Condition, , Phone Number or ID">
        </div>

        <!-- Employee List Table -->
        <table class="table">
            <thead>
            <tr>
                <th scope="col">#ID</th>
                <th scope="col">Name</th>
                <th scope="col">Patient condition</th>
                <th scope="col">Phone Number</th>
                <th scope="col">Actions</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="employee in filteredEmployees" :key="employee.id">
                <td>{{ employee.id }}</td>
                <td>{{ employee.name }}</td>
                <td>{{ employee.description }}</td>
                <td>{{ employee.department }}</td>
                <td>
                    <div class="row gap-3">
                        <router-link :to="`/products/${employee.id}`" class="p-2 col border btn btn-primary">View</router-link>
                        <router-link :to="`/products/${employee.id}/edit`" class="p-2 col border btn btn-success">Edit</router-link>

                        <button @click="deleteProduct(employee.id)" type="button" class="p-2 col border btn btn-danger">Delete</button>
                    </div>
                </td>
            </tr>
            </tbody>
        </table>

    </div>
</template>

<script>
import axios from 'axios';
import ProductForm from "./ProductForm.vue";

export default {

    data() {
        return {
            employees: [],
            search: '',
        }
    },
    async created() {
        await this.fetchEmployees();
    },
    methods: {
        async fetchEmployees() {
            try {
                const response = await axios.get('/api/products')

                this.employees = response.data;
            } catch (error) {
                console.error(error);
            }
        },
        async deleteProduct(id) {
            try {
                await axios.delete(`/api/products/${id}`);
                // Filter out the employee with the matching id
                console.error(id);

                this.employees = this.employees.filter(employee => employee.id !== id);
            } catch (error) {
                console.error(error);
            }
        },
    },
    computed: {
        filteredEmployees() {
            return this.employees.filter(employee =>
                employee.name.toLowerCase().includes(this.search.toLowerCase()) ||
                employee.department.toLowerCase().includes(this.search.toLowerCase()) ||
                employee.id.toString().includes(this.search.toLowerCase())
            );
        },
    },
}
</script>

<style scoped>
.search-container {
    background-color: #36454F;
    padding: 10px;
    border-radius: 5px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    margin-bottom: 20px;
}

.table th, .table td {
    text-align: center;
}
</style>
