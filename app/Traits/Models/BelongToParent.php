<?php
namespace App\Traits\Models;

use App\Models\Parents;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

trait BelongToParent 
{
  /**
   * The roles that belong to the BelongToParent
   *
   * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
   */
  public function parent(): BelongsToMany
  {
      return $this->belongsToMany(Parent::class, 'parent_students', 'parent_id', 'student_id');
  }
}