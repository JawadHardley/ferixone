<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToArray;

class InvoiceImport implements ToArray
{
    public function array(array $array)
    {
        // Process the data from the imported Excel file here
        return $array;
    }
}
