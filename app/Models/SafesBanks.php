<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SafesBanks extends Model
{
    //
    protected $guarded = [];
    public function revenues()
    {
        return $this->hasMany(Revenues::class,'safe_id');
    }
    public function expenses()
    {
        return $this->hasMany(Expenses::class,'safe_id');
    }
    public function totals()
    {
        $totals = [
            'income' => $this->revenues()->sum('amount'),
            'outcome' => $this->expenses()->sum('Expense'),
            'salaries' => 0
        ];
        $totals['balance'] = $totals['income'] - $totals['outcome'] - $totals['salaries'];
        return $totals;
    }
    public function TypeText()
    {
        return safeTypes(session()->get('Lang'))[$this->Type];
    }
    public function branch()
    {
        return $this->belongsTo(Branches::class,'branch_id');
    }
}