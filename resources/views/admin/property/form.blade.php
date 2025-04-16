@extends('layouts.admin')

@section('title', $property->exists ? "Éditer un produit" : "Ajouter un produit")

@section('content')

    <div class="form-product-container">
        <h1 class="product-form-title">@yield('title')</h1>

        <form action="{{ route($property->exists ? 'admin.property.update' : 'admin.property.store', $property) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method($property->exists ? 'put' : 'post')

            <div class="product-form-row">
                @include('shared.input', ['class'=>'col product-form-input', 'label' => 'Nom du consommateur', 'name' => 'name', 'value' => $user->name])
            </div>

            <div class="product-form-row">
                @include('shared.input', ['class'=>'col product-form-input', 'label' => 'Nom du produit', 'name' => 'nomProduit', 'value' => $property->nomProduit])
            </div>

            <div class="product-form-row">
                <div class="product-form-half-width">
                    @include('shared.input', ['class'=>'product-form-input', 'name' => 'marque', 'value' => $property->marque])
                </div>
                <div class="product-form-half-width">
                    @include('shared.input', ['class'=>'product-form-input', 'name' => 'prix', 'label' => 'Prix', 'value' => $property->prix])
                </div>
            </div>

            <div class="product-form-group">
                <label for="image" class="product-form-label">Image du produit</label>
                <input type="file" class="product-form-input @error('image') is-invalid @enderror" id="image" name="image" onchange="previewImage(event)">

                    <div class="mt-2">
                        {{-- Si image existante, l’afficher comme preview par défaut --}}
                        <img 
                            id="image-preview" 
                            src="{{ $property->exists && $property->image ? asset('storage/'.$property->image) : '#' }}" 
                            class="product-form-image" 
                            style="{{ $property->exists && $property->image ? '' : 'display: none;' }}"
                        >
                        <p id="image-preview-text" class="text-muted mt-1">
                            {{ $property->exists && $property->image ? 'Image actuelle' : '' }}
                        </p>
                    </div>


                @error('image')
                    <div class="product-form-invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="product-form-row">
                <div class="product-form-half-width">
                    <label for="categorie" class="product-form-label">Catégorie</label>
                    <select class="product-form-select @error('categorie') is-invalid @enderror" id="categorie" name="categorie">
                        @foreach($categories as $name => $name)
                            <option value="{{ $name }}" {{ old('categorie', $property->category_name ?? '') == $name ? 'selected' : '' }}>
                                {{ $name }}
                            </option>
                        @endforeach
                    </select>

                    @error('categorie')
                        <div class="product-form-invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="product-form-half-width" id="product-newCategoryField">
                    <label for="new_categorie" class="product-form-label">Nouvelle catégorie</label>
                    <input type="text" class="product-form-input @error('new_categorie') is-invalid @enderror"
                        name="new_categorie" id="new_categorie" value="{{ old('new_categorie') }}">
                    @error('new_categorie')
                        <div class="product-form-invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            @include('shared.input',['type' => 'textarea', 'class' => 'col product-form-input', 'name' => 'description', 'value' => $property->description])

            <div>
                <button class="product-form-button product-form-button-primary">
                    @if($property->exists)
                        Modifier
                    @else
                        Ajouter
                    @endif
                </button>
            </div>
        </form>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function () {
    const select = document.getElementById('categorie');
    const newCatField = document.getElementById('product-newCategoryField');

    function toggleNewCategory() {
        if (select.value === 'Autre') {
            newCatField.classList.add('show');
        } else {
            newCatField.classList.remove('show');
        }
    }

    // Initial check
    toggleNewCategory();

    // On change
    select.addEventListener('change', toggleNewCategory);
});



function previewImage(event) {
        const output = document.getElementById('image-preview');
        const previewText = document.getElementById('image-preview-text');

        const file = event.target.files[0];
        if (file) {
            output.src = URL.createObjectURL(file);
            output.style.display = 'block';
            previewText.innerText = "Aperçu de la nouvelle image";
        } else {
            output.style.display = 'none';
            previewText.innerText = "";
        }
    }
    </script>

@endsection
