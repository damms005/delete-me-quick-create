<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Todo;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $customer = Customer::factory()->create();

        $user = User::factory()->for($customer)->create([
            'email' => 'test@example.com',
            'password' => bcrypt('test@example.com'),
        ]);

        Todo::factory()
            ->for($customer)
            ->for($user)
            ->count(5)
            ->create();
    }
}
