<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    use HasFactory;
    protected $table = 'employees';
    protected $primaryKey = 'employee_id';
    protected $fillable = [
        'employee_name','employee_email','image_path','designation_id'
    ];
    use SoftDeletes;

    public function designation()
    {
        return $this->belongsTo(Designation::class , 'designation_id');
    }
}
