<?php

namespace Spatie\TailTool\Tests;

use Spatie\TailTool\Controllers\TailController;
use Spatie\TailTool\TailTool;
use Symfony\Component\HttpFoundation\Response;

class TailControllerTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->app
            ->when(TailController::class)
            ->needs('$logDirectory')
            ->give(__DIR__ . '/stubs');

        TailTool::auth(function() {
            return true;
        });
    }

    /** @test */
    public function it_will_start_from_the_ending_of_the_file_when_no_starting_line_number_is_given()
    {
        $this
            ->postJson('/nova/tail-tool')
            ->assertSuccessful()
            ->assertJson([
                'text' => '',
                'lastRetrievedLineNumber' => 10,
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
                'lastRetrievedLineNumber' => 10,
            ]);
    }

    /** @test */
    public function it_will_return_a_forbidden_reponse_if_the_auth_function_returns_false()
    {
        TailTool::auth(function() {
            return false;
        });

        $this
            ->postJson('/nova/tail-tool', ['afterLineNumber' => 8])
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }
}
