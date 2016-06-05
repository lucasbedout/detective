<?php

use Detective\Testing\Models\User;
use Detective\Database\Fields\Number;
use Detective\Database\Relations\BasicRelation;
use Detective\Database\Relations\ManyToManyRelation;

use Detective\Filters\Operators\Less;
use Detective\Filters\Operators\Equals;
use Detective\Filters\Operators\Greater;

use Detective\Filters\Separators\Where;
use Detective\Filters\Separators\OrWhere;
use Detective\Filters\Separators\WhereHas;
use Detective\Filters\Separators\OrWhereHas;


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

    public function testBasicWhereHasLess()
    {
        $relation = new BasicRelation('posts', (new User)->posts());

        $operator = new Less(new WhereHas(User::query(), $relation), new Number('id'), 10);

        $users = $operator->apply()->get();

        $this->assertEquals(get_class($users->get(0)), 'Detective\Testing\Models\User');

        $users->each(function($user) {
            $filtered = $user->posts->filter(function($post) {
                return $post->id < 10;
            });

            $this->assertTrue($filtered->count() > 0);
        });
    }

    public function testManyToManyWhereHasGreat()
    {
        $relation = new ManyToManyRelation('reads', (new User)->reads());

        $operator = new Greater(new WhereHas(User::query(), $relation), new Number($relation->primary_key), 50);

        $users = $operator->apply()->get();

        $this->assertEquals(get_class($users->get(0)), 'Detective\Testing\Models\User');

        $users->each(function($user) {
            $filtered = $user->reads->filter(function($post) {
                return $post->id > 50;
            });

            $this->assertTrue($filtered->count() > 0);
        });
    }

    public function testOrWhereHasGreaterOrLesser()
    {
        $builder = User::query();

        $relation = new BasicRelation('posts', (new User)->posts());

        $group = collect([
            new Greater(new WhereHas($builder, $relation), new Number($relation->primary_key), 90),
            new Less(new OrWhereHas($builder, $relation), new Number($relation->primary_key), 10)
        ]);

        $group->each(function($operator) {
            $operator->apply();
        });

        $users = $builder->get();

        $users->each(function($user) {
            $filtered = $user->posts->filter(function($post) {
                return $post->id < 10 || $post->id > 90;
            });

            $this->assertTrue($filtered->count() > 0);
        });
    }
}
