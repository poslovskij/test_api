<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
	protected $fillable = [
		"title", "description", "is_completed", "project_id"
	];

	public function project()
	{
		return $this->belongsTo(Project::class);
	}
}
