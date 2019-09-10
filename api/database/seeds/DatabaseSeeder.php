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
        $users = factory(App\Models\User::class, 2)->create();
    
        foreach ($users as $user) {
            factory(App\Models\Contact::class, 10)->create([
                'user_id' => $user->id
            ]);
                factory(App\Models\Book::class, 5)->create([
                    'user_id' => $user->id
                
                ]);
                factory(App\Models\Project::class, 2)->create([
                    'user_id' => $user->id
                ]);
        }
    }
}
