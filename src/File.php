<?php

namespace Spatie\TailTool;

use SplFileObject;

class File
{
    public function __construct(protected string $filePath)
    {
    }

    public function numberOfLines(): int
    {
        $file = new SplFileObject($this->filePath);
        $lines = 0;

        while (! $file->eof()) {
            if ($file->fgets() !== '') {
                $lines++;
            }
        }

        return $lines;
    }

    public function contentAfterLine(int $lineNumber): string
    {
        $file = new SplFileObject($this->filePath);
        $file->seek($lineNumber);
        $content = '';

        while (! $file->eof()) {
            $content .= $file->fgets();
        }

        return $content;
    }
}
