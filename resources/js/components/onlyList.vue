<template>
    <header>
        <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
            <router-link to="/" class="d-flex align-items-center my-2 my-lg-0 me-lg-auto text-white text-decoration-none " >
                <img src="https://kecbu.uobaghdad.edu.iq/wp-content/uploads/sites/29/uploads/gallery/%D8%B4%D9%83%D8%B1%20%D8%A7%D9%84%D8%AC%D8%A7%D9%85%D8%B9%D8%A9%20%D8%A7%D9%84%D8%AA%D9%83%D9%86%D9%88%D9%84%D9%88%D8%AC%D9%8A%D8%A7/%D8%AA%D9%83%D9%86%D9%88%D9%84%D9%88%D8%AC%D9%8A%D8%A7%20%D8%B4%D8%B9%D8%A7%D8%B1.png" style="height:60px;"/>
            </router-link>
            <ul class="nav col-12 col-lg-auto my-2 justify-content-center my-md-0 text-small">
                <li>
                    <router-link to="/onlyList" class="nav-link text-green" style="text-decoration: green; color: green;"><svg class="bi d-block mx-auto mb-1" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M4.5 21q-.625 0-1.063-.438T3 19.5v-1.9l4-3.55V21H4.5ZM8 21v-4h8v4H8Zm9 0v-8.2L12.725 9l3.025-2.675l4.75 4.225q.25.225.375.513t.125.612V19.5q0 .625-.438 1.063T19.5 21H17ZM3 16.25v-4.575q0-.325.125-.625t.375-.5L11 3.9q.2-.2.463-.287T12 3.525q.275 0 .537.088T13 3.9l2 1.775L3 16.25Z"/></svg>Home</router-link>
                </li>

                <li  >
                    <button @click="logout" class="btn btn-outline-danger">Logout</button>

                </li>
            </ul>
        </div>
    </header>
    <div>
        <!-- Search Input -->
        <div style="color: white" class="search-container mb-3">
            <label for="search" class="form-label">Search:</label>
            <input v-model="search" type="text" class="form-control"  id="search" placeholder="Search by name, department, or ID">
        </div>

        <!-- Employee List Table -->
        <table class="table">
            <thead>
            <tr>
                <th scope="col">#ID</th>
                <th scope="col">Name</th>
                <th scope="col">Description</th>
                <th scope="col">Department</th>

            </tr>
            </thead>
            <tbody>
            <tr v-for="employee in filteredEmployees" :key="employee.id">
                <td>{{ employee.id }}</td>
                <td>{{ employee.name }}</td>
                <td>{{ employee.description }}</td>
                <td>{{ employee.department }}</td>
                <td>

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
        },     logout() {
            // Clear the authentication token from local storage
            localStorage.removeItem('token');
            // Update isAuthenticated to false
            this.isAuthenticated = false;
            // Redirect the user to the login page
            this.$router.push('/login');
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
