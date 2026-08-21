<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HealthTipSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('health_tips')->insert([
            [
                'title' => 'Pregnancy Care',
                'category' => 'Pregnancy Care',
                'description' => 'Learn how to care for yourself during pregnancy, including regular prenatal checkups, taking prescribed vitamins, eating healthy foods, staying active safely, getting enough rest, and avoiding harmful substances.',
                'image' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'title' => 'Nutrition During Pregnancy',
                'category' => 'Nutrition',
                'description' => 'Eat a variety of nutritious foods during pregnancy, including vegetables, fruits, protein-rich foods, whole grains, and foods rich in iron, calcium, and iodine. Drink enough water and follow your healthcare provider’s advice on supplements.',
                'image' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'title' => 'Danger Signs During Pregnancy',
                'category' => 'Danger Signs',
                'description' => 'Seek immediate medical attention for warning signs such as vaginal bleeding, severe headache or blurred vision, severe abdominal pain, high fever, difficulty breathing, reduced or absent baby movement, or leaking water.',
                'image' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'title' => 'Breastfeeding Guide',
                'category' => 'Breastfeeding',
                'description' => 'Breastfeeding provides important nutrients and protection for your baby. Learn proper positioning and attachment, breastfeed frequently, maintain good nutrition and hydration, and seek help from a healthcare provider when needed.',
                'image' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'title' => 'Preparing for Delivery',
                'category' => 'Preparing for Delivery',
                'description' => 'Prepare for delivery by knowing where to go, arranging transportation, preparing important documents and supplies, discussing your birth plan with your healthcare provider, and knowing when to seek help.',
                'image' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'title' => 'Newborn Care',
                'category' => 'Newborn Care',
                'description' => 'Learn the basics of caring for a newborn, including keeping the baby warm, practicing safe sleep, caring for the umbilical cord, watching for signs of illness, and keeping vaccinations and checkups up to date.',
                'image' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}