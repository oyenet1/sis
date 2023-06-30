<?php

use App\Models\Term;
use App\Models\Student;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('psychomotors', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Student::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Term::class)->nullable()->constrained()->nullOnDelete();
            $table->integer('handwriting')->nullable();
            $table->integer('games')->nullable();
            $table->integer('sports')->nullable();
            $table->integer('drawing')->nullable();
            $table->integer('crafts')->nullable();
            $table->integer('music')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('psychomotors');
    }
};