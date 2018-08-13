<?php

namespace Spatie\TailTool\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\TailTool\File;
use Illuminate\Support\Facades\File as IlluminateFile;
use Symfony\Component\Finder\SplFileInfo;
use Illuminate\Routing\Controller;

class TailController extends Controller
{
    /** @var string */
    protected $logDirectory;

    public function __construct(string $logDirectory = null)
    {
        $this->logDirectory = $logDirectory ?? storage_path('logs');
    }

    public function __invoke(Request $request) {

        $validated = $request->validate([
           'afterLineNumber' => 'nullable|numeric',
        ]);

        $logFilePath = $this->findLatestLogFile();

        $logFile = new File($logFilePath);

        $afterLineNumber = $validated['afterLineNumber'] ?? $logFile->numberOfLines();

        $newLines = $logFile->contentAfterLine($afterLineNumber);

        return [
            'text' => $newLines,
            'lastRetrievedLineNumber' => $afterLineNumber + $this->numberOfLines($newLines),
        ];
    }

    protected function findLatestLogFile(): string
    {
        return collect(IlluminateFile::allFiles($this->logDirectory))
            ->sortByDesc(function (SplFileInfo $file) {
                return $file->getMTime();
            })
            ->first() ?? '';
    }

    protected function numberOfLines(string $newLines): int
    {
        return substr_count($newLines, PHP_EOL);
    }
}
