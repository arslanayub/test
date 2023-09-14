<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Companies</div>

                    <div class="card-body">

                        <div>
                            <button class="btn btn-success" @click="addCompany">Create new company</button>
                        </div>

                        <div class="card mt-4">
                            <div class="card-header">Companies list</div>

                            <div class="card-body">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <td>Name</td>
                                            <td>Email</td>
                                            <td>Logo</td>
                                            <td>Website</td>
                                            <td></td>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <template v-if="companies.data.length > 0">
                                            <tr v-for="company in companies.data">
                                                <td>{{ company.name }}</td>
                                                <td>{{ company.email }}</td>
                                                <td>
                                                    <img  v-if="company.logo !== ''"
                                                          :src="company.logo"
                                                          height="50"
                                                    >
                                                </td>
                                                <td>{{ company.website }}</td>
                                                <td>
                                                    <button class="btn btn-secondary m-1" @click="editCompany(company)">Edit</button>
                                                    <button class="btn btn-danger m-1" @click="deleteCompany(company)">Delete</button>
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
                                        <button class="btn btn-light" :disabled="!companies.previous_page" @click="previous">Previous</button>
                                        <button class="btn btn-light" :disabled="!companies.next_page" @click="next">Next</button>
                                    </div>
                                    <div class="mt-4">Page {{ companies.current_page }} of {{ companies.last_page }}</div>
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
        props: ['companies'],
        mounted() {
            console.log('Component mounted.')
        },
        methods: {
            addCompany() {
                this.$emit('addCompany')
            },
            editCompany(company) {
                this.$emit('editCompany', company)
            },
            deleteCompany(company) {
                axios({
                    method: 'delete',
                    url: 'api/companies/' + company.id,
                    baseURL: window.location.origin,
                }).then(response => {
                    this.$emit('deleteCompany')
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
