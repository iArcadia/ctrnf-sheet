<?php

require_once '__ajax.php';

use App\DB;
use Database\DatabaseSeeder;

copy('../database/database.db', '../database/database.bak.' . time() . '.db');
copy('../database/database.empty.db', '../database/database.db');

DB::refresh();
DatabaseSeeder::execute();