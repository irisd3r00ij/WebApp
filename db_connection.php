<?php 
// Deze twee regels zijn alleen relevant als je zelf een API bouwd waarbij je scripts avanaf een ander domein gebruik wilt laten maken van scripts op jou applicatie
// Omdat de database connectie in al je scripts gebruikt wordt is het slim om deze regesl daarom hier op te nemen (dan worden ze altijd geladen)
header("Access-Control-Allow-Origin: *"); 
header("Access-Control-Allow-Headers: Content-Type"); 
try { 
    $db = new PDO('mysql:host=localhost;dbname=jarooij1;charset=utf8','jarooij1','iEts!1WoOrd'); 
    // Set PDO to throw exceptions when Exceptions occur 
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
    // Prevent PDO from adding single quotes around integer values. This gives problems with dynamic limit parameters in queries
    $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false ); 
} 
catch(PDOException $e) { 
    // Toon de fout en stop het script 
    die($e->getMessage()); 
} 