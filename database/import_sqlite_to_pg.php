<?php

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';

$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

config([
    'database.connections.sqlite.database' => database_path('database.sqlite')
]);

$tables = DB::connection('sqlite')
    ->select("SELECT name FROM sqlite_master WHERE type='table' AND name NOT LIKE 'sqlite_%'");

DB::connection('pgsql')->statement('SET session_replication_role = replica');

foreach ($tables as $tableObj) {

    $table = $tableObj->name;

    if ($table === 'migrations') {
        continue;
    }

    if (!Schema::connection('pgsql')->hasTable($table)) {
        echo "Salto tabella non presente in PostgreSQL: $table\n";
        continue;
    }

    DB::connection('pgsql')->table($table)->delete();

    DB::connection('sqlite')->table($table)
        ->orderByRaw('1')
        ->chunk(100, function ($rows) use ($table) {

            $data = $rows->map(function ($row) {
                return (array) $row;
            })->toArray();

            if (!empty($data)) {
                DB::connection('pgsql')->table($table)->insert($data);
            }
        });

    echo "Importata tabella: $table\n";
}

DB::connection('pgsql')->statement('SET session_replication_role = DEFAULT');

echo "Importazione completata.\n";