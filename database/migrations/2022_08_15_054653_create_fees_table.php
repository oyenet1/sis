<?php

use App\Models\Clas;
use App\Models\Term;
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
        Schema::create('fees', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Clas::class)->nullable()->constrained()->nullOnDelete();
            $table->foreignId('term_id')->nullable()->constrained()->nullOnDelete();
            $table->string('type');
            $table->double('amount', 10, 2);
            $table->double('total', 17, 2)->nullable()->default(0);
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
        Schema::dropIfExists('fees');
    }
};