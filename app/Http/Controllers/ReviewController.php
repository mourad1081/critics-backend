<?php

namespace App\Http\Controllers;

use App\Criterion;
use App\FormDefinition;
use App\Picture;
use App\Review;
use App\Section;
use App\ViewCriterion;
use App\ViewReview;
use App\ViewReviewCriterion;
use App\ViewSection;
use Auth;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\UploadedFile;
use Illuminate\View\View;
use PhpOffice\PhpWord\Exception\Exception;
use Request;


class ReviewController extends Controller
{

    public function index(int $id) {
        $slugs = [null, 'restaurant', 'hostel'];

        $review = Review::whereId($id)->first();

        if (!$review) {
            abort(404);
        }

        $type_review = $review->form_definition_id;
        $r = $this->getReview($id);

        return view('review', [
            'slug' => $slugs[$type_review],
            'id_type_review' => $type_review,
            'review' => $r
        ]);
    }

    public function getAll() {
        return Review::orderByDesc('created_at')->get();
    }

    /**
     * @param int $id_form
     * @return Factory|View
     */
    public function new(int $id_form) {
        $slugs = [null, 'restaurant', 'hostel'];
        $fd = FormDefinition::where('id', $id_form)->first();

        if (!$fd) {
            abort(404);
        }

        $review = [
            "title" => $fd->title,
            "form_definition_id" => $fd->id,
            "sections" => Review::createSections($fd)
        ];

        return view('new-review', [
            'slug' => $slugs[$id_form],
            'id_type_review' => $id_form,
            'review' => $review
        ]);

    }


    public function delete(int $id) {
        $review = Review::whereId($id);
        try {
            $review->delete();
        } catch (\Exception $e) {
            return back()->with([
                "deleted" => false
            ]);
        }
        return back()->with([
            "deleted" => true
        ]);
    }

    /**
     * Saves a review
     * @param int $id_form
     * @return array
     */
    public function save(int $id_form) {
        $id_author = 1;
        if (Auth::user()) {
            $id_author = Auth::user()->id;
        }

        $review_created = Review::create([
            'form_definition_id' => $id_form,
            'user_id' => $id_author,
            'state' => 0
        ]);

        $picture = Request::file('picture');

        if (Request::hasFile('picture')) {
            $name = 'cover' . '.' . $picture->extension();
            $picture->move(public_path() . '/upload/'. $review_created->id . '/', $name);
            $review_created->picture = $review_created->id . '/' . $name;
            $review_created->save();
        }

        $sections = $this->formToSections(Request::except(['_token', 'picture']));

        foreach ($sections as $sId => $section) {
            $section_created = Section::create([
                "section_definition_id" => $section->sectionDefinitionId,
                "review_id" => $review_created->id
            ]);

            foreach ($section->criteria as $cId => $criterion) {
                $criterion_created = Criterion::create([
                    "criterion_definition_id" => $criterion->criterionDefinitionId,
                    'section_id' => $section_created->id,
                    "score" => $criterion->score,
                    "note" => $criterion->note
                ]);

                if ($criterion->files) {
                    /* @var UploadedFile $file The uploaded file */
                    foreach ($criterion->files as $index => $file) {
                        $name = 'file-criterion-' . $criterion_created->id . '-' . $index . '.' . $file->extension();
                        $path = $review_created->id . '/' . $section_created->id . '/';
                        $file->move(public_path() . '/upload/'. $path, $name);

                        Picture::create([
                            'criterion_id' => $criterion_created->id,
                            'path' => $path . $name
                        ]);
                    }
                }
            }
        }

        return redirect()->to('/api/reviews/' . $review_created->id);
    }

    private function formToSections($input) {
        // format des noms : <name>-<criterion_definition_id>-<section_definition_id>-<form_definition_id>

        $sections = [];

        foreach ($input as $name => $value) {
            $parts = explode('-', $name);

            // [0]: name
            // [1]: criterion definition id
            // [2]: section definition id
            // [3]: form definition id

            // Si la section existe...
            if (isset($sections[$parts[2]])) {
                // on check si le crière existe...
                if (isset($sections[$parts[2]]->criteria[$parts[1]])) {
                    // on update la valeur simplement
                    $sections[$parts[2]]->criteria[$parts[1]]->{$parts[0]} = $value;
                }
                // sinon, on le créé
                else {
                    $new_criterion = (object) array("criterionDefinitionId" => $parts[1], "score" => null, "note" => null, "files" => null);
                    $new_criterion->{$parts[0]} = $value;
                    $sections[$parts[2]]->criteria = array_add($sections[$parts[2]]->criteria, $parts[1], $new_criterion);
                }
            }
            // On n'a pas déjà créé cette section, on le fait et on rajoute le premier criterion
            else {
                $new_section = (object) array(
                    "sectionDefinitionId" => $parts[2],
                    "criteria" => [
                        $parts[1] => (object) array("criterionDefinitionId" => $parts[1], "score" => null, "note" => null, "files" => null)
                    ]
                );

                $new_section->criteria[$parts[1]]->{$parts[0]} = $value;
                $sections = array_add($sections, $parts[2], $new_section);
            }
        }
        return $sections;
    }

    /**
     * Updates a review
     * @return array
     */
    public function update() {
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

    public function generate(int $id) {

        $review = $this->getReview($id);
        // Creating the new document...
        $phpWord = new \PhpOffice\PhpWord\PhpWord();
        $phpWord->setDefaultFontName('Times New Roman');
        $phpWord->setDefaultFontSize(12);

        $phpWord->addTitleStyle(1, array('size' => 16, 'color' => '1B2232', 'bold' => true));
        $phpWord->addTitleStyle(2, array('size' => 14, 'color' => '1B2232', 'bold' => true));

        $section_word = $phpWord->addSection();

        foreach ($review->sections as $section) {
            // Adding an empty Section to the document...
            // Note: any element you append to a document
            // must reside inside of a Section.
            $section_word->addTitle($section->title, 1);

            foreach ($section->criteria as $criterion) {
                $section_word->addTitle($criterion->title, 2);
                $section_word->addText('Score : ' . $criterion->score . '/' . $criterion->score_max);
                $section_word->addText('Commentaire : ' . $criterion->note);

                $section_word->addChart('radar', array(
                    'type 1', 'type 2', 'type 3', 'type 4', 'type 5'
                ), array(
                    23, 12, 5, 17, 21
                ));

                /*
                array(
                    'type' => 'radarChart',
                    'title' => 'Scores',
                    'color' => 3,
                    'float' => 'right',
                    'data' => array(
                        array(
                            'name' => 'Yo mec',
                            'values' => array(10),
                        ),
                        array(
                            'name' => 'Yo mec 2',
                            'values' => array(4),
                        ),
                        array(
                            'name' => 'Yo mec 3',
                            'values' => array(15),
                        ),
                        array(
                            'name' => 'Yo mec 4',
                            'values' => array(12),
                        ),
                    )
                ));
                */
            }
            $section_word->addPageBreak();
        }

        // Saving the document as OOXML file...
        try {
            $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
            header("Content-Disposition: attachment; filename=myFile.docx");
            $objWriter->save("php://output");
        } catch (Exception $e) {
            echo "Erreur: " . $e->getMessage();
        }
    }

    /**
     * @param int $id
     * @return object
     */
    private function getReview(int $id)
    {
        $review = ViewReview::where('id', $id)->first();

        $sections = ViewSection::where('review_id', $review->id)
            ->orderBy('priority')
            ->get();
        $s = [];
        foreach ($sections as $section) {
            $section = (object)array(
                "id" => $section->id,
                "title" => $section->title,
                "criteria" => []
            );
            $criteria = ViewCriterion::where('section_id', $section->id)->orderBy('priority')->get();

            foreach ($criteria as $criterion) {
                $c = (object)array(
                    'id' => $criterion->id,
                    'section_id' => $criterion->section_id,
                    'score' => $criterion->score,
                    'note' => $criterion->note,
                    'title' => $criterion->title,
                    'score_max' => $criterion->score_max,
                    'priority' => $criterion->priority,
                    'files' => []
                );

                $files = Picture::whereCriterionId($criterion->id)->get();

                foreach ($files as $file) {
                    $c->files[] = (object)array(
                        'id' => $file->id,
                        'criterion_id' => $file->criterion_id,
                        'path' => $file->path
                    );
                }

                $section->criteria[] = $c;
            }

            $s[] = $section;
        }

        $r = (object) array(
            "id" => $review->id,
            "title" => $review->title,
            "created_at" => $review->created_at,
            "picture" => $review->picture,
            "sections" => $s
        );
        return $r;
    }
}
