<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('cnam', function (Blueprint $table) {
            $table->id(); // id auto-increment

            $table->string('numele');          // text scurt
            $table->string('prenumele');       // text scurt
            $table->date('data_nasterii');     // dată
            $table->string('idnp')->unique();  // cod unic

            $table->string('localitatea');     // text scurt
            $table->string('sectorul')->nullable();
            $table->string('strada')->nullable();
            $table->string('casa')->nullable();
            $table->string('blocul')->nullable();
            $table->string('apartamentul')->nullable();

            $table->string('full_info');       // câmpul calculat automat

            $table->timestamps(); // created_at + updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cnam');
    }
};
