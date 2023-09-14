<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ action === 'add' ? 'Create new Employee' : 'Edit Employee' }}</div>

                    <div class="card-body">
                        <form>

                            <div class="row mb-3">
                                <label for="first_name" class="col-md-4 col-form-label text-md-end">First Name</label>

                                <div class="col-md-6">
                                    <input v-model="first_name" id="first_name" type="text" class="form-control" name="first_name" autofocus>
                                    <div class="text-danger mt-2" v-if="errors && errors.hasOwnProperty('first_name')">
                                        <strong>{{ errors.first_name[0] }}</strong>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="last_name" class="col-md-4 col-form-label text-md-end">Last Name</label>

                                <div class="col-md-6">
                                    <input v-model="last_name" id="last_name" type="text" class="form-control" name="last_name">
                                    <div class="text-danger mt-2" v-if="errors && errors.hasOwnProperty('last_name')">
                                        <strong>{{ errors.last_name[0] }}</strong>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="company" class="col-md-4 col-form-label text-md-end">Company</label>

                                <div class="col-md-6">
                                    <select v-model="company_id" id="company" class="form-control" name="company">
                                        <template v-for="company in companies">
                                            <option :value="company.id">{{ company.name }}</option>
                                        </template>
                                    </select>
                                    <div class="text-danger mt-2" v-if="errors && errors.hasOwnProperty('company_id')">
                                        <strong>{{ errors.company_id[0] }}</strong>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="email" class="col-md-4 col-form-label text-md-end">Email</label>

                                <div class="col-md-6">
                                    <input v-model="email" id="email" type="text" class="form-control" name="email">
                                    <div class="text-danger mt-2" v-if="errors && errors.hasOwnProperty('email')">
                                        <strong>{{ errors.email[0] }}</strong>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="phone" class="col-md-4 col-form-label text-md-end">Phone</label>

                                <div class="col-md-6">
                                    <input v-model="phone" id="phone" type="text" class="form-control" name="phone">
                                    <div class="text-danger mt-2" v-if="errors && errors.hasOwnProperty('phone')">
                                        <strong>{{ errors.phone[0] }}</strong>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-light" @click="cancelAction">
                                        Cancel
                                    </button>

                                    <button type="submit" class="btn btn-primary m-3" @click="createEmployee" v-if="action === 'add'">
                                        Create Employee
                                    </button>

                                    <button type="submit" class="btn btn-primary m-3" @click="updateEmployee" v-else>
                                        Update Employee
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ['employee', 'companies'],
    data() {
        return {
            action: 'add',
            id: null,
            first_name: '',
            last_name: '',
            company_id: '',
            email: '',
            phone: '',
            errors: null
        }
    },
    mounted() {
        console.log('Component mounted.')
    },
    created() {
        this.action = this.employee ? 'edit' : 'add';

        if (this.employee) {
            this.id = this.employee.id;
            this.first_name = this.employee.first_name;
            this.last_name = this.employee.last_name;
            this.company_id = this.employee.company_id;
            this.email = this.employee.email;
            this.phone = this.employee.phone;
        }
    },
    methods: {
        cancelAction() {
            this.$emit('cancel');
        },
        createEmployee(e) {
            e.preventDefault()

            const formData = new FormData();
            formData.append('first_name', this.first_name);
            formData.append('last_name', this.last_name);
            formData.append('company_id', this.company_id);
            formData.append('phone', this.phone);
            formData.append('email', this.email);

            axios({
                method: 'post',
                url: 'api/employees',
                baseURL: window.location.origin,
                data: formData
            }).then(response => {
                this.$emit('refreshEmployees')
            }).catch((error) => {
                this.errors = error.response.data.errors
            });
        },
        updateEmployee(e) {
            e.preventDefault()

            axios({
                method: 'put',
                url: 'api/employees/' + this.id,
                baseURL: window.location.origin,
                params: {
                    first_name: this.first_name,
                    last_name: this.last_name,
                    company_id: this.company_id,
                    email: this.email,
                    phone: this.phone
                }
            }).then(response => {
                this.$emit('refreshEmployees')
            }).catch((error) => {
                this.errors = error.response.data.errors
            });
        },
    }
}
</script>
