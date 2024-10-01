<?php

namespace App\Service;
use TCPDF;

class PDFService extends TCPDF
{
//    private $headerHeight = 40; // Ajusta según sea necesario
    
    public function Header()
    {    
        // Ruta de la imagen del logo
        $imageFile = __DIR__ . '/../../public/images/logo.jpg';

        // Verificar si el archivo de imagen existe antes de agregarlo
        if (file_exists($imageFile)) {
            // Insertar el logo (ajusta las coordenadas y el tamaño según tus necesidades)
            $this->Image($imageFile, 10, 10, 30, 0, 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        }
        
        $this->SetY(12);
        
        // Establecer la fuente para el nombre de la inhstitución
        $this->SetFont('helvetica', 'B', 18); // Fuente, estilo, tamaño
        $this->Cell(0, 5, 'Unidad Educativa Héroes del Cenepa', 0, 1, 'C', 0, '', 0, false, 'T', 'M');

        // Establecer la fuente para el subtítulo
        $this->SetFont('helvetica', '', 12);
        $this->Cell(0, 5, 'Patuca, Santiago, Morona Santiago', 0, 1, 'C', 0, '', 0, false, 'T', 'M');

        // Establecer la fuente para el subtítulo
        $this->SetFont('helvetica', '', 15);
        $this->Cell(0, 5, 'Año Lectivo 2024 - 2025', 0, 1, 'C', 0, '', 0, false, 'T', 'M');

        // Línea de separación debajo del encabezado
        $this->Ln(10);
        $this->Cell(0, 0, '', 'T', 1, 'C');
    }

    // Sobrescribir el método Footer (Opcional)
    public function Footer()
    {
        // Posición a 15 mm del final de la página
        $this->SetY(-15);
        $this->SetFont('helvetica', 'I', 8);
        // Número de página
        $this->Cell(0, 10, 'Página ' . $this->getAliasNumPage() . '/' . $this->getAliasNbPages(), 0, 0, 'C');
    }
    public function createPDF()
    {
        // Configurar el documento
        $this->SetCreator(PDF_CREATOR);
        $this->SetAuthor('Jose Ortega');
        $this->SetTitle('Certificado de Matricula');
        $this->SetSubject('Generación de PDF con Symfony y TCPDF');
        $this->SetKeywords('TCPDF, PDF, Symfony');

        // Ajustar márgenes antes de añadir la página
        $this->SetMargins(PDF_MARGIN_LEFT, 50, PDF_MARGIN_RIGHT); // Margen superior ajustado para dejar espacio al encabezado
        $this->SetHeaderMargin(20); // Margen del encabezado

        // Agregar una página
        $this->AddPage();

        // Configurar la fuente
        $this->SetFont('helvetica', '', 12);

        // Obtener el contenido del PDF como cadena
        return $this;
    }
}