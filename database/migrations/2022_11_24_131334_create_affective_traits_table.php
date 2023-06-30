<?php

use App\Models\Student;
use App\Models\Term;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('affective_traits', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Student::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Term::class)->nullable()->constrained()->nullOnDelete();
            $table->integer('punctuality')->nullable();
            $table->integer('attendance')->nullable();
            $table->integer('reliability')->nullable();
            $table->integer('neatness')->nullable();
            $table->integer('politeness')->nullable();
            $table->integer('honesty')->nullable();
            $table->integer('relationship')->nullable();
            $table->integer('self_control')->nullable();
            $table->integer('attentiveness')->nullable();
            $table->integer('perseverance')->nullable();
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
        Schema::dropIfExists('affective_traits');
    }
};