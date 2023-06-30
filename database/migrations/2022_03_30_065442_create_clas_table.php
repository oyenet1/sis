<?php

use App\Models\User;
use App\Models\Department;
use App\Models\School;
use Illuminate\Support\Str;
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
        Schema::create('clas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('department_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignIdFor(School::class)->nullable()->constrained()->nullOnDelete();
            $table->string('name')->nullable();
            $table->string('high')->nullable();
            $table->string('section')->nullable()->default('A');
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
        Schema::dropIfExists('clas');
    }
};