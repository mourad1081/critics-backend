@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row" style="height: 300px; background: url('{{ asset('upload/' . $review->picture) }}') no-repeat center center; background-size: cover;">
        </div>
        <div class="row">
            <p class="col-12 my-2 text-center text-muted">
                <i class="fa fa-map-marker-alt"></i> Restaurant X, Avenue Louise 345, Bruxelles
                <br>
                Critique faite par <i class="fa fa-user"></i> <strong>Boussa El Ouafi</strong>, le {{ $review->created_at->format('d/m/Y') }}, commencée à {{ $review->created_at->format('H\hi') }}
            </p>
        </div>
        <div class="row my-3">
            <h4 class="col-12 text-muted text-uppercase">Summary</h4>
            <canvas class="col-12" height="300" id="myChart"></canvas>
        </div>

        <div class="row">
            <h4 class="col-12 text-muted text-uppercase">Details</h4>
            <div class="col-12 py-4" style="background: #f0f0f0; border-top: solid lightgrey 10px;">
                <h5 class="text-uppercase text-muted text-center">
                    <strong>{{ $review->title }}</strong>
                </h5>
                <hr>

                @foreach($review->sections as $section)
                    <h6 class="text-uppercase text-muted mb-4"><strong>{{ $section->title }}</strong></h6>
                    <div class="row">
                        <div class="col-12 col-md-6">
                            @foreach($section->criteria as $criterion)
                                @php($score = $criterion->score / $criterion->score_max)
                                <p class="mb-0">
                                    {{ $criterion->title }} :
                                    <strong>
                                        {{ $criterion->score ?? 'N/A' }} / {{ $criterion->score_max }}
                                    </strong>
                                </p>
                                <div class="progress mb-3" style="height: 5px;">
                                    @if($score < 0.5)
                                        @php($color = 'bg-danger')
                                    @elseif($score < 0.7)
                                        @php($color = 'bg-warning-alt')
                                    @elseif($score < 0.8)
                                        @php($color = 'bg-success-alt')
                                    @elseif($score <= 1)
                                        @php($color = 'bg-success')
                                    @endif
                                    <div class="progress-bar {{ $color }}"
                                         role="progressbar"
                                         style="width: {{ $criterion->score*10 ?? 0 }}%;"
                                         aria-valuenow="{{ $criterion->score ?? 0 }}"
                                         aria-valuemin="0"
                                         aria-valuemax="{{ $criterion->score_max }}"></div>
                                </div>
                                <p class="p-3" style="background-color:lightgray;">
                                    <i class="fa fa-sticky-note mr-2"></i>
                                    @if($criterion->note)
                                        {{ $criterion->note }}
                                    @else
                                        <em class="text-muted">Pas de commentaire</em>
                                    @endif
                                </p>
                                <div class="p-3 mb-2" style="background-color:lightgray;">
                                    <p><i class="fa fa-paperclip"></i> Images</p>
                                    @forelse($criterion->files as $file)
                                        <img height="64" width="64" src="{{ asset('upload/' . $file->path) }}" alt="Attachment"/>
                                    @empty
                                    <p class="mt-1 mb-1 text-muted"><em>Aucune image</em></p>
                                    @endforelse
                                </div>
                            @endforeach
                        </div>
                        <div class="col-12 col-md-6">
                            <canvas height="200" id="section-{{ $section->id }}"></canvas>
                        </div>
                        <div class="col-12">
                            <hr>
                            <hr>
                            <hr>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="col-12 mb-4"></div>
        </div>
    </div>
@endsection


@section('javascript')
    <script>

        $('[data-toggle="tooltip"]').tooltip();

        let review = {!!  json_encode($review) !!};

        // Le code ci-dessous est équivalent à celui ci-dessus,
        // sauf que celui du dessus génère une
        // erreur sur Phpstorm (ça surligne en rouge).

        // let review =  [].concat(@json($review));
        let ctx = document.getElementById('myChart').getContext('2d');
        let charts = [];

        for(let i = 0; i < review.sections.length; i++) {
            let context = document.getElementById('section-' + review.sections[i].id).getContext('2d');

            charts.push(new Chart(context, {
                type: 'radar',
                data: {
                    labels: $(review.sections[i].criteria).map((k,v) => { return v.title.substring(0, 20) + ((v.title.length>20)? '...':'') }).toArray(),
                    datasets: [{
                        label: 'Score ',
                        data: $(review.sections[i].criteria).map((k,v) => { return v.score }).toArray(),
                        borderWidth: 1,
                        backgroundColor: 'rgba(0, 0, 255, 0.3)',
                        borderColor: 'rgba(0, 0, 200, 0.4)'
                    }]
                },
                options: {
                    title: {
                        display: true,
                        text: review.sections[i].title
                    },
                    scale: {
                        ticks: {
                            min: 0,
                            max: 10,
                            beginAtZero: true
                        }
                    }
                }
            }));
        }


        /**
         * Computes the average score when grouping by a property.
         * Typically the average by section.
         * @returns {Array} The averages
         */
        let average = function() {
            let averages = [];
            for(let i = 0; i < review.sections.length; i++) {
                let sum = 0, cpt = 0;

                for (let j = 0; j < review.sections[i].criteria.length; j++) {
                    if (review.sections[i].criteria[j].score > 0) {
                        sum += parseFloat(review.sections[i].criteria[j].score);
                        cpt++;
                    }
                }
                averages.push({
                    x:  review.sections[i].title,
                    y: sum / (cpt > 0 ? cpt : 1)
                });
                sum = 0;
                cpt = 0;
            }
            return averages;
        };

        let averages = average();
        let labels = $(review.sections).map((k, v) => { return v.title }).toArray();
        console.log("labels", labels);
        console.log('averages', averages);
        let myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Average score ',
                    data: averages,
                    borderWidth: 1,
                    backgroundColor: 'rgba(0, 0, 255, 0.3)',
                    borderColor: 'rgba(0, 0, 200, 0.4)'
                }]
            },
            options: {
                title: {
                    display: true,
                    text: 'Average score by section'
                },
                scales: {
                    yAxes: [{
                        ticks: {
                            min: 0,
                            max: 10,
                            beginAtZero: true
                        }
                    }]
                }
            }
        });
    </script>
@endsection