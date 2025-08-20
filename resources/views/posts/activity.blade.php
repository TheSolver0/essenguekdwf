@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto py-10 space-y-10 px-4">
  @foreach ($posts as $index => $post)
    <x-post-card :post="$post" :delay="$index * 100" />
  @endforeach
</div>
@endsection
