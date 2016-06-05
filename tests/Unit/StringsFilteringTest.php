<?php

// use Detective\Testing\Models\User;

// class StringsFilteringTest extends \Detective\Testing\TestCase
// {
//     public function testStringFirstLetterMatch()
//     {
//         $user = User::filter(['name' => 'd*'])->first();
//         $first_letter = strtolower(substr($user->name, 0, 1));

//         $this->assertTrue(get_class($user) == 'Detective\Testing\Models\User');
//         $this->assertTrue($first_letter === 'd');
//     }

//     public function testStringLastLetterMatch()
//     {
//         $user = User::filter(['name' => '*e'])->first();
//         $last_letter = strtolower(substr($user->name, -1));

//         $this->assertTrue(get_class($user) == 'Detective\Testing\Models\User');
//         $this->assertTrue($last_letter === 'e');
//     }

//     public function testStringFilteringReturnsCollection()
//     {
//         $users = User::filter(['name' => 'e*'])->get();

//         $class = get_class($users) == 'Illuminate\Database\Eloquent\Collection';
//     }

// }
