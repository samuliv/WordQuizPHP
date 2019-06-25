<?php

$JS .= "
    function reloadQ() { window.location.href = '?p=reload'; }
    function shuffle(a) { for (let i = a.length - 1; i > 0; i--) { const j = Math.floor(Math.random() * (i + 1)); [a[i], a[j]] = [a[j], a[i]]; } return a; }      
    function aon(n,z) {let arr=[]; for(let i=0;i<n;i++) { arr.push(i); } return shuffle(arr).slice(0,z).join('|'); }
    function rq(z) { return '&q='+aon(".$QAM.", z); }
    function study(m)  { window.location.href = '?p=study'+(m?rq(m):'')+'&l='+document.getElementById('langmode').value; }
";

if(isset($_COOKIE['LANG'])) $LastLang = $_COOKIE['LANG']; else $LastLang = '';

$BODY .= '
    <button onClick="javascript:reloadQ();">Reload Dictionary from GitHub</button> Loaded ('.trim(rl('questions_loaded')).') - '.$QAM.' words<br><br>
    <select id="langmode"><option value="PO">Study typing POLISH</option><option value="FI"'.($LastLang == 'FI' ? ' SELECTED="SELECTED"' : '').'>Study typing FINNISH</option></select> --> 
    <button onClick="javascript:study(10);">Study 10 words</button>
    <button onClick="javascript:study(25);">25 words</button>
    <button onClick="javascript:study(50);">50 words</button>
';

?>