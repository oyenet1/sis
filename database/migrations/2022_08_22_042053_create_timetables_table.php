<?php

use App\Models\Clas;
use App\Models\Day;
use App\Models\Subject;
use App\Models\User;
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
        Schema::create('timetables', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Clas::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Subject::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(User::class)->nullable()->constrained()->nullOnDelete();
            $table->foreignIdFor(Day::class)->nullable()->constrained()->nullOnDelete();
            $table->time('start');
            $table->time('end');
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
        Schema::dropIfExists('timetables');
    }
};