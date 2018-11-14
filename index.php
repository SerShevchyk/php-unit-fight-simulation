<?php

require_once "Somberbrook/src/Unit/StanhopeHero.php";
require_once "Somberbrook/src/Unit/WildBeast.php";
require_once "Somberbrook/src/Fight.php";

use Somberbrook\Unit\StanhopeHero;
use Somberbrook\Unit\WildBeast;
use Somberbrook\Fight;

$fight = new Fight();

$fight->addFighter(new StanhopeHero());
$fight->addFighter(new WildBeast());

$fight->fight();