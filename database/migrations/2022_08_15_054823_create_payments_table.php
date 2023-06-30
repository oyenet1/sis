<?php

use App\Models\Fee;
use App\Models\Method;
use App\Models\Student;
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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string('reference');
            $table->foreignIdFor(Fee::class)->nullable()->constrained()->nullOnDelete();
            $table->foreignIdFor(Student::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Method::class)->default(3)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(User::class)->nullable()->constrained()->cascadeOnDelete();
            $table->string('status')->default('processing');
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
        Schema::dropIfExists('payments');
    }
};