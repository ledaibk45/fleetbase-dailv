<?php

namespace Tests\Unit;

use App\Utils\Geometry;
use PHPUnit\Framework\TestCase;

class GeometryTest extends TestCase
{
    /**
     * Test cylinder volume calculation with given parameters (r=2cm, h=10cm)
     *
     * @return void
     */
    public function test_calculate_cylinder_volume_with_given_parameters()
    {
        $radius = 2;
        $height = 10;
        $expectedVolume = pi() * 4 * 10; // π × 2² × 10 = 40π ≈ 125.66
        
        $volume = Geometry::calculateCylinderVolume($radius, $height);
        
        $this->assertEquals($expectedVolume, $volume);
        $this->assertEqualsWithDelta(125.66, $volume, 0.01);
    }

    /**
     * Test cylinder volume calculation with different values
     *
     * @return void
     */
    public function test_calculate_cylinder_volume_with_different_values()
    {
        // Test with radius=1, height=1
        $volume = Geometry::calculateCylinderVolume(1, 1);
        $this->assertEqualsWithDelta(3.14159, $volume, 0.001);
        
        // Test with radius=5, height=3
        $volume = Geometry::calculateCylinderVolume(5, 3);
        $expectedVolume = pi() * 25 * 3; // π × 25 × 3
        $this->assertEquals($expectedVolume, $volume);
    }

    /**
     * Test cylinder volume calculation with decimal values
     *
     * @return void
     */
    public function test_calculate_cylinder_volume_with_decimal_values()
    {
        $radius = 2.5;
        $height = 7.5;
        $expectedVolume = pi() * pow(2.5, 2) * 7.5;
        
        $volume = Geometry::calculateCylinderVolume($radius, $height);
        
        $this->assertEquals($expectedVolume, $volume);
    }

    /**
     * Test cylinder volume calculation with zero height
     *
     * @return void
     */
    public function test_calculate_cylinder_volume_with_zero_height()
    {
        $volume = Geometry::calculateCylinderVolume(5, 0);
        $this->assertEquals(0, $volume);
    }

    /**
     * Test cylinder volume calculation with zero radius
     *
     * @return void
     */
    public function test_calculate_cylinder_volume_with_zero_radius()
    {
        $volume = Geometry::calculateCylinderVolume(0, 10);
        $this->assertEquals(0, $volume);
    }
}
