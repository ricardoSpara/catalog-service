<?php

namespace Tests\Feature\Models;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\Models\Category;

class CategoryTest extends TestCase
{
    use DatabaseMigrations;
    
    public function testList()
    {
        factory(Category::class, 1)->create();

        $categories = Category::all();
        $categoryKeys = array_keys($categories->first()->getAttributes());

        $this->assertCount(1, $categories);
        
        $this->assertEqualsCanonicalizing([
            'name', 'description', 'is_active', 'id', 'deleted_at', 'created_at', 'updated_at'
        ], $categoryKeys);

    }
}
