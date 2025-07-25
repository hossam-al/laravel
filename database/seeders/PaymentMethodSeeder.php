<?php

namespace Database\Seeders;
use App\Models\PaymentMethod;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PaymentMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
  public function run(): void
    {
        $methods = [
            [
                'name' => 'Visa',
                'logo' => 'Visa.ico',
                'code' => 'VISA',
                'active' => true,
                'description' => 'Visa card payment method',
                'config' => json_encode(['api_key' => 'VISA123']),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'PayPal',
                'logo' => 'paypal.ico',
                'code' => 'PAYPAL',
                'active' => true,
                'description' => 'PayPal payment method',
                'config' => json_encode(['client_id' => 'abc', 'secret' => 'xyz']),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Vodafone Cash',
                'logo' => 'Vodafone.ico',
                'code' => 'VOD',
                'active' => true,
                'description' => 'Vodafone cash wallet service',
                'config' => json_encode(['phone_number' => '01000000000']),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Fawry',
                'logo' => 'fawry.ico',
                'code' => 'FAWRY',
                'active' => false,
                'description' => 'Fawry payment method (currently disabled)',
                'config' => json_encode(['merchant_code' => '123456']),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        PaymentMethod::insert($methods);
    }
}
