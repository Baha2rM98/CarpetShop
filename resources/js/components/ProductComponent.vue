<template>
    <div>
        <aside id="column-left" class="col-sm-3 hidden-xs">
            <h3 class="subtitle">فیلتر</h3>
            <div class="box-category">
                <div class="form-group" v-for="(attributeGroup, index) in attributeGroups">
                    <label>{{attributeGroup.title}}</label>
                    <select name="attributes[]" class="form-control" @change="addFilter($event, index)">
                        <option value="null" selected>---انتخاب کنید---</option>
                        <option v-for="attributeValue in attributeGroup.attribute_values" :value="attributeValue.id">{{attributeValue.title}}</option>
                    </select>
                </div>
                <div class="form-group" style="text-align: left">
                    <button type="submit" class="btn btn-danger" @click="getFilteredProduct()">اعمال فیلتر</button>
                </div>
            </div>
        </aside>
        <div id="content" class="col-sm-9">
            <h1 class="title">{{category.name}}</h1>
            <div class="product-filter">
                <div class="row">
                    <div class="col-md-4 col-sm-5">
                        <div class="btn-group">
                            <button type="button" id="list-view" class="btn btn-default" data-toggle="tooltip" title="List"><i class="fa fa-th-list"></i></button>
                            <button type="button" id="grid-view" class="btn btn-default" data-toggle="tooltip" title="Grid"><i class="fa fa-th"></i></button>
                        </div>
                    </div>
                    <div class="col-md-2 text-left">
                        <label class="control-label" for="input-sort">مرتب سازی :</label>
                    </div>
                    <div class="col-md-3 col-sm-2 text-right">
                        <select class="form-control col-sm-3" id="input-sort" v-model="sort"
                                @change="getSortedProducts()">
                            <option value="default" selected>پیشفرض</option>
                            <option value="asc">قیمت (کم به زیاد)</option>
                            <option value="desc">قیمت (زیاد به کم)</option>
                        </select>
                    </div>
                </div>
            </div>
            <br/>
            <div class="row products-category">
                <!--            We return paginate in laravel so instead of products we use products.data, because other key is pagination information-->
                <div class="product-layout product-grid col-lg-3 col-md-3 col-sm-4 col-xs-12" v-for="product in products.data">
                    <div class="product-thumb clearfix">
                        <div class="image"><a :href="url + '/product/' + product.sku" v-model="url"><img :src="product.photos[0].path" :alt="product.title" :title="product.title" class="img-responsive"/></a></div>
                        <div class="caption">
                            <h4><a :href="url + '/product/' + product.sku" v-model="url">{{product.title}}</a></h4>
                            <p class="price" v-if="product.discount_price"><span class="price-new">{{product.discount_price}} تومان</span><span class="price-old">{{product.price}} تومان</span><span class="saving">{{Math.round(Math.abs(((product.price - product.discount_price) / product.price) * 100))}}%</span></p>
                            <p class="price" v-if="!product.discount_price">{{product.price}}تومان </p>
                        </div>
                        <div class="button-group">
                            <a class="btn-primary" :href="url + '/cart/add/' + product.id"><span>افزودن به سبد</span></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row" v-if="products.last_page">
                <div class="col-sm-12 text-center">
                    <paginate
                            v-model="page"
                            :page-count="products.last_page"
                            :page-range="3"
                            :margin-pages="2"
                            :click-handler="clickCallback"
                            :prev-text="'قبلی'"
                            :next-text="'بعدی'"
                            :container-class="'pagination'"
                            :page-class="'page-item'">
                    </paginate>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                products: [],
                url: '',
                sort: 'default',
                page: 1,
                attributeGroups: [],
                selectedAttribute: [],
                convertedAttribute: [],
                attributes: null,
                flag: false
            }
        },
        props: ['category'],
        mounted() {
            console.log("ProductComponent mounted.");
            axios.get('/api/category/' + this.category.id + '/products').then(
                res => {
                    this.products = res.data.products;
                    this.url = res.data.url;
                }
            ).catch(err => {
                console.log(err)
            });

            axios.get('/api/category/' + this.category.id + '/attributes').then(
                res => {
                    this.attributeGroups = res.data.attributeGroups;
                }
            ).catch(err => {
                console.log(err)
            });
        },
        methods: {
            clickCallback: function (pageNum) {
                this.products = [];
                if (this.flag) {
                    this.getFilteredProduct();
                } else if (this.sort === 'asc' || this.sort === 'desc') {
                    this.getSortedProducts();
                } else if (this.sort === 'default') {
                    axios.get('/api/category/' + this.category.id + '/products?page=' + pageNum).then(
                        res => {
                            this.products = res.data.products;
                        }
                    ).catch(err => {
                        console.log(err)
                    });
                }
            },
            getSortedProducts: function () {
                this.products = [];
                axios.get('/api/category/' + this.category.id + '/products-sorted/' + this.sort + '?page=' + this.page).then(
                    res => {
                        this.products = res.data.products;
                    }
                ).catch(err => {
                    console.log(err)
                });
            },
            addFilter: function (event, index) {
                for (let i = 0; i < this.selectedAttribute.length; i++) {
                    let current = this.selectedAttribute[i];
                    if (current.index === index)
                        this.selectedAttribute.splice(i, 1);
                }
                this.selectedAttribute.push({
                    'index': index,
                    'value': event.target.value
                });
                this.convertedAttribute = [];
                for (let i = 0; i < this.selectedAttribute.length; i++) {
                    this.convertedAttribute.push(this.selectedAttribute[i].value);
                }
            },
            getFilteredProduct: function () {
                this.flag = true;
                this.attributes = null;
                this.products = [];
                this.attributes = JSON.stringify(this.convertedAttribute);
                axios.get('/api/category/' + this.category.id + '/filtered-products/' + this.attributes + '/' + this.sort + '?page=' + this.page).then(
                    res => {
                        this.products = res.data.products
                    }
                ).catch(err => {
                    console.log(err)
                });
            }
        }
    }
</script>
