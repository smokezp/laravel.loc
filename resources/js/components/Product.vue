<template>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">All products</div>
                <table v-if="products">
                    <thead>
                    <tr>
                        <td>Id</td>
                        <td>Name</td>
                        <td>Size</td>
                        <td>Edit</td>
                        <td>Delete</td>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="product in products">
                        <td>{{product.id}}</td>
                        <td>{{product.name}}</td>
                        <td>{{product.size}}</td>
                        <td>
                            <input type="submit" class="btn btn-primary" value="Edit">
                        </td>
                        <td>
                            <input type="submit" class="btn btn-danger" @click="destroy(product.id)" value="Delete">
                        </td>
                    </tr>
                    </tbody>
                </table>
                <div class="card-body">
                    <input type="submit" class="btn btn-primary" value="Create">
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import axios from 'axios';

    export default {
        name: "Product",
        data: () => {
            return {
                products: null,
            }
        },
        created() {
            axios
                .get('/api/product')
                .then(response => {
                    if (response.status === 200) {
                        this.products = response.data.data.products;
                    } else {

                    }
                });

        },

        mounted() {

        },
        methods: {
            destroy(id) {debugger
                axios
                    .delete('/api/product', {id:id})
                    .then(response => {debugger

                        if (response.status === 200) {
                            this.products = response.data.data.products;
                        } else {

                        }
                    });
            }
        }


    }
</script>

<style scoped>

</style>
