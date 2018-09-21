<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableOrders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('customer_id')->nullable();
            $table->string('customer_name')->nullable();
            $table->string('customer_phone')->nullable();
            $table->text('customer_address')->nullable();
            $table->integer('sale_user_id');
            $table->integer('payment_id');
            $table->string('code')->nullable();
            $table->integer('quantity')->nullable();
            $table->integer('price')->nullable();
            $table->integer('total')->nullable();
            $table->integer('salary')->nullable();
            $table->integer('award')->nullable();
            $table->integer('bag_qty')->default(0);
            $table->integer('box_qty')->default(0);
            $table->integer('gift')->default(0);
            $table->text('note')->nullable();

            $table->integer('vc_user_id')->nullable();
            $table->integer('phi_vc_thu_ho')->default(0);
            $table->integer('phi_vc_cty_tra')->default(0);
            $table->integer('tien_phai_thu')->default(0);
            $table->string('vc_name')->nullable();
            $table->string('vc_phone')->nullable();
            $table->string('vc_code')->nullable();
            $table->smallInteger('status')->default(0);

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
        Schema::dropIfExists('orders');
    }
}
