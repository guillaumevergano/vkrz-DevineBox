<?php
function get_indication_nbvotes($top_number){
    $indications_votes = array();
    $minComplete = ($top_number - 5) * 2 + 6;
    $maxComplete = $minComplete * 2;
    
    $indications_votes["top1"] = "Il te faudra " . ($top_number - 1) . " votes pour avoir ton Top1";
    if ($top_number > 10) {
      $max = floor($top_number / 2) + (3 * (round($top_number / 2) - 1));
      $min = floor($top_number / 2) + (round($top_number / 2) - 1) + 3;
      $moy = ($max + $min) / 2;
      $indications_votes["top3"] = "Il faut environ " . round($moy) . " votes pour faire ton podium";
    }
    if ($top_number < 3) {
        $indications_votes["topcomplet"] = "Un seul vote suffira pour finir ce Top";
    } else {
        $indications_votes["topcomplet"] = "Entre " . $minComplete . " et " . $maxComplete . " votes pour classer du 1er au " . $top_number . "ème";
    }
    return $indications_votes;
}
?>