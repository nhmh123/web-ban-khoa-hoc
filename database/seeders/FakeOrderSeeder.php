<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Course;
use App\Services\OrderService;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class FakeOrderSeeder extends Seeder
{
    protected $orderService;
    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::pluck('id')->toArray();
        $courses = Course::pluck('id')->toArray();

        $faker = fake();

        $years = [2023, 2024, 2025];

        $orderCreated = 0;
        foreach ($years as $year) {
            for ($month = 1; $month <= 12; $month++) {
                if ($orderCreated >= 100) break;

                $ordersThisMonth = min(4, 100 - $orderCreated);

                for ($i = 0; $i < $ordersThisMonth; $i++) {
                    $userId = $faker->randomElement($users);
                    $courseIds = $faker->randomElements($courses, rand(1, 3));

                    $user = User::find($userId);

                    $order = $this->orderService->createOrderFormList($user, $courseIds);

                    $randomDate = Carbon::create($year, $month, rand(1, 28), rand(0, 23), rand(0, 59), rand(0, 59));
                    $order->created_at = $randomDate;
                    $order->updated_at = $randomDate;
                    $order->save();

                    $orderCreated++;
                }
            }
        }

        $this->command->info("Created $orderCreated fake order.");
    }
}
