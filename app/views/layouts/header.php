<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>StaffTracker</title>
    
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="/ControlAsistencia/public/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="/ControlAsistencia/public/assets/css/style.css">
    <link rel="stylesheet" href="/ControlAsistencia/public/assets/css/responsive.css">
    
    <!-- Favicon -->
    <link rel="icon" href="/ControlAsistencia/public/assets/img/logo.png">
    <link rel="apple-touch-icon" href="/ControlAsistencia/public/assets/img/logo.png">
    
    <!-- Custom Scrollbar CSS -->
    <link rel="stylesheet" href="/ControlAsistencia/public/assets/css/jquery.mCustomScrollbar.min.css">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css">
    
    <!-- Fancybox -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.css" media="screen">
    
    <style>
        .navbar {
            background-color: white !important;
            
            box-shadow: 0px 4px 10px rgba(0, 120, 50, 0.5); /* Sombra difuminada */
        }
        .navbar-brand img {
            height: 70px; /* Aumenta el tamaño del logo */
        }
        .nav-link {
            font-size: 1.3rem; /* Aumenta el tamaño de la letra */
            color: #007832 !important; /* Color de los textos */
        }
        .navbar-toggler-icon {
            background-color: black !important; /* Cambia el color del icono del botón toggler */
        }
    </style>
</head>
<body class="main-layout">
    <header>
        <nav class="navbar navbar-expand-lg">
            <div class="container-fluid">
                <a class="navbar-brand" href="Inicio">
                    <img src="/ControlAsistencia/public/assets/img/logo.png" alt="Logo" class="img-fluid">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link active" href="#">Inicio</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Contacto</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Login</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
</body>
</html>