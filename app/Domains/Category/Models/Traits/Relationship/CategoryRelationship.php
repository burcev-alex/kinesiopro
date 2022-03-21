<?php 

namespace App\Domains\Category\Models\Traits\Relationship;

use App\Domains\Course\Models\Course;
use Orchid\Attachment\Models\Attachment;

trait CategoryRelationship {

    public function courses()
    {
        return $this->hasMany(Course::class, 'category_id', 'id')->where('active', 1);
    }

    public function attachment()
    {
        return $this->hasOne(Attachment::class, 'id', 'attachment_id');
    }
}