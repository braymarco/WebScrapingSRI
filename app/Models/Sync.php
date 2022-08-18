<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/*
/*
 * @property string msg
 * @property int status
 * @property string percent
 */

class Sync extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function statusColor(): string
    {
        return match ($this->status) {
            0 => 'danger',
            1 => 'info',
            2 => 'success',
            default => '',
        };
    }
}
