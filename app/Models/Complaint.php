<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Complaint extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = [];
    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
    public function respondedBy()
    {
        return $this->belongsTo(User::class,'responded_by');
    }
    public function complaintImages()
    {
        return $this->hasMany(ComplaintImage::class);
    }
    public function responses()
    {
        return $this->hasMany(Response::class);
    }
    
}
