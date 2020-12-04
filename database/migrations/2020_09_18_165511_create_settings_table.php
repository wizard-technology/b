<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->double('bizzcoin');
            $table->text('message');
            $table->text('forget');
            $table->boolean('state_app');
            $table->timestamps();
        });
        DB::table('settings')->insert(
            array(
                'bizzcoin' => 0.68,
                'message' => 'This is a verification OTP Code:',
                'forget' => 'This is a verification OTP Code:',
                'state_app' => true,
            )
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('settings');
    }
}
