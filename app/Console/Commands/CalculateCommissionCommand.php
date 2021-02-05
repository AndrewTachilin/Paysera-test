<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use App\Contracts\Services\ParseFiles\ParseFileInterface;

class CalculateCommissionCommand extends Command
{
    private ParseFileInterface $parseFileService;

    public function __construct(ParseFileInterface $parseFileService)
    {
        parent::__construct();

        $this->parseFileService = $parseFileService;
    }
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

    public function getOptions()
    {
        return [
            ['fileName', null, InputOption::VALUE_REQUIRED, 'file name']
        ];
    }
    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle(): void
    {
        try {
            $this->parseFileService->parseFile($this->argument('fileName'));
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }
}
