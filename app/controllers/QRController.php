<?php
require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../models/PanelModelo.php';

use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;

class QRController {
    public function generarTodosLosQR() {
        $modelo = new PanelModelo();
        $aprendices = $modelo->obtenerTodosLosAprendices();

        if (empty($aprendices)) {
            die("No hay aprendices registrados.");
        }

        // Carpeta donde se guardarán los QR
        $directorio = __DIR__ . "/../views/temp_qr/";
        if (!is_dir($directorio)) {
            mkdir($directorio, 0777, true);
        }

        // Nombre del ZIP
        $zipNombre = $directorio . "qr_aprendices.zip";
        $zip = new ZipArchive();

        if ($zip->open($zipNombre, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== TRUE) {
            die("No se pudo crear el archivo ZIP.");
        }

        foreach ($aprendices as $aprendiz) {
            $documento = $aprendiz['numero_identidad'];
            $datosQR = "Nombre: " . $aprendiz['nombre'] . "\nNúmero de Identidad: " . $documento;

            // Generar QR
            $qrCode = new QrCode($datosQR);
            $writer = new PngWriter();
            $result = $writer->write($qrCode);
            $qrImagen = $directorio . $documento . '.png';

            // Guardar el archivo QR
            file_put_contents($qrImagen, $result->getString());

            // Agregar al ZIP
            $zip->addFile($qrImagen, $documento . ".png");
        }

        $zip->close();

        // **Forzar descarga del ZIP**
        if (file_exists($zipNombre)) {
            header('Content-Type: application/zip');
            header('Content-Disposition: attachment; filename="qr_aprendices.zip"');
            header('Content-Length: ' . filesize($zipNombre));
            readfile($zipNombre);
            exit();
        } else {
            die("Error: No se pudo generar el archivo ZIP.");
        }
    }
}
