<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $users = factory(App\Models\Member::class, 2)->create();

        foreach ($users as $user) {
            factory(App\Models\Contact::class, 10)->create([
                'member_id' => $user->id
            ]);
                factory(App\Models\Story::class, 5)->create([
                    'member_id' => $user->id

                ]);
                factory(App\Models\Project::class, 2)->create([
                    'member_id' => $user->id
                ]);
        }
    }
}
