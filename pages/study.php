<?php

      $WORD_WAS = '';
      
      $STEP = nz(tpg('s'));
      $L = tpg('l');
      setCookie('LANG', $L);
      $Q = tpg('q');
      $R = tpg('r');
      $W = tpg('w');
      $ANSWER = superTrim(tpg('ans'));
      $WAS_CORRECT = 0;
      $QUESTIONS = explode('|',$Q);
      $STEPS = count($QUESTIONS);
      
      if ( $STEP > 0 ) { 
        // Check the answer:
        $WORD_ROW = explode(';',rl('questions', $QUESTIONS[$STEP-1]));
        if ( $L == 'PO' ) {$WORD_WAS = $WORD_ROW[1]; $CORRECT_WAS = $WORD_ROW[0]; }else{ $WORD_WAS = $WORD_ROW[0]; $CORRECT_WAS = $WORD_ROW[1]; };
        
        $CORR = lower($CORRECT_WAS);
        $CORRECTS = explode(',',$CORR);

        explodeToPieces($CORRECTS);

        $i=0;while($i<count($CORRECTS)){
          $CORRECTS[$i] = trim(preg_replace('/\(([^\)])*\)/u', '', $CORRECTS[$i]));
          $i++;}
        
        if ( in_array($ANSWER, $CORRECTS) ) {
          $WAS_CORRECT = 1;
          }
        
        if ( $WAS_CORRECT ) { $R++; } else { $W++; }

        }
      
        $BODY .= '
          <form method="POST" enctype="multipart/form-data"  autocomplete="off">
          <input type="hidden" name="p" value="'.$page.'">
          <input type="hidden" name="q" value="'.$Q.'">
          <input type="hidden" name="l" value="'.$L.'">
          <input type="hidden" name="s" value="'.($STEP+1).'">
          <input type="hidden" name="r" value="'.$R.'">
          <input type="hidden" name="w" value="'.$W.'">
        ';

      if($STEP > 0 ){
        $BODY.='
        <table>
        <tr><td>Last Word:</td><td class="lastquestion">'.$WORD_WAS.'</td></tr>
        <tr><td>Your Answer:</td><td>'.$ANSWER.'</td></tr>
        <tr><td>Correct Answer:</td><td>'.$CORRECT_WAS.' '.($WAS_CORRECT ? '<span class="answer correct">CORRECT!</span>':'<span class="answer wrong">WRONG!</span>').'</td></tr>
        </table>
        <hr>
        ';
      }
      
      if ( $STEP < $STEPS ) {

        if ($Q) {
          $QUESTIONS = explode('|',$Q);
          $WORD_ROW = explode(';',rl('questions', $QUESTIONS[$STEP]));
          if ( $L == 'PO' ) $WORD_NOW = $WORD_ROW[1]; else $WORD_NOW = $WORD_ROW[0];
        }
        
        $JS .= " 
          (function() { document.getElementById('ans').focus(); })();
          function typeThis(c) { 
            let ans = document.getElementById('ans'); ans.value = ans.value + c; ans.focus(); 
          }";
        
        $BODY .= '
          <table>
          <tr><td></td><td>'.($STEP+1).'/'.$STEPS.'</td></tr>
          <tr><td>Word: </td><td class="question">'.$WORD_NOW.'</td></tr>
          <td>Answer:</td><td>
          <input class="ansBox" id="ans" name="ans" type="text">
          <br>
          '.createButtons("åäöąćęłńśźż").'
          </td></tr>
          </table><br><input type="submit" value="Check! [ENTER]"> <input type="button" value="Exit" onClick="javascript:window.location.href=\'?p=\';">
          </form>
        ';


      } else { 

        $BODY.='
          <h2>Quiz Ended!</h2><h3>Results:</h3>
          <table class="scoretable">
            <tr><td>Questions:</td><td>'.$STEPS.'</td></tr>
            <tr><td>Right:</td><td>'.$R.'</td></tr>
            <tr><td>Wrong:</td><td>'.$W.'</td></tr>
            <tr><td>Score:</td><td class="big">'.round($R/$STEPS*100).'%</td></tr>
          </table><br>
          <input type="button" value="Again?" onClick="javascript:window.location.href=\'?\';">
        ';
      }

      ?>