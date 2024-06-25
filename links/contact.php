<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kontaktaufnahme - OmniCloud</title>
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
            margin-bottom: 20px; /* Abstand zwischen Header und Formular */
            transition: background-color 0.5s ease, color 0.5s ease;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
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
            max-width: 700px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            margin-bottom: 8px;
        }

        input,
        textarea {
            width: 95%;
            padding: 17px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-top: 10px;
        }

        .radiobutton {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
        }

        .radiobutton label {
            flex-basis: 48%;
        }

        input[type="radio"] {
            margin-right: 5px;
        }

        textarea {
            resize: vertical;
        }

        button {
            background-color: #3498db;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 1em;
        }

        button:hover {
            background-color: #2072b1;
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
            <h1 class="title">Kontaktaufnahme</h1>
            <p class="subtitle">Treten Sie mit uns in Kontakt</p>
            
            <!-- Navigationsleiste -->
            <nav>
                <ul>
                    <li><a href="../index.php">Startseite</a></li>
                    <li><a href="./about.html">Über uns</a></li>
                    <li><a href="./pricing.html">Preise</a></li>
                    <li><a href="./umsatzberechnung.php">Umsatzberechnung</a></li>
                </ul>
            </nav>
        </div>
    </header>
    <form action="mailto:finn.bachman@stud.edubs.ch" method="post" enctype="text/plain">
        <div class="radiobutton">
            <label for="gender">Anrede:</label>
            <input type="radio" name="gender" id="male" required>
            <label for="male">Männlich</label>
            <input type="radio" name="gender" id="female" required>
            <label for="female">Weiblich</label>
        </div>

        <label for="name">Name:</label>
        <input type="text" name="name" id="name" required>

        <label for="firstname">Vorname:</label>
        <input type="text" name="firstname" id="firstname" required>

        <label for="email">E-Mail Adresse:</label>
        <input type="email" name="email" id="email" required>

        <label for="phone">Telefonnummer:</label>
        <input type="tel" name="phone" id="phone" pattern="[0-9]+" required>

        <label for="reason">Grund der Kontaktaufnahme:</label>
        <textarea name="reason" id="reason" cols="30" rows="10" required></textarea>

        <button type="submit">Absenden</button>
    </form>
</body>
</html>
