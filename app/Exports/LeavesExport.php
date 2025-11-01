<?php

namespace App\Exports;

use App\Models\Leave;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\Exportable;

class LeavesExport implements FromQuery, WithHeadings, WithMapping {

    use Exportable;//gives the class the ability to be downloaded as excel/csv file  
    protected $query; //filtered request will be stored
    public function __construct($query){
        $this->query = $query;
    }
    public function query(){ //tells excel which data to export and return the filtered query you passed in
        return $this->query;
    }
    public function map($leave): array //converts each leave record into an array
    {
        return [
            $leave->id,
            $leave->user->name,
            $leave->type,
            $leave->start_date ? $leave->start_date->format('d/m/Y') : '',
            $leave->end_date ? $leave->end_date->format('d/m/Y') : '',
            $leave->comment,
            $leave->status,
        ];
    }
    public function headings(): array { //column titles 
        return [
            'Id',
            'Staff Name',
            'Type',
            'Start Date',
            'End Date',
            'Comment',
            'Status'
        ];
    }
}
