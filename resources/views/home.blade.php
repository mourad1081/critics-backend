@extends('layouts.app')

@section('content')
    <div id="add-review" class="btn btn-primary d-block d-sm-none">
        <a href="{{ route('new_review', 1) }}"><i class="fa fa-plus"></i></a>
    </div>
    <div class="container-fluid" style="margin-bottom: 100px;">
        <div class="row">
            <div class="col-12 my-2">
                <h4><i class="fa fa-tachometer-alt"></i> Dashboard - {{ $type_review }}</h4>
            </div>
            <div class="col-12 col-sm-6">
                <div class="card">
                    <div class="card-body text-center">
                        <h2 class="card-title">{{ $review_states['finished']  }}</h2>
                        <h6 class="card-subtitle mb-2 text-muted text-uppercase"><i class="fa fa-check"></i> Reviews done</h6>
                        <a href="#" class="card-link">Go to finished reviews</a>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6">
                <div class="card">
                    <div class="card-body text-center">
                        <h2 class="card-title">{{ $review_states['pending'] }}</h2>
                        <h6 class="card-subtitle mb-2 text-muted text-uppercase"><i class="fa fa-hourglass-half"></i> Pending reviews</h6>
                        <a href="#" class="card-link">Go to pending reviews</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12 card my-4 py-3">
                <p class="text-uppercase text-muted"><i class="fa fa-clock mr-1"></i> Latest reviews</p>
                @if(count($reviews))
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th class="border-top-0" scope="col">#</th>
                            <th class="border-top-0" scope="col">State</th>
                            <th class="border-top-0" scope="col">Location</th>
                            <th class="border-top-0" scope="col">Reviewer</th>
                            <th class="border-top-0" scope="col">Created at</th>
                            <th class="border-top-0 text-right" scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($reviews as $review)
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td>{{ $review->state }}</td>
                            <td>/</td>
                            <td>/</td>
                            <td>{{ $review->created_at->diffForHumans() }}</td>
                            <td class="text-right">
                                <a href="{{ route('review', $review->id) }}" class="btn btn-light text-uppercase">
                                    <i class="fa fa-eye"></i> <span class="d-none d-sm-inline-block">See</span>
                                </a>

                                <a href="{{ route('delete_review', $review->id) }}"
                                   onclick="return confirm('Voulez-vous vraiment supprimer cette critique ?');"
                                   class="btn btn-danger text-uppercase">
                                    <i class="fa fa-trash"></i> <span class="d-none d-sm-inline-block">Delete</span>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                @else
                <p class="alert alert-warning text-center">
                    No review to show
                </p>
                @endif
            </div>
        </div>
    </div>
@endsection
