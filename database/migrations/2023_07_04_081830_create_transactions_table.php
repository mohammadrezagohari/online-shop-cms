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
            $table->foreignId('order_id')->constrained('orders');
            $table->foreignId('user_id')->constrained('users');
            $table->enum("bank",App\Enums\GatewayType::ALL)->default(App\Enums\GatewayType::Zarinpal)->index();  //// Use Enum BankName => BankName::ALL
            $table->string("message")->nullable();   //// عنوان تراکنش
            $table->string("code")->nullable(); // شماره کد
            $table->string("card_hash")->nullable()->index(); // شماره کارت هش شده
            $table->string("card_pan")->nullable()->index(); //// شماره کارت
            $table->tinyInteger("status")->nullable()->default(0)->index();
            $table->text("ref_id")->nullable();/////  شماره ارجاع
            $table->text("fee_type")->nullable();/////   نوع کارمزد
            $table->text("fee")->nullable();/////    کارمزد
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
