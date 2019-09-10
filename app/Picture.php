<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Picture
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Picture newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Picture newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Picture query()
 * @mixin \Eloquent
 * @property int $id
 * @property int $criterion_id
 * @property string $path
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Picture whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Picture whereCriterionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Picture whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Picture wherePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Picture whereUpdatedAt($value)
 */
class Picture extends Model
{
    protected $fillable = ['criterion_id', 'path', 'created_at', 'updated_at'];
}


