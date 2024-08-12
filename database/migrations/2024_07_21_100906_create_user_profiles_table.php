<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('user_profiles', function (Blueprint $table) {
            $table->id();
            $table->string('user_id');
            $table->string('company_name')->nullable();
            $table->string('mobile', 20)->nullable();
            $table->string('fax', 20)->nullable();
            $table->string('billing_address1')->nullable();
            $table->string('billing_address2')->nullable();
            $table->string('billing_city')->nullable();
            $table->string('billing_state')->nullable();
            $table->string('billing_postcode', 20)->nullable();
            $table->string('billing_country')->nullable();
            $table->string('same_as_billing')->default('true');
            $table->string('shipping_address1')->nullable();
            $table->string('shipping_address2')->nullable();
            $table->string('shipping_city')->nullable();
            $table->string('shipping_state')->nullable();
            $table->string('shipping_postcode', 20)->nullable();
            $table->string('shipping_country')->nullable();
            $table->string('primary_payment_method')->nullable();
            $table->string('terms')->nullable();
            $table->string('discount')->nullable();
            $table->string('customer_type')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_profiles');
    }
};
