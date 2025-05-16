@extends('layouts.frontend')

@section('title', 'Eduwisata')

@section('content')
<section class="py-5">
    <div class="container">
        <h1 class="mb-5">Eduwisata Program</h1>
        
        <div class="row">
            @foreach($eduwisatas as $eduwisata)
            <div class="col-md-6 mb-4">
                <div class="card h-100">
                    @if($eduwisata->image)
                        <img src="{{ asset('storage/' . $eduwisata->image) }}" class="card-img-top" alt="{{ $eduwisata->name }}">
                    @endif
                    <div class="card-body">
                        <h2 class="card-title">{{ $eduwisata->name }}</h2>
                        <p class="card-text"><strong>Location:</strong> {{ $eduwisata->location }}</p>
                        <p class="card-text">{{ $eduwisata->description }}</p>
                        
                        @if($eduwisata->schedules->count() > 0)
                            <h3 class="h5 mt-4">Available Schedules</h3>
                            <ul class="list-group list-group-flush mb-3">
                                @foreach($eduwisata->schedules->take(3) as $schedule)
                                <li class="list-group-item">
                                    {{ $schedule->date->format('F j, Y') }} at {{ $schedule->time }} (Max: {{ $schedule->max_participants }})
                                </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                    <div class="card-footer bg-transparent">
                        <a href="{{ route('eduwisata.schedule') }}" class="btn btn-success">View All Schedules</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endsection