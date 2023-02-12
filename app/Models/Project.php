<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;
    use HasFactory;
    protected $fillable = ["name", "type_id", "description", "cover_img", "github_link"];

    public function type() {

        return $this->belongsTo(Type::class);
    }
}
