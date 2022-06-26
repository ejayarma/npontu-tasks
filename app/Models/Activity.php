<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
use OwenIt\Auditing\Auditable;

class Activity extends Model implements AuditableContract
{
    use HasFactory;
    use Auditable;
    use SoftDeletes;

    public function assigned_to()
    {
        return $this->belongsTo(User::class, null, 'assigned_to');
    }
}
