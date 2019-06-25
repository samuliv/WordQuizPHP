<?php
  
  $temporaryFile = './data/_tmp.txt';
  $finalFile = './data/questions.txt';
        
  set_time_limit(0);
  $fp = fopen ($temporaryFile, 'w+');
  $ch = curl_init(str_replace(" ","%20",$URI));
  curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, false);
  curl_setopt($ch, CURLOPT_TIMEOUT, 50);
  curl_setopt($ch, CURLOPT_FILE, $fp); 
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
  curl_exec($ch); 
  curl_close($ch);
  fclose($fp);

  $lines=0; $h = fopen($temporaryFile, 'r');

  while(!feof($h)){
    $line = fgets($h,4096);
    if ( $line == "" ) break;
    $lines++;
    }

  fclose($h);
  
  pf('questions_amount',$lines);
  pf('questions_loaded',date('d.m.Y \@ H:i:s'));
  
  @unlink($finalFile);
  rename($temporaryFile, $finalFile);

  redirect('?p=');

  ?>