<?php

  function xmb_substr_replace($string, $replacement, $start, $length=NULL) {
    if (is_array($string)) {
        $num = count($string);
        $replacement = is_array($replacement) ? array_slice($replacement, 0, $num) : array_pad(array($replacement), $num, $replacement);
        if (is_array($start)) {
          $start = array_slice($start, 0, $num);
          foreach ($start as $key => $value)
            $start[$key] = is_int($value) ? $value : 0;
        }
        else {
          $start = array_pad(array($start), $num, $start);
        }
        if (!isset($length)) {
          $length = array_fill(0, $num, 0);
        }
        elseif (is_array($length)) {
          $length = array_slice($length, 0, $num);
          foreach ($length as $key => $value)
            $length[$key] = isset($value) ? (is_int($value) ? $value : $num) : 0;
        }
        else {
          $length = array_pad(array($length), $num, $length);
        }
        return array_map(__FUNCTION__, $string, $replacement, $start, $length);
    }
    preg_match_all('/./us', (string)$string, $smatches);
    preg_match_all('/./us', (string)$replacement, $rmatches);
    if ($length === NULL) $length = mb_strlen($string);
    array_splice($smatches[0], $start, $length, $rmatches[0]);
    return join($smatches[0]);
  }    

  function createButtons($s){
    $ret='';$i=0;while($i<mb_strlen($s)){
      $ret.='<input class="typeButton" type="button" value="'.mb_substr($s,$i,1).'" onClick="javascript:typeThis(\''.mb_substr($s,$i,1).'\');">';
      $i++;} 
    return $ret;
  }

  function rsubstring($s,$a,$b) {
    return xmb_substr_replace($s, '', $a, $b);
  }

  function mb_preg_match_all($ps_pattern, $ps_subject, &$pa_matches, $pn_flags = PREG_PATTERN_ORDER, $pn_offset = 0, $ps_encoding = NULL) {
    if (is_null($ps_encoding))
      $ps_encoding = mb_internal_encoding();

    $pn_offset = strlen(mb_substr($ps_subject, 0, $pn_offset, $ps_encoding));
    $ret = preg_match_all($ps_pattern, $ps_subject, $pa_matches, $pn_flags, $pn_offset);

    if ($ret && ($pn_flags & PREG_OFFSET_CAPTURE))
      foreach($pa_matches as &$ha_match)
        foreach($ha_match as &$ha_match)
          $ha_match[1] = mb_strlen(substr($ps_subject, 0, $ha_match[1]), $ps_encoding);

    return $ret;
  }      
    
  function explodeToPieces(&$arr) {
    $i=count($arr)-1; while ($i>-1) {
      $matches = array();
      mb_preg_match_all ('/\[([^\[])*\]/u', $arr[$i], $matches, PREG_OFFSET_CAPTURE);
      mb_regex_encoding('UTF-8');
      $matchesCount = count($matches[0]);
      if($matchesCount>0){
        $pow = pow(2,$matchesCount);
        $z=$pow-1; while ($z>-1) {
          $bnu = decbin($z);
          $binary = str_pad(decbin($z),8,'0', STR_PAD_LEFT);
          $temp = $arr[$i];
          $x=$matchesCount-1; while ($x>-1) {
            if(substr($binary,7-$x,1) == "0" ) $temp = rsubstring($temp, $matches[0][$x][1], strlen($matches[0][$x][0]));
            $x--;
          }
          $temp = str_replace(array('[', ']', '?', '!', ','), '', $temp);
          $temp = spaceTrim($temp);
          if ($z==$pow-1){ $all = $temp; } else { $arr[] = $temp; }
          $z--;
        }
        $arr[$i] = $all;
        }
    $i--;}
  }

  function tpg($v) {
  if ( isset ( $_POST[$v] ) ) {
    return trim($_POST[$v]);
    }else{
    if ( isset ( $_GET[$v] ) ) {
      return trim($_GET[$v]);
      }else{
      return '';
      }
    }
  }

  function lower($t){
    return mb_strtolower($t);
  }

  function spaceTrim($i) {
    return str_replace(array('     ', '    ', '   ', '  '), ' ', $i);
  }

  function superTrim($i) {
    return trim(spaceTrim(lower($i)));
  }

  function nz($i) { 
    if (!$i) { return 0; }else{ return $i; }
  }

  function redirect($a,$b=0) {
    global $HEAD; $HEAD.= '<meta http-equiv="refresh" content="'.$b.'; url='.$a.'">';
  }

  function rl($f, $l=0) {
    $h = fopen('./data/'.$f.'.txt', 'r');
    $i=0; while(!feof($h)){
    $lin = fgets($h, 4096);
    if($i==$l) { 
      fclose($h);
      return $lin;
      }
    $i++;}
    fclose($h); 
    return '';
  }

  function pf($f, $c) {
    $h = fopen('./data/'.$f.'.txt', 'w');
    fputs($h, $c);
    fclose($h);
  }

?>