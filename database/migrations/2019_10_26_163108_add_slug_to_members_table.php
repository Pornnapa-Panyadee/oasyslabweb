<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSlugToMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('members', function (Blueprint $table) {
            $table->string('slug');
        });
        $members = DB::table('members')->get();
        foreach($members as $member){
            $tempName = explode(" ", $member->en_name);
            $slug = join("-",$tempName);
            DB::table('members')->where('id',$member->id)->update(['slug' => $slug]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('members', function (Blueprint $table) {
            $table->dropColumn('slug');
        });
    }
}
