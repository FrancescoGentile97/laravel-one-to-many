@extends('layouts.app')

@section('content')
<div class="container my-5">
    <div class="text-center pt-2 mt-4">
        <h1 class="text-dark"> To Modify Project #{{ $project->id }}</h1>
    </div>
    {{-- Validazione Dati --}}
    @if($errors->any())
    <div>
        <div class="alert alert-danger">I i dati inseriti non sono validi:
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
    @endif
    <div>
        <form action="{{ route('projects.update', $project->id ) }}" method="POST" class="p-5" enctype="multipart/form-data">
            @csrf
            @method('put')

            <label class="form-label">Title: </label>
            <input type="text" name="name" class="form-control mb-4 @error('name') is-invalid @enderror"
            value="{{ $errors->has('name') ? '' : $project->name }}">
            @error('name')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror

            <label class="form-label">Type: </label>
            <select name="type_id" class="form-select mb-4">
                @foreach ($types as $type)
                <option value="{{ $type->id }}">{{ $type->name }}</option>
                @endforeach
            </select>

            <label class="form-label">Description: </label>
            <textarea type="text" name="description" class="form-control mb-4 @error('description') is-invalid @enderror" rows="3">{{ $errors->has('description') ? '' : $project->description }}</textarea>
            @error('description')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror

            <label class="form-label">Image: </label>
            <input type="file" name="cover_img" class="form-control mb-4 @error('cover_img') is-invalid @enderror">
            @error('cover_img')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror

            <label class="form-label">GitHub: </label>
            <input type="text" name="github_link" class="form-control mb-4 @error('github_link') is-invalid @enderror"
            value="{{ $errors->has('github_link') ? '' : $project->github_link }}">
            @error('github_link')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror

            <div class="mt-4">
                <button type="submit" class="btn btn-primary me-3">Modifica</button>
            </div>
        </form>
        <div class="text-center">
            <a href="{{ route("dashboard") }}"><button class="btn btn-secondary">Back to Home</button></a>
        </div>
    </div>
</div>
@endsection