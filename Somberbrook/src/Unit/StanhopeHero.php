<?php

namespace Somberbrook\Unit;

use Somberbrook\Unit\SomberbrookUnit;

/**
 * Class StanhopeHero
 * @package Somberbrook\Unit
 */
class StanhopeHero extends SomberbrookUnit {

  private $health = [70, 100];
  private $strength = [70, 80];
  private $defense = [45, 55];
  private $speed = [40, 50];
  private $luck = [10, 30];
  private $unit_name = 'Stanhope';
  private $skills = [
    'attack' => [
      0 => [
        'skill_name' => 'Rapid strike',
        'strength' => 0,
        'defense' => 0,
        'luck' => 10,
        'count' => 2
      ]
    ],
    'defense' => [
      0 => [
        'skill_name' => 'Magic shield',
        'strength' => 0,
        'defense' => 0.5,
        'luck' => 20,
        'count' => 1
      ]
    ]
  ];

  public function __construct() {
    parent::__construct($this->health, $this->strength, $this->defense, $this->speed, $this->luck, $this->unit_name, $this->skills);
  }
}