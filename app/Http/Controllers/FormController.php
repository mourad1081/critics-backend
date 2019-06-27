<?php

namespace App\Http\Controllers;

use App\CriterionDefinition;
use App\FormDefinition;
use App\SectionDefinition;
use Request;

class FormController extends Controller
{
    public function get(int $id) {
        $fd = FormDefinition::where('id', $id)->first();
        return [
            "id" => $fd->id,
            "title" => $fd->title,
            "sections" => $fd->formToJson()
        ];
    }

    public function patch() {
        $form = json_decode(Request::instance()->getContent());
        FormDefinition::whereId($form->id)->update(['title' => $form->title]);
        $new_section = null;
        foreach ($form->sections as $section) {
            // if it is a new section, we create it
            if (!isset($section->id)) {
                $new_section = SectionDefinition::create(["title" => $section->title, 'form_definition_id' => $form->id, 'priority' => $section->priority]);
            // otherwise, we update it
            } else {
                SectionDefinition::whereId($section->id)->update(['title' => $section->title, 'priority' => $section->priority]);
            }
            foreach ($section->criteria as $criterion) {
                // if it is a new criterion, we create it
                if (!isset($criterion->id)) {
                    CriterionDefinition::create([
                        "title" => $criterion->title,
                        "score_max" => $criterion->score_max,
                        "section_definition_id" => $new_section == null ? $section->id : $new_section->id,
                        "priority" => $criterion->priority
                    ]);
                }
                // otherwise, we update it
                else {
                    CriterionDefinition::whereId($criterion->id)->update(["title" => $criterion->title, "score_max" => $criterion->score_max, "priority" => $criterion->priority]);
                }
            }
            $new_section = null;
        }

        return [
            "success" => true,
            "newForm" => $this->get($form->id)
        ];
    }
}
