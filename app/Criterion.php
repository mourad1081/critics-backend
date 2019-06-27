<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Criterion
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Criterion newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Criterion newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Criterion query()
 * @mixin \Eloquent
 * @property int $id
 * @property int $form_id
 * @property int $criterion_definition_id
 * @property float|null $score
 * @property string|null $note
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Criterion whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Criterion whereCriterionDefinitionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Criterion whereFormId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Criterion whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Criterion whereNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Criterion whereScore($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Criterion whereUpdatedAt($value)
 */
class Criterion extends Model
{
    //
    protected $fillable = [
        "criterion_definition_id",
        "section_id",
        "score",
        "note"
    ];

    public static function createCriteria(SectionDefinition $sd, Section $section) {
        $cs = CriterionDefinition::whereSectionDefinitionId($sd->id)->get();

        $a = array();

        foreach ($cs as $c) {
            $cr = Criterion::create([
                "section_id" => $section->id,
                "criterion_definition_id" => $c->id,
                "score" => 0,
                "note" => ""
            ]);

            $a[] = [
                "id" => $cr->id,
                "section_id" => $section->id,
                "title" => $c->title,
                "criterion_definition_id" => $c->id,
                "score" => null,
                "score_max" => $c->score_max,
                "note" => null
            ];
        }

        return $a;
    }
}
