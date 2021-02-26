<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Services\Data\CalculateService;
use App\Services\ParseFiles\ParseService;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;

class CalculateCommissionCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'calculate:commission {fileName}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Calculate commission by file';

    public function getOptions(): array
    {
        return [
            ['fileName', null, InputOption::VALUE_REQUIRED, 'file name']
        ];
    }
    /**
     * Execute the cons`ole command.
     *
     * @return void
     */
    public function handle(ParseService $parseFileService, CalculateService $calculateService): void
    {
        try {
            $lines = $parseFileService->parseFile($this->argument('fileName'));
            $percents = $calculateService->calculate($lines);

            foreach ($percents as $percent) {
                $this->info($percent / config('app.total_percent'));
            }
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }
}
