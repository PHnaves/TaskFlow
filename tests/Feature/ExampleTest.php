<?php

namespace Tests\Feature;

use Tests\TestCase;

class ExampleTest extends TestCase
{
    public function test_root_redirects_to_tasks(): void
    {
        $this->get('/')->assertRedirect('/tasks');
    }
}
