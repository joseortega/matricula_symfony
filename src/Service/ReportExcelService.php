<?php

namespace App\Service;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use App\Entity\Matricula;


class ReportExcelService
{
    public function __construct()
    {

    }

    public function printMatriculaList(
        string $periodoFilter,
        string $gradoFilter,
        string $paraleloFilter,
        array $estadoMatriculaFilter,
        string $searchFilter,
        array $matriculas): Spreadsheet
    {

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();


        //Filtros de busqueda
        $sheet->getStyle('A1:A5')->getFont()->setBold(true);

        $sheet->mergeCells('A1:B1');
        $sheet->setCellValue('A1', "Periodo Lectivo");

        $sheet->mergeCells('A2:B2');
        $sheet->setCellValue('A2', "Grado Escolar");

        $sheet->mergeCells('A3:B3');
        $sheet->setCellValue('A3', "Paralelo");

        $sheet->mergeCells('A4:B4');
        $sheet->setCellValue('A4', "Estado");

        $sheet->mergeCells('A5:B5');
        $sheet->setCellValue('A5', "Termino de Busqueda");

        $sheet->setCellValue('C1', $periodoFilter);
        $sheet->setCellValue('C2', $gradoFilter);
        $sheet->setCellValue('C3', $paraleloFilter);
        if(!empty($estadoMatriculaFilter)){
            // Convertimos el array en string separado por coma
            $estadoStr = implode(', ', $estadoMatriculaFilter);
            $sheet->setCellValue('C4', $estadoStr);
        }else{
            $sheet->setCellValue('C4', "Todos");
        }
        $sheet->setCellValue('C5', $searchFilter);

        $sheet->getStyle('A7:J7')->getFont()->setBold(true);

        //Encabezado de Tabla
        $sheet->setCellValue("A7", "Nro");
        $sheet->setCellValue("B7", "Identificación");
        $sheet->setCellValue("C7", "Nombres");
        $sheet->setCellValue("D7", "Sexo");
        $sheet->setCellValue("E7", "fecha de Nacimiento");
        $sheet->setCellValue("F7", "Talla Uniforme");
        $sheet->setCellValue("G7", "Periodo Lectivo");
        $sheet->setCellValue("H7", "Grado");
        $sheet->setCellValue("I7", "Estado");
        $sheet->setCellValue("J7", "Consta-CAS?");
        $sheet->setCellValue("K7", "Está-Legalizada?");
        $sheet->setCellValue("L7", "Representante-Legal");
        $sheet->setCellValue("M7", "Representante-Identificación");
        $sheet->setCellValue("N7", "Representante-Contacto");
        $sheet->setCellValue("O7", "Representante-Dirección");

        $this->estiloEncabezadoTabla($sheet, 'A7:O7');

        //Datos de tabla
        $row = 8;
        $count = 1;

        foreach (range('A', 'O') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        foreach ($matriculas as $matricula) {
            $sheet->setCellValue('A'.$row, $count);
            $sheet->setCellValue('B'.$row, $matricula->getEstudiante()->getIdentificacion());
            $sheet->setCellValue('C'.$row, $matricula->getEstudiante()->getApellidos()." ".$matricula->getEstudiante()->getNombres());
            $sheet->setCellValue('D'.$row, $matricula->getEstudiante()->getSexo());
            $sheet->setCellValue('E'.$row, $matricula->getEstudiante()->getFechanacimiento()->format('d-m-Y'));
            if($matricula->getEstudiante()->getUniformeTalla() !== null){
                $sheet->setCellValue('F'.$row, $matricula->getEstudiante()->getUniformeTalla()->getDescripcion());
            }else{
                $sheet->setCellValue('F'.$row, "");
            }
            $sheet->setCellValue('G'.$row, $matricula->getPeriodoLectivo()->getDescripcion());
            $sheet->setCellValue('H'.$row, $matricula->getGradoEscolar()->getDescripcion());
            $sheet->setCellValue('I'.$row, $matricula->getEstadoMatricula()->getDescripcion());
            $sheet->setCellValue('J'.$row, $matricula->isInscritoSistemaPublico());
            $sheet->setCellValue('K'.$row, $matricula->isLegalizada());

            if($representante = $matricula->getEstudiante()->getRepresentantePrincipal()){
                $sheet->setCellValue('L'.$row, $representante->getApellidos()." ".$representante->getNombres());
                $sheet->setCellValue('M'.$row, $representante->getIdentificacion());
                $sheet->setCellValue('N'.$row, $representante->getTelefono());
                $sheet->setCellValue('O'.$row, $representante->getDireccion());
            }

            $row++;
            $count++;
        }

        // La tabla empieza en la fila 1 (con encabezados)
        $startRow = 7;

        // La última fila de datos
        $endRow = $row - 1;

        // Definir el rango
        $range = 'A' . $startRow . ':O' . $endRow;

        $this->estiloCeldaTabla($sheet, $range);

        return $spreadsheet;

    }

    public function estiloEncabezadoTabla(Worksheet $sheet, string $range = ''){


        // Estilo para encabezados
        $headerStyle = [
            'font' => [
                'bold' => true, // Negrita
                'color' => ['argb' => '000000'], // Texto negro
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => [
                    'argb' => 'FFD9D9D9', // Gris claro
                ],
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
                'vertical'   => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '000000'],
                ],
            ],
        ];

        // Aplicar estilo al rango de encabezados
        $sheet->getStyle($range)->applyFromArray($headerStyle);
    }

    public function estiloCeldaTabla(Worksheet $sheet, $range = 'A7:E7')
    {
        // Estilos de borde
        $styleArray = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '000000'],
                ],
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
                'vertical'   => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
        ];

        // Aplicar a toda la tabla
        $sheet->getStyle($range)->applyFromArray($styleArray);
    }

}