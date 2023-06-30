<?php

use App\Models\Clas;
use App\Models\Term;
use App\Models\User;
use App\Models\Sesion;
use App\Models\Student;
use App\Models\Subject;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('scores', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Clas::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Subject::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(User::class)->nullable()->constrained()->nullOnDelete();
            $table->foreignIdFor(Student::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Term::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Sesion::class)->nullable()->constrained()->cascadeOnDelete();
            $table->integer('total')->default(0)->nullable();
            $table->boolean('submitted')->default(false)->nullable();
            $table->integer('ca1')->nullable();
            $table->integer('ca2')->nullable();
            $table->integer('pm')->nullable();
            $table->integer('em')->nullable();
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
        Schema::dropIfExists('scores');
    }
};