<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('members', function (Blueprint $table) {
            $table->id();

            // 01. සම්පූර්ණ නම — Full Name
            $table->string('full_name');
            // 02. ස්ථිර ලිපිනය — Permanent Address
            $table->text('permanent_address');
            // 03. දුරකථන අංකය — Phone Number
            $table->string('phone');
            // 04. ජාතික හැඳුනුම්පත් අංකය — National Identity Card Number (also the login username)
            $table->string('nic')->unique();
            // 05. රැකියා ස්ථානයෙහි ලිපිනය හා දුරකථන අංකය — Workplace Address and Phone Number
            $table->text('workplace_address_phone')->nullable();
            // 06. වර්ථමාන රැකියාව — Current Occupation
            $table->string('occupation')->nullable();
            // 07. පාසලට ඇතුලත් වීමේ අංකය — School Admission Number
            $table->string('admission_number');
            // 08. පාසලෙන් පිටව ගිය වර්ෂය — Year Left the School
            $table->string('year_left');

            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('members');
    }
};
