<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="build/js/app.js"></script>
    <link rel="shortcut icon" href="<?= asset('images/cit.png') ?>" type="image/x-icon">
    <link rel="stylesheet" href="<?= asset('build/styles.css') ?>">
    <title>DemoApp</title>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark  bg-dark">
        
        <div class="container-fluid">

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarToggler" aria-controls="navbarToggler" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <a class="navbar-brand" href="/<?= $_ENV['APP_NAME'] ?>/">
                <img src="<?= asset('./images/cit.png') ?>" width="35px" alt="cit" >
                Aplicaciones
            </a>
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
    <ul class="navbar-nav ms-auto">
    <li class="nav-item">
        <a class="nav-link" href="/app01_avpc">inicio</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="/app01_avpc/productos">Lista de Compras</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="#scrollspyHeading2">Second</a>
    </li>
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false">Más</a>
        <ul class="dropdown-menu dropdown-menu-end">
            <li><a class="dropdown-item" href="#scrollspyHeading3">Third</a></li>
            <li><a class="dropdown-item" href="#scrollspyHeading4">Fourth</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="#scrollspyHeading5">Fifth</a></li>
        </ul>
    </li>
</ul>
</div>
        </div>
        
    </nav>
    <div class="progress fixed-bottom" style="height: 6px;">
        <div class="progress-bar progress-bar-animated bg-danger" id="bar" role="progressbar" aria-valuemin="0" aria-valuemax="100"></div>
    </div>
    <div class="container-fluid pt-5 mb-4" style="min-height: 85vh">
        
        <?php echo $contenido; ?>
    </div>
    <div class="container-fluid " >
        <div class="row justify-content-center text-center">
            <div class="col-12">
                <p style="font-size:xx-small; font-weight: bold;">
                        Comando de Informática y Tecnología, <?= date('Y') ?> &copy;
                </p>
            </div>
        </div>
    </div>
</body>
</html>