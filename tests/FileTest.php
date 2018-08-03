<?php

namespace Spatie\NovaTailTool\Tests;

use Spatie\NovaTailTool\File;
use Spatie\Snapshots\MatchesSnapshots;

class FileTest extends TestCase
{
    use MatchesSnapshots;

    /** @var \Spatie\NovaTailTool\File */
    protected $file;

    public function setUp()
    {
        parent::setup();

        $this->file = new File($this->getStub('log.txt'));
    }

    /** @test */
    public function it_can_get_the_number_of_lines_in_a_file()
    {
        $this->assertEquals(10, $this->file->numberOfLines());
    }

    /** @test */
    public function it_can_get_the_last_lines_of_a_file()
    {
        $this->assertMatchesSnapshot($this->file->contentAfterLine(3));
    }

    /** @test */
    public function it_can_all_lines_of_a_file()
    {
        $this->assertMatchesSnapshot($this->file->contentAfterLine(0));
    }

    /** @test */
    public function it_will_return_an_empty_string_when_getting_content_after_the_last_line()
    {
        $this->assertEquals('', $this->file->contentAfterLine(1000));
    }

    public function getStub(string $name): string
    {
        return __DIR__ . "/stubs/{$name}";
    }
}
