<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AllotedLeave extends Model
{
    use HasFactory;

    protected $fillable = [
        'alloted_for',
        'total_alloted_leaves',
        'sick_leave',
        'annual_leave',
        'maternity_leave',
        'unpaid_leave',
        'business_year_start',
        'business_year_end',
    ];

    public function enjoyedTotalLeaveCount()
    {
        return $this->sick_leave +
                $this->annual_leave +
                $this->maternity_leave +
                $this->unpaid_leave;
    }

    public function remainingLeaveCount()
    {
        return $this->total_alloted_leaves - $this->enjoyedTotalLeaveCount();
    }
}
