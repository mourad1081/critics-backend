<?php

namespace App\Http\Controllers;

use App\Criterion;
use App\FormDefinition;
use App\Review;
use App\Section;
use Request;


class ReviewController extends Controller
{
    public function get() {

    }

    public function getAll() {
        return Review::orderByDesc('created_at')->get();
    }

    public function new(int $id_form) {
        $fd = FormDefinition::where('id', $id_form)->first();
        $review = Review::create([
            "form_definition_id" => $fd->id,
            "user_id" => 1
        ]);
        return [
            "id" => $review->id,
            "title" => $fd->title,
            "form_definition_id" => $fd->id,
            "sections" => Review::createSections($fd, $review)
        ];
    }




    /**
     * Updates a review
     * @return array
     */
    public function save() {
        $review = json_decode(Request::instance()->getContent());
        foreach ($review->sections as $section) {
            Section::whereId($section->id)->update([
                "average" => $section->average
            ]);

            foreach ($section->criteria as $criterion) {
                Criterion::whereId($criterion->id)->update([
                    "score" => $criterion->score,
                    "note" => $criterion->note
                ]);
            }
        }
        return ["success" => true];
    }
}
