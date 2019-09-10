<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Section
 *
 * @property int $id
 * @property float|null $average
 * @property int|null $section_definition_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Section newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Section newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Section query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Section whereAverage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Section whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Section whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Section whereSectionDefinitionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Section whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Section extends Model
{
    protected $fillable = [
        "id", "average", "created_at", "updated_at", "section_definition_id", "review_id"
    ];
}
