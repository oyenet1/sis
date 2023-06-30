<?php

use App\Models\User;
use Illuminate\Support\Facades\Hash;
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
        Schema::create('guardians', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)->nullable()->constrained()->nullOnDelete();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('title')->nullable();
            $table->string('address')->nullable();
            $table->string('occupation')->nullable();
            $table->string('parent_id')->unique();
            $table->string('email')->unique();
            $table->string('phone')->unique();
            $table->string('password')->nullable()->default(Hash::make('password'));
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
        Schema::dropIfExists('guardians');
    }
};