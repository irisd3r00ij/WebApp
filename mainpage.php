<?php 
include "db_connection.php"; 
$pagetemplatebestand = "main-page.txt";  

// inlezen template's (zowel het pagina als het item template moet bestaan) 
if (File_Exists($pagetemplatebestand)) {  

    // open het  template bestand voor de hele pagina (dit template bevast de basis HTML van de pagina) 
    $fhandle = fopen($pagetemplatebestand, "r");  

    // Lees alle data uit het template bestand en stop deze in een string   
    // (via filesize($templatebestand) wordt er voor gezorgt dat het hele bestand wordt gelezen)  
    $pagetemplate = fread($fhandle, filesize($pagetemplatebestand));  
    // sluit het bestand (de inhoud is beschikbaar in de variabele $template  
    fclose($fhandle);  
     
     
    // Gegevens ophalen uit de database en opslaan in (een dimensionale JSON objecten (zijn feitelijk gewoon Javascript Arrays) 

    // PHP arrays op leeg initialiseren 
    $longis_php=array(); 
    $latis_php=array(); 
    $titles_php=array(); 

    // Query, wat halen we op uit de database? 
    $query = $db->prepare("select id, name, lat, lon from quests"); 
    $query->execute(); 
    $result= $query->fetchAll(PDO::FETCH_ASSOC); 
    foreach($result as $item) { 
        $longis_php[]=$item["lon"]; 
        $latis_php[]=$item["lat"]; 
        $titles_php[]=$item["name"];         
    } 
    // PHP arrays omzetten naar JSON (Javascript arrays 
    $longis_json=json_encode($longis_php); 
    $latis_json=json_encode($latis_php); 
    $titles_json=json_encode($titles_php);     

    // Invoegen informatie in het template 
    $pagetemplate=str_replace("###LONGIS###",$longis_json,$pagetemplate);          
    $pagetemplate=str_replace("###LATIS###",$latis_json,$pagetemplate);  
    $pagetemplate=str_replace("###TITLES###",$titles_json,$pagetemplate);   
     
    // Toon het gevulde template (de pagina) 
    echo $pagetemplate; 
} else { 
    // item template niet gevonden 
    echo "Template(s) voor weergave niet gevonden. Pagina kan niet worden weergegeven.\n"; 
} 
?> 