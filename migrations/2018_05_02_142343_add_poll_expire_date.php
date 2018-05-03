<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Schema\Builder;

return [
    'up' => function (Builder $schema) {
        $schema->table('polls', function (Blueprint $table) {
            $table->dateTime('end_date');
        });
        if (!$schema->hasColumn('users', 'last_vote_time')) {
            $schema->table('users', function (Blueprint $table) {
                $table->dateTime('last_vote_time');
            });
        }
    },

    'down' => function (Builder $schema) {
        $schema->table('polls', function (Blueprint $table) {
            $table->dropColumn('end_date');
        });
        if ($schema->hasColumn('users', 'last_vote_time')) {
            $schema->table('users', function (Blueprint $table) {
                $table->dropColumn('last_vote_time');
            });
        }
    },
];
