<?php

use Detective\Testing\Models\User;
use Detective\Database\Fields\Number;
use Detective\Filters\Operators\Less;
use Detective\Filters\Separators\Where;
use Detective\Filters\Operators\Equals;
use Detective\Filters\Operators\Greater;
use Detective\Filters\Separators\OrWhere;


class FilterFunctionsTest extends \Detective\Testing\TestCase
{
    public function testEquals()
    {
        $builder = User::query();

        $operator = new Equals(new Where($builder), new Number('id'), 1);

        $user = $operator->apply()->first();

        $this->assertTrue(!empty($user));
        $this->assertEquals($user->id, 1);
    }

    public function testGreaterLess()
    {
        $operator = new Greater(new Where(User::query()), new Number('id'), 50);
        $users = $operator->apply()->get();
        $this->assertEquals($users->count(), 50);

        $operator = new Less(new Where(User::query()), new Number('id'), 20);
        $users = $operator->apply()->get();
        $this->assertEquals($users->count(), 19);
    }

    public function testChainingGreaterAndLesser()
    {
        $builder = User::query();

        $group = collect([
            new Greater(new Where($builder), new Number('id'), 50),
            new Less(new Where($builder), new Number('id'), 70)
        ]);

        $group->each(function($operator) {
            $operator->apply();
        });

        $this->assertEquals($builder->count(), 19);
    }

    public function testChainingGreaterOrLesser()
    {
        $builder = User::query();

        $group = collect([
            new Greater(new Where($builder), new Number('id'), 70),
            new Less(new OrWhere($builder), new Number('id'), 10)
        ]);

        $group->each(function($operator) {
            $operator->apply();
        });

        $this->assertEquals($builder->count(), 39);
    }
}
