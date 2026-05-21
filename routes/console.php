<?php

use Illuminate\Foundation\Console\ServeCommand as LaravelServeCommand;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Symfony\Component\Process\Process;

Artisan::command('serve {--host=localhost : The host address to serve the application on} {--port= : The port to serve the application on} {--tries=10 : The number of ports to attempt to serve the application on} {--env= : The environment file to use} {--no-reload : Disable auto-reload on environment file changes}', function () {
    $npmProcess = new Process(
        ['npm', 'run', 'dev'],
        base_path(),
    );

    $npmProcess->setTimeout(null);
    $npmProcess->setIdleTimeout(null);
    $npmProcess->start();

    $this->info('Starting Vite dev server...');
    $this->comment('Vite is running in the background.');

    register_shutdown_function(function () use ($npmProcess) {
        if ($npmProcess->isRunning()) {
            $npmProcess->stop(10);
        }
    });

    $serveCommand = new LaravelServeCommand();
    $serveCommand->setLaravel(app());
    $serveCommand->setApplication($this->getApplication());

    return $serveCommand->run($this->input, $this->output);
})->purpose('Serve the application on the PHP development server and start Vite');

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');
