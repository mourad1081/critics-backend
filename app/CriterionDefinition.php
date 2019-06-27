<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * App\CriterionDefinition
 *
 * @method static Builder|CriterionDefinition query()
 * @mixin \Eloquent
 * @property int $id
 * @property string $title
 * @property float $score_max
 * @property int $section_definition_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property string|null $upated_at
 * @method static Builder|CriterionDefinition whereCreatedAt($value)
 * @method static Builder|CriterionDefinition whereId($value)
 * @method static Builder|CriterionDefinition whereScoreMax($value)
 * @method static Builder|CriterionDefinition whereSectionDefinitionId($value)
 * @method static Builder|CriterionDefinition whereTitle($value)
 * @method static Builder|CriterionDefinition whereUpatedAt($value)
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $priority
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CriterionDefinition newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CriterionDefinition newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CriterionDefinition wherePriority($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CriterionDefinition whereUpdatedAt($value)
 */
class CriterionDefinition extends Model
{
    //
    protected $fillable = [
        "title",
        "priority",
        "score_max",
        "section_definition_id",
        "created_at",
        "updated_at",
        "deleted_at"
    ];


}
