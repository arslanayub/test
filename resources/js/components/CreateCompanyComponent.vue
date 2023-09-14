<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ action === 'add' ? 'Create new Company' : 'Edit Company' }}</div>

                    <div class="card-body">
                        <form>

                            <div class="row mb-3">
                                <label for="name" class="col-md-4 col-form-label text-md-end" autofocus>Name</label>

                                <div class="col-md-6">
                                    <input v-model="name" id="name" type="text" class="form-control" name="name">
                                    <div class="text-danger mt-2" v-if="errors && errors.hasOwnProperty('name')">
                                        <strong>{{ errors.name[0] }}</strong>
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
                                <label for="logo" class="col-md-4 col-form-label text-md-end">Logo</label>

                                <div class="col-md-6">
                                    <input id="logo" type="file" class="form-control" name="logo">
                                    <div class="text-danger mt-2" v-if="errors && errors.hasOwnProperty('logo')">
                                        <strong>{{ errors.logo[0] }}</strong>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="website" class="col-md-4 col-form-label text-md-end">Website</label>

                                <div class="col-md-6">
                                    <input v-model="website" id="website" type="text" class="form-control" name="website">
                                    <div class="text-danger mt-2" v-if="errors && errors.hasOwnProperty('website')">
                                        <strong>{{ errors.website[0] }}</strong>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-light" @click="cancelAction">
                                        Cancel
                                    </button>

                                    <button type="submit" class="btn btn-primary m-3" @click="createCompany" v-if="action === 'add'">
                                        Create company
                                    </button>

                                    <button type="submit" class="btn btn-primary m-3" @click="updateCompany" v-else>
                                        Update company
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
        props: ['company'],
        data() {
            return {
                action: 'add',
                id: null,
                name: '',
                email: '',
                logo: '',
                website: '',
                errors: null
            }
        },
        mounted() {
            console.log('Component mounted.')
        },
        created() {
            this.action = this.company ? 'edit' : 'add';

            if (this.company) {
                this.id = this.company.id;
                this.name = this.company.name;
                this.email = this.company.email;
                this.website = this.company.website;
            }
        },
        methods: {
            cancelAction() {
                this.$emit('cancel');
            },
            createCompany(e) {
                e.preventDefault()

                const formData = new FormData();
                formData.append('name', this.name);
                formData.append('email', this.email);
                formData.append('website', this.website);

                if (document.getElementById("logo").files.length > 0) {
                    formData.append('logo', document.getElementById("logo").files[0]);
                }

                axios({
                    method: 'post',
                    url: 'api/companies',
                    baseURL: window.location.origin,
                    data: formData
                }).then(response => {
                    this.$emit('refreshCompanies')
                }).catch((error) => {
                    this.errors = error.response.data.errors
                });
            },
            updateCompany(e) {
                e.preventDefault()

                const formData = new FormData();
                formData.append('name', this.name);
                formData.append('email', this.email);
                formData.append('website', this.website);

                if (document.getElementById("logo").files.length > 0) {
                    formData.append('logo', document.getElementById("logo").files[0]);
                }

                axios({
                    method: 'post',
                    url: 'api/companies/' + this.id,
                    baseURL: window.location.origin,
                    data: formData
                }).then(response => {
                    this.$emit('refreshCompanies')
                }).catch((error) => {
                    this.errors = error.response.data.errors
                });
            },
        }
    }
</script>
