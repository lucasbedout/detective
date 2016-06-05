<?php

use Detective\Testing\Models\User;
use Detective\Database\Fields\Number;
use Detective\Filters\Separators\Where;
use Detective\Filters\Operators\Equals;
use Detective\Filters\Operators\Greater;
use Detective\Filters\Operators\Less;

class FilterFunctionsTest extends \Detective\Testing\TestCase
{
    public function testAndEquals()
    {
        $builder = User::query();

        $operator = new Equals(new Where($builder), new Number('id'), 1);

        $user = $operator->apply()->first();

        $this->assertTrue(!empty($user));
        $this->assertEquals($user->id, 1);
    }

    public function testAndGreaterLess()
    {
        $operator = new Greater(new Where(User::query()), new Number('id'), 50);
        $users = $operator->apply()->get();
        $this->assertEquals($users->count(), 50);

        $operator = new Less(new Where(User::query()), new Number('id'), 20);
        $users = $operator->apply()->get();
        $this->assertEquals($users->count(), 19);
    }
}
