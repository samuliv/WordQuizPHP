<?php

  ini_set('default_charset', 'UTF-8');
  require_once('functions.php');

  $page = $HEAD = $BODY = $JS = '';
  $page = tpg ( 'p' );
  $QAM = rl('questions_amount');

  $URI = 'https://raw.githubusercontent.com/szdanowi/repertoaari/master/pl-fi.dict';

  $pageFile = './pages/' . str_replace('/', '', $page) . '.php';
  if (file_exists($pageFile )) {
    require_once($pageFile);
  } else {
    die ('Page not found.');
  }

  require_once('html.output.php');

  ?>