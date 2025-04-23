<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            // $table->string('invoice_number')->unique();
            $table->id();
            $table->date('invoice_date');

            $table->integer('feri_quantity');
            $table->string('feri_units');
            // $table->decimal('feri_amount', 12, 2);

            $table->integer('cod_quantities');
            $table->string('cod_units');
            // $table->decimal('cod_amount', 12, 2);

            $table->decimal('euro_rate', 10, 4);
            $table->integer('transporter_quantity');

            $table->string('customer_ref');
            $table->string('customer_po');
            $table->string('customer_trip_no');
            $table->string('application_invoice_no');
            $table->string('certificate_no');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
