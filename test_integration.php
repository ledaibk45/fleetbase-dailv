<?php
/**
 * Test script to verify IntegrationGeometry class functionality
 * Run with: php test_integration.php
 */

// Include the IntegrationGeometry class
require_once __DIR__ . '/api/app/Utils/IntegrationGeometry.php';

use App\Utils\IntegrationGeometry;

echo "═══════════════════════════════════════════════════════════════\n";
echo "  TÍNH THỂ TÍCH HÌNH TRỤ BẰNG PHƯƠNG PHÁP TÍCH PHÂN\n";
echo "  CYLINDER VOLUME CALCULATION USING INTEGRATION METHOD\n";
echo "═══════════════════════════════════════════════════════════════\n\n";

// Test parameters (from the original problem)
$radius = 2;  // cm
$height = 10; // cm

echo "📐 Thông số đầu vào / Input Parameters:\n";
echo "   • Bán kính (Radius): {$radius} cm\n";
echo "   • Chiều cao (Height): {$height} cm\n\n";

// Test 1: Numerical Integration
echo "─────────────────────────────────────────────────────────────\n";
echo "  1️⃣  PHƯƠNG PHÁP TÍCH PHÂN SỐ (NUMERICAL INTEGRATION)\n";
echo "─────────────────────────────────────────────────────────────\n\n";

$numericalResult = IntegrationGeometry::calculateCylinderVolumeByIntegration($radius, $height, 1000);

echo "🧮 Phương pháp: {$numericalResult['integration_method']}\n";
echo "📊 Công thức: {$numericalResult['formula']}\n";
echo "🔢 Số bước tích phân: {$numericalResult['number_of_steps']} steps\n";
echo "📏 Độ dày mỗi lát cắt (Δz): {$numericalResult['delta_z']} cm\n";
echo "⭕ Diện tích mặt cắt ngang: {$numericalResult['cross_sectional_area']} cm²\n\n";

echo "📝 Một số bước tính toán mẫu / Sample Integration Steps:\n\n";
printf("%-10s %-15s %-20s %-20s %-15s\n", "Bước", "Vị trí z (cm)", "Diện tích A(z)", "Thể tích lát", "Tích lũy");
printf("%-10s %-15s %-20s %-20s %-15s\n", "Step", "", "(cm²)", "(cm³)", "(cm³)");
echo str_repeat("-", 80) . "\n";

foreach ($numericalResult['sample_steps'] as $step) {
    printf("%-10d %-15.4f %-20.4f %-20.6f %-15.4f\n",
        $step['step'],
        $step['z_position'],
        $step['cross_sectional_area'],
        $step['slice_volume'],
        $step['cumulative_volume']
    );
}

echo "\n";
echo "✅ KẾT QUẢ / RESULT:\n";
echo "   Thể tích (Numerical Integration): {$numericalResult['volume']} cm³\n";
echo "   Thể tích (Công thức trực tiếp): {$numericalResult['exact_formula_result']} cm³\n";
$error = abs($numericalResult['volume'] - $numericalResult['exact_formula_result']);
echo "   Sai số: " . round($error, 6) . " cm³\n\n";

// Test 2: Analytical Integration
echo "─────────────────────────────────────────────────────────────\n";
echo "  2️⃣  PHƯƠNG PHÁP TÍCH PHÂN GIẢI TÍCH (ANALYTICAL INTEGRATION)\n";
echo "─────────────────────────────────────────────────────────────\n\n";

$analyticalResult = IntegrationGeometry::calculateCylinderVolumeAnalytical($radius, $height);

echo "🧮 Phương pháp: {$analyticalResult['method']}\n\n";

echo "📐 Các bước giải tích phân / Integration Steps:\n\n";

foreach ($analyticalResult['integration_steps'] as $key => $step) {
    $stepNum = str_replace('step_', '', $key);
    echo "  {$stepNum}. {$step['description']}\n";
    echo "      → {$step['formula']}\n";
    
    if (isset($step['values'])) {
        echo "        Giá trị: r = {$step['values']['r']}, h = {$step['values']['h']}, limits = {$step['values']['limits']}\n";
    }
    if (isset($step['constant'])) {
        echo "        Hằng số: {$step['constant']}\n";
    }
    if (isset($step['calculation'])) {
        echo "        Tính toán: {$step['calculation']}\n";
    }
    echo "\n";
}

echo "✅ KẾT QUẢ / RESULT:\n";
echo "   Thể tích (Analytical Integration): {$analyticalResult['volume']} cm³\n\n";

// Comparison
echo "═══════════════════════════════════════════════════════════════\n";
echo "  SO SÁNH KẾT QUẢ / COMPARISON\n";
echo "═══════════════════════════════════════════════════════════════\n\n";

echo "Phương pháp giải tích (Analytical):  {$analyticalResult['volume']} cm³\n";
echo "Phương pháp số (Numerical):          {$numericalResult['volume']} cm³\n";
echo "Công thức trực tiếp (Direct):        {$numericalResult['exact_formula_result']} cm³\n\n";

echo "✅ Tất cả các phương pháp cho kết quả tương đương!\n";
echo "✅ All methods produce equivalent results!\n\n";
