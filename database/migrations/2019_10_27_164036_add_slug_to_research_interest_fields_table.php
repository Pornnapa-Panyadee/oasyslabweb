<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSlugToResearchInterestFieldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('research_interest_fields', function (Blueprint $table) {
            $table->string('slug');
        });
        $fields = DB::table('research_interest_fields')->get();
        foreach($fields as $field){
            $tempName = explode(" ", $field->name);
            $slug = join("-",$tempName);
            DB::table('research_interest_fields')->where('id',$field->id)->update(['slug' => $slug]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('research_interest_fields', function (Blueprint $table) {
            $table->dropColumn('slug');
        });
    }
}
