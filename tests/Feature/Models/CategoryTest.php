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


    public function testCreate()
    {
        $category = Category::create([
            'name' => 'test'
        ]);
        $category->refresh();

        $this->assertEquals(36, strlen($category->id)); 
        $this->assertEquals('test', $category->name);
        $this->assertNull($category->description);
        $this->assertTrue($category->is_active);

        $category = Category::create([
            'name' => 'test',
            'description' => null
        ]);
        $this->assertNull($category->description);

        $category = Category::create([
            'name' => 'test',
            'description' => 'test_description'
        ]);
        $this->assertEquals('test_description', $category->description);

        $category = Category::create([
            'name' => 'test',
            'is_active' => false
        ]);
        $this->assertFalse($category->is_active);
    }

    public function testUpdate()
    {
        $category = factory(Category::class)->create([
            'description' => 'test_description'
        ])->first();

        $data = [
            'name' => 'test_name',
            'description' => 'test_description_updated',
            'is_active' => false
        ];

        $category->update($data);

        foreach ($data as $key => $value) {
            $this->assertEquals($value, $category[$key]);
        }
    }

    public function testDelete()
    {
        $category = factory(Category::class)->create();
        $category->delete();

        $this->assertNull(Category::find($category->id));

        $category->restore();
        $this->assertNotNull(Category::find($category->id));
    }
}
