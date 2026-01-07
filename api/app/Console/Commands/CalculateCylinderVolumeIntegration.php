<?php

namespace App\Console\Commands;

use App\Utils\IntegrationGeometry;
use Illuminate\Console\Command;

class CalculateCylinderVolumeIntegration extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'geometry:cylinder-volume-integration
                            {radius=2 : Radius of the cylinder in cm}
                            {height=10 : Height of the cylinder in cm}
                            {--steps=1000 : Number of integration steps for numerical method}
                            {--method=both : Method to use (numerical, analytical, or both)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Calculate cylinder volume using integration methods (Tính thể tích hình trụ bằng phương pháp tích phân)';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $radius = (float) $this->argument('radius');
        $height = (float) $this->argument('height');
        $steps = (int) $this->option('steps');
        $method = $this->option('method');

        $this->info("═══════════════════════════════════════════════════════════════");
        $this->info("  TÍNH THỂ TÍCH HÌNH TRỤ BẰNG PHƯƠNG PHÁP TÍCH PHÂN");
        $this->info("  CYLINDER VOLUME CALCULATION USING INTEGRATION METHOD");
        $this->info("═══════════════════════════════════════════════════════════════");
        $this->newLine();

        $this->info("📐 Thông số đầu vào / Input Parameters:");
        $this->line("   • Bán kính (Radius): {$radius} cm");
        $this->line("   • Chiều cao (Height): {$height} cm");
        $this->newLine();

        // Numerical Integration
        if ($method === 'numerical' || $method === 'both') {
            $this->displayNumericalIntegration($radius, $height, $steps);
        }

        // Analytical Integration
        if ($method === 'analytical' || $method === 'both') {
            $this->displayAnalyticalIntegration($radius, $height);
        }

        return Command::SUCCESS;
    }

    /**
     * Display numerical integration results
     */
    private function displayNumericalIntegration(float $radius, float $height, int $steps)
    {
        $this->info("─────────────────────────────────────────────────────────────");
        $this->info("  1️⃣  PHƯƠNG PHÁP TÍCH PHÂN SỐ (NUMERICAL INTEGRATION)");
        $this->info("─────────────────────────────────────────────────────────────");
        $this->newLine();

        $result = IntegrationGeometry::calculateCylinderVolumeByIntegration($radius, $height, $steps);

        $this->line("🧮 <fg=yellow>Phương pháp:</> {$result['integration_method']}");
        $this->line("📊 <fg=yellow>Công thức:</> {$result['formula']}");
        $this->line("🔢 <fg=yellow>Số bước tích phân:</> {$result['number_of_steps']} steps");
        $this->line("📏 <fg=yellow>Độ dày mỗi lát cắt (Δz):</> {$result['delta_z']} cm");
        $this->line("⭕ <fg=yellow>Diện tích mặt cắt ngang:</> {$result['cross_sectional_area']} cm²");
        $this->newLine();

        $this->info("📝 Một số bước tính toán mẫu / Sample Integration Steps:");
        $this->newLine();

        $headers = ['Bước/Step', 'Vị trí z (cm)', 'Diện tích A(z) (cm²)', 'Thể tích lát (cm³)', 'Tích lũy (cm³)', 'Tiến độ (%)'];
        $rows = [];

        foreach ($result['sample_steps'] as $step) {
            $rows[] = [
                $step['step'],
                $step['z_position'],
                $step['cross_sectional_area'],
                $step['slice_volume'],
                $step['cumulative_volume'],
                $step['progress_percentage'] . '%'
            ];
        }

        $this->table($headers, $rows);
        $this->newLine();

        $this->info("✅ <fg=green;options=bold>KẾT QUẢ / RESULT:</>");
        $this->line("   <fg=green;options=bold>Thể tích (Numerical Integration): {$result['volume']} cm³</>");
        $this->line("   <fg=cyan>Thể tích (Công thức trực tiếp): {$result['exact_formula_result']} cm³</>");
        $this->line("   <fg=magenta>Sai số: " . round(abs($result['volume'] - $result['exact_formula_result']), 6) . " cm³</>");
        $this->newLine();
    }

    /**
     * Display analytical integration results
     */
    private function displayAnalyticalIntegration(float $radius, float $height)
    {
        $this->info("─────────────────────────────────────────────────────────────");
        $this->info("  2️⃣  PHƯƠNG PHÁP TÍCH PHÂN GIẢI TÍCH (ANALYTICAL INTEGRATION)");
        $this->info("─────────────────────────────────────────────────────────────");
        $this->newLine();

        $result = IntegrationGeometry::calculateCylinderVolumeAnalytical($radius, $height);

        $this->line("🧮 <fg=yellow>Phương pháp:</> {$result['method']}");
        $this->newLine();

        $this->info("📐 Các bước giải tích phân / Integration Steps:");
        $this->newLine();

        foreach ($result['integration_steps'] as $key => $step) {
            $stepNum = str_replace('step_', '', $key);
            $this->line("  <fg=cyan;options=bold>{$stepNum}.</> <fg=white>{$step['description']}</>");
            $this->line("      <fg=yellow>→ {$step['formula']}</>");

            if (isset($step['values'])) {
                $this->line("      <fg=gray>  Giá trị: r = {$step['values']['r']}, h = {$step['values']['h']}, limits = {$step['values']['limits']}</>");
            }
            if (isset($step['constant'])) {
                $this->line("      <fg=gray>  Hằng số: {$step['constant']}</>");
            }
            if (isset($step['calculation'])) {
                $this->line("      <fg=gray>  Tính toán: {$step['calculation']}</>");
            }
            $this->newLine();
        }

        $this->info("✅ <fg=green;options=bold>KẾT QUẢ / RESULT:</>");
        $this->line("   <fg=green;options=bold>Thể tích (Analytical Integration): {$result['volume']} cm³</>");
        $this->newLine();
    }
}
