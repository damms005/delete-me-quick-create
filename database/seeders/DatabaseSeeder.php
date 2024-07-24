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
            ->count(3)
            ->sequence(fn () => ['due_date' => now()->addDays(rand(7, 14))])
            ->create()
            ->each(function (Todo $todo) use ($user) {
                $todo->users()->attach($user, ['due_date' => $todo->due_date->addDays(rand(2, 7))]);

                $todo->update([
                    'title' => "{$todo->title} - {$todo->due_date->format('Y-m-d')}",
                ]);
            });
    }
}
