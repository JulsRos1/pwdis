<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PWA Installation Guide</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        header {
            background-color: #007bff;
            color: white;
        }

        main img {
            max-width: 100%;
            height: auto;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        footer {
            background-color: #343a40;
            color: white;
        }


        .mobile {
            height: 400px;
        }

        @media (max-width: 960px) {
            .mobile {
                height: 15em;
            }
        }
    </style>
</head>

<body>
    <header class="bg-primary text-white text-center py-3">
        <h1> PWDIS Installation Guide</h1>
        <p>Follow these steps to install our Progressive Web App (PWA) on your device.</p>
    </header>

    <main class="container my-4">
        <section>
            <h2>Install on Android</h2>
            <ol class="list-group list-group-numbered">
                <li class="list-group-item">
                    Open the app in Chrome or your preferred browser.
                </li>
                <li class="list-group-item">
                    Tap the <strong>Menu</strong> button (three dots in the top-right corner).
                </li>
                <li class="list-group-item">
                    Select <strong>"Add to Home Screen"</strong>.
                </li>
                <li class="list-group-item">
                    Confirm by tapping <strong>"Add"</strong>.
                </li>
            </ol>
            <img src="./images/android.jpg" class="img-fluid mt-3 mobile" alt="Install PWA on Android">
        </section>

        <hr>

        <section>
            <h2>Install on iOS</h2>
            <ol class="list-group list-group-numbered">
                <li class="list-group-item">
                    Open the app in Safari on your iPhone or iPad and go to our website's URL.
                </li>
                <li class="list-group-item">
                    Tap the <strong>Share</strong> button (box with an arrow pointing up).
                </li>
                <li class="list-group-item">
                    Scroll down and select <strong>"Add to Home Screen"</strong>.
                </li>
                <li class="list-group-item">
                    Confirm by tapping <strong>"Add"</strong> in the top-right corner.
                </li>
            </ol>
            <img src="./images/Ios.jpg" class="img-fluid mt-3 mobile" alt="Install PWA on iOS">
        </section>

        <hr>

        <section>
            <h2>Install on Desktop</h2>
            <ol class="list-group list-group-numbered">
                <li class="list-group-item">
                    Open the app in Chrome, Edge, or a supported browser.
                </li>
                <li class="list-group-item">
                    Look for the <strong>Install</strong> icon in the url or address bar of our website.
                </li>
                <li class="list-group-item">
                    Click <strong>"Install"</strong> and follow the prompts.
                </li>
            </ol>
            <img src="./images/Desktop.jpg" class="img-fluid mt-3 mobile" alt="Install PWA on Desktop">
        </section>
    </main>

    <footer class="bg-dark text-white text-center py-3">
        <p>&copy; 2024 Your App Name. All Rights Reserved.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>