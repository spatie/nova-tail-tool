<?php

namespace Spatie\NovaTailTool\Tests;

use Spatie\NovaTailTool\Controllers\TailController;

class TailControllerTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->app
            ->when(TailController::class)
            ->needs('$logDirectory')
            ->give(__DIR__ . '/stubs');
    }

    /** @test */
    public function it_will_start_from_the_ending_of_the_file_when_no_starting_line_number_is_given()
    {
        $this
            ->postJson('/nova/tail-tool')
            ->assertSuccessful()
            ->assertJson([
                'text' => '',
                'nextPartLineNumber' => 10,
            ]);
    }

    /** @test */
    public function it_can_start_from_a_specific_line()
    {
        $this
            ->postJson('/nova/tail-tool', ['afterLineNumber' => 8])
            ->assertSuccessful()
            ->assertJson([
                'text' => 'nine' . PHP_EOL . 'ten' . PHP_EOL,
                'nextPartLineNumber' => 10,
            ]);
    }
}