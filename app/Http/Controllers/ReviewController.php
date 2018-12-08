<?php

namespace App\Http\Controllers;

use App\FormDefinition;
use Request;


class ReviewController extends Controller
{
    public function get() {

    }

    public function new(int $id_form) {
        $fd = FormDefinition::where('id', $id_form)->first();

        return [
            "id" => $fd->id,
            "title" => $fd->title,
            "sections" => $fd->formToJson()
        ];
    }

    public function put() {
        $review = json_decode(Request::instance()->getContent());
    }
}
