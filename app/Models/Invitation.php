<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Invitation extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function imageUrl(): Attribute
    {
        return $this->urlToCdn();
    }

    public function logoUrl(): Attribute
    {
        return $this->urlToCdn();
    }

    private function urlToCdn(): Attribute
    {
        return Attribute::make(
            get: function($value) {
                if(empty($value)) return $value;
                $url = Storage::url($value);
                if(app()->environment('local')) return $url;
                $url = urlencode($value);
                return "https://wsrv.nl/?url=$url&w=512&we";
            }
        );
    }
}