<?php

use App\Models\Student;
use App\Models\Term;
use App\Models\User;
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
        Schema::create('remarks', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Student::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Term::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(User::class)->nullable()->constrained()->nullOnDelete();
            $table->string('type')->default('teacher');
            $table->text('remarks');
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
        Schema::dropIfExists('remarks');
    }
};
