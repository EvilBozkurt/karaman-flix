<?php

return [
    /**
     * Set custom schedule using cron expression
     *
     * @example "5 4 * * *" => means everyday at 4:08
     *
     */
    'configurable_interval_timer' => "* * * * *",


    /**
     * Maximum number of records to be seeded every time
     * the schedule is ran
     *
     * @example 100
     */
    'num_of_records' => 50,


    /**
     * The api key to access TMDB
     *
     * @example '123456789abcdefgh'
     */
    'api_key' => '9731706dc39c851e11ba693eb7859422',


    'tables' => [
        'genres-table-name' => 'genres',
        'movies-table-name' => 'movies',
    ]
];
