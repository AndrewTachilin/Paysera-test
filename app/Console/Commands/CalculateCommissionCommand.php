<?php

declare(strict_types=1);

namespace App\Console\Commands;

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
    public function handle(ParseService $parseFileService): void
    {
        try {
            $percents = $parseFileService->parseFile($this->argument('fileName'));

            foreach ($percents as $percent) {
                $this->info($percent / config('app.total_percent'));
            }
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }
}
