<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class second_quality_link extends Model {

	//
	protected $fillable = ['id', 'bag_id', 'bag', 'bag_qty', 'box_id','box','box_qty','created_at','updated_at','bag_box_key'];
	protected $table = 'second_quality_links';

}