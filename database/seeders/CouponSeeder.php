<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Enums\CouponType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CouponSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('coupons')->insert([
            'code' => 'GIAM10K',
            'value' => 10000,
            'type' => CouponType::FIXED,
            'description' => 'giam 10k ne',
            'min_amount' => 50000,
            // 'max_amount' => 50,
            'start_date' => Carbon::now(),
            'expiry_date' => Carbon::now()->addDays(rand(1, 30)),
            // 'usage_limit' => null,
            'usage_count' => 0,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('coupons')->insert([
            'code' => 'GIAM',
            'value' => 10,
            'type' => CouponType::PERCENT,
            'description' => 'giam 10% nhaaa',
            'min_amount' => 200000,
            'max_amount' => 100000,
            'start_date' => Carbon::now(),
            'expiry_date' => Carbon::now()->addDays(rand(1, 30)),
            // 'usage_limit' => null,
            'usage_count' => 0,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('coupons')->insert([
            'code' => 'CHAOMUNG',
            'value' => 50,
            'type' => CouponType::PERCENT,
            'description' => 'giam 10% nhaaa',
            'min_amount' => 200000,
            'max_amount' => 50000,
            'start_date' => Carbon::now(),
            'expiry_date' => Carbon::now()->addDays(rand(1, 30)),
            'usage_limit' => 100,
            'usage_count' => 0,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('coupons')->insert([
            'code' => 'GIAM100K',
            'value' => 100000,
            'type' => CouponType::FIXED,
            'description' => 'giam 100k ne',
            'min_amount' => 50000,
            // 'max_amount' => 50,
            'start_date' => Carbon::now(),
            'expiry_date' => Carbon::now()->addDays(rand(1, 30)),
            // 'usage_limit' => null,
            'usage_count' => 0,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('coupons')->insert([
            'code' => 'GIAM1K',
            'value' => 1000,
            'type' => CouponType::FIXED,
            'description' => 'giam 10k ne',
            'min_amount' => 30000,
            // 'max_amount' => 50,
            'start_date' => Carbon::now(),
            'expiry_date' => Carbon::now()->addDays(rand(1, 30)),
            // 'usage_limit' => null,
            'usage_count' => 0,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('coupons')->insert([
            'code' => 'HSSV',
            'value' => 100000,
            'type' => CouponType::FIXED,
            'description' => 'giam 100k cho hoc sinh, sinh dien',
            'min_amount' => 50000,
            // 'max_amount' => 50,
            'start_date' => Carbon::now(),
            'expiry_date' => Carbon::now()->addDays(rand(1, 30)),
            // 'usage_limit' => null,
            'usage_count' => 0,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}
