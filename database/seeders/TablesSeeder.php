<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\Doctor;
use App\Models\Pharmacy;
use App\Models\Area;
use App\Models\Client;
use App\Models\Order;
use Faker\Core\Number;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\Models\Medicine;
use App\Models\PharmaciesMedicines;

class TablesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Client::factory(2)->create()->each(function ($client){
            $user= $client->type()->create([
                'name' => fake()->name(),
                'email' => fake()->unique()->safeEmail(),
                'email_verified_at' => now(),
                'password' => Hash::make('123456'), // password
                'remember_token' => Str::random(10),
            ]);
            $user->assignRole('client');
            $areas= Area::factory(2)->create()->each(function($area){
                Pharmacy::factory(2)->create(['area_id'=>$area->id,])->each(function ($pharmacy) {
                    $user= $pharmacy->type()->create([
                        'name' => fake()->lastName(),
                        'email' => fake()->unique()->safeEmail(),
                        'email_verified_at' => now(),
                        'password' => Hash::make('123456'), // password
                        'remember_token' => Str::random(10),
                    ]);
                    $user->assignRole('pharmacy'); 
                    Doctor::factory(2)->create([
                        'pharmacy_id'=> $pharmacy->id,
                    ])->each(function($doctor){
                        $user= $doctor->type()->create([
                            'name' => fake()->name(),
                            'email' => fake()->unique()->safeEmail(),
                            'email_verified_at' => now(),
                            'password' => Hash::make('123456'), // password
                            'remember_token' => Str::random(10),
                        ]);
                
                        $user->assignRole('doctor'); 
                    });
                });
            });
            foreach($areas as $area) {
            $addresses=Address::factory(2)->create([
                    'client_id'=>$client->id,
                    'area_id'=>$area->id,
                ]);
                foreach($addresses as $address){
                    Order::factory(1)->create([
                        'address_id'=>$address->id,
                        'client_id'=>$client->id,
                    ]);
                }
            }
        });

            Medicine::create([
                'name' => 'Aspirin',
                'type' => 'tablet',
            ],
            [
                'name' => 'Panadol',
                'type' => 'tablet',
            ],
            [
                'name' => 'Antinal',
                'type' => 'tablet',
            ],
            [
                'name' => 'Brofin',
                'type' => 'drink',
            ]);
    }
    
}
