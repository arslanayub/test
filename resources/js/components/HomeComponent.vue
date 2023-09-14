<template>
    <div>
        <template v-if="activeComponent === 'create-company'">
            <create-company-component :company="selectedCompany"
                                      @cancel="redirectHome"
                                      @refreshCompanies="getCompanies"
            ></create-company-component>
        </template>
        <template v-else-if="activeComponent === 'create-employee'">
            <create-employee-component :employee="selectedEmployee"
                                       :companies="allCompanies"
                                       @cancel="redirectHome"
                                       @refreshEmployees="getEmployees"
            ></create-employee-component>
        </template>
        <template v-else>
            <company-component :companies="companies"
                               @addCompany="addCompany"
                               @editCompany="editCompany"
                               @deleteCompany="getCompanies"
                               @next="nextCompanies"
                               @previous="previousCompanies"
            ></company-component>

            <employee-component :employees="employees"
                                @addEmployee="addEmployee"
                                @editEmployee="editEmployee"
                                @deleteEmployee="getEmployees"
                                @next="nextEmployees"
                                @previous="previousEmployees"
            ></employee-component>
        </template>

    </div>
</template>

<script>
    import CompanyComponent from "./CompanyComponent.vue";
    import CreateCompanyComponent from "./CreateCompanyComponent.vue";
    import EmployeeComponent from "./EmployeeComponent.vue";
    import CreateEmployeeComponent from "./CreateEmployeeComponent.vue";

    export default {
        components: {CompanyComponent, CreateCompanyComponent, EmployeeComponent, CreateEmployeeComponent},
        data() {
            return {
                activeComponent: 'home',
                companies: {
                    current_page: 1,
                    last_page: 1,
                    next_page: null,
                    previous_page: null,
                    data: []
                },
                employees: {
                    current_page: 1,
                    last_page: 1,
                    next_page: null,
                    previous_page: null,
                    data: []
                },
                allCompanies: [],
                companiesPage: 1,
                employeesPage: 1,
                selectedCompany: null,
                selectedEmployee: null
            }
        },
        mounted() {
            console.log('Component mounted.')
        },
        created() {
            this.getCompanies();
            this.getEmployees();
        },
        methods: {
            redirectHome() {
                this.activeComponent = 'home';
            },
            getCompanies() {
                this.activeComponent = 'home';

                axios({
                    method: 'get',
                    url: 'api/companies',
                    baseURL: window.location.origin,
                    params: {
                        page: this.companiesPage
                    }
                }).then(response => {
                    this.selectedCompany = null;
                    this.companies = response.data.companies;
                }).catch((error) => {

                });
            },
            nextCompanies() {
                this.companiesPage += 1;
                this.getCompanies();
            },
            previousCompanies() {
                this.companiesPage -= 1;
                this.getCompanies();
            },
            addCompany() {
                this.activeComponent = 'create-company';
            },
            editCompany(company) {
                this.selectedCompany = company;
                this.activeComponent = 'create-company';
            },
            getEmployees() {
                this.activeComponent = 'home';

                axios({
                    method: 'get',
                    url: 'api/employees',
                    baseURL: window.location.origin,
                    params: {
                        page: this.employeesPage
                    }
                }).then(response => {
                    this.selectedEmployee = null;
                    this.employees = response.data.employees;
                    this.allCompanies = response.data.companies;
                }).catch((error) => {

                });
            },
            nextEmployees() {
                this.employeesPage += 1;
                this.getEmployees();
            },
            previousEmployees() {
                this.employeesPage -= 1;
                this.getEmployees();
            },
            addEmployee() {
                this.activeComponent = 'create-employee';
            },
            editEmployee(employee) {
                this.selectedEmployee = employee;
                this.activeComponent = 'create-employee';
            },
        }
    }
</script>
