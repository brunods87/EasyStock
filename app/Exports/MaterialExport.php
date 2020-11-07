<?php

namespace App\Exports;

use App\Material;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class MaterialExport implements FromView, ShouldAutoSize
{
    protected $materials;

    public function __construct($materials)
    {
        $this->materials = $materials;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
        return view('materials.excel', [
            'data' => $this->materials
        ]);
    }
}
