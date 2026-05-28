<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Vendor;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class VendorSeeder extends Seeder
{
    public function run(): void
    {
        $vendors = [
            [
                'name' => 'Spice Garden Catering',
                'email' => 'catering@eventease.demo',
                'vendor_type' => 'Caterer',
                'city' => 'Mumbai',
                'price' => 75000,
                'phone' => '9876500001',
                'description' => 'Premium wedding and corporate catering with live counters.',
            ],
            [
                'name' => 'BeatDrop DJs',
                'email' => 'dj@eventease.demo',
                'vendor_type' => 'DJ',
                'city' => 'Delhi',
                'price' => 35000,
                'phone' => '9876500002',
                'description' => 'Professional DJ and sound for parties and receptions.',
            ],
            [
                'name' => 'Lens & Light Studio',
                'email' => 'photo@eventease.demo',
                'vendor_type' => 'Photographer',
                'city' => 'Bangalore',
                'price' => 45000,
                'phone' => '9876500003',
                'description' => 'Candid photography and cinematic wedding films.',
            ],
            [
                'name' => 'Bloom Decor Co.',
                'email' => 'decor@eventease.demo',
                'vendor_type' => 'Decorator',
                'city' => 'Pune',
                'price' => 55000,
                'phone' => '9876500004',
                'description' => 'Stage decor, florals, and themed event styling.',
            ],
            [
                'name' => 'Grand Hall Venues',
                'email' => 'venue@eventease.demo',
                'vendor_type' => 'Venue',
                'city' => 'Hyderabad',
                'price' => 120000,
                'phone' => '9876500005',
                'description' => 'Banquet halls and lawns for 200–800 guests.',
            ],
            [
                'name' => 'Rhythm Live Band',
                'email' => 'band@eventease.demo',
                'vendor_type' => 'Music',
                'city' => 'Chennai',
                'price' => 40000,
                'phone' => '9876500006',
                'description' => 'Live band performances for weddings and corporate galas.',
            ],
        ];

        foreach ($vendors as $data) {
            $user = User::firstOrCreate(
                ['email' => $data['email']],
                [
                    'name' => $data['name'],
                    'password' => Hash::make('password'),
                    'role' => 'vendor',
                ]
            );

            Vendor::updateOrCreate(
                ['user_id' => $user->_id],
                [
                    'name' => $data['name'],
                    'vendor_type' => $data['vendor_type'],
                    'city' => $data['city'],
                    'price' => $data['price'],
                    'phone' => $data['phone'],
                    'description' => $data['description'],
                ]
            );
        }
    }
}
