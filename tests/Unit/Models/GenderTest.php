<?php

namespace Tests\Unit\Models;

use PHPUnit\Framework\TestCase;
use App\Models\Gender;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Traits\Uuid;

class GenderTest extends TestCase
{

    private $gender;

    protected function setUp(): void
    {
        parent::setUp();
        $this->gender = new Gender();
    }

    protected function tearDown(): void
    {
        parent::tearDown();
    }

    public function testFillableAttribute()
    {
        $fillable = ['name', 'is_active'];
        $this->assertEquals($fillable, $this->gender->getFillable());
    }

    public function testIfUseTraits()
    {
        $traits = [
            SoftDeletes::class, Uuid::class
        ];   
        $genderTraits = array_keys(class_uses(Gender::class));
        $this->assertEquals($traits, $genderTraits);
    }

    public function testDatesAttribute()
    {
        $dates = ['deleted_at', 'created_at', 'updated_at']; 
        $datesGender = $this->gender->getDates();

        foreach ($dates as $date) {
            $this->assertContains($date, $datesGender);
        }  

        $this->assertCount(count($dates), $datesGender);
    }

    public function testCastsAttribute()
    {
        $casts = [
            'id' => 'string',
            'is_active' => 'boolean',
        ];   
        $this->assertEquals($casts, $this->gender->getCasts());
    }

    public function testIncrementingAttribute()
    {
        $this->assertFalse($this->gender->incrementing);
    }
}
