<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * App\FormDefinition
 *
 * @property int $id
 * @property string $title
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @method static Builder|FormDefinition query()
 * @method static Builder|FormDefinition whereCreatedAt($value)
 * @method static Builder|FormDefinition whereDeletedAt($value)
 * @method static Builder|FormDefinition whereId($value)
 * @method static Builder|FormDefinition whereTitle($value)
 * @method static Builder|FormDefinition whereUpdatedAt($value)
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FormDefinition newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FormDefinition newQuery()
 */
class FormDefinition extends Model
{
    protected $fillable = [
        "title", "created_at", "updated_at", "deleted_at"
    ];

    /**
     *
     * @return array
     */
    public function formToJson() {
        $sections = $this->hasMany('App\SectionDefinition')->orderBy('priority')->get();
        $json = [];
        foreach ($sections as $section) {
            array_push($json, [
                "id" => $section->id,
                "title" => $section->title,
                "criteria" => $section->retrieveCriteria(),
                "priority" => $section->priority
            ]);
        }
        return $json;
    }
}

