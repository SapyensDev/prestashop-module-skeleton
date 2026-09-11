<?php
/**
 * Archivo de protección estándar de PrestaShop: evita el listado
 * de directorios en servidores mal configurados.
 */
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
header('Cache-Control: no-store, no-cache, must-revalidate');
header('Cache-Control: post-check=0, pre-check=0', false);
header('Pragma: no-cache');

header('Location: ../');
exit;
