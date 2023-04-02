<?php

namespace Database\Seeders;

use App\Models\Doctor;
use App\Models\Pharmacy;
use App\Models\Area;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DoctorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Area::factory(2)->create()->each(function($area){
        Pharmacy::factory(2)->create(['area_id'=>$area->id,])->each(function ($pharmacy) {
        Doctor::factory(2)->create([
            'pharmacy_id'=> $pharmacy->id,
        ])->each(function($doctor){
            $user= $doctor->type()->create([
                'name' => fake()->name(),
                'email' => fake()->unique()->safeEmail(),
                'email_verified_at' => now(),
                'password' => '123456', // password
                'remember_token' => Str::random(10),
            ]);
    
            $user->assignRole('doctor'); 
        });
    });
    });
    }
}
