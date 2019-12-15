<?php

require 'minimax.php';
require 'tictactoe.php';

$square=$_GET["square"];
$board=$_GET["board"];

function endgame($g) 
{
  $result = $g->win();
  if ($result == 1){
   print "gw".implode("",$g->board);

  }else if ($result == -1){

  print "gl".implode("",$g->board);

  }else print "gd".implode("",$g->board);
}

function validBoard($b)
{
  return (strlen($b) == 9 && strlen(preg_replace('/[xo-]*/',"",$b)) == 0);
}

if (isset($square) && isset($board) && ctype_digit($square) && validBoard($board)) {

  $board = str_split($board);
  $board[$square] = "x";
  
  $game = new TicTacToe("o",$board);
  if ($game->terminal()) {
    endgame($game);
  }
  else {
    $moves = $game->next_states();
    $min = 2;
    $next = $moves[0];
    foreach ($moves as $g) {
      $curr = minimax($g);
      if ($curr <= $min) {
	$next = $g;
	$min = $curr;
      }
    }
    if ($next->terminal()) {
      endgame($next);
    }
    else {
      $board = $next->board;
      print implode("",$board);
    }
  }
  exit;
 }
?>
