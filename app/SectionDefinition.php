<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * App\SectionDefinition
 *
 * @method static Builder|SectionDefinition query()
 * @mixin \Eloquent
 * @property int $id
 * @property string $title
 * @property int $form_definition_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @method static Builder|SectionDefinition whereCreatedAt($value)
 * @method static Builder|SectionDefinition whereDeletedAt($value)
 * @method static Builder|SectionDefinition whereFormDefinitionId($value)
 * @method static Builder|SectionDefinition whereId($value)
 * @method static Builder|SectionDefinition whereTitle($value)
 * @method static Builder|SectionDefinition whereUpdatedAt($value)
 * @property int|null $priority
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SectionDefinition newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SectionDefinition newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SectionDefinition wherePriority($value)
 */
class SectionDefinition extends Model
{
    protected $fillable = [
        "title",
        "priority",
        "created_at",
        "updated_at",
        "deleted_at",
        "form_definition_id"
    ];

    public function retrieveCriteria() {
        return $this->hasMany('\App\CriterionDefinition')->get();
    }
}
