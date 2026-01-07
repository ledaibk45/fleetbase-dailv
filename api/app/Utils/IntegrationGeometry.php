<?php

namespace App\Utils;

/**
 * IntegrationGeometry - Utility class for calculating geometric volumes using calculus integration methods.
 * 
 * This class demonstrates how to calculate volumes using integration rather than direct formulas.
 * For a cylinder, the volume is calculated by integrating the cross-sectional area along the height.
 */
class IntegrationGeometry
{
    /**
     * Calculate cylinder volume using integration method.
     * 
     * The cylinder volume is calculated using the integral:
     * V = ∫₀ʰ A(z) dz where A(z) = π × r²
     * 
     * Since the cross-sectional area is constant for a cylinder:
     * V = ∫₀ʰ π × r² dz = π × r² × z |₀ʰ = π × r² × h
     * 
     * @param float $radius Radius of the cylinder (in cm)
     * @param float $height Height of the cylinder (in cm)
     * @param int $steps Number of integration steps (default: 1000 for higher accuracy)
     * @return array ['volume' => float, 'steps' => array, 'formula' => string]
     */
    public static function calculateCylinderVolumeByIntegration(float $radius, float $height, int $steps = 1000): array
    {
        // Using Riemann sum to approximate the integral
        // Δz = h / n where n is number of steps
        $deltaZ = $height / $steps;
        $volume = 0;
        
        $integrationSteps = [];
        
        // Calculate the cross-sectional area (constant for cylinder)
        $crossSectionalArea = pi() * pow($radius, 2);
        
        // Calculate middle step once to avoid repeated computation
        $middleStep = intval($steps / 2);
        
        // Numerical integration using Riemann sum (midpoint rule)
        for ($i = 0; $i < $steps; $i++) {
            // z position at the middle of each interval
            $z = ($i + 0.5) * $deltaZ;
            
            // For a cylinder, A(z) = π × r² is constant
            $areaAtZ = $crossSectionalArea;
            
            // Add the volume of this thin slice
            $sliceVolume = $areaAtZ * $deltaZ;
            $volume += $sliceVolume;
            
            // Store some sample steps for demonstration (first, middle, last)
            // Note: cumulative_volume shows the actual accumulated volume at these specific steps
            if ($i === 0 || $i === $middleStep || $i === $steps - 1) {
                $integrationSteps[] = [
                    'step' => $i + 1,
                    'z_position' => round($z, 4),
                    'cross_sectional_area' => round($areaAtZ, 4),
                    'slice_volume' => round($sliceVolume, 6),
                    'cumulative_volume' => round($volume, 4),
                    'progress_percentage' => round((($i + 1) / $steps) * 100, 2)
                ];
            }
        }
        
        return [
            'volume' => round($volume, 4),
            'formula' => 'V = ∫₀ʰ π×r² dz = π×r²×h',
            'exact_formula_result' => round(pi() * pow($radius, 2) * $height, 4),
            'integration_method' => 'Riemann Sum (Midpoint Rule)',
            'number_of_steps' => $steps,
            'delta_z' => round($deltaZ, 6),
            'sample_steps' => $integrationSteps,
            'radius' => $radius,
            'height' => $height,
            'cross_sectional_area' => round($crossSectionalArea, 4)
        ];
    }
    
    /**
     * Calculate cylinder volume using definite integral (analytical solution).
     * 
     * This method shows the analytical integration process step by step:
     * V = ∫₀ʰ π×r² dz
     * V = π×r² ∫₀ʰ dz
     * V = π×r² × [z]₀ʰ
     * V = π×r² × (h - 0)
     * V = π×r² × h
     * 
     * @param float $radius Radius of the cylinder (in cm)
     * @param float $height Height of the cylinder (in cm)
     * @return array ['volume' => float, 'integration_steps' => array]
     */
    public static function calculateCylinderVolumeAnalytical(float $radius, float $height): array
    {
        $crossSectionalArea = pi() * pow($radius, 2);
        $volume = $crossSectionalArea * $height;
        
        return [
            'volume' => round($volume, 4),
            'method' => 'Analytical Integration',
            'integration_steps' => [
                'step_1' => [
                    'description' => 'Setup definite integral',
                    'formula' => 'V = ∫₀ʰ π×r² dz',
                    'values' => [
                        'r' => $radius,
                        'h' => $height,
                        'limits' => '[0, ' . $height . ']'
                    ]
                ],
                'step_2' => [
                    'description' => 'Factor out constants',
                    'formula' => 'V = π×r² ∫₀ʰ dz',
                    'constant' => 'π×r² = ' . round($crossSectionalArea, 4)
                ],
                'step_3' => [
                    'description' => 'Integrate with respect to z',
                    'formula' => 'V = π×r² × [z]₀ʰ',
                    'antiderivative' => 'z'
                ],
                'step_4' => [
                    'description' => 'Apply limits of integration',
                    'formula' => 'V = π×r² × (h - 0)',
                    'upper_limit' => $height,
                    'lower_limit' => 0
                ],
                'step_5' => [
                    'description' => 'Final result',
                    'formula' => 'V = π×r²×h',
                    'calculation' => round($crossSectionalArea, 4) . ' × ' . $height . ' = ' . round($volume, 4) . ' cm³'
                ]
            ],
            'radius' => $radius,
            'height' => $height
        ];
    }
}
