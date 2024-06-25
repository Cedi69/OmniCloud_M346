<?php
/* 
Small: 4 | 32768 | 1000
Medium: 8 | 65536 | 2000
Big: 16 | 131072 | 4000
*/
$secretNumber = uniqid();
function calculateTotalPrice($cpu, $ram, $ssd) {
    $cpuPrices = [1 => 5, 2 => 10, 4 => 18, 8 => 30, 16 => 45];
    $ramPrices = [512 => 5, 1024 => 10, 2048 => 20, 4096 => 40, 8192 => 80, 16384 => 160, 32768 => 320];
    $ssdPrices = [10 => 5, 20 => 10, 40 => 20, 80 => 40, 240 => 120, 500 => 250, 1000 => 500];
    return $cpuPrices[$cpu] + $ramPrices[$ram] + $ssdPrices[$ssd];
}

function loadTotalRevenue() {
    $file = 'umsatz.txt';
    if (file_exists($file)) {
        return intval(file_get_contents($file));
    }
    return 0;
}
// Funktion zum Aktualisieren und Speichern des Gesamtumsatzes in die Datei
function updateTotalRevenue($totalPrice) {
    $file = 'umsatz.txt';
    $currentRevenue = loadTotalRevenue();
    $newRevenue = $currentRevenue + $totalPrice;
    file_put_contents($file, $newRevenue);
}

function validateInputs($cpu, $ram, $ssd) {
    // Überprüfe, ob die Eingaben numerisch und nicht leer sind
    if (!is_numeric($cpu) || !is_numeric($ram) || !is_numeric($ssd) || empty($cpu) || empty($ram) || empty($ssd)) {
        return false;
    }

    // Überprüfe, ob die Werte im zulässigen Bereich liegen
    $allowedCores = [1, 2, 4, 8, 16];
    $allowedRam = [512, 1024, 2048, 4096, 8192, 16384, 32768];
    $allowedSsd = [10, 20, 40, 80, 240, 500, 1000];

    if (!in_array($cpu, $allowedCores) || !in_array($ram, $allowedRam) || !in_array($ssd, $allowedSsd)) {
        return false;
    }

    return true;
}

function displayMessage($message, $type) {
    $class = ($type == 'error') ? 'error-message' : 'success-message';
    return '<section class="' . $class . '"><p class="' . $class . '-text">' . $message . '</p></section>';
}

function submit_order($order) {
    $servers = loadServers(); // Lade Serverinformationen aus der Datei

    // Extract resources from order
    $cpu = $order['cpu'];
    $memory = $order['memory'];
    $disk = $order['disk'];

    // Jeden Server übrprüfen, ob er genügend Ressourcen hat
    foreach ($servers as $name => &$server) {
        if ($server['cpu'] >= $cpu && $server['memory'] >= $memory && $server['disk'] >= $disk) {
            // Ressourcen verteilen
            $server['cpu'] -= $cpu;
            $server['memory'] -= $memory;
            $server['disk'] -= $disk;

            // Speichern
            saveServers($servers);

            return $name;
        }
    }

    return false; // Kein Server ist frei
}

// Funktion zum Laden der Serverinformationen aus der Datei
function loadServers() {
    $servers = [];
    $lines = file('servers.txt');

foreach ($lines as $line) {
    $parts = explode('|', trim($line));
    if (count($parts) < 3) {
        // Skip this line, it does not have the expected number of parts
        continue;
    }
    $nameParts = explode(':', trim($parts[0]));
    $name = trim($nameParts[0]);
    $cpu = intval(trim($nameParts[1]));
    $memory = intval(trim($parts[1]));
    $disk = intval(trim($parts[2]));

    $servers[$name] = ['cpu' => $cpu, 'memory' => $memory, 'disk' => $disk];
}

    return $servers;
}

// Funktion zum Speichern der aktualisierten Serverinformationen in die Datei
function saveServers($servers) {
    $output = '';
    foreach ($servers as $name => $server) {
        $output .= "$name: {$server['cpu']} | {$server['memory']} | {$server['disk']}\n";
    }
    file_put_contents('servers.txt', $output);
}

$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cpu = $_POST["cpu"];
    $ram = $_POST["ram"];
    $ssd = $_POST["ssd"];

    if (validateInputs($cpu, $ram, $ssd)) {
        $server = submit_order(['cpu' => $cpu, 'memory' => $ram, 'disk' => $ssd]);

        if ($server !== false) {
            $totalPrice = calculateTotalPrice($cpu, $ram, $ssd);

            // Umsatz aktualisieren und speichern
            updateTotalRevenue($totalPrice);

            $orderDetails = "Server: $server, CPU: $cpu, RAM: $ram, SSD: $ssd, Total Price: $totalPrice, Secret Number: $secretNumber\n";
            file_put_contents('orders.txt', $orderDetails, FILE_APPEND);

            $message = displayMessage("Ihre Bestellung wurde erfolgreich gespeichert. Der Gesamtpreis beträgt $totalPrice CHF. Ihre Secret Number zur Beendigung des Vertrages ist [$secretNumber]. Speichern Sie diese ab, da dies der einzige Weg ist, den Server zu kündigen.", 'success');
        } else {
            $message = displayMessage("Ihre Bestellung konnte nicht gespeichert werden. Bitte versuchen Sie es später erneut.", 'error');
        }
    } else {
        $message = displayMessage("Ungültige Eingaben. Bitte überprüfen Sie Ihre Eingaben und versuchen Sie es erneut.", 'error');
    }
}

?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles.css">
    <title>OmniCloud Demo</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
            color: #333;
            transition: background-color 0.5s ease;
        }

        header {
            background-color: #3498db;
            color: #fff;
            text-align: center;
            padding: 2em 0;
            margin-bottom: 20px;
            transition: background-color 0.5s ease, color 0.5s ease;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 0 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .title {
            font-size: 2.5em;
            margin-bottom: 0.2em;
            animation: fadeInDown 1s ease;
        }

        .subtitle {
            font-size: 1.2em;
            margin-bottom: 2em;
            animation: fadeInUp 1s ease;
        }

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

        form {
            width: 100%;
            max-width: 600px;
            margin: 20px 0;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-size: 1.2em;
        }

        input,
        textarea,
        select {
            width: 100%;
            padding: 12px;
            margin-bottom: 12px;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-top: 8px;
            font-size: 1em;
        }

        #vm-provisioning {
            margin-bottom: 40px;
            
        }

        button {
            background-color: #2072b1;
            color: #fff;
            padding: 15px 30px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 1.2em;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #0056b3;
        }

        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>
<body>
    <header style="background-color: #3498db; color: #fff;">
        <div class="container">
            <h1 class="title">Willkommen bei OmniCloud</h1>
            <p class="subtitle">Erleben Sie die Zukunft der Cloud-Infrastruktur</p>
            
            <!-- Navbar -->
            <nav>
                <ul>
                    <li><a href="../links/pricing.html">Preise</a></li>
                    <li><a href="../links/about.html">Über uns</a></li>
                    <li><a href="../links/contact.php">Kontakt</a></li>
                    <li class="dropdown">
                        <a href="./links/contact.php">Kontakt</a>
                            <div class="dropdown-content">
                                <a href="./links/contact.php">Allgemeine Kontaktaufnahme</a>
                                <a href="./links/resign.php">Vertrag kündigen</a>
                            </div>
                    </li>
                </ul>
            </nav>
        </div>
    </header>

    <div class="container">
    <?php echo $message; ?>
    </div>

    <footer style="background-color: #333; color: #fff; margin-bottom: -1px">
        <div class="container">
            <p>&copy; 2023 OmniCloud</p>
        </div>
    </footer>
</body>
</html>