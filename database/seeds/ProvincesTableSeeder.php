<?php

use Illuminate\Database\Seeder;
use App\Province;

class ProvincesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $provinceColumn = 'name';
        factory(Province::class)->create([$provinceColumn => 'آذربايجان شرقي']);
        factory(Province::class)->create([$provinceColumn => 'آذربايجان غربي']);
        factory(Province::class)->create([$provinceColumn => 'اردبيل']);
        factory(Province::class)->create([$provinceColumn => 'اصفهان']);
        factory(Province::class)->create([$provinceColumn => 'البرز']);
        factory(Province::class)->create([$provinceColumn => 'ايلام']);
        factory(Province::class)->create([$provinceColumn => 'بوشهر']);
        factory(Province::class)->create([$provinceColumn => 'تهران']);
        factory(Province::class)->create([$provinceColumn => 'چهارمحال بختياري']);
        factory(Province::class)->create([$provinceColumn => 'خراسان جنوبي']);
        factory(Province::class)->create([$provinceColumn => 'خراسان رضوي']);
        factory(Province::class)->create([$provinceColumn => 'خراسان شمالي']);
        factory(Province::class)->create([$provinceColumn => 'خوزستان']);
        factory(Province::class)->create([$provinceColumn => 'زنجان']);
        factory(Province::class)->create([$provinceColumn => 'سمنان']);
        factory(Province::class)->create([$provinceColumn => 'سيستان و بلوچستان']);
        factory(Province::class)->create([$provinceColumn => 'فارس']);
        factory(Province::class)->create([$provinceColumn => 'قزوين']);
        factory(Province::class)->create([$provinceColumn => 'قم']);
        factory(Province::class)->create([$provinceColumn => 'كردستان']);
        factory(Province::class)->create([$provinceColumn => 'كرمان']);
        factory(Province::class)->create([$provinceColumn => 'كرمانشاه']);
        factory(Province::class)->create([$provinceColumn => 'كهكيلويه و بويراحمد']);
        factory(Province::class)->create([$provinceColumn => 'گلستان']);
        factory(Province::class)->create([$provinceColumn => 'گيلان']);
        factory(Province::class)->create([$provinceColumn => 'لرستان']);
        factory(Province::class)->create([$provinceColumn => 'مازندران']);
        factory(Province::class)->create([$provinceColumn => 'مركزي']);
        factory(Province::class)->create([$provinceColumn => 'هرمزگان']);
        factory(Province::class)->create([$provinceColumn => 'همدان']);
        factory(Province::class)->create([$provinceColumn => 'يزد']);
    }
}
