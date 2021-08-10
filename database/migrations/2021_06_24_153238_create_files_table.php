<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFilesTable extends Migration
{
    public function up()
    {
        Schema::create('files', function (Blueprint $table) {
            $table->id();

            if (config('file-uploader.table')) {
                $table->unsignedBigInteger('user_id')->nullable();
                $table->foreign('user_id')->references('id')->on(config('file-uploader.table'));
            }

            $table->string('name');
            $table->string('disk');
            $table->string('path');
            $table->string('url');
            $table->string('type')->nullable()->default(null);
            $table->string('mime_type')->nullable()->default(null);
            $table->string('extension')->nullable()->default(null);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('files');
    }
}
