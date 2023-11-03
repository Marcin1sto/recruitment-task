<?php

namespace App\Console\Commands;

use App\Enums\ReportTypeEnum;
use App\Services\ReportModelService;
use App\Traits\ReportTypeProcessingTrait;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ReadReports extends Command
{
    use ReportTypeProcessingTrait;

    private ReportModelService $reportModelService;

    public function __construct()
    {
        parent::__construct();
        $this->reportModelService = new ReportModelService();
    }

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:read-reports';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // TODO: Powinna być utworzona również walidacja Message z reportu

        Log::info('Read reports command started.');
        $files = Storage::disk('reports')->files();

        $jsonFiles = array_values(array_filter($files, function ($file) {
            return Str::endsWith($file, '.json');
        }));

        try {
            $fileChoice = $this->choice('Chose file with reports', $jsonFiles, 0);
        } catch (\Throwable $e) {
            Log::error($e->getMessage());
            $this->error('No files in reports directory.');
            return;
        }

        try {
            $fileContent = json_decode(Storage::disk('reports')->get($fileChoice), true, 512, JSON_THROW_ON_ERROR);
        } catch (\Throwable $e) {
            Log::error($e->getMessage());
            $this->error('File is empty or corrupted.');
            return;
        }

        $this->info('Reports count: ' . count($fileContent));

        $reports = collect($fileContent);
        $duplicates = $reports->groupBy('description')
            ->filter(function ($items) {
                return count($items) > 1;
            })
            ->flatten(1);
        $duplicates = collect(array_values($duplicates->groupBy('description')->map(function ($items) {
            return $items[0];
        })->toArray()));

        $reports = $reports->map(function ($report) use ($duplicates) {
            if (in_array($report['description'], $duplicates->pluck('description')->toArray()) &&
                !in_array($report['number'], $duplicates->pluck('number')->toArray())
            ) {
                $report['isDuplicate'] = true;
            }
            $report['type'] = $this->selectType($report);

            return $this->reportModelService->createModel($report, $report['type']);
        });

        $table = [];
        try {
            foreach (ReportTypeEnum::values() as $type) {
                $table[] = [
                    $type,
                    $reports->where('type', $type)->count()
                ];

                $json = json_encode($reports->where('type', $type)->all(),
                    JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

                Storage::disk('results')->put($type . '-' . date('Y-m-d') . '.json', $json);
            }
        } catch (\Throwable $e) {
            $this->error('Error during processing reports.');
            Log::error($e->getMessage());
            return;
        }

        $this->info('Reports processed successfully.');
        $this->table(['Report type', 'Count'], $table);

        Log::info('Moving file to processed directory.');
        Storage::disk('reports')->move($fileChoice, 'processed/'.$fileChoice);
        Log::info('Read reports command end.');
    }

}
