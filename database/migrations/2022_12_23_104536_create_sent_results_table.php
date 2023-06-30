<?php

use App\Models\Clas;
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
        Schema::create('sent_results', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Term::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Clas::class)->nullable()->unique()->constrained()->cascadeOnDelete();
            $table->string('status')->nullable();
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
        Schema::dropIfExists('sent_results');
    }
};
