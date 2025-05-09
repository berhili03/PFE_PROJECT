@extends('layouts.admin')

@section('title', 'Ajouter une catégorie')

@section('content')
<div class="category-form-container">
    <div class="category-form-header">
        <h1>Ajouter une nouvelle catégorie</h1>
        <a href="{{ route('admin.categories.index') }}" class="btn-back">
            <i class="fas fa-arrow-left"></i> Retour aux catégories
        </a>
    </div>

    @if ($errors->any())
        <div class="alert-error">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="category-form-card">
        <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="form-group">
                <label for="name">Nom de la catégorie <span class="required">*</span></label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" required>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="color">Couleur du cercle</label>
                    <div class="color-input-group">
                        <input type="color" id="color" name="color" value="{{ old('color', '#3498db') }}">
                        <input type="text" id="color-hex" value="#3498db" readonly>
                    </div>
                </div>

                <div class="form-group col-md-6">
                    <label for="icon">Icône (classe Font Awesome)</label>
                    <input type="text" id="icon" name="icon" value="{{ old('icon') }}" placeholder="ex: fa-shopping-bag">
                    <small class="form-text">Consultez <a href="https://fontawesome.com/icons" target="_blank">FontAwesome</a> pour les icônes disponibles</small>
                </div>
            </div>

            <div class="form-group">
                <label for="image">Image (optionnelle)</label>
                <div class="file-input-container">
                    <input type="file" id="image" name="image" accept="image/*">
                    <label for="image" class="file-input-label">
                        <i class="fas fa-upload"></i> Choisir une image
                    </label>
                    <span id="file-name">Aucun fichier sélectionné</span>
                </div>
                <div id="image-preview" class="image-preview"></div>
            </div>

            <div class="category-preview-section">
                <h3>Prévisualisation</h3>
                <div class="category-preview-container">
                    <div id="category-preview-circle" class="category-circle" style="background-color: #3498db;">
                        <span id="category-preview-initial">C</span>
                        <i id="category-preview-icon" class="fas" style="display: none;"></i>
                    </div>
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-submit">
                    <i class="fas fa-save"></i> Enregistrer
                </button>
            </div>
        </form>
    </div>
</div>

<style>
    .category-form-container {
        max-width: 800px;
        margin: 0 auto;
        padding: 25px 15px;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    /* Header Styles */
    .category-form-header {
        margin-bottom: 25px;
    }

    .category-form-header h1 {
        color: #2c3e50;
        font-size: 28px;
        font-weight: 600;
        margin: 0 0 15px 0;
    }

    .btn-back {
        display: inline-flex;
        align-items: center;
        color: #566573;
        font-size: 14px;
        text-decoration: none;
        transition: color 0.2s;
    }

    .btn-back:hover {
        color: #2c3e50;
    }

    .btn-back i {
        margin-right: 8px;
    }

    /* Alert Styles */
    .alert-error {
        background-color: #fdecea;
        border-left: 4px solid #e74c3c;
        padding: 15px 20px;
        margin-bottom: 20px;
        border-radius: 4px;
    }

    .alert-error ul {
        margin: 0;
        padding-left: 20px;
    }

    .alert-error li {
        color: #934741;
        margin-bottom: 5px;
    }

    /* Card Styles */
    .category-form-card {
        background-color: white;
        border-radius: 12px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
        padding: 30px;
    }

    /* Form Styles */
    .form-row {
        display: flex;
        margin-left: -15px;
        margin-right: -15px;
        flex-wrap: wrap;
    }

    .form-group {
        margin-bottom: 20px;
        padding: 0 15px;
        width: 100%;
    }

    .col-md-6 {
        flex: 0 0 50%;
        max-width: 50%;
    }

    label {
        display: block;
        margin-bottom: 8px;
        font-weight: 500;
        color: #2c3e50;
    }

    .required {
        color: #e74c3c;
    }

    input[type="text"] {
        width: 100%;
        padding: 10px 15px;
        border: 1px solid #dcdfe6;
        border-radius: 4px;
        font-size: 15px;
        color: #2c3e50;
    }

    input[type="text"]:focus {
        border-color: #3498db;
        outline: none;
    }

    .color-input-group {
        display: flex;
        align-items: center;
    }

    input[type="color"] {
        width: 50px;
        height: 40px;
        border: none;
        border-radius: 4px 0 0 4px;
        padding: 0;
        cursor: pointer;
    }

    #color-hex {
        flex: 1;
        border-radius: 0 4px 4px 0;
        border-left: none;
        text-align: center;
        font-family: monospace;
    }

    .form-text {
        font-size: 12px;
        color: #7f8c8d;
        margin-top: 5px;
        display: block;
    }

    .form-text a {
        color: #3498db;
        text-decoration: none;
    }

    /* File Input Styles */
    .file-input-container {
        position: relative;
        display: flex;
        align-items: center;
    }

    input[type="file"] {
        position: absolute;
        left: -9999px;
    }

    .file-input-label {
        display: inline-flex;
        align-items: center;
        padding: 8px 15px;
        background-color: #3498db;
        color: white;
        border-radius: 4px;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    .file-input-label:hover {
        background-color: #2980b9;
    }

    .file-input-label i {
        margin-right: 8px;
    }

    #file-name {
        margin-left: 15px;
        color: #7f8c8d;
        font-size: 14px;
    }

    .image-preview {
        margin-top: 15px;
        max-width: 100%;
    }

    /* Category Preview Styles */
    .category-preview-section {
        border-top: 1px solid #eaeaea;
        padding-top: 20px;
        margin-top: 10px;
        margin-bottom: 20px;
    }

    .category-preview-section h3 {
        font-size: 18px;
        color: #2c3e50;
        margin-bottom: 15px;
    }

    .category-preview-container {
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 20px 0;
    }

    .category-circle {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 48px;
        overflow: hidden;
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
    }

    /* Form Actions */
    .form-actions {
        border-top: 1px solid #eaeaea;
        padding-top: 20px;
        text-align: right;
    }

    .btn-submit {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 10px 20px;
        border-radius: 6px;
        font-size: 15px;
        font-weight: 500;
        background-color: #2ecc71;
        color: white;
        border: none;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    .btn-submit:hover {
        background-color: #27ae60;
    }

    .btn-submit i {
        margin-right: 8px;
    }

    /* Responsive styles */
    @media (max-width: 768px) {
        .form-row {
            flex-direction: column;
        }

        .col-md-6 {
            max-width: 100%;
            flex: 0 0 100%;
        }

        .file-input-container {
            flex-direction: column;
            align-items: flex-start;
        }

        #file-name {
            margin-left: 0;
            margin-top: 10px;
        }
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Prévisualisation du cercle de catégorie
    const nameInput = document.getElementById('name');
    const colorInput = document.getElementById('color');
    const colorHex = document.getElementById('color-hex');
    const iconInput = document.getElementById('icon');
    const imageInput = document.getElementById('image');
    const fileNameSpan = document.getElementById('file-name');
    const imagePreview = document.getElementById('image-preview');
    
    const categoryPreviewCircle = document.getElementById('category-preview-circle');
    const categoryPreviewInitial = document.getElementById('category-preview-initial');
    const categoryPreviewIcon = document.getElementById('category-preview-icon');
    
    // Mise à jour de la prévisualisation du cercle
    function updateCategoryPreview() {
        // Mise à jour de la couleur
        const color = colorInput.value;
        categoryPreviewCircle.style.backgroundColor = color;
        colorHex.value = color;
        
        // Mise à jour de l'initiale ou de l'icône
        const name = nameInput.value.trim();
        const initialLetter = name ? name.charAt(0).toUpperCase() : 'C';
        categoryPreviewInitial.textContent = initialLetter;
        
        // Affichage de l'icône si spécifiée
        const icon = iconInput.value.trim();
        if (icon) {
            categoryPreviewIcon.className = 'fas ' + (icon.startsWith('fa-') ? icon : 'fa-' + icon);
            categoryPreviewIcon.style.display = 'block';
            categoryPreviewInitial.style.display = 'none';
        } else {
            categoryPreviewIcon.style.display = 'none';
            categoryPreviewInitial.style.display = 'block';
        }
    }
    
    // Événements pour mettre à jour la prévisualisation
    nameInput.addEventListener('input', updateCategoryPreview);
    colorInput.addEventListener('input', updateCategoryPreview);
    iconInput.addEventListener('input', updateCategoryPreview);
    
    // Gestion de l'upload d'image
    imageInput.addEventListener('change', function(e) {
        if (this.files && this.files[0]) {
            const file = this.files[0];
            fileNameSpan.textContent = file.name;
            
            const reader = new FileReader();
            reader.onload = function(event) {
                // Prévisualisation de l'image
                imagePreview.innerHTML = `<img src="${event.target.result}" alt="Prévisualisation" style="max-width: 100%; max-height: 150px; border-radius: 8px;">`;
                
                // Mise à jour de la prévisualisation du cercle avec l'image
                categoryPreviewCircle.style.backgroundImage = `url(${event.target.result})`;
                categoryPreviewCircle.style.backgroundSize = 'cover';
                categoryPreviewCircle.style.backgroundPosition = 'center';
                categoryPreviewInitial.style.display = 'none';
                categoryPreviewIcon.style.display = 'none';
            };
            reader.readAsDataURL(file);
        }
    });
    
    // Initialisation de la prévisualisation
    updateCategoryPreview();
});
</script>
@endsection