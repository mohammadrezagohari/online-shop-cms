<?php
use App\Enums\ResultStatusBank;
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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedDouble("amount")->index();
            $table->enum("bank",App\Enums\GatewayType::ALL)->default(App\Enums\GatewayType::Zarinpal)->index();  //// Use Enum BankName => BankName::ALL
            $table->string("subject")->nullable();   //// عنوان تراکنش
            $table->string("trace_number")->nullable(); // شماره پیگیری
            $table->string("document_number")->nullable();//// rnn شماره سند
            $table->string("digital_receipt")->nullable();    // رسید دیجیتال
            $table->string("is_suer_bank")->nullable(); // بانک صادرکننده کارت
            $table->string("card_number")->nullable()->index(); // شماره کارت
            $table->string("access_token")->nullable()->index(); //// token که از بانک دریافت می کنیم
            $table->enum("status")->nullable()->default(0)->index();
            $table->text("payload")->nullable();///// description text
            $table->unsignedBigInteger("user_id")->index(); //// equals to invoiceID
            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedBigInteger('invoice_id')->index();
            $table->timestamps();   //// date paid update
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
