# Example: Cylinder Volume Calculation Using Integration

## Quick Test

Run the test script directly:

```bash
php test_integration.php
```

## Using the Artisan Command

Once composer dependencies are installed, you can use the Laravel Artisan command:

```bash
cd api

# Default: r=2cm, h=10cm, both methods
php artisan geometry:cylinder-volume-integration

# Custom values
php artisan geometry:cylinder-volume-integration 5 15

# Only numerical method with custom steps
php artisan geometry:cylinder-volume-integration 2 10 --method=numerical --steps=10000

# Only analytical method
php artisan geometry:cylinder-volume-integration --method=analytical
```

## Using in PHP Code

### Numerical Integration (Riemann Sum)

```php
use App\Utils\IntegrationGeometry;

$result = IntegrationGeometry::calculateCylinderVolumeByIntegration(
    radius: 2,
    height: 10,
    steps: 1000
);

// Output:
// Array(
//     'volume' => 125.6637,
//     'formula' => 'V = ∫₀ʰ π×r² dz = π×r²×h',
//     'integration_method' => 'Riemann Sum (Midpoint Rule)',
//     'number_of_steps' => 1000,
//     'sample_steps' => [...]
// )
```

### Analytical Integration (Step-by-Step)

```php
use App\Utils\IntegrationGeometry;

$result = IntegrationGeometry::calculateCylinderVolumeAnalytical(
    radius: 2,
    height: 10
);

// Output:
// Array(
//     'volume' => 125.6637,
//     'method' => 'Analytical Integration',
//     'integration_steps' => [
//         'step_1' => [
//             'description' => 'Setup definite integral',
//             'formula' => 'V = ∫₀ʰ π×r² dz',
//             ...
//         ],
//         ...
//     ]
// )
```

## Output Example

```
═══════════════════════════════════════════════════════════════
  TÍNH THỂ TÍCH HÌNH TRỤ BẰNG PHƯƠNG PHÁP TÍCH PHÂN
  CYLINDER VOLUME CALCULATION USING INTEGRATION METHOD
═══════════════════════════════════════════════════════════════

📐 Thông số đầu vào / Input Parameters:
   • Bán kính (Radius): 2 cm
   • Chiều cao (Height): 10 cm

─────────────────────────────────────────────────────────────
  1️⃣  PHƯƠNG PHÁP TÍCH PHÂN SỐ (NUMERICAL INTEGRATION)
─────────────────────────────────────────────────────────────

🧮 Phương pháp: Riemann Sum (Midpoint Rule)
📊 Công thức: V = ∫₀ʰ π×r² dz = π×r²×h
🔢 Số bước tích phân: 1000 steps
📏 Độ dày mỗi lát cắt (Δz): 0.01 cm
⭕ Diện tích mặt cắt ngang: 12.5664 cm²

✅ KẾT QUẢ / RESULT:
   Thể tích (Numerical Integration): 125.6637 cm³
   Thể tích (Công thức trực tiếp): 125.6637 cm³
   Sai số: 0 cm³

─────────────────────────────────────────────────────────────
  2️⃣  PHƯƠNG PHÁP TÍCH PHÂN GIẢI TÍCH (ANALYTICAL INTEGRATION)
─────────────────────────────────────────────────────────────

📐 Các bước giải tích phân / Integration Steps:

  1. Setup definite integral
      → V = ∫₀ʰ π×r² dz
  2. Factor out constants
      → V = π×r² ∫₀ʰ dz
  3. Integrate with respect to z
      → V = π×r² × [z]₀ʰ
  4. Apply limits of integration
      → V = π×r² × (h - 0)
  5. Final result
      → V = π×r²×h
      → 12.5664 × 10 = 125.6637 cm³

✅ KẾT QUẢ / RESULT:
   Thể tích (Analytical Integration): 125.6637 cm³
```

## Educational Value

This implementation demonstrates:

1. **Two Integration Approaches:**
   - **Numerical (Riemann Sum):** Approximates the integral by summing thin slices
   - **Analytical:** Shows the mathematical steps of solving the definite integral

2. **Key Concepts:**
   - Definite integrals for volume calculation
   - Riemann sum approximation
   - Cross-sectional area integration
   - Vietnamese/English bilingual explanations

3. **Practical Application:**
   - Can be extended to more complex shapes (cones, spheres)
   - Foundation for understanding calculus in geometry
   - Demonstrates accuracy of numerical methods

## See Also

- [INTEGRATION_METHOD.md](INTEGRATION_METHOD.md) - Full documentation in Vietnamese and English
- `api/app/Utils/IntegrationGeometry.php` - Core implementation
- `api/app/Console/Commands/CalculateCylinderVolumeIntegration.php` - Command-line interface
