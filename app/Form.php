<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Form
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Form newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Form newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Form query()
 * @mixin \Eloquent
 * @property int $id
 * @property int $user_id
 * @property int $form_definition_id
 * @property int $state
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Form whereFormDefinitionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Form whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Form whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Form whereUserId($value)
 */
class Form extends Model
{
    //
}
