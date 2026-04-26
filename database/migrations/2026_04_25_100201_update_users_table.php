<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Nullable karena HR Global/Superadmin mungkin tidak terikat 1 perusahaan
            $table->foreignId('company_id')->nullable()->constrained('companies')->nullOnDelete();

            // Ubah tipe role. Jika memakai MySQL, mengubah ENUM butuh library doctrine/dbal, 
            // atau Anda bisa me-replace kolomnya. Ini contoh membuat kolom role baru.
            $table->enum('role', ['superadmin', 'hr_global', 'company_admin', 'staff'])->default('staff')->change();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['company_id']);
            $table->dropColumn('company_id');
        });
    }
};
