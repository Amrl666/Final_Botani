@extends('layouts.app')
@section('content')
<style>
  .cardContainer {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 20px;
    padding: 20px 0;
  }

  .card {
    background: white;
    border-radius: 1rem;
    box-shadow: 0 4px 8px rgb(0 0 0 / 0.1);
    overflow: hidden;
    display: flex;
    flex-direction: column;
    transition: transform 0.2s ease;
  }

  .card:hover {
    transform: scale(1.03);
  }

  .cardImage {
    width: 100%;
    height: 160px;
    object-fit: cover;
  }

  .cardContent {
    padding: 15px 20px;
    flex-grow: 1;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
  }

  .cardTitle {
    font-size: 1.25rem;
    font-weight: 700;
    color: #2d3748; /* gray-800 */
    margin-bottom: 8px;
  }

  .cardDate {
    font-size: 0.9rem;
    color: #718096; /* gray-500 */
    margin-bottom: 15px;
  }

  .cardActions {
    display: flex;
    gap: 10px;
  }

  .btn-edit {
    background-color: #f6ad55; /* orange-400 */
    color: white;
    padding: 6px 12px;
    border-radius: 0.375rem;
    border: none;
    cursor: pointer;
    font-weight: 600;
    flex: 1;
    text-align: center;
    text-decoration: none;
  }

  .btn-edit:hover {
    background-color: #dd6b20; /* orange-600 */
  }

  .btn-delete {
    background-color: #fc8181; /* red-400 */
    color: white;
    padding: 6px 12px;
    border-radius: 0.375rem;
    border: none;
    cursor: pointer;
    font-weight: 600;
    flex: 1;
  }

  .btn-delete:hover {
    background-color: #c53030; /* red-700 */
  }
</style>

<div class="container">
  <div class="d-flex justify-content-between align-items-center mb-4 px-4">
    <h1>Prestasi</h1>
    <a href="{{ route('dashboard.prestasi.create') }}" class="btn btn-primary">Create New</a>
  </div>

  @if($prestasis->count() == 0)
    <p class="text-center text-gray-600">Belum ada prestasi yang dibuat.</p>
  @else
    <div class="cardContainer">
      @foreach($prestasis as $prestasi)
        <div class="card">
          @if($prestasi->image)
            <img src="{{ asset('storage/' . $prestasi->image) }}" alt="{{ $prestasi->title }}" class="cardImage" />
          @else
            <div class="cardImage" style="background: #e2e8f0; display: flex; align-items: center; justify-content: center; color: #718096;">
              No Image
            </div>
          @endif
          <div class="cardContent">
            <div>
              <h2 class="cardTitle">{{ $prestasi->title }}</h2>
              <p class="cardDate">{{ $prestasi->created_at->format('d M Y') }}</p>
            </div>
            <div class="cardActions">
              <a href="{{ route('dashboard.prestasi.edit', $prestasi) }}" class="btn-edit">Edit</a>
              <form action="{{ route('dashboard.prestasi.destroy', $prestasi) }}" method="POST" 
                    onsubmit="return confirm('Are you sure you want to delete this prestasi?');" style="flex:1;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-delete">Delete</button>
              </form>
            </div>
          </div>
        </div>
      @endforeach
    </div>

    <div class="mt-8 px-4">
      {{ $prestasis->links() }}
    </div>
  @endif
</div>
@endsection
