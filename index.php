<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
    <title>OmniCloud Demo</title>
</head>
<body>
    <header style="background-color: #3498db; color: #fff;">
        <div class="container">
            <h1 class="title">Willkommen bei OmniCloud</h1>
            <p class="subtitle">Erleben Sie die Zukunft der Cloud-Infrastruktur</p>
            
            <!-- Navbar -->
            <nav>
    <ul>
        <li><a href="./links/pricing.html">Preise</a></li>
        <li><a href="./links/about.html">Über uns</a></li>
        <li><a href="./links/umsatzberechnung.php">Umsatzberechnung</a></li>
        <li class="dropdown">
            <a href="#">Kontakt</a>
            <div class="dropdown-content">
                <a href="./links/contact.php">Allgemeine Kontaktaufnahme</a>
                <a href="./links/resign.php">Kündigung</a>
            </div>
        </li>
    </ul>
</nav>

        </div>
    </header>

    <div class="container">
        <!-- VM-Verkauf -->
        <section id="vm-provisioning" class="animated-section">
            <h2 class="section-title">VM Bestellen</h2>
            <form action="verarbeitung/submit_order.php" method="post" class="form">
                <div class="form-group">
                    <label for="cpu">Anzahl Cores:</label>
                    <select name="cpu" id="cpu" class="styled-select">
                        <option value="1">1 Core (5 CHF)</option>
                        <option value="2">2 Cores (10 CHF)</option>
                        <option value="4">4 Cores (18 CHF)</option>
                        <option value="8">8 Cores (30 CHF)</option>
                        <option value="16">16 Cores (45 CHF)</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="ram">RAM (MB):</label>
                    <select name="ram" id="ram" class="styled-select">
                        <option value="512">512 MB (5 CHF)</option>
                        <option value="1024">1'024 MB (10 CHF)</option>
                        <option value="2048">2'048 MB (20 CHF)</option>
                        <option value="4096">4'096 MB (40 CHF)</option>
                        <option value="8192">8'192 MB (80 CHF)</option>
                        <option value="16384">16'384 MB (160 CHF)</option>
                        <option value="32768">32'768 MB (320 CHF)</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="ssd">SSD (GB):</label>
                    <select name="ssd" id="ssd" class="styled-select">
                        <option value="10">10 GB (5 CHF)</option>
                        <option value="20">20 GB (10 CHF)</option>
                        <option value="40">40 GB (20 CHF)</option>
                        <option value="80">80 GB (40 CHF)</option>
                        <option value="240">240 GB (120 CHF)</option>
                        <option value="500">500 GB (250 CHF)</option>
                        <option value="1000">1'000 GB (500 CHF)</option>
                    </select>
                </div>

                <button type="submit">VM bestellen</button>
            </form>
        </section>
    </div>

    <footer style="background-color: #333; color: #fff;">
        <div class="container">
            <p>&copy; 2023 OmniCloud</p>
        </div>
    </footer>
</body>
</html>
