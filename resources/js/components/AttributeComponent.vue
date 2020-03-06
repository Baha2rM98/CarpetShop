<template>
    <div>
        <div class="form-group">
            <label>دسته بندی</label>
            <select name="categories[]" id="" class="form-control" multiple>
                <option v-for="category in categories" :value="category.id">{{category.name}}</option>
            </select>

        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                categories: []
            }
        },
        mounted() {
            console.log("AttributeComponent mounted.");
            axios.get('/api/administrator/categories').then(
                res => {
                    this.getAllCategoriesChildren(res.data.categories, 0)
                }
            ).catch(err => {
                console.log(err)
            });
        },
        methods: {
            getAllCategoriesChildren: function (currentValue, level) {
                for (let i = 0; currentValue.length; i++) {
                    let current = currentValue[i];
                    this.categories.push({
                        id: current.id,
                        name: Array(level + 1).join('>>>') + ' ' + current.name
                    });
                    if (current.children && current.children.length > 0) {
                        this.getAllCategoriesChildren(current.children, level + 1)
                    }
                }
            },
        }
    }
</script>

<!--<style scoped>-->

<!--</style>-->
