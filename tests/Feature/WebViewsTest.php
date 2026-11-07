<?php

namespace Tests\Feature;

use Tests\TestCase;

class WebViewsTest extends TestCase
{
    public function test_welcome_page_renders(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('ConstrucKit');
        $response->assertSee('bootstrap@5.3.3');
        $response->assertSee('axios@1.7.9');
        $response->assertSee('Entrar al panel');
        $response->assertSee('250 h');
    }

    public function test_views_use_verified_script_integrity_hashes(): void
    {
        foreach (['/', '/panel'] as $path) {
            $this->get($path)->assertSee(
                'sha384-jLwhcmGu/RL8PSTUEl/559f8QVLL4QqM+HBvoZlt4F7XCdsdoDGAwW4nPFfoM7lU',
                false
            );
        }

        $this->get('/')->assertSee(
            'sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz',
            false
        );
    }

    public function test_panel_page_renders(): void
    {
        $response = $this->get('/panel');

        $response->assertStatus(200);
        $response->assertSee('id="eq-table"', false);
        $response->assertSee('cdn.datatables.net/2.3.2/js/dataTables.min.js', false);
        $response->assertSee('id="report-modal"', false);
        $response->assertSee('id="history-modal"', false);
        $response->assertSee('<tbody></tbody>', false);
        $response->assertSee('Error de aplicación:', false);
        $response->assertSee('Cerrar sesión');
        $response->assertSeeInOrder([
            'https://code.jquery.com/jquery-3.7.1.min.js',
            'https://cdn.datatables.net/2.3.2/js/dataTables.min.js',
            'https://cdn.datatables.net/2.3.2/js/dataTables.bootstrap5.min.js',
            "new DataTable('#eq-table'",
        ], false);
    }
}
