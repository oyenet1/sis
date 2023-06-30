<?php

use App\Models\Clas;
use App\Models\User;
use App\Models\Guardian;
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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)->nullable()->constrained()->nullOnDelete();
            $table->foreignIdFor(Guardian::class)->nullable()->constrained()->nullOnDelete();
            $table->string('student_id')->nullable();
            $table->string('admission_id')->nullable();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('gender');
            $table->string('blood')->nullable();
            $table->string('disability')->nullable();
            $table->string('religion')->nullable();
            $table->json('hobbies')->nullable();
            $table->date('dob');
            $table->string('status')->nullable()->default('active');
            $table->string('email')->nullable()->unique();
            $table->string('phone')->nullable()->unique();
            $table->string('reg_class')->nullable();
            $table->string('result')->nullable();
            $table->foreignIdFor(Clas::class)->nullable()->constrained()->nullOnDelete();
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
        Schema::dropIfExists('students');
    }
};