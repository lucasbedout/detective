<?php

use Detective\Testing\Models\User;

class UsersTest extends \Detective\Testing\TestCase
{
    public function testGet()
    {
        $user = User::filter(['name' => 'D*'])->first();

        dd($user);
    }
}
