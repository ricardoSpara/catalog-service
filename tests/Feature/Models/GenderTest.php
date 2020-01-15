<?php

namespace Tests\Feature\Models;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\Models\Gender;

class GenderTest extends TestCase
{
    use DatabaseMigrations;
    
    public function testList()
    {
        factory(Gender::class, 1)->create();

        $genders = Gender::all();
        $genderKeys = array_keys($genders->first()->getAttributes());

        $this->assertCount(1, $genders);
        $this->assertEqualsCanonicalizing([
            'name', 'is_active', 'id', 'deleted_at', 'created_at', 'updated_at'
        ], $genderKeys);
    }


    public function testCreate()
    {
        $gender = Gender::create([
            'name' => 'test'
        ]);
        $gender->refresh();

        $this->assertEquals(36, strlen($gender->id)); 
        $this->assertEquals('test', $gender->name);
        $this->assertTrue($gender->is_active);

        $gender = Gender::create([
            'name' => 'test',
            'is_active' => false
        ]);
        $this->assertFalse($gender->is_active);
    }

    public function testUpdate()
    {
        $gender = factory(Gender::class)->create();

        $data = [
            'name' => 'test_name',
            'is_active' => false
        ];

        $gender->update($data);

        foreach ($data as $key => $value) {
            $this->assertEquals($value, $gender[$key]);
        }
    }

    public function testDelete()
    {
        $gender = factory(Gender::class)->create();
        $gender->delete();

        $this->assertNull(Gender::find($gender->id));

        $gender->restore();
        $this->assertNotNull(Gender::find($gender->id));
    }
}
