<?php

namespace Somberbrook\Unit;

interface SomberbrookUnitInterface {
  /**
   * Method for get Unit Health value
   *
   * @return mixed
   */
  public function getHealth();

  /**
   * Method for set Unit Health value
   *
   * @param $hp
   * @return mixed
   */
  public function setHealth($hp);

  /**
   * Method for get Unit Strength value
   *
   * @return mixed
   */
  public function getStrength();

  /**
   * Method for get Unit Defense value
   *
   * @return mixed
   */
  public function getDefense();

  /**
   * Method for get Unit Speed value
   *
   * @return mixed
   */
  public function getSpeed();

  /**
   * Method for get Unit Luck value
   *
   * @return mixed
   */
  public function getLuck();

  /**
   * Method for get random stats value
   *
   * @param $stats
   * @return mixed
   */
  public function getRandomStatsValue($stats);

  /**
   * Method for get unit name
   *
   * @return mixed
   */
  public function getUnitName();

  /**
   * Method for get all stats
   *
   * @return mixed
   */
  public function getStats();

  /**
   * Method for add new skill for unit
   *
   * @param $skill
   * @return mixed
   *
   * Add skill with array with keys: skill_name, defense, strength, luck, count
   */
  public function addSkill($skill);

  /**
   * Method for get skills
   *
   * @return mixed
   */
  public function getSkills();
}