<template>
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Employees</div>

                    <div class="card-body">

                        <div>
                            <button class="btn btn-success" @click="addEmployee">Create new employee</button>
                        </div>

                        <div class="card mt-4">
                            <div class="card-header">Employees list</div>

                            <div class="card-body">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <td>First Name</td>
                                            <td>Last Name</td>
                                            <td>Company</td>
                                            <td>Email</td>
                                            <td>Phone</td>
                                            <td></td>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <template v-if="employees.data.length > 0">
                                            <tr v-for="employee in employees.data">
                                                <td>{{ employee.first_name }}</td>
                                                <td>{{ employee.last_name }}</td>
                                                <td>{{ employee.company_name }}</td>
                                                <td>{{ employee.email }}</td>
                                                <td>{{ employee.phone }}</td>
                                                <td>
                                                    <button class="btn btn-secondary m-1" @click="editEmployee(employee)">Edit</button>
                                                    <button class="btn btn-danger m-1" @click="deleteEmployee(employee)">Delete</button>
                                                </td>
                                            </tr>
                                        </template>
                                        <template v-else>
                                            <tr>
                                                <td colspan="5">
                                                    <p class="text-center m-0">No data available</p>
                                                </td>
                                            </tr>
                                        </template>
                                    </tbody>
                                </table>

                                <div>
                                    <div>
                                        <button class="btn btn-light" :disabled="!employees.previous_page" @click="previous">Previous</button>
                                        <button class="btn btn-light" :disabled="!employees.next_page" @click="next">Next</button>
                                    </div>
                                    <div class="mt-4">Page {{ employees.current_page }} of {{ employees.last_page }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['employees'],
        mounted() {
            console.log('Component mounted.')
        },
        methods: {
            addEmployee() {
                this.$emit('addEmployee')
            },
            editEmployee(employee) {
                this.$emit('editEmployee', employee)
            },
            deleteEmployee(employee) {
                axios({
                    method: 'delete',
                    url: 'api/employees/' + employee.id,
                    baseURL: window.location.origin,
                }).then(response => {
                    this.$emit('deleteEmployee')
                }).catch((error) => {
                    this.errors = error.response.data.errors
                });
            },
            previous() {
                this.$emit('previous')
            },
            next() {
                this.$emit('next')
            }
        }
    }
</script>
