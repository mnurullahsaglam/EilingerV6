<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Application;

class CreateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public const MSG_STATUS = [
        'not_send' => 'not_send',
        'approved' => 'approved',
        'pending' => 'pending',
        'waiting' => 'waiting'
    ];

    public function up()
    { /**
        * Status
        *
        * not_send = noch nicht eingereicht
        * pending = Wartet auf Antwort der Stiftun
        * waiting = Wartet auf Antwort vom Benutzer
        */
        
        Schema::create('messages', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->foreignIdFor(Application::class)->nullable($value = true);
            $table->longText('message');
            $table->longText('answer');
            $table->string('msg_status')->default('not_send');
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
        Schema::dropIfExists('messages');
    }
};
