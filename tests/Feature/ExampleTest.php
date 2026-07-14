<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    public function test_las_paginas_publicas_responden(): void
    {
        $this->get('/')->assertOk();
        $this->get('/sobre-mi')->assertOk();
        $this->get('/proyectos')->assertOk();
        $this->get('/contacto')->assertOk();
    }
}
