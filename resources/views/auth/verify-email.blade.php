<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link href="img/logo/logo.png" rel="icon">
    <title>Vérification de l'e-mail</title>
    <!-- Styles du thème -->
    <link href="{{ asset('admin/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('admin/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('admin/css/ruang-admin.min.css') }}" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fc; /* Couleur de fond du corps */
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 40px 20px;
            background-color: #fff;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
        }

        h1 {
            color: #333;
            font-size: 28px;
            margin-bottom: 20px;
        }

        p {
            color: #666;
            font-size: 16px;
            line-height: 1.5;
            margin-bottom: 20px;
        }

        form button {
            padding: 10px 20px;
            background-color: #007bff; /* Couleur de fond du bouton */
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        form button:hover {
            background-color: #0056b3; /* Couleur de fond du bouton au survol */
        }

        a {
            color: #007bff; /* Couleur des liens */
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Vérification de l'e-mail</h1>
        <p>Merci pour votre inscription ! Avant de commencer, veuillez vérifier votre e-mail pour un lien de vérification.</p>
        <p>Si vous n'avez pas reçu l'e-mail, cliquez sur le bouton ci-dessous pour renvoyer le lien de vérification.</p>
        <form method="POST" action="{{ route('verification.resend') }}">
            @csrf
            <button type="submit">Renvoyer le lien de vérification</button>
        </form>
        @if (session('message'))
        <p>{{ session('message') }}</p>
        @endif
        <p>Une fois votre e-mail vérifié, vous pouvez vous <a href="{{ route('login') }}">connecter ici</a></p>
        <!-- Liens de navigation -->
       
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault();
                        this.closest('form').submit();">
                    <i class="fas fa-fw fa-sign-out-alt"></i>
                    <span>Back</span>
                </a>
            </form>
       
    </div>

    <!-- Scripts -->
    <script src="{{ asset('admin/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('admin/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('admin/js/ruang-admin.min.js') }}"></script>
</body>

</html>
