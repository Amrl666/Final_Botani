@extends('layouts.frontend')

@section('title', 'Eduwisata Schedule')

@section('content')
<section class="py-5">
    <div class="container">
        <h1 class="mb-5">Eduwisata Schedule</h1>
        
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Program</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Max Participants</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($eduwisatas as $eduwisata)
                        @foreach($eduwisata->schedules as $schedule)
                        <tr>
                            <td>{{ $eduwisata->name }}</td>
                            <td>{{ $schedule->date->format('F j, Y') }}</td>
                            <td>{{ $schedule->time }}</td>
                            <td>{{ $schedule->max_participants }}</td>
                            <td>
                                <a href="#" class="btn btn-sm btn-success">Register</a>
                            </td>
                        </tr>
                        @endforeach
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <div class="mt-4">
            <a href="{{ route('eduwisata') }}" class="btn btn-outline-success">Back to Eduwisata</a>
        </div>
    </div>
</section>
@endsection