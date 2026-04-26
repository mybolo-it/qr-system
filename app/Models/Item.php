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
        'letterhead',
        'token',
        'views',
        'company_id',  // Relasi ke anak perusahaan yang menerbitkan dokumen
        'category_id', // Kategori dokumen (misal: SK, Memo)
        'status',      // Status dokumen (draft, published, dll)
    ];

    // --- ACCESSORS ---

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
        return $this->letterhead ? asset('storage/' . $this->letterhead) : null;
    }

    /**
     * Accessor untuk URL detail (digunakan untuk QR code)
     */
    public function getDetailUrlAttribute()
    {
        return route('item.show', $this->token);
    }

    // --- RELASI ---

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function scanLogs()
    {
        return $this->hasMany(ItemScanLog::class);
    }
}
