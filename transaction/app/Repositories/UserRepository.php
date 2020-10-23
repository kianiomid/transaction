<?php

namespace App\Repositories;

use App\User;
use Illuminate\Container\Container as Application;


class UserRepository extends BaseRepository
{

    /**
     * @param Application $app
     * @param null $entityManager
     * @return UserRepository
     */
    public static function createInstance(Application $app, $entityManager = null)
    {
        return new UserRepository($app, new User(), $entityManager);
    }

    /**
     * @param $query
     * @return array
     */
    public function getForAutocomplete($query)
    {

        $res = $this->model
            ->where('name', "like", "%" . $query . '%')
            ->limit(10)
            ->get();

        $ret = [];
        foreach ($res as $item) {
            $ret[] = [
                'id' => $item->id,
                'text' => $item->name
            ];
        }

        return $ret;
    }
}