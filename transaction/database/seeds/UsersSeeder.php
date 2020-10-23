<?php

use App\User;
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i=0; $i < 1000; $i++) {
            factory(User::class, 1000)
                ->create();
        }


        /*$users = factory(User::class, 100)->make();
        $chunks = $users->chunk(10);
        $chunks->each(function ($chunk) {
            User::insert($chunk->toArray());
        });*/
    }
}
