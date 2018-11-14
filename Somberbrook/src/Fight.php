<?php

namespace Somberbrook;

use Somberbrook\Unit\SomberbrookUnit;

class Fight {
  private $fighters = [];
  private $fighters_stats = [];
  private $raund_counter = 1;
  private $fighters_names = [];
  private $attacker = 0;
  private $defender = 0;

  /**
   * Method for add new fighter
   *
   * @param SomberbrookUnit $fighter
   * @return $this
   */
  public function addFighter(SomberbrookUnit $fighter) {
    $this->fighters[] = $fighter;
    return $this;
  }

  /**
   * Method for display information
   * @param $log_message
   */
  public function fightLog($log_message) {
    echo $log_message;
    echo '</br>';
  }

  /**
   * Method for start fight with 2 fighters
   */
  public function fight() {
    if (count($this->fighters) != 2) {
      die("The fight never starts. ... And as such, it needs at least 2 fighters!");
    }

    foreach ($this->fighters as $key => $fighter) {
      $this->fighters_stats[$key]['stats'] = $fighter->getStats();
      $this->fighters_stats[$key]['name'] = $this->fighters_names[] = $fighter->getUnitName();
    }
    $this->fightLog('~~~~~~~~~~~~~~~~ Fight ' . implode(' vs ', $this->fighters_names) . ' start ~~~~~~~~~~~~~~~~~~~');

    while ($this->isUnitsAlive()) {
      if ($this->raund_counter == 1) {
        $this->printStats();

        $speed_1 = $this->fighters[0]->getSpeed();
        $speed_2 = $this->fighters[1]->getSpeed();

        if (($speed_1 != $speed_2)) {
          $this->attacker = $speed_1 < $speed_2 ? 1 : 0;
        } elseif ($this->fighters[0]->getLuck() < $this->fighters[1]->getLuck()) {
          $this->attacker = 1;
        }
        $this->defender = $this->attacker == 1 ? 0 : 1;
      }

      if ($this->raund_counter != 20) {
        $this->turn();
      } else {
        $this->fightLog('~~~~~~~~~~~~~~~~~~~~~~~~~ Fight is over ~~~~~~~~~~~~~~~~~~~~~~~~~~~');
        die('Fight over. Heroes fighted more 20 rounds!!!');
      }
    }
  }

  /**
   * Mehod for do turn in fight and display information about turn
   */
  public function turn() {
    $this->fightLog('~~~~~~~~~~~~~~~~~~~~~~~~~ Round ' . $this->raund_counter . ' ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~');
    $this->fightLog($this->fighters[$this->attacker]->getUnitName() . ' attacks ' . $this->fighters[$this->defender]->getUnitName() . ' :');

    // Attack
    $attacker_strength = $this->fighters[$this->attacker]->getStrength();
    $defender_defense = $this->fighters[$this->defender]->getDefense();

    // Get skills
    $attacker_strength = $this->useSkills('attack', $attacker_strength, $this->fighters[$this->attacker]);
    $defender_defense = $this->useSkills('defense', $defender_defense, $this->fighters[$this->defender]);

    $this->strike($attacker_strength, $defender_defense);

    $this->raund_counter++;
    $this->attacker = $this->attacker == 0 ? 1 : 0;
    $this->defender = $this->defender == 0 ? 1 : 0;
  }

  /**
   * Method for do strike
   *
   * @param $attacker_strength
   * @param $defender_defense
   */
  protected function strike($attacker_strength, $defender_defense) {
    if ($this->chance($this->fighters[$this->attacker]->getLuck())) {
      $damage = $attacker_strength - $defender_defense;
      $damage = $damage < 0 ? 0 : $damage;

      $this->fightLog($this->fighters[$this->attacker]->getUnitName() . ' attacks with total damage ' . $damage);

      $this->fighters[$this->defender]->setHealth($this->fighters[$this->defender]->getHealth() - $damage);

      $this->fightLog($this->fighters[$this->defender]->getUnitName() . ' has ' . $this->fighters[$this->defender]->getHealth() . ' HP');
    } else {
      $this->fightLog($this->fighters[$this->attacker]->getUnitName() . " has no luck to attack in this strike");
    }
  }

  protected function useSkills($function, $stat_value, SomberbrookUnit $fighter) {
    if (!empty($skills = $fighter->getSkills())) {
      if (!empty($skills['attack']) && $function == 'attack') {
        foreach ($skills[$function] as $attacker_skill) {
          if ($this->chance($attacker_skill['luck'])) {
            $this->fightLog($this->fighters[$this->attacker]->getUnitName() . ' use skill ' . $attacker_skill['skill_name']);

            switch ($attacker_skill['skill_name']) {
              case "Rapid strike" :
                $this->strike($stat_value, $this->fighters[$this->defender]->getDefense());
                break;
              default :
                if (is_null($attacker_skill['strength'])) {
                  $stat_value = $stat_value + $this->fighters[$this->attacker]->getStrength();
                } elseif ($attacker_skill['strength'] > 0) {
                  $stat_value = $stat_value + $attacker_skill['strength'];
                }

                $stat_value = $stat_value * $attacker_skill['count'];
                break;
            }
          }
        }
      }

      if (!empty($skills['defense']) && $function == 'defense') {
        foreach ($skills[$function] as $defender_skill) {
          if ($defender_skill['defense'] != 0 && $this->chance($defender_skill['luck'])) {

            $this->fightLog($this->fighters[$this->defender]->getUnitName() . ' use skill ' . $defender_skill['skill_name']);

            switch ($defender_skill['skill_name']) {
              case "Magic shield" :
                $stat_value = ($stat_value + ($this->fighters[$this->attacker]->getStrength() * $defender_skill['defense'])) * $defender_skill['count'];

                break;
              default :
                if (!is_null($defender_skill['defense']) && $defender_skill['defense'] != 0) {
                  if (is_float($defender_skill['defense'])) {
                    $stat_value = $stat_value + ($stat_value * $defender_skill['defense']) * $defender_skill['count'];
                  } else {
                    $stat_value = ($stat_value + $defender_skill['defense']) * $defender_skill['count'];
                  }
                  $this->fightLog($this->fighters[$this->defender]->getUnitName() . ' get ' . ($stat_value - $this->fighters[$this->defender]->getDefense()) . ' point of defense');
                }
                break;
            }
          }
        }
      }
    }
    return $stat_value;
  }

  /**
   * Method for check lucky chance in the fight
   *
   * @param $percent
   * @return bool
   */
  public function chance($percent) {
    return mt_rand(0, 99) < $percent;
  }

  /**
   * Method for check if fighters alive and display information about it
   *
   * @return bool
   */
  public function isUnitsAlive() {
    $units_alive = TRUE;

    foreach ($this->fighters as $key => $fighter) {
      if ($fighter->getHealth() < 1) {
        $this->fightLog('~~~~~~~~~~~~~~~~~~~~~~~ Fight is over ~~~~~~~~~~~~~~~~~~~~~~~~~~');
        die($this->fighters[$key]->getUnitName() . ' die !!!');
      }
    }

    return $units_alive;
  }

  /**
   * Method for display table with heroes stats
   */
  public function printStats() {
    echo '<table>';
    echo '<tr><td></td><td>Health</td><td>Strength</td><td>Defense</td><td>Speed</td><td>Luck</td></tr>';
    foreach ($this->fighters as $key => $fighter_info) {
      echo "<tr>";
      echo "<td>" . $fighter_info->getUnitName() . "</td>";
      foreach ($fighter_info->getStats() as $value) {
        echo "<td>" . $value . "</td>";
      }
      echo "</tr>";
    }
    echo '</table>';
  }
}