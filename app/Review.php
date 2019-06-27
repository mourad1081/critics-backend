<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Review
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Review newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Review newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Review query()
 * @mixin \Eloquent
 * @property int $id
 * @property int $user_id
 * @property int $form_definition_id
 * @property int $state
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Review whereFormDefinitionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Review whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Review whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Review whereUserId($value)
 */
class Review extends Model
{
    protected $fillable = [
        "id",
        "user_id",
        "form_definition_id",
        "state",
        "created_at",
        "updated_at"
    ];


    public static function createSections(FormDefinition $fd, Review $review)
    {
        $sections = SectionDefinition::whereFormDefinitionId($fd->id)->orderBy('priority')->get();
        $s = array();
        foreach ($sections as $sd) {
            $section = Section::create([
                "review_id" => $review->id,
            ]);
            $s[] = [
                "id" => $section->id,
                "review_id" => $review->id,
                "title" => $sd->title,
                "average" => 0,
                "section_definition_id" => $sd->id,
                "criteria" => Criterion::createCriteria($sd, $section)
            ];
        }

        return $s;
    }
}
