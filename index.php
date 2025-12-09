<?php
// ... (Tu código PHP de conexión a la base de datos se mantiene igual)

// 1. Conexión a la base de datos (se usa @ para suprimir errores si estás probando)
$conn = @new mysqli($servername, $username, $password, $dbname);

$db_error = "";
if ($conn->connect_error) {
    // Si la conexión falla, se guarda un mensaje de error
    $db_error = "";
}

// 2. Función para obtener productos por categoría (USA SENTENCIAS PREPARADAS POR SEGURIDAD)
function get_productos($conn, $categoria) {
    if ($conn->connect_error || empty($conn) || !$conn) {
        return null; 
        // No intenta consultar si la conexión falló
    }

    // Consulta SQL segura (requiere que la tabla 'productos' exista con la columna 'categoria')
    $stmt = $conn->prepare("SELECT nombre FROM productos WHERE categoria = ?");
    
    if (!$stmt) { return null; } // Si falla la preparación (ej: tabla no existe)

    $stmt->bind_param("s", $categoria); // "s" indica que el parámetro es un string
    $stmt->execute();
    $result = $stmt->get_result();
    return $result;
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agropecuaria Guiza</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/shorthandcss@1.1.1/dist/shorthand.min.css" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Muli:200,300,400,500,600,700,800,900&display=swap" />
    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.css" />
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css" />
    
    <style>
        /* ... (Tus estilos CSS se mantienen igual) ... */
        .hidden {
            display: none !important;
        }

        .position-relative {
            position: relative;
        }

        .submenu-content {
            /* Estilos para que el submenú flote sobre la tarjeta */
            position: absolute;
            top: 0;
            left: 0;
            z-index: 10; 
            background-color: rgba(0, 0, 0, 0.95);
            border: 1px solid var(--indigo-lighter);
            width: 100%;
            min-height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
    </style>
</head>

<body class="bg-black muli">
     <nav class="w-100pc flex flex-column md-flex-row md-px-10 py-5 bg-black">
        <div class="flex justify-between">
            <a href="#" class="flex items-center p-2 mr-4 no-underline">
                <img class="max-h-l2 w-auto" src="assets/images/logo.png" alt="Logo Agropecuaria San Camilo" />
            </a>
            <a data-toggle="toggle-nav" data-target="#nav-items" href="#"
                class="flex items-center ml-auto md-hidden indigo-lighter opacity-50 hover-opacity-100 ease-300 p-1 m-3">
                <i data-feather="menu"></i>
            </a>
        </div>
        <div id="nav-items" class="hidden flex sm-w-100pc flex-column md-flex md-flex-row md-justify-end items-center">
            <a href="#home" class="fs-s1 mx-3 py-3 indigo no-underline hover-underline">Inicio</a>
            <a href="#features" class="fs-s1 mx-3 py-3 indigo no-underline hover-underline">Productos</a>
            <a href="#pricing" class="fs-s1 mx-3 py-3 indigo no-underline hover-underline">Combos</a>
            <a href="#servicios" class="fs-s1 mx-3 py-3 indigo no-underline hover-underline">Servicios</a>
            <a href="#contacto" class="button bg-white black fw-600 no-underline mx-5">Contáctanos</a>
        </div>
    </nav>

    
    <section 
        id="home" 
        class="min-h-100vh flex justify-center items-center bg-cover bg-center" 
        style="background-image:url('assets/images/hero-campo.jpg');"
    >
        
        <div class="text-center w-100pc px-5">
            <div class="inline-block br-round bg-indigo-30 indigo-lightest p-2 fs-s2 mb-5">
                <div class="inline-block bg-indigo indigo-lightest br-round px-3 py-1 mr-3 fs-s3">Promoción</div>
                Llegamos con ofertas para productores de San Camilo. Conoce más…
            </div>
            
            <div>
                <h1 class="white fs-l3 lh-2 md-fs-xl1 md-lh-1 fw-900">
                    Insumos confiables<br />para tu campo
                </h1>

                <div class="position-relative mx-auto w-100pc sm-w-80pc md-w-60pc mt-10">
                    <input 
                        id="search-input"
                        type="text" 
                        placeholder="Busca medicinas, fertilizantes o herramientas..."
                        class="input-lg w-100pc bw-0 fw-300 bg-indigo-lightest-10 white ph-indigo-lightest focus-white opacity-80 fs-s3 py-5 px-5 br-8"
                    />
                    <div 
                        id="search-results" 
                        class="hidden position-absolute w-100pc bg-white br-8 shadow-l2 z-10" 
                        style="top: 100%; margin-top: 5px;"
                    >
                        </div>
                </div>
                <div class="white opacity-20 fs-s3 mt-3">
                    Búsqueda en tiempo real en todo nuestro catálogo.
                </div>
            </div>
        </div>
        
    </section>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://unpkg.com/feather-icons"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/cferdinandi/smooth-scroll@15.0.0/dist/smooth-scroll.polyfills.min.js"></script>
    
    <script>
        // Inicializar íconos Feather
        feather.replace();

        // Inicializar sliders
        $(document).ready(function () {
            $('#slider-1').slick({
                dots: true,
                arrows: false,
                autoplay: true,
                autoplaySpeed: 4000,
                adaptiveHeight: true
            });
            $('#slider-2').slick({
                dots: true,
                arrows: false,
                autoplay: true,
                autoplaySpeed: 5000,
                adaptiveHeight: true
            });

            // Botones prev/next externos para slider-1
            $('.prev').on('click', function () { $('#slider-1').slick('slickPrev'); });
            $('.next').on('click', function () { $('#slider-1').slick('slickNext'); });

            // Smooth scroll para navegacion
            var scroll = new SmoothScroll('a[href*="#"]', {
                speed: 500,
                speedAsDuration: true
            });

            // Toggle nav responsive
            $('[data-toggle="toggle-nav"]').on('click', function (e) {
                e.preventDefault();
                var target = $(this).data('target');
                $(target).toggleClass('hidden');
            });

            // =========================================================================
            // !!! CÓDIGO JAVASCRIPT/AJAX PARA BÚSQUEDA INTELIGENTE !!!
            // =========================================================================
            var searchInput = $('#search-input');
            var resultsContainer = $('#search-results');
            var timeout = null;

            // Escucha el evento de teclado en la barra de búsqueda
            searchInput.on('keyup', function() {
                clearTimeout(timeout);
                
                var termino = searchInput.val().trim();
                
                if (termino.length < 3) {
                    // Si el término es muy corto, oculta los resultados
                    resultsContainer.addClass('hidden').empty();
                    return;
                }

                // Espera 300ms (debounce) para no sobrecargar el servidor con cada tecla
                timeout = setTimeout(function() {
                    
                    // Llama al mismo archivo index.php, pero con el parámetro 'ajax=search'
                    $.ajax({
                        url: 'index.php', 
                        method: 'Post',
                        dataType: 'json',
                        data: { q: termino, ajax: 'search' }, // Aquí se envía el parámetro mágico
                        
                        success: function(data) {
                            var htmlContent = '';
                            
                            if (data.error) {
                                // Manejo de errores de PHP (ej. si la DB está caída)
                                htmlContent = `<div class="p-3 red-dark">Error de DB: ${data.error}</div>`;
                            } else if (data.length > 0) {
                                // Muestra los resultados
                                data.forEach(function(producto) {
                                    htmlContent += `
                                        <a href="#" class="block p-3 blue-darker hover-bg-indigo-lightest-10 no-underline ease-300">
                                            <span class="fw-700">${producto.nombre}</span> 
                                            <span class="fs-s3 opacity-60">(${producto.tipo_producto})</span>
                                        </a>
                                    `;
                                });
                            } else {
                                // No hay resultados
                                htmlContent = `
                                    <div class="p-3 fs-s3 blue-darker opacity-60">No se encontraron productos para "${termino}".</div>
                                `;
                            }
                            
                            // Inyecta el contenido y muestra el contenedor
                            resultsContainer.html(htmlContent).removeClass('hidden');
                        },
                        error: function(xhr, status, error) {
                            console.error("Error en la solicitud AJAX:", status, error);
                            resultsContainer.html('<div class="p-3 red-dark">Esto es solo una versión de prueba (no ahi productos en la base de datos).</div>').removeClass('hidden');
                        }
                    });
                    
                }, 300); // Espera 300 milisegundos
            });

            // Ocultar resultados si el usuario hace clic fuera
            $(document).on('click', function(e) {
                if (!$(e.target).closest('#search-input, #search-results').length) {
                    resultsContainer.addClass('hidden').empty();
                }
            });
            
        });
    </script>
    <script src="assets/js/script.js"></script>
                
                <div class="white opacity-20 fs-s3 mt-3">
                    No requerimos tarjeta de crédito
                </div>
            </div>
        </div>
        
    </section>
      
    <section id="features" class="p-10 md-p-l5">
        <h2 class="white fs-l3 fw-900 mb-10 text-center">Nuestros Productos</h2>
        <?php echo $db_error; // Muestra el error de conexión si existe ?>
        <div class="flex flex-column md-flex-row mx-auto">
            
            <div class="w-100pc md-w-40pc position-relative">
                <div class="br-8 p-5 m-5">
                    <div class="flex justify-center items-center bg-indigo-lightest-10 white w-l5 h-l5 br-round mb-5"><i
                            data-feather="package" class="w-l5"></i></div>
                    <h4 class="white fw-600 fs-m3 mb-5">Medicina en general</h4>
                    <div class="indigo-lightest fw-600 fs-m1 lh-3 opacity-50">Inyecciones, pastillas, cremas y mucho más....</div>
                    
                    <button 
                        class="mt-5 button bg-indigo-lightest-10 fs-s3 white no-underline hover-opacity-100 hover-scale-up-1 ease-300 open-submenu" 
                        data-target="submenu-semillas">
                        Ver más
                    </button>

                    <div id="submenu-semillas" class="submenu-content hidden br-8 p-5 m-5">
                        <h5 class="white fw-800 mb-4">Medicina disponible</h5>
                        <ul class="list-none p-0">
                            <?php
                            // Lógica PHP para obtener y mostrar productos de la categoría 'Semillas certificadas'
                            if (empty($db_error)) {
                                $productos_semillas = get_productos($conn, 'Semillas certificadas');
                                if ($productos_semillas && $productos_semillas->num_rows > 0) {
                                    while($row = $productos_semillas->fetch_assoc()) {
                                        // Inyectar (imprimir) dinámicamente cada producto
                                        echo '<li class="indigo-lightest mb-2 fs-s2">🌱 ' . htmlspecialchars($row['nombre']) . '</li>';
                                    }
                                } else {
                                    echo '<li class="indigo-lightest mb-2 fs-s2">No se encontraron productos de Medicina.</li>';
                                }
                            } else {
                                 echo '<li class="indigo-lightest mb-2 fs-s2">Productos de ejemplo (Base de Datos Desconectada): Desparacitante, Gotas Certificado.</li>';
                            }
                            ?>
                        </ul>
                        <button class="close-submenu button bg-white black p-2 br-4 mt-5 fw-600 fs-s2">Cerrar</button>
                    </div>
                </div>
            </div>

            <div class="w-100pc md-w-40pc position-relative">
                <div class="br-8 p-5 m-5">
                    <div class="flex justify-center items-center bg-indigo-lightest-10 white w-l5 h-l5 br-round mb-5"><i
                            data-feather="droplet" class="w-l5"></i></div>
                    <h4 class="white fw-600 fs-m3 mb-5">Fertilizantes y enmiendas</h4>
                    <div class="indigo-lightest fw-600 fs-m1 opacity-50">Orgánicos y químicos con asesoría de dosis generales para mejorar rendimiento y sanidad del suelo.</div>
                    
                    <button 
                        class="mt-5 button bg-indigo-lightest-10 fs-s3 white no-underline hover-opacity-100 hover-scale-up-1 ease-300 open-submenu"
                        data-target="submenu-fertilizantes">
                        Ver más
                    </button>

                    <div id="submenu-fertilizantes" class="submenu-content hidden br-8 p-5 m-5">
                        <h5 class="white fw-800 mb-4">Fertilizantes disponibles</h5>
                        <ul class="list-none p-0">
                            <?php
                            // Lógica PHP para obtener y mostrar productos de la categoría 'Fertilizantes y enmiendas'
                            if (empty($db_error)) {
                                $productos_fert = get_productos($conn, 'Fertilizantes y enmiendas');
                                if ($productos_fert && $productos_fert->num_rows > 0) {
                                    while($row = $productos_fert->fetch_assoc()) {
                                        echo '<li class="indigo-lightest mb-2 fs-s2">🧪 ' . htmlspecialchars($row['nombre']) . '</li>';
                                    }
                                } else {
                                    echo '<li class="indigo-lightest mb-2 fs-s2">No se encontraron productos de Fertilizantes.</li>';
                                }
                            } else {
                                 echo '<li class="indigo-lightest mb-2 fs-s2">Productos de ejemplo (Base de Datos Desconectada): Urea 46-0-0, Abono Orgánico.</li>';
                            }
                            ?>
                        </ul>
                        <button class="close-submenu button bg-white black p-2 br-4 mt-5 fw-600 fs-s2">Cerrar</button>
                    </div>
                </div>
            </div>

            <div class="w-100pc md-w-40pc position-relative">
                <div class="br-8 p-5 m-5">
                    <div class="flex justify-center items-center bg-indigo-lightest-10 white w-l5 h-l5 br-round mb-5"><i
                            data-feather="tool" class="w-l5"></i></div>
                    <h4 class="white fw-600 fs-m3 mb-5">Herramientas y equipos</h4>
                    <div class="indigo-lightest fw-600 fs-m1 opacity-50">Palas, machetes, bombas de fumigar, mangueras, y repuestos para mantener tu finca operativa.</div>
                    
                    <button 
                        class="mt-5 button bg-indigo-lightest-10 fs-s3 white no-underline hover-opacity-100 hover-scale-up-1 ease-300 open-submenu"
                        data-target="submenu-herramientas">
                        Ver más
                    </button>

                    <div id="submenu-herramientas" class="submenu-content hidden br-8 p-5 m-5">
                        <h5 class="white fw-800 mb-4">Herramientas disponibles</h5>
                        <ul class="list-none p-0">
                            <?php
                            // Lógica PHP para obtener y mostrar productos de la categoría 'Herramientas y equipos'
                            if (empty($db_error)) {
                                $productos_herra = get_productos($conn, 'Herramientas y equipos');
                                if ($productos_herra && $productos_herra->num_rows > 0) {
                                    while($row = $productos_herra->fetch_assoc()) {
                                        echo '<li class="indigo-lightest mb-2 fs-s2">🔧 ' . htmlspecialchars($row['nombre']) . '</li>';
                                    }
                                } else {
                                    echo '<li class="indigo-lightest mb-2 fs-s2">No se encontraron productos de Herramientas.</li>';
                                }
                            } else {
                                 echo '<li class="indigo-lightest mb-2 fs-s2">Productos de ejemplo (Base de Datos Desconectada): Machetes, Bombas de Fumigar.</li>';
                            }
                            ?>
                        </ul>
                        <button class="close-submenu button bg-white black p-2 br-4 mt-5 fw-600 fs-s2">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
    </section>

     <section class="relative bg-indigo-lightest-10">
        <div id="slider-1">
            <div class="p-10 md-p-l10 flex justify-center items-center flex-column text-center">
                <h2 class="white fs-l3 fw-900">Medicina Veterinaria y mucho más</h2>
                <p class="indigo-lightest fw-600 fs-m1 opacity-30 my-5">Mediciona par Bobinos, Porcinos, Caninos y mucho más.</p>
                <a href="#" class="button-md bg-indigo white fs-s3 br-4 black fw-600 no-underline m-5">Comprar ahora</a>
            </div>
            <div class="p-10 md-p-l10 flex justify-center items-center flex-column text-center">
                <h2 class="white fs-l3 fw-900">Combo semillas + herramienta</h2>
                <p class="indigo-lightest fw-600 fs-m1 opacity-30 my-5">Semillas certificadas con machete y guantes a precio especial.</p>
                <a href="#" class="button-md bg-indigo white fs-s3 br-4 black fw-600 no-underline m-5">Comprar ahora</a>
            </div>
            <div class="p-10 md-p-l10 flex justify-center items-center flex-column text-center">
                <h2 class="white fs-l3 fw-900">Entrega a domicilio en San Camilo</h2>
                <p class="indigo-lightest fw-600 fs-m1 opacity-30 my-5">Llevamos tus insumos directo a tu finca.</p>
                <a href="#" class="button-md bg-indigo white fs-s3 br-4 black fw-600 no-underline m-5">Solicitar</a>
            </div>
        </div>
        <ul class="absolute list-none w-100pc flex justify-between top-50pc">
            <li><button
                    class="prev ml-10 br-round border-indigo-lightest indigo-lightest  bg-transparent flex justify-center items-center p-2 focus-indigo-lighter outline-none"><i
                        data-feather="chevron-left"></i></button></li>
            <li><button
                    class="next mr-10 br-round border-indigo-lightest indigo-lightest  bg-transparent flex justify-center items-center p-2  focus-indigo-lighter outline-none"><i
                        data-feather="chevron-right"></i></button></li>
        </ul>
    </section>

    <section class="p-10 md-py-10">
        <div class="w-100pc md-w-70pc mx-auto py-10">
            <h2 class="white fs-l2 md-fs-xl1 fw-900 lh-2">
                Insumos de calidad para <span class="border-b bc-indigo bw-4">productores</span> de San Camilo, Apure
            </h2>
        </div>
    </section>

    <section class="py-l10">
        <div class="flex flex-column md-flex-row md-w-80pc mx-auto">
            <div class="w-100pc md-w-50pc">
                <div class="br-8 p-5 m-5 bg-indigo-lightest-10 pointer hover-scale-up-1 ease-300">
                    <div class="inline-block bg-indigo indigo-lightest br-3 px-4 py-1 mb-10 fs-s4 uppercase">
                        pequeño productor</div>
                    <div class="indigo-lightest fw-600 fs-m1">Soluciones para parcelas y huertos familiares:
                        <span class="opacity-30"> paquetes de semillas, herramientas básicas y asesoría general.</span>
                    </div>
                    <a href="#" class="mt-10 button bg-black fs-s3 white no-underline">Conocer</a>
                </div>
            </div>
            <div class="w-100pc md-w-50pc">
                <div class="br-8 p-5 m-5 bg-indigo-lightest-10  pointer hover-scale-up-1 ease-300">
                    <div class="inline-block bg-indigo indigo-lightest br-3 px-4 py-1 mb-10 fs-s4 uppercase">
                        finca y equipo</div>
                    <div class="indigo-lightest fw-600 fs-m1">Abastecimiento para fincas y unidades productivas:
                        <span class="opacity-30"> fertilizantes, bombas, mangueras, protección y repuestos.</span>
                    </div>
                    <a href="#" class="mt-10 button bg-black fs-s3 white no-underline">Conocer</a>
                </div>
            </div>
        </div>
    </section>

    <section id="pricing">
        <div class="p-10 flex flex-wrap">
            <div class="w-100pc md-w-50pc">
                <div class="p-5">
                    <h4 class="white fw-800 fs-l3 mb-5">Combos destacados</h4>
                    <div class="indigo-lightest fw-600 fs-m1 opacity-50">Ahorra con nuestros paquetes pensados para la realidad del productor local.</div>
                    <h4 class="white fw-600 fs-m2 mt-10">Clientes que confían en nosotros</h4>
                    <div class="flex indigo-lightest opacity-50">
                        <div class="w-25pc">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 177.78 100" fill="currentColor">
                                <path d="M63.87,44.07h3V56.2h-3Zm4.19,7.55c0-3,1.84-4.79,4.68-4.79s4.68,1.79,4.68,4.79-1.8,4.8-4.68,4.8S68.06,54.67,68.06,51.62Zm6.35,0c0-1.65-.65-2.62-1.67-2.62s-1.66,1-1.66,2.62.63,2.6,1.66,2.6S74.41,53.3,74.41,51.63Zm4.14,5.17h2.88a1.55,1.55,0,0,0,1.62.9c1.14,0,1.74-.62,1.74-1.52V54.49h-.06A2.84,2.84,0,0,1,82,56.13c-2.19,0-3.64-1.67-3.64-4.54s1.38-4.68,3.68-4.68a2.87,2.87,0,0,1,2.76,1.76h0V47h3V56.1c0,2.19-1.93,3.55-4.78,3.55C80.37,59.65,78.72,58.46,78.55,56.8Zm6.25-5.18c0-1.46-.67-2.38-1.73-2.38s-1.71.91-1.71,2.38.64,2.3,1.71,2.3S84.8,53.1,84.8,51.62Zm4.13,0c0-3,1.84-4.79,4.68-4.79s4.69,1.79,4.69,4.79-1.8,4.8-4.69,4.8S88.93,54.67,88.93,51.62Zm6.35,0c0-1.65-.65-2.62-1.67-2.62S92,50,92,51.63s.63,2.6,1.65,2.6S95.28,53.3,95.28,51.63Zm4.16-6.79A1.53,1.53,0,1,1,101,46.31,1.46,1.46,0,0,1,99.44,44.84Zm0,2.2h3V56.2h-3Zm13.89,4.59c0,3-1.33,4.71-3.61,4.71a2.86,2.86,0,0,1-2.8-1.7h-.06v4.52h-3V47h3v1.64h.06a2.87,2.87,0,0,1,2.78-1.77C112,46.91,113.37,48.63,113.37,51.63Zm-3,0c0-1.46-.67-2.39-1.72-2.39s-1.72.94-1.73,2.39.68,2.38,1.73,2.38S110.33,53.08,110.33,51.63Zm8.15-4.8c2.49,0,4,1.18,4.07,3.07h-2.73c0-.65-.54-1.06-1.37-1.06s-1.2.32-1.2.79.33.62,1,.76l1.92.39c1.83.39,2.61,1.13,2.61,2.52,0,1.9-1.73,3.12-4.28,3.12s-4.22-1.22-4.35-3.09h2.89c.09.68.63,1.08,1.51,1.08s1.28-.29,1.28-.77-.28-.58-1-.73l-1.73-.37c-1.79-.37-2.73-1.32-2.73-2.72C114.39,48,116,46.83,118.48,46.83Zm14.31,9.37H129.9V54.47h-.06a2.61,2.61,0,0,1-2.66,1.91,3.19,3.19,0,0,1-3.36-3.45V47h3v5.24c0,1.09.56,1.67,1.49,1.67a1.53,1.53,0,0,0,1.52-1.73V47h3ZM134.24,47h2.9v1.77h.06a2.66,2.66,0,0,1,2.61-1.94,2.39,2.39,0,0,1,2.55,2h.06a2.82,2.82,0,0,1,2.82-2,2.91,2.91,0,0,1,3,3.12V56.2h-3V50.75c0-1-.45-1.46-1.29-1.46a1.31,1.31,0,0,0-1.31,1.48V56.2h-2.85V50.71c0-.92-.45-1.42-1.27-1.42a1.34,1.34,0,0,0-1.33,1.5V56.2h-3Z" />
                                <path d="M55.48,44.62a13.25,13.25,0,0,0-2-3.22A13.53,13.53,0,1,0,34.8,60.72,13.09,13.09,0,0,0,38,62.55a13.39,13.39,0,0,0,5.07,1A13.56,13.56,0,0,0,56.6,50,13.39,13.39,0,0,0,55.48,44.62ZM43.06,39.19a10.71,10.71,0,0,1,4.52,1h0a4.39,4.39,0,0,1-1.08.31,5.73,5.73,0,0,0-4.85,4.85A3,3,0,0,1,38.94,48a5.73,5.73,0,0,0-4.85,4.85,2.91,2.91,0,0,1-.79,1.74h0a10.8,10.8,0,0,1,9.77-15.42ZM34.79,57c.12-.11.24-.21.36-.33a5.48,5.48,0,0,0,1.62-3.23,2.92,2.92,0,0,1,.87-1.82,2.83,2.83,0,0,1,1.81-.86,5.73,5.73,0,0,0,4.85-4.85A2.92,2.92,0,0,1,45.17,44,2.87,2.87,0,0,1,47,43.17a5.48,5.48,0,0,0,3-1.43,10.51,10.51,0,0,1,2.36,2.78.86.86,0,0,1-.13.14,2.87,2.87,0,0,1-1.81.88,5.71,5.71,0,0,0-4.85,4.85,3,3,0,0,1-2.69,2.68A5.76,5.76,0,0,0,38,57.92a3.14,3.14,0,0,1-.49,1.37A10.89,10.89,0,0,1,34.79,57Zm8.27,3.86a10.84,10.84,0,0,1-3-.42,5.78,5.78,0,0,0,.64-2,3,3,0,0,1,2.68-2.68,5.73,5.73,0,0,0,4.86-4.85,3,3,0,0,1,2.68-2.68,5.71,5.71,0,0,0,2.56-1A10.82,10.82,0,0,1,43.06,60.81Z" />
                            </svg>
                        </div>
                        <div class="w-25pc">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 177.78 100" fill="currentColor">
                                <path d="M46.23,41.39h2V55.31h6v2h-8Zm14.23,0a6,6,0,1,1-6,6A6,6,0,0,1,60.46,41.39Zm0,10a4,4,0,1,0-4-4A4,4,0,0,0,60.46,51.37Zm-4,3.94h8v2h-8Zm25.6,2h-2V55.9a7.69,7.69,0,0,1-4.4,1.39,8,8,0,1,1,6-13.23l-1.47,1.31a6,6,0,1,0-4.46,10,5.77,5.77,0,0,0,4.38-2H74.71v-2l7.37,0Zm7.36-15.9a6,6,0,1,1-6,6A6,6,0,0,1,89.44,41.39Zm0,10a4,4,0,1,0-4-4A4,4,0,0,0,89.44,51.37Zm-4,3.94h8v2h-8ZM97.55,41.39h2v15.9h-2Zm4.77,0,2,0a1.47,1.47,0,0,1,.31,0,6,6,0,1,1,0,11.93h-.31v4h-2Zm2,2v7.91h.31a4,4,0,1,0,0-7.93A1.47,1.47,0,0,0,104.31,43.44Zm14.41-.85-1.48,1.17a1.94,1.94,0,0,0-3.33,1.13V45c0,.88.61,1.47,1.8,1.55,4.58.28,6.68,2.43,6.68,5.27V52a5.9,5.9,0,0,1-10.17,3.42l1.53-1.18a3.6,3.6,0,0,0,2.8,1.14A3.74,3.74,0,0,0,120.48,52v-.14c0-2.67-2.62-3.16-4.89-3.38-2.1-.2-3.61-1.51-3.61-3.4V45a3.85,3.85,0,0,1,3.93-3.56A3.74,3.74,0,0,1,118.72,42.59Zm11.5,12.72c2.49,0,4.46-2.69,4.46-6v-8h2l0,8c0,4.4-2.88,7.95-6.42,7.95s-6.42-3.55-6.42-7.95v-8h2v8C125.77,52.62,127.74,55.31,130.22,55.31Zm21.81,2h-2V47.36l-4.61,6-4.61-6v9.93h-2V41.39l6.6,8.69,6.6-8.69Z" />
                                <path d="M36.63,39a5.44,5.44,0,0,0-10.88,0V55.45l4.48,3.21v7.82h1.92V58.66l4.48-3.21Zm-1.92,9.2-2.56,2.56v-2.4l2.56-2.56Zm-7-2.4,2.56,2.56v2.4l-2.56-2.56Zm7-2.72-3.52,3.52L27.67,43v-2.4l3.52,3.52,3.52-3.52Zm-3.52-7.6a3.54,3.54,0,0,1,3.4,2.61l-3.4,3.39-3.4-3.39A3.54,3.54,0,0,1,31.19,35.44Zm-3.52,19V50.88l2.56,2.56V56.3Zm4.48,1.83V53.44l2.56-2.56v3.59Z" />
                            </svg>
                        </div>
                        <div class="w-25pc">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 177.78 100" fill="currentColor">
                                <path d="M67.88,57.39a2.65,2.65,0,0,1-1.67-.48,1.56,1.56,0,0,1-.63-1.31V46.33a.26.26,0,0,1,.29-.29h1.68c.19,0,.28.1.28.29v8.55c0,.38.17.57.52.57a1.44,1.44,0,0,0,.44-.05c.2,0,.31.06.32.24l.15,1.25a.26.26,0,0,1-.24.31A3.77,3.77,0,0,1,67.88,57.39Z" />
                                <path d="M77.33,56.32a4.71,4.71,0,0,1-6,0,4,4,0,0,1,0-5.63,4.73,4.73,0,0,1,6,0,4.06,4.06,0,0,1,0,5.62ZM72.91,55a2.13,2.13,0,0,0,2.86,0,2.24,2.24,0,0,0,0-2.94,2.13,2.13,0,0,0-2.86,0,2.24,2.24,0,0,0,0,2.94Z" />
                                <path d="M87.71,49.87c.19,0,.28.1.28.29v7.17a3.26,3.26,0,0,1-1.11,2.57,4.2,4.2,0,0,1-2.91,1,4.68,4.68,0,0,1-2.71-.75,3,3,0,0,1-1.31-2c0-.2,0-.29.27-.29H81.9a.37.37,0,0,1,.33.23,1.31,1.31,0,0,0,.61.71,2.34,2.34,0,0,0,1.12.26,1.77,1.77,0,0,0,1.29-.46,1.7,1.7,0,0,0,.47-1.25v-.63a3.35,3.35,0,0,1-2.08.65,3.88,3.88,0,0,1-2.84-1.09,4,4,0,0,1,0-5.56,3.91,3.91,0,0,1,2.84-1.08,3.36,3.36,0,0,1,2.13.69v-.16a.26.26,0,0,1,.28-.29Zm-3.88,5.72A1.76,1.76,0,0,0,85.2,55a2.45,2.45,0,0,0,0-3,1.75,1.75,0,0,0-1.36-.58,1.8,1.8,0,0,0-1.39.59,2.12,2.12,0,0,0-.54,1.5A2.16,2.16,0,0,0,82.44,55,1.81,1.81,0,0,0,83.83,55.59Z" />
                                <path d="M96.62,56.32a4.73,4.73,0,0,1-6,0,4.07,4.07,0,0,1,0-5.63,4.74,4.74,0,0,1,6,0,4.06,4.06,0,0,1,0,5.62ZM92.19,55a2,2,0,0,0,1.44.55A2,2,0,0,0,95.06,55a2.27,2.27,0,0,0,0-2.94,2,2,0,0,0-1.43-.55,2,2,0,0,0-1.44.55,2.27,2.27,0,0,0,0,2.94Z" />
                                <path d="M101.36,48.17a1.45,1.45,0,0,1-1.91,0,1.21,1.21,0,0,1,0-1.76,1.48,1.48,0,0,1,1.91,0,1.21,1.21,0,0,1,0,1.76Zm.21,9.22a2.69,2.69,0,0,1-1.67-.48,1.58,1.58,0,0,1-.62-1.31V50.16a.26.26,0,0,1,.29-.29h1.68c.19,0,.28.1.28.29v4.72q0,.57.51.57a1.55,1.55,0,0,0,.45-.05c.2,0,.31.06.32.24l.15,1.25a.26.26,0,0,1-.24.31A3.79,3.79,0,0,1,101.57,57.39Z" />
                                <path d="M109.14,49.63A3.92,3.92,0,0,1,112,50.71a4.1,4.1,0,0,1,0,5.59,3.89,3.89,0,0,1-2.86,1.09,3.44,3.44,0,0,1-2.09-.65v3.61c0,.19-.1.28-.29.28h-1.68a.24.24,0,0,1-.28-.28v-8.2a.52.52,0,0,0-.59-.59l-.33,0q-.33,0-.33-.24V50.14a.32.32,0,0,1,.23-.33,3,3,0,0,1,1.08-.18,1.85,1.85,0,0,1,1.81,1A3.37,3.37,0,0,1,109.14,49.63ZM107.58,55a1.91,1.91,0,0,0,2.76,0,2.16,2.16,0,0,0,.55-1.53,2.13,2.13,0,0,0-.55-1.53,1.91,1.91,0,0,0-2.76,0,2.21,2.21,0,0,0-.53,1.53A2.24,2.24,0,0,0,107.58,55Z" />
                                <path d="M117.82,57.39a4.82,4.82,0,0,1-2.57-.62A2.44,2.44,0,0,1,114.09,55c0-.2.07-.3.29-.3h1.47a.38.38,0,0,1,.33.22c.21.54.76.81,1.64.81a1.87,1.87,0,0,0,.89-.18.58.58,0,0,0,.34-.49c0-.26-.16-.44-.48-.56a5.41,5.41,0,0,0-1.17-.25A11.12,11.12,0,0,1,116,54a2.3,2.3,0,0,1-1.17-.67,2.14,2.14,0,0,1,.43-3.1,4.12,4.12,0,0,1,2.42-.64,4.42,4.42,0,0,1,2.36.59,2.23,2.23,0,0,1,1.1,1.57q0,.3-.27.3h-1.48a.31.31,0,0,1-.3-.18,1,1,0,0,0-.52-.53,1.76,1.76,0,0,0-.86-.2,1.74,1.74,0,0,0-.85.17.5.5,0,0,0-.32.46.64.64,0,0,0,.48.59,5.42,5.42,0,0,0,1.19.3,13.08,13.08,0,0,1,1.39.26,2.3,2.3,0,0,1,1.17.67,1.89,1.89,0,0,1,.49,1.37,2,2,0,0,1-.93,1.74A4.37,4.37,0,0,1,117.82,57.39Z" />
                                <path d="M131.83,56.89a.27.27,0,0,1-.23.31,3.86,3.86,0,0,1-1.13.19,2.22,2.22,0,0,1-2-.87,3.62,3.62,0,0,1-2.55.87,3.1,3.1,0,0,1-2.34-.91,3.28,3.28,0,0,1-.89-2.41V50.16c0-.19.09-.29.28-.29h1.68c.19,0,.28.1.28.29v3.61a1.77,1.77,0,0,0,.43,1.23,1.5,1.5,0,0,0,1.15.47,1.66,1.66,0,0,0,1.2-.44,1.6,1.6,0,0,0,.45-1.19V50.16c0-.19.09-.29.28-.29h1.7c.19,0,.28.1.28.29v4.71c0,.39.17.58.5.58a1.58,1.58,0,0,0,.46-.05.26.26,0,0,1,.33.24Z" />
                                <path d="M147.72,56.89a.25.25,0,0,1-.23.31,3.88,3.88,0,0,1-1.15.19,2.67,2.67,0,0,1-1.67-.48A1.56,1.56,0,0,1,144,55.6V53.25a1.77,1.77,0,0,0-.42-1.23,1.42,1.42,0,0,0-1.12-.47,1.25,1.25,0,0,0-1,.44,1.78,1.78,0,0,0-.38,1.18v3.69c0,.19-.09.29-.28.29h-1.69a.26.26,0,0,1-.29-.29V53.25a1.85,1.85,0,0,0-.39-1.23,1.3,1.3,0,0,0-1-.47,1.45,1.45,0,0,0-1.1.44,1.65,1.65,0,0,0-.41,1.18v3.69a.26.26,0,0,1-.29.29H134c-.19,0-.28-.1-.28-.29V52.15a.52.52,0,0,0-.59-.59l-.33,0q-.33,0-.33-.24V50.14a.32.32,0,0,1,.23-.33,3,3,0,0,1,1.08-.18,1.88,1.88,0,0,1,1.78.92,3.38,3.38,0,0,1,2.54-.92,2.87,2.87,0,0,1,2.37,1.06,3.3,3.3,0,0,1,2.62-1.06,3.16,3.16,0,0,1,2.37.91,3.26,3.26,0,0,1,.89,2.41v1.93c0,.38.17.57.49.57a1.5,1.5,0,0,0,.46-.05q.31,0,.33.24Z" />
                                <path d="M30.46,48.57a13.69,13.69,0,0,1,26.57,0h-1.2a9.69,9.69,0,0,0-5.67,1.73,2.86,2.86,0,0,1-.3.19h-.14a2.86,2.86,0,0,1-.3-.19,10.17,10.17,0,0,0-11.35,0,2.86,2.86,0,0,1-.3.19h-.14a2.86,2.86,0,0,1-.3-.19,9.69,9.69,0,0,0-5.67-1.73Zm23.21,6.27a3.37,3.37,0,0,1,2.16-.71h1.61V50.92H55.83A6.38,6.38,0,0,0,52,52.14a3.64,3.64,0,0,1-4.32,0,6.8,6.8,0,0,0-7.77,0,3.64,3.64,0,0,1-4.32,0,6.38,6.38,0,0,0-3.88-1.22H30.05v3.21h1.61a3.37,3.37,0,0,1,2.16.71,6.78,6.78,0,0,0,7.76,0,3.39,3.39,0,0,1,2.16-.71,3.35,3.35,0,0,1,2.16.71,6.8,6.8,0,0,0,7.77,0Zm0,5.74a3.37,3.37,0,0,1,2.16-.71h1.61V56.66H55.83A6.38,6.38,0,0,0,52,57.88a3.64,3.64,0,0,1-4.32,0,6.8,6.8,0,0,0-7.77,0,3.64,3.64,0,0,1-4.32,0,6.38,6.38,0,0,0-3.88-1.22H30.05v3.21h1.61a3.37,3.37,0,0,1,2.16.71,6.78,6.78,0,0,0,7.76,0,3.39,3.39,0,0,1,2.16-.71,3.35,3.35,0,0,1,2.16.71,6.8,6.8,0,0,0,7.77,0Z" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
            <div class="w-100pc md-w-25pc">
                <div class="m-3 p-5 br-8 bg-indigo-lightest-10 overflow-hidden">
                    <div class="p-3">
                        <h3 class="indigo">Combo básico</h3>
                        <div class="white flex items-center">Bs <span class="fs-l5 lh-1">0</span></div>
                    </div>
                    <div class="p-3 indigo-lightest fw-400 fs-s1 lh-5">
                        <div>
                            <i class="h-3 indigo" stroke-width="4" data-feather="check"></i>
                            <span class="opacity-50">Semillas seleccionadas</span>
                        </div>
                        <div>
                            <i class="h-3 indigo" stroke-width="4" data-feather="check"></i>
                            <span class="opacity-50">Herramienta básica</span></div>
                        <div>
                            <i class="h-3 indigo" stroke-width="4" data-feather="check"></i>
                            <span class="opacity-50">Asesoría general</span></div>
                        <div>
                            <i class="h-3 indigo" stroke-width="4" data-feather="check"></i>
                            <span class="opacity-50">Soporte</span></div>
                        <div>
                            <i class="h-3" stroke-width="4" data-feather="x"></i>
                            <span class="opacity-50">Equipos avanzados</span></div>
                    </div>
                    <div class="p-3">
                        <button class="button full bg-black white  hover-opacity-100 hover-scale-up-1 ease-300">Solicitar</button>
                    </div>
                </div>
            </div>
            <div class="w-100pc md-w-25pc">
                <div class="m-3 p-5 br-8 bg-white overflow-hidden">
                    <div class="p-3">
                        <h3 class="indigo">Combo finca</h3>
                        <div class="black flex items-center">Bs <span class="fs-l5 lh-1">99</span></div>
                    </div>
                    <div class="p-3 black fw-400 fs-s1 lh-5">
                        <div>
                            <i class="h-3 indigo" stroke-width="4" data-feather="check"></i>
                            <span class="opacity-50">Semillas certificadas</span></div>
                        <div>
                            <i class="h-3 indigo" stroke-width="4" data-feather="check"></i>
                            <span class="opacity-50">Fertilizantes NPK</span></div>
                        <div>
                            <i class="h-3 indigo" stroke-width="4" data-feather="check"></i>
                            <span class="opacity-50">Herramientas y protección</span></div>
                        <div>
                            <i class="h-3 indigo" stroke-width="4" data-feather="check"></i>
                            <span class="opacity-50">Soporte y entrega local</span></div>
                        <div>
                            <i class="h-3 indigo" stroke-width="4" data-feather="check"></i>
                            <span class="opacity-50">Repuestos esenciales</span></div>
                    </div>
                    <div class="p-3">
                        <button class="button full bg-indigo white hover-opacity-100 hover-scale-up-1 ease-300">Solicitar</button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="p-10 md-p-l5">
        <div id="slider-2">
            <div class="px-3">
                <div class="p-8 br-8 bg-indigo-lightest-10 relative">
                    <span class="fs-l5 lh-1 white opacity-10 absolute top-0 z--1">&#10077;</span>
                    <p class="fw-600 fs-m1 indigo-lightest opacity-80 italic ls-wider">“Con sus semillas y fertilizantes, el maíz rindió mejor este ciclo.”</p>
                    <div class="flex items-center my-5">
                        <div class="block br-round border bc-black bw-4 w-l3 h-l3"><img class="br-round"
                                src="https://randomuser.me/api/portraits/men/46.jpg" alt="Cliente local"></div>
                        <div class="ml-4 fs-s1">
                            <div class="indigo-lightest">Pedro G.</div>
                            <div class="indigo-lightest opacity-20">Productor, San Camilo</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="px-3">
                <div class="p-8 br-8 bg-indigo-lightest-10 relative">
                    <span class="fs-l5 lh-1 white opacity-10 absolute top-0 z--1">&#10077;</span>
                    <p class="fw-600 fs-m1 indigo-lightest opacity-80 italic ls-wider">“Buena atención y entrega a tiempo en la finca.”</p>
                    <div class="flex items-center my-5">
                        <div class="block br-round border bc-black bw-4 w-l3 h-l3"><img class="br-round"
                                src="https://randomuser.me/api/portraits/women/46.jpg" alt="Clienta local"></div>
                        <div class="ml-4 fs-s1">
                            <div class="indigo-lightest">María R.</div>
                            <div class="indigo-lightest opacity-20">Productora, Apure</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="px-3">
                <div class="p-8 br-8 bg-indigo-lightest-10 relative">
                    <span class="fs-l5 lh-1 white opacity-10 absolute top-0 z--1">&#10077;</span>
                    <p class="fw-600 fs-m1 indigo-lightest opacity-80 italic ls-wider">“Consigo repuestos y herramientas sin salir del pueblo.”</p>
                    <div class="flex items-center my-5">
                        <div class="block br-round border bc-black bw-4 w-l3 h-l3"><img class="br-round"
                                src="https://randomuser.me/api/portraits/men/32.jpg" alt="Cliente local"></div>
                        <div class="ml-4 fs-s1">
                            <div class="indigo-lightest">José L.</div>
                            <div class="indigo-lightest opacity-20">Ganadero, San Camilo</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="px-3">
                <div class="p-8 br-8 bg-indigo-lightest-10 relative">
                    <span class="fs-l5 lh-1 white opacity-10 absolute top-0 z--1">&#10077;</span>
                    <p class="fw-600 fs-m1 indigo-lightest opacity-80 italic ls-wider">“Las mezclas recomendadas mejoraron el suelo y el rendimiento.”</p>
                    <div class="flex items-center my-5">
                        <div class="block br-round border bc-black bw-4 w-l3 h-l3"><img class="br-round"
                                src="https://randomuser.me/api/portraits/women/18.jpg" alt="Clienta local"></div>
                        <div class="ml-4 fs-s1">
                            <div class="indigo-lightest">Ana P.</div>
                            <div class="indigo-lightest opacity-20">Productora, Apure</div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <section class="p-10 md-p-l10">
        <div class="md-w-75pc">
            <h2 class="white fs-l3 fw-900 lh-1">Consejos para mejorar tus cultivos</h2>
            <p class="indigo-lightest fw-600 fs-m1 opacity-50 my-5">Recomendaciones generales sobre manejo de suelo, riego y selección de semillas.</p>
        </div>
        <div class="relative w-100pc h-75vh bg-cover bg-b"
            style="background-image: url(assets/images/featured-finca.jpg);">
            <a href="#"
                class="bg-white black px-5 py-3 absolute right-0 bottom-0 hover-bg-black hover-white ease-500 flex justify-center items-center after-arrow-right no-underline fs-m1">Leer artículo</a>
        </div>

    </section>

    <section class="p-0 md-p-5">
        <div class="flex flex-wrap">
            <div class="w-100pc md-w-33pc p-10">
                <a href="#" class="block no-underline p-5 br-8 hover-bg-indigo-lightest-10 hover-scale-up-1 ease-300">
                    <img class="w-100pc" src="assets/images/blog-semillas.jpg" alt="Semillas">
                    <p class="fw-600 white fs-m3 mt-3">
                        Cómo elegir semillas para clima local y suelos de Apure
                    </p>
                    <div class="indigo fs-s3 italic after-arrow-right my-4">Hace 3 días por Equipo Agrocamilo</div>
                </a>
            </div>
            <div class="w-100pc md-w-33pc p-10">
                <a href="#" class="block no-underline p-5 br-8 hover-bg-indigo-lightest-10 hover-scale-up-1 ease-300">
                    <img class="w-100pc" src="assets/images/blog-fertilizantes.jpg" alt="Fertilizantes">
                    <p class="fw-600 white fs-m3 mt-3">
                        Enmiendas comunes para mejorar estructura y fertilidad del suelo
                    </p>
                    <div class="indigo fs-s3 italic after-arrow-right my-4">Hace 5 días por Equipo Agrocamilo</div>
                </a>
            </div>
            <div class="w-100pc md-w-33pc p-10">
                <a href="#" class="block no-underline p-5 br-8 hover-bg-indigo-lightest-10 hover-scale-up-1 ease-300">
                    <img class="w-100pc" src="assets/images/blog-herramientas.jpg" alt="Herramientas">
                    <p class="fw-600 white fs-m3 mt-3">
                        Herramientas esenciales para mantenimiento y cosecha
                    </p>
                    <div class="indigo fs-s3 italic after-arrow-right my-4">Hace 1 semana por Equipo Agrocamilo</div>
                </a>
            </div>

        </div>
    </section>

    <section class="p-10 md-p-l5">
        <div class="br-8 bg-indigo-lightest-10 p-5 md-p-l5 flex flex-wrap md-justify-between md-items-center">
            <div class="w-100pc md-w-33pc">
                <h2 class="white fs-m4 fw-800">Recibe el catálogo</h2>
                <p class="fw-600 indigo-lightest opacity-40">Te enviaremos promociones y disponibilidad de insumos. Sin costo.</p>
            </div>
            <div class="w-100pc md-w-50pc">
                <div class="flex my-5">
                    <input type="text"
                        class="input-lg flex-grow-1 bw-0 fw-200 bg-indigo-lightest-10 white ph-indigo-lightest focus-white opacity-80 fs-s3 py-5 br-r-0"
                        placeholder="Correo electrónico">
                    <button class="button-lg bg-indigo indigo-lightest fw-300 fs-s3 br-l-0">Enviar</button>
                </div>
            </div>
        </div>
    </section>

    <section id="servicios" class="p-10 md-p-l5">
        <div class="flex flex-column md-flex-row mx-auto">
            <div class="w-100pc md-w-40pc">
                <div class="br-8 p-5 m-5">
                    <div class="flex justify-center items-center bg-indigo-lightest-10 white w-l5 h-l5 br-round mb-5"><i
                            data-feather="map-pin" class="w-l5"></i></div>
                    <h4 class="white fw-600 fs-m3 mb-5">Entrega local</h4>
                    <div class="indigo-lightest fw-600 fs-m1 lh-3 opacity-50">Distribución en San Camilo y zonas cercanas, coordinada según disponibilidad.</div>
                    <a href="#contacto"
                        class="mt-5 button bg-indigo-lightest-10 fs-s3 white no-underline hover-opacity-100 hover-scale-up-1 ease-300">Coordinar</a>
                </div>
            </div>
            <div class="w-100pc md-w-40pc">
                <div class="br-8 p-5 m-5">
                    <div class="flex justify-center items-center bg-indigo-lightest-10 white w-l5 h-l5 br-round mb-5"><i
                            data-feather="help-circle" class="w-l5"></i></div>
                    <h4 class="white fw-600 fs-m3 mb-5">Asesoría general</h4>
                    <div class="indigo-lightest fw-600 fs-m1 opacity-50">Orientación no personalizada para elegir insumos adecuados a tu cultivo.</div>
                    <a href="#contacto"
                        class="mt-5 button bg-indigo-lightest-10 fs-s3 white no-underline hover-opacity-100 hover-scale-up-1 ease-300">Solicitar</a>
                </div>
            </div>
            <div class="w-100pc md-w-40pc">
                <div class="br-8 p-5 m-5">
                    <div class="flex justify-center items-center bg-indigo-lightest-10 white w-l5 h-l5 br-round mb-5"><i
                            data-feather="phone-call" class="w-l5"></i></div>
                    <h4 class="white fw-600 fs-m3 mb-5">Atención al cliente</h4>
                    <div class="indigo-lightest fw-600 fs-m1 opacity-50">Consultas sobre disponibilidad, precios y tiempos de entrega.</div>
                    <a href="#contacto"
                        class="mt-5 button bg-indigo-lightest-10 fs-s3 white no-underline hover-opacity-100 hover-scale-up-1 ease-300">Contactar</a>
                </div>
            </div>
        </div>
    </section>

    <footer id="contacto" class="p-5 md-p-l5 bg-indigo-lightest-10">
        <div class="flex flex-wrap">
            <div class="md-w-25pc mb-10">
                <img src="assets/images/logo.png" class="w-l5" alt="Logo Agropecuaria San Camilo">
                <div class="white opacity-70 fs-s2 mt-4 md-pr-10">
                    <p>Somos una agropecuaria local dedicada a suministrar insumos confiables: semillas, fertilizantes, herramientas y repuestos.</p>
                    <br>
                    <p>Atendemos productores de San Camilo y zonas cercanas con entrega coordinada y atención cercana.</p>
                </div>
            </div>
            <div class="w-100pc md-w-50pc">
                <div class="flex justify-around">
                    <div class="w-33pc md-px-10 mb-10">
                        <h5 class="white">Agrocamilo</h5>
                        <ul class="list-none mt-5 fs-s2">
                            <li class="my-3"><a href="#home" class="white opacity-70 no-underline hover-underline">Inicio</a></li>
                            <li class="my-3"><a href="#features" class="white opacity-70 no-underline hover-underline">Productos</a></li>
                            <li class="my-3"><a href="#servicios" class="white opacity-70 no-underline hover-underline">Servicios</a></li>
                            <li class="my-3"><a href="#pricing" class="white opacity-70 no-underline hover-underline">Combos</a></li>
                        </ul>
                    </div>
                    <div class="w-33pc md-px-10 mb-10">
                        <h5 class="white">Información</h5>
                        <ul class="list-none mt-5 fs-s2">
                            <li class="my-3"><a href="#" class="white opacity-70 no-underline hover-underline">Catálogo</a></li>
                            <li class="my-3"><a href="#" class="white opacity-70 no-underline hover-underline">Promociones</a></li>
                            <li class="my-3"><a href="#" class="white opacity-70 no-underline hover-underline">Blog</a></li>
                            <li class="my-3"><a href="#" class="white opacity-70 no-underline hover-underline">Testimonios</a></li>
                        </ul>
                    </div>
                    <div class="w-33pc md-px-10 mb-10">
                        <h5 class="white">Contacto</h5>
                        <ul class="list-none mt-5 fs-s2">
                            <li class="my-3"><a href="#contacto" class="white opacity-70 no-underline hover-underline">San Camilo, Apure</a></li>
                            <li class="my-3"><a href="#contacto" class="white opacity-70 no-underline hover-underline">Tel: +58 000-0000000</a></li>
                            <li class="my-3"><a href="#contacto" class="white opacity-70 no-underline hover-underline">Email: contacto@agrocamilo.com</a></li>
                            <li class="my-3"><a href="#contacto" class="white opacity-70 no-underline hover-underline">Horario: Lun-Sáb</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="w-100pc md-w-25pc">
                <div class="flex w-75pc md-w-100pc mx-auto">
                    <input type="text"
                        class="input flex-grow-1 bw-0 fw-200 bg-indigo-lightest-10 white ph-indigo-lightest focus-white opacity-80 fs-s3 py-5 br-r-0"
                        placeholder="Correo electrónico">
                    <button class="button bg-indigo indigo-lightest fw-300 fs-s3 br-l-0">Enviar</button>
                </div>
                <div class="white opacity-70 fs-s2 mt-4">
                    <p>📍 San Camilo, Apure, Venezuela</p>
                    <p>📞 +58 000-0000000</p>
                    <p>✉️ contacto@agrocamilo.com</p>
                </div>
                <div class="flex justify-around my-8">
                    <a href="#" class="relative p-5 bg-indigo br-round white hover-scale-up-1 ease-400"><i
                            data-feather="twitter" class="absolute-center h-4"></i></a>
                    <a href="#" class="relative p-5 bg-indigo br-round white hover-scale-up-1 ease-400"><i
                            data-feather="facebook" class="absolute-center h-4"></i></a>
                    <a href="#" class="relative p-5 bg-indigo br-round white hover-scale-up-1 ease-400"><i
                            data-feather="instagram" class="absolute-center h-4"></i></a>
                </div>
            </div>
        </div>
    </footer>
    
        <i class="w-4" data-feather="download"></i>
    </div>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://unpkg.com/feather-icons"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/cferdinandi/smooth-scroll@15.0.0/dist/smooth-scroll.polyfills.min.js"></script>
    <script>
        // Inicializar íconos Feather
        feather.replace();

        // Inicializar sliders
        $(document).ready(function () {
            $('#slider-1').slick({
                dots: true,
                arrows: false,
                autoplay: true,
                autoplaySpeed: 4000,
                adaptiveHeight: true
            });
            $('#slider-2').slick({
                dots: true,
                arrows: false,
                autoplay: true,
                autoplaySpeed: 5000,
                adaptiveHeight: true
            });

            // Botones prev/next externos para slider-1
            $('.prev').on('click', function () { $('#slider-1').slick('slickPrev'); });
            $('.next').on('click', function () { $('#slider-1').slick('slickNext'); });

            // Smooth scroll para navegacion
            var scroll = new SmoothScroll('a[href*="#"]', {
                speed: 500,
                speedAsDuration: true
            });

            // Toggle nav responsive
            $('[data-toggle="toggle-nav"]').on('click', function (e) {
                e.preventDefault();
                var target = $(this).data('target');
                $(target).toggleClass('hidden');
            });
        });
        
        // --- Lógica de Submenús Desplegables (Función JavaScript) ---
        document.addEventListener('DOMContentLoaded', function() {
            const HIDE_CLASS = 'hidden';

            // 1. Mostrar el submenú al hacer clic en 'Ver más'
            document.querySelectorAll('.open-submenu').forEach(button => {
                button.addEventListener('click', function() {
                    const targetId = this.getAttribute('data-target');
                    const targetSubmenu = document.getElementById(targetId);
                    
                    // Ocultar todos los submenús antes de mostrar el actual (solo uno visible a la vez)
                    document.querySelectorAll('.submenu-content').forEach(submenu => {
                        submenu.classList.add(HIDE_CLASS);
                    });

                    // Mostrar el submenú deseado
                    if (targetSubmenu) {
                        targetSubmenu.classList.remove(HIDE_CLASS);
                    }
                });
            });

            // 2. Ocultar el submenú al hacer clic en 'Cerrar'
            document.querySelectorAll('.close-submenu').forEach(button => {
                button.addEventListener('click', function() {
                    // El submenú es el contenedor padre con la clase '.submenu-content'
                    this.closest('.submenu-content').classList.add(HIDE_CLASS);
                });
            });

            // 3. Ocultar todos los submenús al inicio
            document.querySelectorAll('.submenu-content').forEach(submenu => {
                submenu.classList.add(HIDE_CLASS);
            });
        });
        // --- FIN Lógica de Submenús Desplegables ---
    </script>
    <script src="assets/js/script.js"></script>
</body>

</html>
<?php
// Cierre de la conexión a la base de datos al finalizar la página.
if (!empty($conn) && empty($conn->connect_error)) {
    $conn->close(); 
}
?>