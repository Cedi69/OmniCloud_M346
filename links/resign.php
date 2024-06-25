<?php
function release_resources($geheimeNummer) {
    // Dateien
    $serversDatei = '../verarbeitung/servers.txt';
    $bestellungenDatei = '../verarbeitung/orders.txt';

    if (!file_exists($serversDatei) || !file_exists($bestellungenDatei)) {
        echo "Fehler beim Laden der Dateien.";
        return;
    }
    // Server und Bestellungen laden
    $servers = loadServers($serversDatei);
    $bestellungen = loadOrders($bestellungenDatei);
    // Bestellungen durchgehen
    foreach ($bestellungen as $bestellIndex => $bestellung) {
        $bestellGeheimeNummer = trim($bestellung['secretNumber']);
        $geheimeNummer = trim($geheimeNummer);

        if ($bestellGeheimeNummer == $geheimeNummer) {
            $serverName = $bestellung['server'];
            // Ressourcen freigeben
            if (isset($servers[$serverName])) {
                $servers[$serverName]['cpu'] += $bestellung['cpu'];
                $servers[$serverName]['memory'] += $bestellung['ram'];
                $servers[$serverName]['disk'] += $bestellung['ssd'];

                unset($bestellungen[$bestellIndex]);

                saveServers($servers, $serversDatei);
                saveOrders($bestellungen, $bestellungenDatei);

                echo "Erfolgreich";
                return;
            } else {
                echo "Server nicht im Servers-Array gefunden.<br>";
            }
        }
    }

    echo "Ungültige geheime Nummer. Ressourcen können nicht freigegeben werden.";
}

function updateServerResources($serverName, $cpu, $ram, $ssd) {
    $serversDatei = '../verarbeitung/servers.txt';
    $servers = loadServers($serversDatei);

    if (isset($servers[$serverName])) {
        $servers[$serverName]['cpu'] += $cpu;
        $servers[$serverName]['memory'] += $ram;
        $servers[$serverName]['disk'] += $ssd;

        saveServers($servers, $serversDatei);
    }
}

function removeOrder($datei, $bestellung) {
    $bestellungen = loadOrders($datei);
    $index = array_search($bestellung, $bestellungen);
    
    if ($index !== false) {
        unset($bestellungen[$index]);
        saveOrders($datei, $bestellungen);
    }
}

function loadServers($datei) {
    $servers = [];
    $zeilen = file($datei);

    foreach ($zeilen as $zeile) {
        $teile = explode('|', trim($zeile));
        if (count($teile) < 3) {
            continue;
        }
        $nameTeile = explode(':', trim($teile[0]));
        $name = trim($nameTeile[0]);
        $cpu = intval(trim($nameTeile[1]));
        $memory = intval(trim($teile[1]));
        $disk = intval(trim($teile[2]));

        $servers[$name] = ['cpu' => $cpu, 'memory' => $memory, 'disk' => $disk];
    }

    return $servers;
}

function saveServers($servers, $datei) {
    $ausgabe = '';
    foreach ($servers as $name => $server) {
        $ausgabe .= "$name: {$server['cpu']} | {$server['memory']} | {$server['disk']}\n";
    }
    file_put_contents($datei, $ausgabe);
}

function loadOrders($datei) {
    $bestellungen = [];
    $zeilen = file($datei);

    foreach ($zeilen as $zeile) {
        // Bestelldetails auslesen
        $bestellTeile = explode(',', trim($zeile));
        $server = trim(substr($bestellTeile[0], 7));
        $cpu = intval(trim($bestellTeile[1]));
        $ram = intval(trim($bestellTeile[2]));
        $ssd = intval(trim($bestellTeile[3]));
        $geheimeNummer = trim(str_replace([':', ' '], '', substr($bestellTeile[5], 14)));

        $bestellungen[] = ['server' => $server, 'cpu' => $cpu, 'ram' => $ram, 'ssd' => $ssd, 'secretNumber' => $geheimeNummer];
    }

    return $bestellungen;
}

function saveOrders($bestellungen, $datei) {
    $ausgabe = '';
    foreach ($bestellungen as $bestellung) {
        $ausgabe .= "Server: {$bestellung['server']}, CPU: {$bestellung['cpu']}, RAM: {$bestellung['ram']}, SSD: {$bestellung['ssd']}, Gesamtpreis: " . calculateTotalPrice($bestellung['cpu'], $bestellung['ram'], $bestellung['ssd']) . ", Geheime Nummer: {$bestellung['secretNumber']}\n";
    }
    file_put_contents($datei, $ausgabe);
}

function calculateTotalPrice($cpu, $ram, $ssd) {
    $cpuPreise = [1 => 5, 2 => 10, 4 => 18, 8 => 30, 16 => 45];
    $ramPreise = [512 => 5, 1024 => 10, 2048 => 20, 4096 => 40, 8192 => 80, 16384 => 160, 32768 => 320];
    $ssdPreise = [10 => 5, 20 => 10, 40 => 20, 80 => 40, 240 => 120, 500 => 250, 1000 => 500];
    return $cpuPreise[$cpu] + $ramPreise[$ram] + $ssdPreise[$ssd];
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["geheimeNummer"])) {
        $geheimeNummer = $_POST["geheimeNummer"];
        release_resources($geheimeNummer);
    }
}
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vertrag kündigen</title>
    <link rel="stylesheet" href="../styles.css">
    <style>
        
    nav {
            text-align: center;
            margin-top: 20px;
        }

        nav ul {
            list-style: none;
            display: flex;
            justify-content: center;
            margin: 0;
            padding: 0;
        }

        nav ul li {
            margin-right: 20px;
            position: relative;
        }

        nav a {
            text-decoration: none;
            color: #333;
            font-weight: bold;
            font-size: 1.2em;
            transition: color 0.3s ease, background-color 0.3s ease;
            padding: 10px;
            border-radius: 5px;
            background-color: #2072b1;
        }
        .dropdown {
            display: inline-block;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #f9f9f9;
            box-shadow: 0 8px 16px rgba(0,0,0,0.2);
            z-index: 1;
        }

        .dropdown-content a {
            color: #333;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
        }

        .dropdown-content a:hover {
            background-color: #ddd;
        }

        .dropdown:hover .dropdown-content {
            display: block;
        }


        nav a:hover {
            color: #fff;
            background-color: #0056b3;
        }
</style>
</head>
<body>
    <header style="background-color: #3498db; color: #fff;">
        <div class="container">
            <h1 class="title">Vertrag kündigen</h1>
            <p class="subtitle">Geben Sie die geheime Nummer ein, um den Vertrag zu kündigen</p>
            
            <nav>
    <ul>
        <li><a href="../index.php">Startseite</a></li>
        <li><a href="./pricing.html">Preise</a></li>
        <li><a href="./about.html">Über uns</a></li>
        <li><a href="./umsatzberechnung.php">Umsatzberechnung</a></li>
        <li class="dropdown">
            <a href="#">Kontakt</a>
            <div class="dropdown-content">
                <a href="./contact.php">Allgemeine Kontaktaufnahme</a>
            </div>
        </li>
    </ul>
</nav>
        </div>
    </header>

    <div class="container">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <label for="geheimeNummer">Geheime Nummer:</label>
            <input type="text" name="geheimeNummer" id="geheimeNummer" required>
            <button type="submit">Vertrag kündigen</button>
        </form>
    </div>
</body>
</html>
