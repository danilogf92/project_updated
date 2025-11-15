<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Schema;

class Data extends Model
{

    use HasFactory;
    protected $table = 'data';

    protected $fillable = [
        'area',
        'project_id',
        'group_1',
        'group_2',
        'description',
        'general_classification',
        'item_type',
        'unit',
        'qty',
        'unit_price',
        'global_price',
        'stage',
        'real_value',
        'committed',
        'percentage',
        'executed_dollars',
        'executed_euros',
        'supplier',
        'code',
        'order_no',
        'input_num',
        'observations',
        'booked',
        'executed_euros',
        'global_price_euros',
        'real_value_euros',
        'booked_euros',
    ];

    public function getColumnNames()
    {
        $allColumns = Schema::getColumnListing($this->table);
        $excludedColumns = [
            'id',
            'project_id',
            'description',
            'unit',
            'qty',
            'unit_price',
            'global_price',
            'real_value',
            'booked',
            'percentage',
            'executed_dollars',
            'executed_euros',
            'global_price_euros',
            'real_value_euros',
            'booked_euros',
            'code',
            'order_no',
            'input_num',
            'observations',
            'created_at',
            'updated_at',
        ];

        // Filtrar las columnas excluidas
        $filteredColumns = array_diff($allColumns, $excludedColumns);

        sort($filteredColumns);

        return $filteredColumns;
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
