@extends('layouts.app')
@section('content')
<style>
  .blogContainer {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 20px;
    padding: 20px 0;
  }

  .blogCard {
    background: white;
    border-radius: 1rem;
    box-shadow: 0 4px 8px rgb(0 0 0 / 0.1);
    overflow: hidden;
    display: flex;
    flex-direction: column;
    transition: transform 0.2s ease;
  }

  .blogCard:hover {
    transform: scale(1.03);
  }

  .blogImage {
    width: 100%;
    height: 160px;
    object-fit: cover;
  }

  .blogContent {
    padding: 15px 20px;
    flex-grow: 1;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
  }

  .blogTitle {
    font-size: 1.25rem;
    font-weight: 700;
    color: #2d3748; /* gray-800 */
    margin-bottom: 8px;
  }

  .blogDate {
    font-size: 0.9rem;
    color: #718096; /* gray-500 */
    margin-bottom: 15px;
  }

  .blogActions {
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
    <h1>Blog Posts</h1>
    <a href="{{ route('dashboard.blog.create') }}" class="btn btn-primary">Create New Post</a>
  </div>

  @if($blogs->count() == 0)
    <p class="text-center text-gray-600">Belum ada postingan blog.</p>
  @else
    <div class="blogContainer">
      @foreach($blogs as $blog)
        <div class="blogCard">
          @if($blog->image)
            <img src="{{ asset('storage/' . $blog->image) }}" alt="{{ $blog->title }}" class="blogImage" />
          @else
            <div class="blogImage" style="background: #e2e8f0; display: flex; align-items: center; justify-content: center; color: #718096;">
              No Image
            </div>
          @endif
          <div class="blogContent">
            <div>
              <h2 class="blogTitle">{{ $blog->title }}</h2>
              <p class="blogDate">{{ $blog->created_at->format('d M Y') }}</p>
            </div>
            <div class="blogActions">
              <a href="{{ route('dashboard.blog.edit', $blog) }}" class="btn-edit">Edit</a>
              <form action="{{ route('dashboard.blog.destroy', $blog) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this post?');" style="flex:1;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-delete">Delete</button>
              </form>
            </div>s
          </div>
        </div>
      @endforeach
    </div>

    <div class="mt-8 px-4">
      {{ $blogs->links() }}
    </div>
  @endif
</div>
@endsection
