@extends('layouts.admin')

@section('title', 'Modifier une catégorie')

@section('content')
<div class="category-edit-container">
    <div class="category-header">
        <div class="category-title">
            <h1>Modifier la catégorie</h1>
            <p class="category-name">{{ $category->name }}</p>
        </div>
        <a href="{{ route('admin.categories.index') }}" class="btn-back">
            <i class="fas fa-arrow-left"></i> Retour aux catégories
        </a>
    </div>

    @if ($errors->any())
        <div class="alert-error">
            <div class="alert-icon">
                <i class="fas fa-exclamation-circle"></i>
            </div>
            <div class="alert-content">
                <h4>Veuillez corriger les erreurs suivantes :</h4>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <div class="form-card">
        <form action="{{ route('admin.categories.update', $category) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="form-sections">
                <!-- Section des informations de base -->
                <div class="form-section">
                    <h3 class="section-title">Informations de base</h3>
                    
                    <div class="form-group">
                        <label for="name">Nom de la catégorie <span class="required">*</span></label>
                        <input type="text" id="name" name="name" value="{{ old('name', $category->name) }}" required>
                    </div>
                </div>

                <!-- Section de l'apparence -->
                <div class="form-section">
                    <h3 class="section-title">Apparence</h3>
                    
                    <div class="form-row">
                        <div class="form-group form-group-half">
                            <label for="color">Couleur</label>
                            <div class="color-input-group">
                                <input type="color" id="color" name="color" value="{{ old('color', $category->color ?? '#3498db') }}">
                                <input type="text" id="color-hex" value="{{ old('color', $category->color ?? '#3498db') }}" readonly>
                            </div>
                            <small class="form-hint">Cette couleur sera utilisée pour identifier votre catégorie</small>
                        </div>

                        <div class="form-group form-group-half">
                            <label for="icon">Icône</label>
                            <div class="icon-input-group">
                                <span class="icon-preview" id="icon-preview">
                                    @if($category->icon)
                                        <i class="fas {{ $category->icon }}"></i>
                                    @else
                                        <i class="fas fa-question"></i>
                                    @endif
                                </span>
                                <input type="text" id="icon" name="icon" value="{{ old('icon', $category->icon) }}" placeholder="ex: fa-shopping-bag">
                            </div>
                            <small class="form-hint">Consultez <a href="https://fontawesome.com/icons" target="_blank">FontAwesome</a> pour les icônes disponibles</small>
                        </div>
                    </div>
                </div>

                <!-- Section de l'image -->
                <div class="form-section">
                    <h3 class="section-title">Image de la catégorie</h3>
                    
                    <div class="image-upload-container">
                        <div class="current-image-container">
                            @if($category->image)
                                <div class="current-image">
                                    <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}">
                                </div>
                                <p class="current-image-label">Image actuelle</p>
                            @else
                                <div class="no-image">
                                    <i class="fas fa-image"></i>
                                    <p>Aucune image</p>
                                </div>
                            @endif
                        </div>
                        
                        <div class="image-upload-controls">
                            <label for="image" class="main-label">Nouvelle image (optionnelle)</label>
                            <div class="file-input-wrapper">
                                <input type="file" id="image" name="image" accept="image/*">
                                <label for="image" class="custom-file-upload">
                                    <i class="fas fa-cloud-upload-alt"></i>
                                    <span>Choisir un fichier</span>
                                </label>
                                <span id="file-selected">Aucun fichier sélectionné</span>
                            </div>
                            <div id="image-preview" class="new-image-preview"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-save">
                    <i class="fas fa-save"></i> Enregistrer les modifications
                </button>
            </div>
        </form>
    </div>
</div>

<style>
:root {
    --primary-color: #4361ee;
    --primary-light: #ebefff;
    --secondary-color: #3a0ca3;
    --accent-color: #7209b7;
    --success-color: #2ecc71;
    --danger-color: #e74c3c;
    --warning-color: #f39c12;
    --info-color: #3498db;
    --dark-color: #2d3748;
    --text-color: #333;
    --text-muted: #6c757d;
    --light-gray: #f8f9fa;
    --border-color: #e2e8f0;
    --shadow-sm: 0 1px 3px rgba(0,0,0,0.1);
    --shadow-md: 0 4px 6px rgba(0,0,0,0.1);
    --shadow-lg: 0 10px 15px rgba(0,0,0,0.1);
    --radius-sm: 4px;
    --radius-md: 8px;
    --radius-lg: 12px;
    --transition: all 0.3s ease;
}

.category-edit-container {
    max-width: 850px;
    margin: 2rem auto;
    padding: 0 1.5rem;
}

.category-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2rem;
}

.category-title h1 {
    font-size: 1.75rem;
    color: var(--dark-color);
    margin: 0;
    font-weight: 600;
}

.category-name {
    color: var(--primary-color);
    font-size: 1.25rem;
    margin: 0.5rem 0 0;
    font-weight: 500;
}

.btn-back {
    display: inline-flex;
    align-items: center;
    padding: 0.625rem 1.25rem;
    background-color: var(--light-gray);
    color: var(--dark-color);
    border: 1px solid var(--border-color);
    border-radius: var(--radius-md);
    text-decoration: none;
    font-weight: 500;
    transition: var(--transition);
    box-shadow: var(--shadow-sm);
}

.btn-back:hover {
    background-color: var(--border-color);
    color: var(--dark-color);
    text-decoration: none;
    box-shadow: var(--shadow-md);
}

.btn-back i {
    margin-right: 0.5rem;
    font-size: 0.875rem;
}

.alert-error {
    display: flex;
    background-color: #fdf2f2;
    border-left: 4px solid var(--danger-color);
    color: #982929;
    padding: 1rem;
    border-radius: var(--radius-md);
    margin-bottom: 2rem;
    box-shadow: var(--shadow-sm);
}

.alert-icon {
    display: flex;
    align-items: center;
    font-size: 1.5rem;
    padding-right: 1rem;
    color: var(--danger-color);
}

.alert-content h4 {
    margin: 0 0 0.5rem 0;
    font-size: 1rem;
    font-weight: 600;
}

.alert-content ul {
    margin: 0;
    padding-left: 1.25rem;
    font-size: 0.9rem;
}

.form-card {
    background-color: white;
    border-radius: var(--radius-lg);
    box-shadow: var(--shadow-lg);
    overflow: hidden;
}

.form-sections {
    padding: 0;
}

.form-section {
    padding: 1.75rem 2rem;
    border-bottom: 1px solid var(--border-color);
}

.form-section:last-child {
    border-bottom: none;
}

.section-title {
    color: var(--dark-color);
    font-size: 1.125rem;
    margin: 0 0 1.25rem 0;
    font-weight: 600;
    display: flex;
    align-items: center;
}

.section-title::after {
    content: '';
    flex: 1;
    height: 1px;
    background-color: var(--border-color);
    margin-left: 1rem;
}

.form-group {
    margin-bottom: 1.5rem;
}

.form-group:last-child {
    margin-bottom: 0;
}

.form-row {
    display: flex;
    margin: 0 -1rem;
    flex-wrap: wrap;
}

.form-group-half {
    flex: 0 0 50%;
    padding: 0 1rem;
}

@media (max-width: 768px) {
    .form-group-half {
        flex: 0 0 100%;
    }
    
    .form-row {
        margin: 0;
    }
    
    .form-group-half {
        padding: 0;
    }
}

label, .main-label {
    display: block;
    font-weight: 500;
    margin-bottom: 0.5rem;
    color: var(--dark-color);
}

.required {
    color: var(--danger-color);
    margin-left: 0.25rem;
}

input[type="text"],
textarea {
    width: 100%;
    padding: 0.75rem;
    border: 1px solid var(--border-color);
    border-radius: var(--radius-md);
    font-size: 0.95rem;
    transition: var(--transition);
    color: var(--text-color);
}

input[type="text"]:focus,
textarea:focus {
    border-color: var(--primary-color);
    box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.15);
    outline: none;
}

.form-hint {
    display: block;
    margin-top: 0.5rem;
    font-size: 0.8rem;
    color: var(--text-muted);
}

.form-hint a {
    color: var(--primary-color);
    text-decoration: none;
}

.form-hint a:hover {
    text-decoration: underline;
}

.color-input-group {
    display: flex;
    align-items: center;
}

input[type="color"] {
    height: 38px;
    width: 60px;
    padding: 0;
    border: 1px solid var(--border-color);
    border-radius: var(--radius-md) 0 0 var(--radius-md);
    cursor: pointer;
}

#color-hex {
    flex: 1;
    border-radius: 0 var(--radius-md) var(--radius-md) 0;
    border-left: none;
    font-family: monospace;
    background-color: var(--light-gray);
}

.icon-input-group {
    display: flex;
    align-items: center;
}

.icon-preview {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 38px;
    height: 38px;
    background-color: var(--light-gray);
    border: 1px solid var(--border-color);
    border-radius: var(--radius-md) 0 0 var(--radius-md);
    margin-right: -1px;
    font-size: 1.2rem;
    color: var(--text-color);
}

.icon-input-group input[type="text"] {
    flex: 1;
    border-radius: 0 var(--radius-md) var(--radius-md) 0;
}

.image-upload-container {
    display: flex;
    gap: 2rem;
    align-items: flex-start;
}

@media (max-width: 768px) {
    .image-upload-container {
        flex-direction: column;
    }
}

.current-image-container {
    flex: 0 0 200px;
    text-align: center;
}

.current-image {
    width: 100%;
    aspect-ratio: 1;
    border-radius: var(--radius-md);
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: center;
    background-color: var(--light-gray);
    border: 1px solid var(--border-color);
}

.current-image img {
    max-width: 100%;
    max-height: 100%;
    object-fit: cover;
}

.current-image-label {
    margin-top: 0.75rem;
    font-size: 0.875rem;
    color: var(--text-muted);
}

.no-image {
    width: 100%;
    aspect-ratio: 1;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    background-color: var(--light-gray);
    border: 1px solid var(--border-color);
    border-radius: var(--radius-md);
    color: var(--text-muted);
}

.no-image i {
    font-size: 3rem;
    margin-bottom: 0.75rem;
    opacity: 0.5;
}

.no-image p {
    margin: 0;
    font-size: 0.875rem;
}

.image-upload-controls {
    flex: 1;
}

.file-input-wrapper {
    position: relative;
    margin-bottom: 1rem;
}

input[type="file"] {
    position: absolute;
    left: -9999px;
}

.custom-file-upload {
    display: inline-flex;
    align-items: center;
    padding: 0.75rem 1.25rem;
    background-color: var(--primary-light);
    color: var(--primary-color);
    border: 1px dashed var(--primary-color);
    border-radius: var(--radius-md);
    cursor: pointer;
    font-weight: 500;
    transition: var(--transition);
}

.custom-file-upload:hover {
    background-color: rgba(67, 97, 238, 0.15);
}

.custom-file-upload i {
    margin-right: 0.625rem;
    font-size: 1.25rem;
}

#file-selected {
    display: block;
    margin: 0.75rem 0;
    font-size: 0.875rem;
    color: var(--text-muted);
}

.new-image-preview {
    margin-top: 1rem;
    max-width: 300px;
    border-radius: var(--radius-md);
    overflow: hidden;
}

.new-image-preview img {
    max-width: 100%;
    border-radius: var(--radius-md);
    box-shadow: var(--shadow-sm);
}

.form-actions {
    padding: 1.5rem 2rem;
    background-color: var(--light-gray);
    border-top: 1px solid var(--border-color);
    text-align: right;
}

.btn-save {
    display: inline-flex;
    align-items: center;
    padding: 0.75rem 1.5rem;
    background-color: var(--success-color);
    color: white;
    border: none;
    border-radius: var(--radius-md);
    font-size: 1rem;
    font-weight: 500;
    cursor: pointer;
    transition: var(--transition);
    box-shadow: var(--shadow-sm);
}

.btn-save:hover {
    background-color: #27ae60;
    box-shadow: var(--shadow-md);
}

.btn-save i {
    margin-right: 0.625rem;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Mise à jour de la valeur hexadécimale lorsque la couleur change
    const colorInput = document.getElementById('color');
    const colorHex = document.getElementById('color-hex');
    
    colorInput.addEventListener('input', function() {
        colorHex.value = this.value;
    });
    
    // Affichage du nom du fichier sélectionné
    const fileInput = document.getElementById('image');
    const fileSelected = document.getElementById('file-selected');
    const imagePreview = document.getElementById('image-preview');
    
    fileInput.addEventListener('change', function() {
        if (this.files && this.files[0]) {
            fileSelected.textContent = this.files[0].name;
            
            // Prévisualisation de l'image
            const reader = new FileReader();
            reader.onload = function(e) {
                imagePreview.innerHTML = `<img src="${e.target.result}" alt="Prévisualisation">`;
            }
            reader.readAsDataURL(this.files[0]);
        } else {
            fileSelected.textContent = 'Aucun fichier sélectionné';
            imagePreview.innerHTML = '';
        }
    });
    
    // Mise à jour de l'aperçu de l'icône
    const iconInput = document.getElementById('icon');
    const iconPreview = document.getElementById('icon-preview');
    
    iconInput.addEventListener('input', function() {
        if (this.value) {
            iconPreview.innerHTML = `<i class="fas ${this.value}"></i>`;
        } else {
            iconPreview.innerHTML = `<i class="fas fa-question"></i>`;
        }
    });
});
</script>
@endsection