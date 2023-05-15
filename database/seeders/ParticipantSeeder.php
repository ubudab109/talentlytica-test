<?php

namespace Database\Seeders;

use App\Services\ParticipantService;
use Illuminate\Database\Seeder;

class ParticipantSeeder extends Seeder
{

    private $services;

    public function __construct(ParticipantService $services)
    {
        $this->services = $services;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [];

        for ($i = 0; $i < 300; $i++) {
            $data[] = [
                'fullname' => 'Participant'.$i,
                'email'    => 'participant'.$i.'@mail.com',
                'x'        => rand(1, 33),
                'y'        => rand(1, 23),
                'w'        => rand(1, 18),
                'z'        => rand(1, 13),
            ];
            
        }

        foreach ($data as $participant) {
            $this->services->createParticipant($participant);
        }
    }
}
