<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Employees</div>

                    <div class="card-body">

                        <div>
                            <button class="btn btn-success" @click="emitAction('add')">Create new company</button>
                        </div>

                        <div class="card mt-4">
                            <div class="card-header">Companies list</div>

                            <div class="card-body">
                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <td>Name</td>
                                        <td>Address</td>
                                        <td>Website</td>
                                        <td>Email</td>
                                        <td></td>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    <tr>
                                        <td>laravel daily</td>
                                        <td>New York, New York</td>
                                        <td>www.laraveldaily.com</td>
                                        <td>povilas@laraveldaily.com</td>
                                        <td>
                                            <button class="btn btn-secondary m-1" @click="emitAction('edit')">Edit</button>
                                            <button class="btn btn-danger m-1">Delete</button>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>

                                <div>
                                    <div>
                                        <button class="btn btn-light">Previous</button>
                                        <button class="btn btn-light">Next</button>
                                    </div>
                                    <div class="mt-4">Page 1 of 3</div>
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
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
