<?php

namespace App\Imports;

use App\Models\Batch;
use App\Models\BatchItem;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class BatchImport implements ToModel, WithHeadingRow
{
    private Batch $batch;

    public function __construct(Batch $batch)
    {
        $this->batch = $batch;
    }

    public function model(array $row): BatchItem
    {
        $batchItem = [
            'batch_id' => $this->batch->id,
            'item_no' => $row['item_no'],
            'name' => $row['name'],
            'gauge' => $row['gauge'],
            'quantity' => $row['qty'],
            'end_1' => $row['end_1'],
            'end_2' => $row['end_2'],
            'end_3' => $row['end_3'],
            'end_4' => $row['end_4'],
            'item_length_angle' => $row['item_lengthangle'],
            'area' => $row['area'],
            'insulation' => $row['insulation'],
            'connector_1' => $row['connector_1'],
            'connector_2' => $row['connector_2'],
            'notes' => $row['notes'],
            'long_side' => $row['long_side'],
            'material' => $row['material'],
        ];

        return new BatchItem($batchItem);
    }

    public function startRow(): int
    {
        return 2;
    }
}
