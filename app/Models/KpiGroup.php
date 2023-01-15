<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KpiGroup extends Model
{
    use HasFactory;
    protected $fillable = ['name'];

    public function kpis(){
        return $this->hasMany(KPI::class, "group_id", "id");
    }

    public static function fistItemId(){
        $id = 0;
        $first = KpiGroup::first();
        if ($first)
            $id = $first->id;
        return $id;
    }
}
