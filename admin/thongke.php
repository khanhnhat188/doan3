<?php
require './carbon/autoload.php';

use Carbon\Carbon;
use Carbon\CarbonInterval;

printf("Now: %s", Carbon::now());

printf("1 day: %s", CarbonInterval::day()->forHumans());
?>