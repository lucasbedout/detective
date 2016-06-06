<?php

use Detective\Testing\Models\User;

use Detective\Database\Relations\BasicRelation;
use Detective\Database\Relations\ManyToManyRelation;

use Detective\Database\Fields\Text;
use Detective\Database\Fields\Number;
use Detective\Database\Fields\DateTime;

use Detective\Filters\Operators\In;
use Detective\Filters\Operators\Less;
use Detective\Filters\Operators\Like;
use Detective\Filters\Operators\NotIn;
use Detective\Filters\Operators\Equals;
use Detective\Filters\Operators\IsNull;
use Detective\Filters\Operators\NotLike;
use Detective\Filters\Operators\Greater;
use Detective\Filters\Operators\NotNull;
use Detective\Filters\Operators\Between;
use Detective\Filters\Operators\Different;
use Detective\Filters\Operators\NotBetween;

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

    public function testDifferent()
    {
        $builder = User::query();

        $operator = new Different(new Where($builder), new Number('id'), 1);

        $user = $operator->apply()->first();

        $this->assertTrue(!empty($user));
        $this->assertEquals($user->id, 2);
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

    public function testNull()
    {
        $operator = new IsNull(new Where(User::query()), new Text('email'));
        $users = $operator->apply()->get();
        $this->assertTrue($users->isEmpty());
    }

    public function testNotNull()
    {
        $operator = new NotNull(new Where(User::query()), new Text('email'));
        $users = $operator->apply()->get();
        $this->assertEquals($users->count(), 100);
    }

    public function testLike()
    {
        $operator = new Like(new Where(User::query()), new Text('name'), 'd%');
        $users = $operator->apply()->get();
        
        $users->each(function($user) {
            $f_name_letter = strtolower(substr($user->name, 0, 1));
            $this->assertEquals($f_name_letter, 'd');
        });
    }

    public function testNotLike()
    {
        $operator = new NotLike(new Where(User::query()), new Text('name'), 'd%');
        $users = $operator->apply()->get();
        
        $users->each(function($user) {
            $f_name_letter = strtolower(substr($user->name, 0, 1));
            $this->assertNotEquals($f_name_letter, 'd');
        });
    }

    public function testBetween()
    {
        $operator = new Between(new Where(User::query()), new Number('id'), 10, 20);
        $users = $operator->apply()->get();
        
        $users->each(function($user) {
            $this->assertTrue($user->id >= 10 && $user->id <= 20);
        });
    }

    public function testNotBetween()
    {
        $operator = new NotBetween(new Where(User::query()), new Number('id'), 10, 90);
        $users = $operator->apply()->get();
        
        $users->each(function($user) {
            $this->assertTrue($user->id < 10 || $user->id > 90);
        });
    }

    public function testIn()
    {
        $ids = [1, 3, 8];

        $operator = new In(new Where(User::query()), new Number('id'), $ids);
        $users = $operator->apply()->get();
        
        $users->each(function($user) use ($ids) {
            $this->assertTrue(in_array($user->id, $ids));
        });
    }

    public function testNotIn()
    {
        $ids = range(10, 80);

        $operator = new NotIn(new Where(User::query()), new Number('id'), $ids);
        $users = $operator->apply()->get();
        
        $users->each(function($user) use ($ids) {
            $this->assertFalse(in_array($user->id, $ids));
        });
    }

    public function testChainingInAndBetweenWithRelation()
    {
        $builder = User::query();

        $relation = new BasicRelation('posts', (new User)->posts());

        $group = collect([
            new In(new WhereHas($builder, $relation), new Number('posts.id'), range(30, 80)),
            new Between(new WhereHas($builder, $relation), new Number('posts.id'), 45, 65),
        ]);

        $group->each(function($operator) {
            $operator->apply();
        });

        $users = $builder->get();

        $users->each(function($user) {
            $filtered = $user->posts->filter(function($post) {
                return in_array($post->id, range(45, 65));
            });

            $this->assertTrue($filtered->count() > 0);
        });
    }
}
