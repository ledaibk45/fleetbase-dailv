<?php

namespace App\Console\Commands;

use App\Utils\Geometry;
use Illuminate\Console\Command;

class CalculateCylinderVolume extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'geometry:cylinder-volume {radius?} {height?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Calculate the volume of a cylinder. Usage: geometry:cylinder-volume {radius} {height}';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // Get parameters from command arguments or use defaults (r=2cm, h=10cm)
        $radius = $this->argument('radius') ?? 2;
        $height = $this->argument('height') ?? 10;

        // Calculate volume
        $volume = Geometry::calculateCylinderVolume($radius, $height);

        // Display results
        $this->info("============================================");
        $this->info("Tính thể tích hình trụ (Cylinder Volume)");
        $this->info("============================================");
        $this->line("Bán kính (Radius): {$radius} cm");
        $this->line("Chiều cao (Height): {$height} cm");
        $this->info("--------------------------------------------");
        $this->line("Công thức (Formula): V = π × r² × h");
        $this->line("V = π × ({$radius})² × {$height}");
        $this->line("V = π × " . pow($radius, 2) . " × {$height}");
        $this->info("--------------------------------------------");
        $this->info(sprintf("Thể tích (Volume): %.2f cm³", $volume));
        $this->info(sprintf("Volume: %.4f cm³", $volume));
        $this->info("============================================");

        return 0;
    }
}
