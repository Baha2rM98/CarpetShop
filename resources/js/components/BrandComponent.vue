<template>
    <div>
        <div class="form-group">
            <label>برند</label>
            <select name="brand" class="form-control">
                <option v-for="brand in brands" :value="brand.id">{{brand.title}}</option>
            </select>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                brands: []
            }
        },
        mounted() {
            console.log("BrandComponent mounted.");
            axios.get('/api/administrator/brands').then(
                res => {
                    this.getAllBrands(res.data.brands)
                }
            ).catch(err => {
                console.log(err)
            });
        },
        methods: {
            getAllBrands: function (value) {
                for (let i = 0; value.length; i++) {
                    let current = value[i];
                    this.brands.push({
                        id: current.id,
                        title: current.title
                    });
                }
            }
        }
    }
</script>
