<?php

namespace App\Utils;

class Geometry
{
    /**
     * Calculate the volume of a cylinder
     * Formula: V = π × r² × h
     *
     * @param float $radius The radius of the cylinder base in cm
     * @param float $height The height of the cylinder in cm
     * @return float The volume in cubic cm
     */
    public static function calculateCylinderVolume(float $radius, float $height): float
    {
        return pi() * pow($radius, 2) * $height;
    }
}
