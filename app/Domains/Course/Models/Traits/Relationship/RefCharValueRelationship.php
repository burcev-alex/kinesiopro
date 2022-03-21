<?php 
namespace App\Domains\Course\Models\Traits\Relationship;

use App\Domains\Course\Models\RefChar;

trait RefCharValueRelationship {
    
    public function char()
    {
        return $this->belongsTo(RefChar::class, 'char_id', 'id');
    }

    public function chars()
    {
        return $this->belongsTo(RefChar::class, 'char_id', 'id', 'values');
    }

}