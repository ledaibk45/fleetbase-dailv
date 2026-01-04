# Cylinder Volume Calculator

## Overview
This feature adds a mathematical utility to calculate the volume of a cylinder. It includes a utility class, comprehensive tests, and a console command for easy use.

## Problem Statement
Calculate the volume of a cylinder with:
- Radius (bán kính): 2 cm
- Height (chiều cao): 10 cm

## Solution
The volume of a cylinder is calculated using the formula:
```
V = π × r² × h
```

For the given parameters:
```
V = π × (2)² × 10
V = π × 4 × 10
V ≈ 125.66 cm³
```

## Usage

### Console Command
Run the calculation from the command line:

```bash
# Using default values (r=2cm, h=10cm)
php artisan geometry:cylinder-volume

# Using custom values
php artisan geometry:cylinder-volume {radius} {height}

# Example with radius=5cm and height=3cm
php artisan geometry:cylinder-volume 5 3
```

### Programmatic Usage
Use the `Geometry` utility class in your code:

```php
use App\Utils\Geometry;

// Calculate volume
$volume = Geometry::calculateCylinderVolume(2, 10);
echo "Volume: " . $volume . " cm³"; // Output: Volume: 125.6637061435917 cm³
```

## Files Added

1. **Utility Class**: `api/app/Utils/Geometry.php`
   - Contains the `calculateCylinderVolume()` static method
   - Formula: V = π × r² × h

2. **Unit Tests**: `api/tests/Unit/GeometryTest.php`
   - Comprehensive test coverage including:
     - Default parameters test (r=2, h=10)
     - Different values
     - Decimal values
     - Edge cases (zero radius, zero height)

3. **Console Command**: `api/app/Console/Commands/CalculateCylinderVolume.php`
   - Interactive command-line tool
   - Supports custom parameters
   - Displays calculation steps in both Vietnamese and English

4. **Documentation**: `CYLINDER_VOLUME.md` (this file)

## Running Tests

```bash
cd api
./vendor/bin/phpunit tests/Unit/GeometryTest.php
```

All tests should pass with 5 tests and 7 assertions.

## Example Output

```
============================================
Tính thể tích hình trụ (Cylinder Volume)
============================================
Bán kính (Radius): 2 cm
Chiều cao (Height): 10 cm
--------------------------------------------
Công thức (Formula): V = π × r² × h
V = π × (2)² × 10
V = π × 4 × 10
--------------------------------------------
Thể tích (Volume): 125.66 cm³
Volume: 125.6637 cm³
============================================
```
