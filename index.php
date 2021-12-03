<?php // Made by Marek_p :)

// Formulář pro vyhledávání
echo("
    <form action='#' method='get'>
        <input type='text' name='ip' placeholder='IP Adresa'>
        <input type='submit' name='submit' value='Vyhledat'>
    </form>
    ");

// CSS Pro celou stránku
echo(" 
<style>
    * {
        font-family: \"Arial\";
        margin: 5px;
    }
    form {
        padding: 15px;
        width: 400px;
        border-radius: 10px;
        background-color: #E7F4FF;
        margin: 20px 0 0 20px;
    }
    form input {
        background-color: #DBE7F1;
        border: 2px solid #E7F4FF;
        padding: 10px;
        border-radius: 10px;
        color: #000;
        font-weight: bold;
    }
    form input:hover {
        box-shadow: 2px 2px 2px gray;
    }
    .status {
        padding: 15px;
        width: 400px;
        border-radius: 10px;
        background-color: #E7F4FF;
        margin: 10px 0 0 20px;
    }
    .status p {
        font-weight: bold;
    }
</style>
");

if(isset($_GET["submit"])) {
        
    // API request
    $status = json_decode(file_get_contents('https://api.mcsrvstat.us/2/'.$_GET["ip"]));

    echo "<div class='status'>";
    if ($status->online) { // Zobrazení dat o serveru, pokud je ONLINE
        echo "<p>Adresa: ".$_GET["ip"]."</p><br>";
        if (isset($status->players->online)) {echo "<p>Online Hráči: ".$status->players->online."</p><br>";}
        if (isset($status->players->max)) {echo "<p>Počet Slotů: ".$status->players->max."</p><br>";}
        if (isset($status->version)) {echo "<p>Verze Serveru: ".$status->version."</p><br>";}
        if (isset($status->hostname)) {echo "<p>Hostname: ".$status->hostname."</p><br>";}
        if (isset($status->ip)) {echo "<p>IPv4 Adresa: ".$status->ip."</p><br>";}
        if (isset($status->port)) {echo "<p>Port Serveru: ".$status->port."</p><br>";}
        if (isset($status->software)) {echo "<p>Software: ".$status->software."</p><br>";}
        if (isset($status->debug->ping)) {
            if ($status->debug->ping == "1") {
                echo "<p>Ping: Povoleno</p><br>";
            } else {
                echo "<p>Ping: Zakázáno</p><br>";
            }
        }
        if (isset($status->debug->query)) {
            if ($status->debug->query == "1") {
                echo "<p>Query: Povoleno</p><br>";
            } else {
                echo "<p>Query: Zakázáno</p><br>";
            }
        }
        if (isset($status->motd->html[0])) {echo "<p>MOTD Serveru:</p><br>".$status->motd->html["0"]."<br>";}
        if (isset($status->motd->html[1])) {echo $status->motd->html["1"]."<br>";}


    } else { // Zobrazení dat o serveru, pokud je OFFLINE
        echo "Server je offline, nebo nenalazen.";
    }
    echo "</div>";
}
