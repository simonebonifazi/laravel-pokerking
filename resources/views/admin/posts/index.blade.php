@extends('layouts.app')

@section('content')



<header class="d-flex justify-content-between align-items-center mb-4">
    <h2> I tuoi post </h2>
    <a href="{{ route('admin.posts.create') }}" class="btn btn-outline-success p-2">
        <i class="fa-solid fa-circle-plus"></i> Nuovo post
    </a>
</header>


<table class="table">
    <thead class="thead-light">
        <tr>
            <th scope="col">#</th>
            <th scope="col">Titolo</th>
            <th scope="col">Slug</th>
            <th scope="col">Categoria:</th>
            <th scope="col">Tag:</th>
            <th scope="col">Creato alle:</th>
            <th scope="col">Ultima modifica:</th>
            <th scope="col" class="text-center">Azioni ... </th>
        </tr>
    </thead>
    <tbody>
        @forelse($posts as $post)
        <tr>
            <th scope="row">{{ $post->id }}</th>
            <td>{{$post->title}}</td>
            <td>{{$post->slug}}</td>
            <td>
                @if($post->category_id)
                {{ $post->category->label }}
                @else
                Non inserita
                @endif
            </td>
            <td>

                @forelse($post->tags as $tag)
                <!-- gestire lo stile -->
                <span class="mx-1"> {{ $tag->label}} @if ($loop->last) . @else , @endif </span>
                @empty
                Nessun tag selezionato per questo post
                @endforelse
            </td>
            <td>{{$post->created_at}}</td>
            <td>{{$post->updated_at}}</td>
            <td class="d-flex align-items-center justify-content-around">
                <a href="{{ route('admin.posts.show' , $post ) }}" class="btn btn-sm btn-outline-primary p-2">
                    <i class="fa-solid fa-eye"> </i> Vedi ...
                </a>
                <a href="{{ route('admin.posts.edit', $post) }}" class="btn btn-sm btn-outline-secondary p-2">
                    <i class="fa-solid fa-file-pen"></i> Modifica
                </a>

                <form action="{{ route('admin.posts.destroy', $post->id )}}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-outline-danger">
                        <i class="fa-solid fa-trash-can"></i> Elimina!
                    </button>
                    <!-- TODO conferma utente  -->
                </form>

            </td>
        </tr>
        @empty
        <tr>
            <td colspan="6">
                <h4 class="text-center">

                    Ancora nessun post
                </h4>
            </td>
        </tr>
        @endforelse

    </tbody>
</table>
<section id="posts-by-category">
    <h1> I tuoi post ordinati per Categoria</h1>
    <div class="row">
        @foreach($categories as $category)
        <div class="col-6 mt-5">
            <p class="mb-4">
                <strong>
                    {{ $category->label }} ({{count($category->posts)}}) :
                </strong>
            </p>
            @forelse($category->posts as $post)
            <p><a href=" {{ route('admin.posts.show', $post) }} ">{{$post->slug}}</a></p>
            @empty
            Nessun post per questa Categoria
            @endforelse
        </div>
        @endforeach

    </div>

</section>

@endsection