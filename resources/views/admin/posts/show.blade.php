@extends('layouts.app')

@section('content')

<header>
    <h1>{{ $post->title }}</h1>
</header>
<div class="clearfix">
    @if($post->image)
    <figure class="float-left mr-3">
        <img src=" {{ $post->image }}" alt="{{ $post->slug }}">
    </figure>
    @endif
    <p class="mb-5"> {{ $post->content }} </p>
    <div class="my3">
        <strong> Categoria: </strong>
        @if($post->category_id)
        {{ $post->category->label }}
        @else
        Non inserita
        @endif

    </div>
    <div class="my-3">
        <strong> Tag: </strong>
        @forelse($post->tags as $tag)
        <!-- gestire lo stile -->
        <span class="mx-2"> {{ $tag->label}} @if ($loop->last) . @else , @endif </span>
        @empty
        Nessun tag selezionato per questo post
        @endforelse
    </div>
    <div class="my-3">
        <strong> Creato il: </strong> <time> {{ $post->created_at }}</time>
    </div>
    <div class="my-3">
        <strong> Ultima modifica: </strong> <time> {{ $post->updated_at }}</time>
    </div>
</div>
<footer class="d-flex align-items-center justify-content-between mt-5">

    <a href="{{ route('admin.posts.index') }}" class="btn btn-outline-primary">
        <i class="fa-solid fa-circle-left"> </i> Indietro ...
    </a>
    <div class="d-flex">
        <a href="{{ route('admin.posts.edit', $post) }}" class="btn btn-sm btn-outline-secondary p-2">
            <i class="fa-solid fa-file-pen"></i> Modifica
        </a>
        <form action="{{ route('admin.posts.destroy', $post->id )}}" method="POST" class="mx-2">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-outline-danger">
                <i class="fa-solid fa-trash-can"></i> Elimina!
            </button>
        </form>
    </div>
</footer>


@endsection