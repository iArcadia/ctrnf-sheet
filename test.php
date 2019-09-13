<?php

require_once 'vendor/autoload.php';

use App\DB;
use App\Game\Track;

DB::connect();

dump(Track::getTrackOfTheDay());

?>
