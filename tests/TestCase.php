<?php

namespace Tests;

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use RuntimeException;

abstract class TestCase extends BaseTestCase
{
    /**
     * Sobe a aplicação garantindo que os testes usem o ambiente e o banco de TESTE.
     *
     * No Docker, APP_ENV e DB_* existem como variáveis reais do container (apontando
     * para o banco de desenvolvimento). O PHPUnit aplica o <env force="true"> do
     * phpunit.xml apenas em getenv(), mas o Laravel lê $_SERVER/$_ENV, que ainda
     * guardam os valores do container. Resultado: "php artisan test" rodava contra o
     * banco de desenvolvimento (e o RefreshDatabase apagava tudo) com o CSRF ativo.
     */
    public function createApplication()
    {
        // Espelha o ambiente real do processo (já com os valores do phpunit.xml)
        // nas superglobais que o Laravel lê.
        foreach (getenv() as $key => $value) {
            $_SERVER[$key] = $_ENV[$key] = $value;
        }

        $app = parent::createApplication();

        $this->ensureTestingDatabase($app);

        return $app;
    }

    /**
     * Trava de segurança: recusa rodar se o banco não for um banco de testes.
     */
    private function ensureTestingDatabase(Application $app): void
    {
        $connection = $app['config']['database.default'];
        $database = (string) $app['config']["database.connections.{$connection}.database"];

        if (! $app->environment('testing') || ! str_contains($database, 'test')) {
            throw new RuntimeException(
                "Recusando rodar os testes: ambiente \"{$app->environment()}\" com banco \"{$database}\". ".
                'Os testes só podem rodar com APP_ENV=testing e um banco de testes (ex.: taskflow_testing), '.
                'senão o RefreshDatabase apagaria os dados de desenvolvimento.'
            );
        }
    }
}
