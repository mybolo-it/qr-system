<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    // Kolom yang dapat diisi secara massal
    protected $fillable = [
        'nama',
        'deskripsi',
        'file_path',
        'letterhead',   // <-- tambahkan kolom letterhead
        'token',
        'views',
    ];

    /**
     * Accessor untuk URL file dokumen
     */
    public function getFileUrlAttribute()
    {
        return asset('storage/' . $this->file_path);
    }

    /**
     * Accessor untuk URL kop surat (letterhead)
     */
    public function getLetterheadUrlAttribute()
    {
        // Jika letterhead tidak null, kembalikan URL-nya
        return $this->letterhead ? asset('storage/' . $this->letterhead) : null;
    }

    /**
     * Accessor untuk URL detail (digunakan untuk QR code)
     */
    public function getDetailUrlAttribute()
    {
        return route('item.show', $this->token);
    }
}