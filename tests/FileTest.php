<?php

use Spatie\TailTool\File;

it('counts lines including the last line without a newline', function () {
    expect((new File(__DIR__.'/stubs/log.txt'))->numberOfLines())->toBe(10);
});

it('reads the remaining lines without changing their contents', function () {
    $file = new File(__DIR__.'/stubs/log.txt');

    expect($file->contentAfterLine(8))->toBe("nine\nten")
        ->and($file->contentAfterLine(1000))->toBe('')
        ->and($file->contentAfterLine(0))->toBe(file_get_contents(__DIR__.'/stubs/log.txt'));
});
