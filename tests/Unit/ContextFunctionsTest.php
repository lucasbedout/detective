<?php

use Detective\Testing\Models\User;

class ContextFunctionsTest extends \Detective\Testing\TestCase
{
    public function testGetModelFields()
    {
        $user = new User;

        $user->fields();
    }

    /*
    public function testGetModelBasicRelation()
    {
        $user = new User;

        $relations = $user->relations();
        $posts_relation = $relations->get(0);

        $this->assertTrue(
            get_class($posts_relation) == 'Detective\Database\Relations\BasicRelation'
        );

        $this->assertEquals($posts_relation->foreign_key, 'posts.user_id');
        $this->assertEquals($posts_relation->primary_key, 'id');
        $this->assertEquals($posts_relation->model, 'Detective\Testing\Models\User');
        $this->assertEquals($posts_relation->related_model, 'Detective\Testing\Models\Post');
    }

    public function testGetModelManyToManyRelation()
    {
        $user = new User;

        $relations = $user->relations();
        $reads_relation = $relations->get(1);

        $this->assertTrue(
            get_class($reads_relation) == 'Detective\Database\Relations\ManyToManyRelation'
        );

        $this->assertEquals($reads_relation->pivot_foreign_key, 'reads.user_id');
        $this->assertEquals($reads_relation->pivot_other_key, 'reads.post_id');
        $this->assertEquals($reads_relation->primary_key, 'id');
        $this->assertEquals($reads_relation->model, 'Detective\Testing\Models\User');
        $this->assertEquals($reads_relation->related_model, 'Detective\Testing\Models\Post');
    }

    */

}
