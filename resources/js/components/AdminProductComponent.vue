<template>
    <div>
        <div class="form-group">
            <label>دسته بندی</label>
            <select name="categories[]" id="" class="form-control" multiple="true" v-model="selectedCategories"
                    @change="onChange($event, null)">
                <option v-for="category in categories" :value="category.id">{{category.name}}</option>
            </select>
        </div>
        <div class="form-group">
            <label>برند</label>
            <select name="brand_id" class="form-control">
                <option v-if="!product" v-for="brand in brands" :value="brand.id">{{brand.title}}</option>
                <option v-if="product" v-for="brand in brands" :selected="product.brand.id === brand.id" :value="brand.id">{{brand.title}}</option>
            </select>
        </div>
        <div v-if="flag">
            <div class="form-group" v-for="(attribute, index) in myAttributes">
                <label>ویژگی {{attribute.title}}</label>
                <select class="form-control" @change="addAttribute($event, index)">
                    <option value="null">انتخاب کنید...</option>
                    <option v-if="!product" v-for="attributeValue in attribute.attribute_values" :value="attributeValue.id">{{attributeValue.title}}</option>
                    <option v-if="product" v-for="attributeValue in attribute.attribute_values" :value="attributeValue.id" :selected="product.attribute_values[index] && product.attribute_values[index]['id'] === attributeValue.id">{{attributeValue.title}}</option>
                </select>
            </div>
        </div>
        <input type="hidden" name="attributes[]" :value="myConvertedAttribute">
    </div>
</template>

<script>
    export default {
        data() {
            return {
                categories: [],
                selectedCategories: [],
                flag: false,
                myAttributes: [],
                mySelectedAttribute: [],
                myConvertedAttribute: []
            }
        },
        props: ['brands', 'product'],
        mounted() {
            console.log("AdminProductComponent mounted.");
            axios.get('/api/categories').then(res => {
                this.getAllChildren(res.data.categories, 0)
            }).catch(err => {
                console.log(err)
            });
            if (this.product) {
                // console.log(this.product);
                for (let i = 0; i < this.product.categories.length; i++) {
                    this.selectedCategories.push(this.product.categories[i].id)
                }
                for (let i = 0; i < this.product.attribute_values.length; i++) {
                    this.mySelectedAttribute.push({
                        'index': i,
                        'value': this.product.attribute_values[i].id
                    });
                    this.myConvertedAttribute.push(this.product.attribute_values[i].id)
                }
                const load = 'ok';
                this.onChange(null, load);
            }
        },
        methods: {
            getAllChildren: function (currentValue, level) {
                for (let i = 0; i < currentValue.length; i++) {
                    let current = currentValue[i];
                    this.categories.push({
                        id: current.id,
                        name: Array(level + 1).join(">>>") + " " + current.name
                    });
                    if (current.children && current.children.length > 0) {
                        this.getAllChildren(current.children, level + 1)
                    }
                }
            },
            onChange: function (event, load) {
                this.flag = false;
                axios.post('/api/category/attributes', this.selectedCategories).then(res => {
                    if (this.product && load == null) {
                        this.myConvertedAttribute = [];
                        this.mySelectedAttribute = []
                    }
                    this.myAttributes = res.data.myAttributes;
                    this.flag = true
                }).catch(err => {
                    console.log(err);
                    this.flag = false
                })

            },
            addAttribute: function (event, index) {
                for (let i = 0; i < this.mySelectedAttribute.length; i++) {
                    let current = this.mySelectedAttribute[i];
                    if (current.index === index) {
                        this.mySelectedAttribute.splice(i, 1)
                    }
                }
                this.mySelectedAttribute.push({
                    'index': index,
                    'value': event.target.value
                });
                this.myConvertedAttribute = [];
                for (let i = 0; i < this.mySelectedAttribute.length; i++) {
                    this.myConvertedAttribute.push(this.mySelectedAttribute[i].value)
                }
            },
        }
    }
</script>
