<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Borders;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class ReclamationsExport implements FromCollection, WithHeadings, WithStyles
{
    use Exportable;

    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function collection()
    {
        return collect($this->data);
    }

    public function headings(): array
    {
        return [
            'Référence Réclamation',
            'Date réception',
            'Canal principal  : 1er  canal par lequel la réclamation a été remontée',
            'Canal secondaire  : 2ème canal éventuelle par lequel la réclamation a été remontée, doublement',
            'Niveau d\'urgence de la réclamation (Forte, Normale, faible)',
            'La réclamation a fait l\'objet d\'une relance (Via le même canal principal (Oui/Non)',
            'Réclamation  Fondée ? (Oui/Non)',
            'Famille Réclamation',
            'Catégorie Réclamation',
            'Marché',
            'Niveau Service',
            'Agence du client',
            'Compte',
            'Nom client',
            'Montant réclamé',
            'Devise',
            'Motif de la réclamation',
            'Description de la réclamtion',
            'Entité traitante',
            'Réclamation retourné par la Qualification pour complèment d\'information (Oui/Non)',
            'Motif de retour par la Qualification',
            'Date de re envoie de la réclamation à la Qualifification après complètude d\'information',
            'Date de Traitement',
            'Date de clôture',
            'Statut',
            'Commentaires                                 (si observations)',
            // add more headings as needed
        ];
    }

    public function styles($sheet)
    {
        $columnCount = count($this->headings());

        // Set styles for the heading row
        $sheet->getStyle('A1:' . $sheet->getHighestColumn() . '1')->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 12,
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
                'wrapText' => true,
            ],
            'fill' => [
                'fillType' => Fill::FILL_GRADIENT_LINEAR,
                'rotation' => 90,
                'startColor' => [
                    'argb' => 'FFA0A0A0',
                ],
                'endColor' => [
                    'argb' => 'FFFFFFFF',
                ],
            ],
            'borders' => [
                'allBorders' => [
                    'color' => ['rgb' => '000000'],
                ],
            ],
        ]);

        // Set styles for data rows
        $sheet->getStyle('A2:' . $sheet->getHighestColumn() . $sheet->getHighestRow())->applyFromArray([
            'alignment' => [
                'vertical' => Alignment::VERTICAL_TOP,
                'wrapText' => true,
            ],
            'borders' => [
                'allBorders' => [
                    'color' => ['rgb' => '000000'],
                ],
            ],
            'font' => [
                'size' => 10,
            ],
            'rowDimension' => [
                'autoSize' => true,
                'rowHeight' => 20, // Set a minimum row height
            ],
        ]);

        // Set column width based on the length of the data in each column
        for ($i = 1; $i <= $columnCount; $i++) {
            $columnIndex = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($i);
            $columnData = $this->collection()->pluck($this->headings()[$i - 1])->toArray();
            $columnDataLength = array_map('strlen', $columnData);
            $maxColumnDataLength = max($columnDataLength) + 1; // Add 1 to account for padding

            // Set a minimum column width of 10 characters
            $sheet->getColumnDimension($columnIndex)->setWidth(max($maxColumnDataLength, 20));
        }

        return [
            1 => [
                'font' => [
                    'bold' => true,
                    'size' => 0,
                ],
            ],
            'A2:' . $sheet->getHighestColumn() . '2' => [
                'font' => [
                    'bold' => true,
                ],
            ],
        ];
    }
}
