<?php

namespace Somberbrook\Unit;

require_once "SomberbrookUnit.php";

use Somberbrook\Unit\SomberbrookUnit;

/**
 * Class StanhopeHero
 * @package Somberbrook\Unit
 */
class WildBeast extends SomberbrookUnit {

  private $health = [60, 90];
  private $strength = [60, 90];
  private $defense = [40, 60];
  private $speed = [40, 50];
  private $luck = [25, 40];
  private $unit_name = 'Wild Beast';
  private $skills = [];

  public function __construct() {
    parent::__construct($this->health, $this->strength, $this->defense, $this->speed, $this->luck, $this->unit_name, $this->skills);
  }
}