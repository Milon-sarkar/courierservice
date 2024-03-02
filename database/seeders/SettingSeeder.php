<?php

namespace Database\Seeders;

use App\Models\Backend\Setting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {


        //social login settings
        //facebook
        Setting::create(['key' => 'facebook_client_id',     'value' => '761215211788306']);
        Setting::create(['key' => 'facebook_client_secret', 'value' => '7723532b0459756c86a8c0467ab27ae1']);
        Setting::create(['key' => 'facebook_status',        'value' => 1]);
        //google
        Setting::create(['key' => 'google_client_id',     'value' => '730724862191-cncotvoaiai5vd5hikltrah9df39uou5.apps.googleusercontent.com']);
        Setting::create(['key' => 'google_client_secret', 'value' => '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']);
        Setting::create(['key' => 'google_status',        'value' => 1]);

        //===== payment setup ===
        //stripe
        Setting::create(['key' => 'stripe_publishable_key',     'value' => 'pk_test_csMkzUcsbjbcEuuW6K0QImTT00M403UGkp']);
        Setting::create(['key' => 'stripe_secret_key',          'value' => 'sk_test_aqfYWud5ZhFx0EGIvY6Scdxh00dlfZKnFT']);
        Setting::create(['key' => 'stripe_status',              'value' => 1]);

        //Razorpay
        Setting::create(['key' => 'razorpay_key',               'value' => '']);
        Setting::create(['key' => 'razorpay_secret',            'value' => '']);
        Setting::create(['key' => 'razorpay_status',            'value' => 1]);

        //sslcommerz
        Setting::create(['key' => 'sslcommerz_store_id',        'value' => 'wemax635e0bd65804e']);
        Setting::create(['key' => 'sslcommerz_store_password',  'value' => 'wemax635e0bd65804e@ssl']);
        Setting::create(['key' => 'sslcommerz_testmode',        'value' => 1]);
        Setting::create(['key' => 'sslcommerz_status',          'value' => 1]);

        //paypal
        Setting::create(['key' => 'paypal_client_id',              'value' => 'ASNysE4ENGfyplv-cNRife5zi8137rEh21yoK4cBZvuy1JWEm-v_DdmfBKVedtmadG1VPgXxUjRg6Q_3']);
        Setting::create(['key' => 'paypal_client_secret',          'value' => 'EJwTIUMb8mjg0EH2gim8jpi8tQaVeomcVm0Rs-c3mjXxcvGR3y6imw1kohYuGs5NCPzJuXe-ggvyixaF']);
        Setting::create(['key' => 'paypal_mode',                   'value' => 'sendbox']);
        Setting::create(['key' => 'paypal_status',                 'value' => 1]);

        //skrill
        Setting::create(['key' => 'skrill_merchant_email',         'value' => 'demoqco@sun-fish.com']);
        Setting::create(['key' => 'skrill_status',                 'value' => 1]);


        // //bkash
        Setting::create(['key' => 'bkash_app_id',              'value' => 'application id']);
        Setting::create(['key' => 'bkash_app_secret',          'value' => 'application secret key']);
        Setting::create(['key' => 'bkash_username',            'value' => 'username']);
        Setting::create(['key' => 'bkash_password',            'value' => 'password']);
        Setting::create(['key' => 'bkash_test_mode',           'value' => 1]);
        Setting::create(['key' => 'bkash_status',              'value' => 1]);


        //aamar pay
        Setting::create(['key' => 'aamarpay_store_id',        'value' => 'aamarypay']);
        Setting::create(['key' => 'aamarpay_signature_key',   'value' => '28c78bb1f45112f5d40b956fe104645a']);
        Setting::create(['key' => 'aamarpay_sendbox_mode',    'value' => 1]);
        Setting::create(['key' => 'aamarpay_status',          'value' => 1]);
         

        //=====payment setup===





    }
}
