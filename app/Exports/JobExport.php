<?php

namespace App\Exports;

use App\Job;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class JobExport implements FromView, ShouldAutoSize
{
	protected $job;

    public function __construct($job)
    {
        $this->job = $job;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
        return view('jobs.excel', [
            'data' => $this->job
        ]);
    }
}
