@extends('layouts.app')

@section('content')
    <div class="container-fluid" style="margin-bottom: 100px;">
        <form class="row" method="post" action="{{ route('save-review') }}" id="review" data-form-definition-id="1" enctype="multipart/form-data">
            <div class="col-12 p-2 p-sm-4 shadow" style="background: white; border-top: solid #EEE 15px;">
                <h5 class="text-center text-uppercase text-muted py-3">
                    <strong><i class="mr-2 fa fa-utensils"></i> {{ $review['title'] }}</strong>
                </h5>
                <hr>
                <p class="text-center">
                    @csrf()
                    <button class="save btn btn-success text-uppercase" type="submit">
                        <i class="fa fa-check"></i> Sauvegarder
                    </button>
                </p>

                <h5 class="text-uppercase"><strong><i class="mx-2 fa fa-cogs"></i> Details</strong></h5>
                <hr>
                <div class="row px-3">
                    <label for="author" class="text-muted col-sm-2"><i class="mr-2 fa fa-user"></i> Author</label>
                    <p id="author" class="col-sm-10">
                        <strong>Boussa El Ouafi</strong>
                    </p>
                </div>
                <div class="row px-3">
                    <label for="localisation" class="text-muted col-sm-2"><i class="mr-2 fa fa-map-marker-alt"></i> Localisation</label>
                    <p id="localisation" class="col-sm-10">
                        <strong>Restaurant X, Avenue Louise 345, Brussels</strong>
                    </p>
                </div>
                <div class="form-group row px-3">
                    <label class="text-muted col-sm-2 col-form-label" for="picture"><i class="mr-2 fa fa-map-marked-alt"></i> Image de l'enseigne</label>
                    <div class="col-sm-10">
                        <input type="file"
                               name="picture"
                               id="picture"
                               class="form-control-file"
                               accept="image/*">
                    </div>
                </div>
                <hr class="my-4" style="border-width: 10px; border-color: #EEE;">

                <h5 class="text-uppercase"><strong><i class="mx-2 fa fa-bars"></i> Sections</strong></h5>
                <hr>
                @foreach($review['sections'] as $section)
                    <h6 class="section text-uppercase p-3" data-section-definition-id="{{ $section['section_definition_id'] }}">
                        <strong>{{ $section['title'] }}</strong>
                    </h6>
                    @foreach($section['criteria'] as $criterion)
                        <div class="criterion p-3 mb-3" style="background-color: #eee;" data-section-definition-id="{{ $section['section_definition_id'] }}" data-criterion-definition-id="{{ $criterion['criterion_definition_id'] }}">
                            <p class="ml-3"><strong>{{ $criterion['title'] }}</strong></p>
                            <hr class="ml-3">
                            <div style="border-left: solid #cfcfcf 5px;" class="ml-sm-3 pl-2 pl-sm-4">
                                <div class="form-group row">
                                    <label class="text-muted col-sm-2 col-form-label" for="score-{{ $criterion['criterion_definition_id'] }}"><i class="mr-2 fas fa-chart-bar"></i> Score (on {{ $criterion['score_max'] }})</label>
                                    <div class="col-sm-10">
                                        <input name="score-{{ $criterion['criterion_definition_id'] }}-{{ $section['section_definition_id'] }}-1"
                                               id="score-{{ $criterion['criterion_definition_id'] }}"
                                               type="number"
                                               min="0"
                                               max="{{ $criterion['score_max'] }}"
                                               class="score form-control">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="text-muted col-sm-2 col-form-label" for="note-{{ $criterion['criterion_definition_id'] }}"><i class="mr-2 fa fa-sticky-note"></i> Note</label>
                                    <div class="col-sm-10">
                                        <textarea name="note-{{ $criterion['criterion_definition_id'] }}-{{ $section['section_definition_id'] }}-1"
                                                  id="note-{{ $criterion['criterion_definition_id'] }}"
                                                  class="note form-control"
                                                  rows="2"
                                                  placeholder="Write a facultative note..."></textarea>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="text-muted col-sm-2 col-form-label" for="file-{{ $criterion['criterion_definition_id'] }}"><i class="mr-2 fa fa-paperclip"></i> Joindre des photos</label>
                                    <div class="col-sm-10">
                                        <input type="file"
                                               name="files-{{ $criterion['criterion_definition_id'] }}-{{ $section['section_definition_id'] }}-1[]"
                                               id="files-{{ $criterion['criterion_definition_id'] }}"
                                               class="form-control-file"
                                               accept="image/*"
                                               multiple>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endforeach
                <hr>
                <p class="text-center">
                    <button class="save btn btn-success text-uppercase">
                        <i class="fa fa-check"></i> Sauvegarder
                    </button>
                </p>
            </div>
        </form>
    </div>
@endsection
