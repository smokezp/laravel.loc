<template>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card" v-if="newState === 'table'">
                <div class="card-header">All products</div>
                <input type="text" v-model="query" @input="getProducts"/>
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
                            <input type="submit" class="btn btn-primary" value="Edit" @click="edit(product.id)">
                        </td>
                        <td>
                            <input type="submit" class="btn btn-danger" @click="destroy(product.id)" value="Delete">
                        </td>
                    </tr>
                    </tbody>
                </table>
                <div class="card-body">
                    <input type="submit" class="btn btn-primary" value="Create" @click="create">
                </div>
            </div>
            <div class="card" v-if="newState !== 'table'">
                <div class="card-header" v-if="newState === 'create'">Create product</div>
                <div class="card-header" v-if="newState === 'edit'">Edit product</div>
                <div class="card-body">
                    <div class="form-group row justify-content-center">
                        <div class="col-md-8">
                            <label for="name"
                                   class="col-sm-4 col-form-label text-md-right">Name</label>
                            <input type="text"
                                   class="form-control"
                                   v-model="name" id="name">

                            <label for="number"
                                   class="col-sm-4 col-form-label text-md-right">Size</label>
                            <input type="number"
                                   class="form-control"
                                   v-model="size" id="number">


                            <input type="submit" class="btn btn-primary float-left mt-2"
                                   value="Store" @click="store" v-if="newState === 'create'">
                            <input type="submit" class="btn btn-primary float-left mt-2"
                                   value="Update" @click="update" v-if="newState === 'edit'">
                            <input type="submit" class="btn btn-light float-right mt-2"
                                   value="Cancel" @click="cancel">
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>
</template>

<script>
    import User from '../services/User';
    import Http from '../services/Http';

    export default {
        name: "Product",
        data: () => {
            return {
                products: null,
                newState: 'table',
                oldState: 'table',
                editableProduct: null,
                name: '',
                size: null,
                query: ''
            }
        },
        created() {
            Http.get('products')
                .then(response => {
                    if (response.status === 200) {
                        this.products = response.data.data.products;
                    }
                });
        },
        watch: {
            newState: (newVal, oldVal) => {
                this.oldState = oldVal;
            }
        },
        methods: {
            destroy(id) {
                Http.delete('products/' + id).then(response => {
                    if (response.status === 200) {
                        this.products.splice(this.findKeyById(id), 1);
                    }
                });
            },
            create() {
                this.newState = 'create';
                this.name = '';
                this.size = null;
            },
            edit(id) {
                this.editableProduct = this.products[this.findKeyById(id)];
                this.name = this.editableProduct.name;
                this.size = this.editableProduct.size;
                this.newState = 'edit';
            },
            update() {
                let id = this.editableProduct.id;
                Http.put('products/' + id, {
                    name: this.name,
                    size: this.size
                }).then(response => {
                    if (response.status === 200) {
                        this.products[this.findKeyById(id)] = response.data.data.product;
                        this.newState = 'table';
                    }
                });
            },
            cancel() {
                this.newState = this.oldState;
            },
            store() {
                let id = User.getUser().id;
                Http.post('users/' + id + '/products', {
                    name: this.name,
                    size: this.size
                }).then(response => {
                    if (response.status === 200) {
                        this.products.push(response.data.data.product);
                        this.newState = 'table';
                    }
                });
            },
            findKeyById(id) {
                return this.products.map(item => item.id).indexOf(id);
            },
            getProducts() {
                console.log(this.query);
                Http.get('products/search?q=' + this.query).then(response => {
                    if (response.status === 200) {
                        console.log('222');
                    }
                });
            }
        }
    }
</script>

<style scoped>

</style>
