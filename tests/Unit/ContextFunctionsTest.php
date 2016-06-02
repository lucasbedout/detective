<?php

use Detective\Testing\Models\User;

class ContextFunctionsTest extends \Detective\Testing\TestCase
{
    public function testGetModelRelations()
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

}
