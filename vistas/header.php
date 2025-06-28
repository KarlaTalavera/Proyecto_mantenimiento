<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio</title>
    <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/dataTables.bootstrap4.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.5/js/dataTables.bootstrap4.min.js"></script>

    <link rel="stylesheet" href="/Mantenimiento-Ascardio/vistas/estilos/style.css">
    <link rel="stylesheet" href="/Mantenimiento-Ascardio/vistas/estilos/estiloDispositivos.css">
    <link rel="stylesheet" href="/Mantenimiento-Ascardio/vistas/estilos/estiloUsuarios.css">
</head>

<body>
    <header>    
        <nav class="navbar navbar-expand-lg" style="background-color: #800020;">
            <div class="container-fluid">
                <a class="navbar-brand d-flex align-items-center text-white" href="#">
                    <svg width="36" height="36" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg" transform="rotate(0 0 0)">
                    <path d="M5.91553 3.5625C5.91553 3.14829 6.25131 2.8125 6.66553 2.8125H14.3364C16.9598 2.8125 19.0864 4.93915 19.0864 7.5625V7.74609C19.0864 8.16031 18.7506 8.49609 18.3364 8.49609H6.66553C6.25131 8.49609 5.91553 8.16031 5.91553 7.74609V3.5625Z" fill="#ffffff"/>
                    <path d="M10.3349 9.49609L9.8244 20.4578C9.76468 21.7402 10.7882 22.8125 12.072 22.8125H12.929C14.2127 22.8125 15.2363 21.7402 15.1766 20.4578L14.6661 9.49609H10.3349Z" fill="#ffffff"/>
                    </svg>
                    <span class="mantenimiento-text">Control de Mantenimiento</span>
                </a>
                <span class="ms-auto text-white">
                    Bienvenido <?php
                    if (isset($_SESSION['usuario']['nombre'], $_SESSION['usuario']['apellido'])) {
                        echo htmlspecialchars($_SESSION['usuario']['nombre'] . ' ' . $_SESSION['usuario']['apellido']);
                    } elseif (isset($_SESSION['usuario']['usuario'])) {
                        echo htmlspecialchars($_SESSION['usuario']['usuario']);
                    }
                ?>
                </span>
            </div>
        </nav>
    </header>
    <div class="wrapper">
        <aside id="sidebar">
            <div class="d-flex">
                <button id="toggle-btn" type="button">
                    <i class="lni lni-grid-alt"></i>
                </button>
                <div class="sidebar-logo"> 
                    <a href="#" class="menu-title">Menu</a>
                </div>
            </div>
            <ul class="sidebar-nav">

                <li class="sidebar-item">
                    <a href="#" class="sidebar-link">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" transform="rotate(0 0 0)">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M9.75 20.5V22H6.75C5.50736 22 4.5 20.9926 4.5 19.75V9.62105C4.5 9.02455 4.73686 8.45247 5.15851 8.03055L10.5262 2.65951C10.9482 2.23725 11.5207 2 12.1177 2H17.25C18.4926 2 19.5 3.00736 19.5 4.25V9.75H18V4.25C18 3.83579 17.6642 3.5 17.25 3.5H12.248L12.2509 7.4984C12.2518 8.74166 11.2442 9.75 10.0009 9.75H6V19.75C6 20.1642 6.33579 20.5 6.75 20.5H9.75ZM10.7488 4.55876L7.05986 8.25H10.0009C10.4153 8.25 10.7512 7.91389 10.7509 7.49947L10.7488 4.55876Z" fill="#343C54"/>
                            <path d="M12.4853 12.4853C12.1924 12.7782 12.1924 13.2531 12.4853 13.546L15.5643 16.625L12.4853 19.704C12.1924 19.9969 12.1924 20.4718 12.4853 20.7647C12.7782 21.0576 13.2531 21.0576 13.546 20.7647L16.625 17.6857L19.7026 20.7633C19.9955 21.0562 20.4704 21.0562 20.7633 20.7633C21.0562 20.4704 21.0562 19.9955 20.7633 19.7026L17.6857 16.625L20.7633 13.5474C21.0562 13.2545 21.0562 12.7796 20.7633 12.4867C20.4704 12.1938 19.9955 12.1938 19.7026 12.4867L16.625 15.5643L13.546 12.4853C13.2531 12.1924 12.7782 12.1924 12.4853 12.4853Z" fill="#343C54"/>
                        </svg>
                        <span>Reportes de Fallos</span>
                    </a>
                </li>

                <li class="sidebar-item">
                    <a href="index.php?vista=usuarios" class="sidebar-link">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" transform="rotate(0 0 0)">
                            <path d="M8.80437 4.10156C6.7626 4.10156 5.10742 5.75674 5.10742 7.79851C5.10742 9.84027 6.7626 11.4955 8.80437 11.4955C10.8461 11.4955 12.5013 9.84027 12.5013 7.79851C12.5013 5.75674 10.8461 4.10156 8.80437 4.10156Z" fill="#343C54"/>
                            <path d="M1.85175 19.16L1.85172 19.1577L1.85165 19.1513L1.85156 19.1321C1.85156 19.1164 1.85169 19.0952 1.85215 19.0688C1.85309 19.016 1.85538 18.9421 1.86069 18.8502C1.8713 18.6666 1.89402 18.4095 1.94242 18.1031C2.03866 17.4938 2.23948 16.6698 2.66304 15.837C3.08862 15.0001 3.74414 14.1453 4.74743 13.5023C5.75344 12.8576 7.06383 12.4551 8.75032 12.4551C10.4368 12.4551 11.7472 12.8576 12.7532 13.5023C13.7565 14.1453 14.412 15.0001 14.8376 15.837C15.2612 16.6698 15.462 17.4938 15.5582 18.1031C15.6066 18.4095 15.6293 18.6666 15.6399 18.8502C15.6453 18.9421 15.6476 19.016 15.6485 19.0688C15.649 19.0952 15.6491 19.1164 15.6491 19.1321L15.649 19.1513L15.6489 19.1577L15.6489 19.161C15.6418 19.5701 15.3081 19.8988 14.899 19.8988H2.60167C2.19253 19.8988 1.85888 19.5709 1.85178 19.1618C1.85178 19.1618 1.85179 19.1625 1.85175 19.16Z" fill="#343C54"/>
                            <path d="M17.0209 19.8988C17.0999 19.6756 17.1446 19.4363 17.149 19.187L17.1491 19.1799L17.1493 19.1676L17.1494 19.1387L17.1494 19.1327C17.1494 19.1083 17.1492 19.078 17.1486 19.0422C17.1473 18.9708 17.1443 18.8769 17.1378 18.7637C17.1247 18.538 17.0974 18.2312 17.0402 17.8691C17.0103 17.6801 16.9717 17.472 16.9215 17.2494C16.9165 17.2261 16.9113 17.2028 16.9058 17.1794C16.6448 16.0607 16.0667 14.4931 14.7497 13.189C14.515 12.9567 14.2627 12.7384 13.9924 12.5363C14.3865 12.4831 14.8056 12.4551 15.2509 12.4551C16.9373 12.4551 18.2477 12.8576 19.2537 13.5023C20.257 14.1453 20.9126 15.0001 21.3381 15.837C21.7617 16.6698 21.9625 17.4938 22.0588 18.1031C22.1072 18.4095 22.1299 18.6666 22.1405 18.8502C22.1458 18.9421 22.1481 19.016 22.149 19.0688C22.1495 19.0952 22.1496 19.1164 22.1496 19.1321L22.1495 19.1513L22.1495 19.1577L22.1494 19.161C22.1423 19.5701 21.8086 19.8988 21.3995 19.8988H17.0209Z" fill="#343C54"/>
                            <path d="M14.0028 7.79851C14.0028 8.89595 13.6627 9.91394 13.082 10.7528C13.7007 11.219 14.4705 11.4955 15.3049 11.4955C17.3467 11.4955 19.0018 9.84027 19.0018 7.79851C19.0018 5.75674 17.3467 4.10156 15.3049 4.10156C14.4705 4.10156 13.7007 4.37797 13.082 4.84422C13.6627 5.68307 14.0028 6.70106 14.0028 7.79851Z" fill="#343C54"/>
                        </svg>
                        <span>Gestión de Usuarios</span>
                    </a>
                </li>

                <li class="sidebar-item">
                    <a href="index.php?vista=mantenimiento" class="sidebar-link">
                        <svg width="16" height="16" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg" transform="rotate(0 0 0)">
                            <path d="M14.1362 4.81223L14.0173 4.0966C13.8941 3.35513 13.2527 2.81152 12.5011 2.81152C11.7501 2.81152 11.109 3.35433 10.9852 4.09511L10.8653 4.81223H6.66553C6.25131 4.81223 5.91553 5.14802 5.91553 5.56223V9.74583C5.91553 10.16 6.25131 10.4958 6.66553 10.4958H18.3364C18.7506 10.4958 19.0864 10.16 19.0864 9.74583V9.56223C19.0864 6.93888 16.9598 4.81223 14.3364 4.81223H14.1362Z" fill="#343C54"/>
                            <path d="M14.6797 11.4961H10.3213L9.83717 20.4406C9.76742 21.7292 10.7935 22.8122 12.0839 22.8122H12.9171C14.2075 22.8122 15.2336 21.7292 15.1638 20.4406L14.6797 11.4961Z" fill="#343C54"/>
                        </svg>

                        <span>Mantenimiento</span>
                    </a>
                </li>
                 <li class="sidebar-item">
                    <a href="index.php?vista=dispositivos" class="sidebar-link">
                        <svg width="16" height="16" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg" transform="rotate(0 0 0)">
                            <path d="M18.1551 7.03906V6.87162C18.1551 6.26272 17.9083 5.67982 17.4711 5.25602L16.3139 4.1344C15.8942 3.72753 15.3325 3.5 14.7479 3.5H8.09493C6.85229 3.5 5.84493 4.50736 5.84493 5.75V7.03906H18.1551Z" fill="#343C54"/>
                            <path d="M5.50049 8.03906C4.25785 8.03906 3.25049 9.04642 3.25049 10.2891V14.2076C3.25049 15.2221 3.92196 16.0798 4.84473 16.3605V14.1953C4.84473 13.2288 5.62823 12.4453 6.59473 12.4453H17.4049C18.3714 12.4453 19.1549 13.2288 19.1549 14.1953V16.3606C20.0779 16.0801 20.7496 15.2223 20.7496 14.2076V10.2891C20.7496 9.04642 19.7422 8.03906 18.4996 8.03906H5.50049Z" fill="#343C54"/>
                            <path d="M5.84473 18.749C5.84473 19.9916 6.85209 20.999 8.09473 20.999H15.9049C17.1475 20.999 18.1549 19.9916 18.1549 18.749V14.1953C18.1549 13.7811 17.8191 13.4453 17.4049 13.4453H6.59473C6.18051 13.4453 5.84473 13.7811 5.84473 14.1953V18.749Z" fill="#343C54"/>
                        </svg>
                        <span>Gestión de dispositivos</span>
                    </a>
                </li>
            </ul>
            <div class="sidebar-item">
                <a href="vistas/logout.php" class="sidebar-link">
                    <i class="lni lni-exit text-danger fs-3"></i>
                    <span>Cerrar sesión</span>
                </a>
            </div>
        </aside>
