<?php

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
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)->constrained('users')->onDelete('cascade')->default(1);
            $table->string('type')->nullable();
            $table->double('salary', 8, 2)->nullable();
            $table->string('certificate')->nullable();
            $table->string('id_type')->nullable();
            $table->string('occupation')->nullable();
            $table->string('id_number')->nullable();
            $table->string('address')->nullable();
            $table->string('gender')->nullable();
            $table->string('status')->nullable()->default('active');
            $table->string('passport')->nullable();
            $table->date('admitted')->nullable();
            $table->date('dob')->nullable();
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
        Schema::dropIfExists('profiles');
    }
};