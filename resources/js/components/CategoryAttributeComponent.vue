<template>
    <div>
        <div class="form-group">
            <label>دسته بندی</label>
            <select name="categories[]" id="" class="form-control" multiple v-model="selectedCategories"
                    @change="onChange($event)">
                <option v-for="category in categories" :value="category.id">{{category.name}}</option>
            </select>
        </div>
        <div v-if="flag">
            <div class="form-group" v-for="attribute in attributes">
                <label>ویژگی {{attribute.title}}</label>
                <select name="attribute" class="form-control">
                    <option v-for="attributeValue in attribute.attribute_values" :value="attributeValue.id">
                        {{attributeValue.title}}
                    </option>
                </select>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                categories: [],
                selectedCategories: [],
                flag: false,
                attributes: []
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
            onChange: function (event) {
                this.flag = false;
                axios.post('/api/administrator/categories/attributes', this.selectedCategories).then(
                    res => {
                        this.attributes = res.data.attributes;
                        this.flag = true;
                    }
                ).catch(err => {
                    console.log(err);
                    this.flag = false;
                });
            }
        }
    }
</script>
