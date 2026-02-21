<?php

declare(strict_types=1);

test('health check', function (): void {
    $response = $this->get('/up');

    $response->assertStatus(200);
});
