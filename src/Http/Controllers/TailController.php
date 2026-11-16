<?php

namespace Spatie\TailTool\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\File as Filesystem;
use Spatie\TailTool\File;
use Symfony\Component\Finder\SplFileInfo;

class TailController extends Controller
{
    protected string $logDirectory;

    public function __construct(?string $logDirectory = null)
    {
        $this->logDirectory = $logDirectory ?? storage_path('logs');
    }

    public function __invoke(Request $request): array
    {
        $validated = $request->validate([
            'afterLineNumber' => ['nullable', 'integer', 'min:0'],
            'file' => ['nullable', 'string', 'max:64'],
        ]);

        $latestFile = is_dir($this->logDirectory)
            ? collect(Filesystem::allFiles($this->logDirectory))
                ->filter(fn (SplFileInfo $file) => $file->getExtension() === 'log')
                ->sortByDesc(fn (SplFileInfo $file) => $file->getMTime())
                ->first()
            : null;

        if (! $latestFile) {
            return ['text' => '', 'lastRetrievedLineNumber' => 0, 'file' => null];
        }

        $fileId = hash('sha256', $latestFile->getPathname().':'.$latestFile->getInode());
        $logFile = new File($latestFile->getPathname());
        $numberOfLines = $logFile->numberOfLines();
        $afterLineNumber = $validated['afterLineNumber'] ?? $numberOfLines;

        if (isset($validated['file']) && $validated['file'] !== $fileId) {
            $afterLineNumber = 0;
        }

        if ($afterLineNumber > $numberOfLines) {
            $afterLineNumber = 0;
        }

        $text = $logFile->contentAfterLine($afterLineNumber);
        $retrievedLines = substr_count($text, "\n");

        if ($text !== '' && ! str_ends_with($text, "\n")) {
            $retrievedLines++;
        }

        return [
            'text' => $text,
            'lastRetrievedLineNumber' => $afterLineNumber + $retrievedLines,
            'file' => $fileId,
        ];
    }
}
