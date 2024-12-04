<?php

namespace Tests\Feature;

use PHPUnit\Framework\Attributes\CoversNothing;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    #[CoversNothing]
    public function test_that_true_is_true(): void
    {
        $this->assertTrue(true);
    }
}
