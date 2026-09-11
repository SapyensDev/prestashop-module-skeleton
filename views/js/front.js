/* Script de ejemplo del módulo, front office */
document.addEventListener('DOMContentLoaded', function () {
    var mensaje = document.getElementById('sapyensdevskeleton-footer-message');

    if (mensaje) {
        mensaje.addEventListener('click', function () {
            console.log('SapyensDevSkeleton, mensaje del footer clickeado');
        });
    }
});
