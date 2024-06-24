<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GroupTherapistSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $groups = [

            [
                'id' => 1,
                'user_id' => 14,
                'title' => 'Сareer growth',
                'desc' => 'Group psychotherapy sets the followigoals:Identification and solution of psychological problems in each patient.Changing behavioral patterns in the direction of improving and expanding communication capabilities, social adaptation and the effectiveness of communication with other people.Disclosure and realization of the personal potential of the group members, increase of working capacity and promotion of career growth. Elimination of negative symptoms, formation of a positive life position and improvement of the general psychological background.',
                'date' => '2023-05-16',
                'seats' => 10,
                'start_time' => '20:00',
                'finish_time' => '21:00'
            ],
            [
                'id' => 2,
                'user_id' => 14,
                'title' => 'Psychotherapeutic practice',
                'desc' => 'Disclosure and realization of the personal potential of the group members, increase of working capacity and promotion of career growth.',
                'date' => '2023-05-16',
                'seats' => 10,
                'start_time' => '17:00',
                'finish_time' => '20:00'
            ],
            [
                'id' => 3,
                'user_id' => 15,
                'title' => 'Сareer growth',
                'desc' => 'Group psychotherapy sets the followigoals:Identification and solution of psychological problems in each patient.Changing behavioral patterns in the direction of improving and expanding communication capabilities, social adaptation and the effectiveness of communication with other people.Disclosure and realization of the personal potential of the group members, increase of working capacity and promotion of career growth. Elimination of negative symptoms, formation of a positive life position and improvement of the general psychological background.',
                'date' => '2023-05-16',
                'seats' => 10,
                'start_time' => '20:00',
                'finish_time' => '21:00'
            ],
            [
                'id' => 4,
                'user_id' => 15,
                'title' => 'Psychotherapeutic practice',
                'desc' => 'Disclosure and realization of the personal potential of the group members, increase of working capacity and promotion of career growth.',
                'date' => '2023-05-16',
                'seats' => 10,
                'start_time' => '17:00',
                'finish_time' => '20:00'
            ],
        ];

        DB::table('group_therapists')->insert($groups);
    }
}
