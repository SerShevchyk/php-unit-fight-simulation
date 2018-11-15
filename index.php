<?php

require './vendor/autoload.php';

use Somberbrook\Unit\StanhopeHero;
use Somberbrook\Unit\WildBeast;
use Somberbrook\Fight;

$fight = new Fight();

$fight->addFighter(new StanhopeHero());
$fight->addFighter(new WildBeast());

$fight->fight();