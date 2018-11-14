<?php

namespace Somberbrook\Unit;

require_once "SomberbrookUnitInterface.php";

use Somberbrook\Unit\SomberbrookUnitInterface;

/**
 * Class SomberbrookUnit
 * @package Somberbrook\Unit
 */
abstract class SomberbrookUnit implements SomberbrookUnitInterface {
  private $health;
  private $strength;
  private $defense;
  private $speed;
  private $luck;
  private $unit_name;
  private $stats;
  private $skills;

  public function __construct($health = NULL, $strength = NULL, $defense = NULL, $speed = NULL, $luck = NULL, $unit_name = NULL, $skills = []) {
    $this->health = $health;
    $this->strength = $strength;
    $this->defense = $defense;
    $this->speed = $speed;
    $this->luck = $luck;
    $this->unit_name = $unit_name;
    $this->skills = $skills;
  }

  /**
   * {@inheritdoc}
   */
  public function getHealth() {
    return $this->stats['health'];
  }

  public function setHealth($hp) {
    $this->stats['health'] = $hp;
  }

  /**
   * {@inheritdoc}
   */
  public function getStrength() {
    return $this->stats['strength'];
  }

  /**
   * {@inheritdoc}
   */
  public function getDefense() {
    return $this->stats['defense'];
  }

  /**
   * {@inheritdoc}
   */
  public function getSpeed() {
    return $this->stats['speed'];
  }

  /**
   * {@inheritdoc}
   */
  public function getLuck() {
    return $this->stats['luck'];
  }

  /**
   * {@inheritdoc}
   */
  public function getRandomStatsValue($stats) {
    return rand($stats[0], $stats[1]);
  }

  public function getUnitName() {
    return $this->unit_name;
  }

  /**
   * {@inheritdoc}
   */
  public function getStats() {
    return $this->stats = [
      'health' => $this->getRandomStatsValue($this->health),
      'strength' => $this->getRandomStatsValue($this->strength),
      'defense' => $this->getRandomStatsValue($this->defense),
      'speed' => $this->getRandomStatsValue($this->speed),
      'luck' => $this->getRandomStatsValue($this->luck)
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function addSkill($skill) {
    $this->skills[] = $skill;

    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function getSkills() {
    return $this->skills;
  }
}