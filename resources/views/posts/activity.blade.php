@extends('layouts.app')

@section('content')
<div class="boxPosts">
  @foreach ($posts as $index => $post)
    <x-post-card :post="$post" :delay="$index * 100" />
  @endforeach

<div class="mt-1">
  {{ $posts->links() }}
</div>
</div>
@endsection
