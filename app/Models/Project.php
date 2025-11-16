<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'pda_code',
        'rate',
        'state',
        'investments',
        'justification',
        'classification_of_investments',
        'data_uploaded',
        'quartile_date',
        'start_date',
        'finish_date',
        'file_name',
        'upload_pda',
        'company_id'
    ];

    protected $casts = [
        'rate' => 'float',
        'start_date' => 'datetime',
        'finish_date' => 'datetime',
    ];


    protected $enumFields = [
        'state' => ['Capex', 'Planification', 'Execution', 'Finished'],
        'investments' => [
            'Innovation',
            'Efficiency & Saving',
            'Replacement & Restructuring',
            'Quality & Hygiene',
            'Health & Safety',
            'Environment',
            'Maintenance',
            'Capacity Increase'
        ],
        'classification_of_investments' => [
            'Buildings',
            'Furniture',
            'General Install',
            'Land',
            'Machines & Equipm',
            'Office Hardware Software',
            'Other',
            'Vehicles',
            'Vessel & Fishing Equipment',
            'Warenhouse & Distrib'
        ],
        'justification' => ['Normal Capex', 'Special Project'],
    ];

    public function getEnumOptions($field)
    {
        return $this->enumFields[$field];
    }

    public function scopeSearch($query, $term)
    {
        if ($term) {
            $query->where(function ($query) use ($term) {
                $query->where('name', 'like', '%' . $term . '%')
                    ->orWhere('pda_code', 'like', '%' . $term . '%')
                    ->orWhere('state', 'like', '%' . $term . '%')
                    ->orWhere('investments', 'like', '%' . $term . '%')
                    ->orWhere('justification', 'like', '%' . $term . '%');
            });
        }

        return $query;
    }

    public function data()
    {
        return $this->hasMany(Data::class);
    }

    /**
     * Get the company that owns the project.
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
