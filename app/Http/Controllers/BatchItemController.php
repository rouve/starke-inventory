<?php

namespace App\Http\Controllers;

use App\Models\Batch;

class BatchItemController extends Controller
{
    public function index(Batch $batch): Batch
    {
        return $batch->load('items');
    }
}
