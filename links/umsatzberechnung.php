<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OmniCloud Umsatzberechnung</title>
    <link rel="stylesheet" href="../styles.css">
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
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
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

        .umsatz-container {
            text-align: center;
            margin-top: 50px;
        }

        .umsatz {
            font-size: 2em;
            font-weight: bold;
            color: #333;
            background-color: #f2f2f2;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
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
                <li><a href="../index.php">Startseite</a></li>
                    <li><a href="./pricing.html">Preise</a></li>
                    <li><a href="./about.html">Über uns</a></li>
                    <li class="dropdown">
                        <a href="#">Kontakt</a>
                        <div class="dropdown-content">
                            <a href="./contact.php">Allgemeine Anfrage</a>
                            <a href="./resign.php">Kündigung</a>
                        </div>
                    </li>
                </ul>
            </nav>
        </div>
    </header>

    <div class="container">
        <!-- Umsatzberechnung -->
        <div class="umsatz-container">
            <div class="umsatz">
            <?php
                // Pfad zur Umsatzdatei
                $umsatzdatei = '../verarbeitung/umsatz.txt';

                // Überprüfen, ob die Datei existiert
                if (file_exists($umsatzdatei)) {
                    // Inhalt der Datei lesen und in $gesamtumsatz speichern
                    $gesamtumsatz = file_get_contents($umsatzdatei);

                    // Ausgabe des Gesamtumsatzes
                    echo "Gesamtumsatz: $gesamtumsatz CHF";
                } else {
                    // Wenn die Datei nicht existiert, eine Fehlermeldung ausgeben
                    echo "Die Umsatzdatei existiert nicht.";
                }
                ?>
            </div>
        </div>
    </div>
</body>
</html>
