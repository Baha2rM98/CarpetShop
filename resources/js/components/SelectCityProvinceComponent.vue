<template>
    <div>
        <div class="form-group required">
            <label for="input-country" class="col-sm-2 control-label">استان</label>
            <div class="col-sm-10">
                <select class="form-control" id="input-country" name="province_id" v-model="province"
                        @change="getAllCities()">
                    <option>--- استان را انتخاب کنید ---</option>
                    <option v-for="province in provinces" :value="province.id">{{province.name}}</option>
                </select>
            </div>
        </div>
        <div class="form-group required" v-if="cities.length > 0">
            <label for="input-zone" class="col-sm-2 control-label">شهر</label>
            <div class="col-sm-10">
                <select class="form-control" id="input-zone" name="city_id">
                    <option v-for="city in cities" :value="city.id">{{city.name}}</option>
                </select>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                provinces: [],
                province: '--- استان را انتخاب کنید ---',
                cities: [],
            }
        },
        mounted() {
            console.log("SelectCityProvinceComponent mounted.");
            axios.get('/api/provinces').then(
                res => {
                    this.provinces = res.data.provinces;
                }
            ).catch(err => {
                console.log(err)
            });
        },
        methods: {
            getAllCities: function () {
                axios.get('/api/cities/' + this.province).then(
                    res => {
                        this.cities = res.data.cities;
                    }
                ).catch(err => {
                    console.log(err)
                });
            }
        }
    }
</script>
