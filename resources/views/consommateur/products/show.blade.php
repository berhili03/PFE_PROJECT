@extends('layouts.consommateur')

@section('content')
<div class="container py-5">
    <div class="product-detail-container">
        <!-- Section principale du produit -->
        <div class="product-main">
            <!-- Image du produit -->
            <div class="product-image-section">
                @if($produit->image)
                    <div class="product-image-container">
                        <img src="{{ asset('storage/' . $produit->image) }}" class="product-image" alt="{{ $produit->nomProduit }}">
                    </div>
                @else
                    <div class="product-image-placeholder">
                        <i class="fas fa-image"></i>
                        <p>Aucune image disponible</p>
                    </div>
                @endif

                <!-- Bouton J'adore -->
                <div class="product-like-section" data-product-id="{{ $produit->id }}">
                    @if($estAime)
                        <form action="{{ route('produits.unlike', $produit->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="like-button btn-unlike" data-liked="true">
                                <span class="heart-icon heart-filled"></span>
                                @if($produit->aimes_count > 0)
                                    <span class="like-count">{{ $produit->aimes_count }}</span>
                                @endif
                            </button>
                        </form>
                    @else
                        <form action="{{ route('produits.like', $produit->id) }}" method="POST">
                            @csrf
                            <button type="button" class="like-button btn-like" data-liked="false">
                                <span class="heart-icon heart-outline"></span>
                                @if($produit->aimes_count > 0)
                                    <span class="like-count">{{ $produit->aimes_count }}</span>
                                @endif
                            </button>
                        </form>
                    @endif
                </div>
            </div>

            <!-- Informations produit -->
            <div class="product-info-section">
                <nav aria-label="breadcrumb" class="product-breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('consommateur.dashboard') }}">Accueil</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $produit->nomProduit }}</li>
                    </ol>
                </nav>

                <h1 class="product-title">{{ $produit->nomProduit }}</h1>
                <p class="product-brand">{{ $produit->marque }}</p>

                <div class="product-price-container">
                    <span class="product-price">{{ number_format($produit->prix, 2) }} €</span>
                    @if($produit->ancien_prix)
                        <span class="product-old-price">{{ number_format($produit->ancien_prix, 2) }} €</span>
                    @endif
                </div>


                @if($produit->description)
                    <div class="product-description">
                        <h4 class="section-subheading">Description</h4>
                        <p>{{ $produit->description }}</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Section Commentaires -->
        <div class="product-comments-section">
            <h3 class="section-heading">Commentaires <span class="comments-count">{{ $commentaires->count() }}</span></h3>

            <div class="comment-form-container">
                <form action="{{ route('produits.comment', $produit->id) }}" method="POST" class="comment-form">
                    @csrf
                    <div class="form-group">
                        <textarea name="contenu" id="new-comment" class="form-control comment-textarea" rows="3" placeholder="Ajouter un commentaire..." required></textarea>
                    </div>
                    <div class="form-group text-right">
                        <button type="submit" class="btn-comment">Publier</button>
                    </div>
                </form>
            </div>

            <div class="comments-container">
                @forelse($commentaires as $commentaire)
                    <div class="comment-item" id="comment-{{ $commentaire->id }}">
                        <div class="comment-avatar">
                            <i class="fas fa-user-circle"></i>
                        </div>
                        <div class="comment-content">
                            <div class="comment-header">
                                <h5 class="comment-author">{{ $commentaire->user->name }}</h5>
                                <span class="comment-date">{{ $commentaire->created_at->diffForHumans() }}</span>
                            </div>
                            
                            <!-- Contenu du commentaire (visible / éditable) -->
                            <div class="comment-display-area">
                                <p class="comment-text">{{ $commentaire->contenu }}</p>
                                
                                <!-- Options de modification/suppression (uniquement pour l'auteur) -->
                                @if(auth()->check() && auth()->id() == $commentaire->user_id)
                                    <div class="comment-actions">
                                        <button class="btn-edit" data-comment-id="{{ $commentaire->id }}">
                                            <i class="fas fa-edit"></i> Modifier
                                        </button>
                                        <form action="{{ route('commentaires.destroy', $commentaire->id) }}" method="POST" class="d-inline delete-comment-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-delete">
                                                <i class="fas fa-trash"></i> Supprimer
                                            </button>
                                        </form>
                                    </div>
                                @endif
                            </div>
                            
                            <!-- Zone d'édition (cachée par défaut) -->
                            @if(auth()->check() && auth()->id() == $commentaire->user_id)
                                <div class="comment-edit-area" style="display: none;">
                                    <form action="{{ route('commentaires.update', $commentaire->id) }}" method="POST" class="edit-comment-form">
                                        @csrf
                                        @method('PUT')
                                        <textarea name="contenu" class="form-control comment-textarea edit-textarea" rows="3" required>{{ $commentaire->contenu }}</textarea>
                                        <div class="edit-actions">
                                            <button type="button" class="btn-cancel">Annuler</button>
                                            <button type="submit" class="btn-save">Enregistrer</button>
                                        </div>
                                    </form>
                                </div>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="empty-comments">
                        <i class="far fa-comment-dots"></i>
                        <p>Aucun commentaire pour l'instant. Soyez le premier à donner votre avis sur ce produit !</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<!-- Script pour la fonctionnalité "J'aime" -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Sélectionner la section des likes
    const likeSection = document.querySelector('.product-like-section');
    if (!likeSection) return;
    
    const productId = likeSection.dataset.productId;
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    
    // Une seule fonction pour gérer le clic, qu'on va attacher directement
    function setupLikeButton() {
        // Recréer tout le contenu HTML en fonction de l'état actuel
        const currentLiked = likeSection.querySelector('.like-button').getAttribute('data-liked') === 'true';
        const currentCountElem = likeSection.querySelector('.like-count');
        const currentCount = currentCountElem ? parseInt(currentCountElem.textContent || '0') : 0;
        
        // Vider la section et recréer le bouton
        likeSection.innerHTML = '';
        
        // Créer le nouveau formulaire et bouton
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = currentLiked 
            ? `/produits/${productId}/unlike` 
            : `/produits/${productId}/like`;
            
        if (currentLiked) {
            form.classList.add('unlike-form');
            // Ajouter le champ DELETE method pour l'unlike
            const methodField = document.createElement('input');
            methodField.type = 'hidden';
            methodField.name = '_method';
            methodField.value = 'DELETE';
            form.appendChild(methodField);
        }
        
        // Ajouter le token CSRF
        const csrfField = document.createElement('input');
        csrfField.type = 'hidden';
        csrfField.name = '_token';
        csrfField.value = csrfToken;
        form.appendChild(csrfField);
        
        // Créer le bouton
        const button = document.createElement('button');
        button.type = 'button';
        button.className = currentLiked ? 'like-button btn-unlike' : 'like-button btn-like';
        button.setAttribute('data-liked', currentLiked ? 'true' : 'false');
        
        // Créer l'icône du coeur
        const heartIcon = document.createElement('span');
        heartIcon.className = currentLiked ? 'heart-icon heart-filled' : 'heart-icon heart-outline';
        button.appendChild(heartIcon);
        
        // Ajouter le compteur si nécessaire
        if (currentCount > 0 || currentLiked) {
            const countSpan = document.createElement('span');
            countSpan.className = 'like-count';
            countSpan.textContent = currentCount;
            button.appendChild(countSpan);
        }
        
        // Ajouter le bouton au formulaire
        form.appendChild(button);
        likeSection.appendChild(form);
        
        // Attacher l'événement de clic au nouveau bouton
        button.addEventListener('click', handleLikeClick);
    }
    
    function handleLikeClick() {
        // Empêcher les clics multiples
        if (this.classList.contains('processing')) return;
        this.classList.add('processing');
        
        const isLiked = this.getAttribute('data-liked') === 'true';
        const url = isLiked ? `/produits/${productId}/unlike` : `/produits/${productId}/like`;
        const method = isLiked ? 'DELETE' : 'POST';
        
        // Animation immédiate
        const heartIcon = this.querySelector('.heart-icon');
        let countSpan = this.querySelector('.like-count');
        let currentCount = countSpan ? parseInt(countSpan.textContent || '0') : 0;
        
        if (isLiked) {
            // Unlike
            heartIcon.classList.remove('heart-filled');
            heartIcon.classList.add('heart-outline');
            if (currentCount > 0) {
                currentCount--;
                if (countSpan) {
                    countSpan.textContent = currentCount;
                    if (currentCount === 0) {
                        countSpan.remove();
                    }
                }
            }
        } else {
            // Like
            heartIcon.classList.remove('heart-outline');
            heartIcon.classList.add('heart-filled');
            currentCount++;
            if (countSpan) {
                countSpan.textContent = currentCount;
            } else {
                countSpan = document.createElement('span');
                countSpan.className = 'like-count';
                countSpan.textContent = currentCount;
                this.appendChild(countSpan);
            }
        }
        
        // Inverser l'état
        this.setAttribute('data-liked', isLiked ? 'false' : 'true');
        
        // Envoyer la requête au serveur
        fetch(url, {
            method: method,
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
            credentials: 'same-origin'
        })
        .then(response => response.json())
        .then(data => {
            // Mettre à jour avec le nombre exact du serveur
            if (data.success) {
                // Recréer complètement le bouton pour garantir un état cohérent
                setupLikeButton();
            }
        })
        .catch(error => {
            console.error('Erreur:', error);
            // Recréer le bouton dans son état initial
            setupLikeButton();
        })
        .finally(() => {
            this.classList.remove('processing');
        });
    }
    
    // Configuration initiale
    const initialButton = likeSection.querySelector('.like-button');
    if (initialButton) {
        initialButton.addEventListener('click', handleLikeClick);
    }
    
    // Gestion des commentaires - Édition et suppression
    setupCommentActions();
});

// Fonction pour gérer l'édition et la suppression des commentaires
function setupCommentActions() {
    // Gestion du bouton d'édition
    document.querySelectorAll('.btn-edit').forEach(button => {
        button.addEventListener('click', function() {
            const commentId = this.getAttribute('data-comment-id');
            const commentItem = document.getElementById('comment-' + commentId);
            const displayArea = commentItem.querySelector('.comment-display-area');
            const editArea = commentItem.querySelector('.comment-edit-area');
            
            // Afficher la zone d'édition, cacher la zone d'affichage
            displayArea.style.display = 'none';
            editArea.style.display = 'block';
            
            // Focus sur le textarea
            editArea.querySelector('textarea').focus();
        });
    });
    
    // Gestion du bouton d'annulation
    document.querySelectorAll('.btn-cancel').forEach(button => {
        button.addEventListener('click', function() {
            const commentItem = this.closest('.comment-item');
            const displayArea = commentItem.querySelector('.comment-display-area');
            const editArea = commentItem.querySelector('.comment-edit-area');
            
            // Cacher la zone d'édition, afficher la zone d'affichage
            editArea.style.display = 'none';
            displayArea.style.display = 'block';
        });
    });
    
    // Gestion de la suppression avec confirmation
    document.querySelectorAll('.delete-comment-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            if (confirm('Êtes-vous sûr de vouloir supprimer ce commentaire ?')) {
                this.submit();
            }
        });
    });
    
    // Soumission du formulaire d'édition avec feedback visuel
    document.querySelectorAll('.edit-comment-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            const submitBtn = this.querySelector('.btn-save');
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Enregistrement...';
        });
    });
}
</script>

<style>
/* Variables de couleurs */
:root {
    --primary-color: #3498db;
    --primary-hover: #2980b9;
    --secondary-color: #f8f9fa;
    --accent-color: #e74c3c;
    --accent-hover: #c0392b;
    --text-color: #333;
    --text-light: #6c757d;
    --border-color: #eaeaea;
    --card-bg: #fff;
    --shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    --border-radius: 10px;
    --transition: all 0.3s ease;
    --success-color: #2ecc71;
    --warning-color: #f39c12;
    --danger-color: #e74c3c;
}

/* Structure globale */
.product-detail-container {
    display: flex;
    flex-direction: column;
    gap: 40px;
}

/* Section principale du produit */
.product-main {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 40px;
    background-color: var(--card-bg);
    border-radius: var(--border-radius);
    box-shadow: var(--shadow);
    overflow: hidden;
}

/* Section image */
.product-image-section {
    display: flex;
    flex-direction: column;
}

.product-image-container {
    height: 450px;
    width: 100%;
    overflow: hidden;
    background-color: #f9f9f9;
    border-radius: var(--border-radius);
}

.product-image {
    width: 100%;
    height: 100%;
    object-fit: contain;
    transition: var(--transition);
}

.product-image-placeholder {
    height: 450px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    background-color: #f9f9f9;
    color: var(--text-light);
    border-radius: var(--border-radius);
}

.product-image-placeholder i {
    font-size: 4rem;
    margin-bottom: 15px;
}

.product-like-section {
    margin-top: 20px;
    display: flex;
    justify-content: center;
}

/* Styles du bouton J'aime */
.like-button {
    background: none;
    border: none;
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 1.1rem;
    padding: 10px 15px;
    border-radius: 30px;
    transition: var(--transition);
    cursor: pointer;
    position: relative;
    overflow: hidden;
}

.like-button:hover {
    background-color: rgba(200, 200, 200, 0.2);
}

.like-button.processing {
    pointer-events: none;
    opacity: 0.7;
}

.heart-icon {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 1.4rem;
    line-height: 1;
    margin-right: 5px;
    transition: transform 0.3s ease;
}

.heart-outline::before {
    content: '♡';  /* Cœur vide */
    color: #999;
}

.heart-filled::before {
    content: '❤️';  /* Cœur plein emoji */
    color: var(--accent-color);
}

/* Animation pour le cœur */
@keyframes heartBeat {
    0% { transform: scale(1); }
    14% { transform: scale(1.3); }
    28% { transform: scale(1); }
    42% { transform: scale(1.3); }
    70% { transform: scale(1); }
}

.btn-unlike .heart-filled {
    animation: heartBeat 1.3s ease;
}

/* Animation quand on clique */
@keyframes clickPulse {
    0% { transform: scale(1); }
    50% { transform: scale(0.9); }
    100% { transform: scale(1); }
}

.like-button:active {
    animation: clickPulse 0.2s ease;
}

.like-count {
    font-size: 0.9rem;
    font-weight: 500;
}

/* Section d'information du produit */
.product-info-section {
    padding: 30px;
    display: flex;
    flex-direction: column;
}

.product-breadcrumb {
    margin-bottom: 20px;
}

.breadcrumb {
    display: flex;
    padding: 0;
    margin: 0;
    list-style: none;
}

.breadcrumb-item {
    font-size: 0.9rem;
}

.breadcrumb-item+.breadcrumb-item::before {
    content: "/";
    padding: 0 8px;
    color: var(--text-light);
}

.breadcrumb-item a {
    color: var(--primary-color);
    text-decoration: none;
}

.breadcrumb-item.active {
    color: var(--text-light);
}

.product-title {
    font-size: 2rem;
    font-weight: 700;
    margin-bottom: 8px;
}

.product-brand {
    color: var(--text-light);
    font-size: 1.1rem;
    margin-bottom: 25px;
}

.product-price-container {
    display: flex;
    align-items: center;
    gap: 15px;
    margin-bottom: 20px;
}

.product-price {
    font-size: 2rem;
    font-weight: 700;
    color: var(--primary-color);
}

.product-old-price {
    font-size: 1.2rem;
    color: var(--text-light);
    text-decoration: line-through;
}

.product-description {
    margin-bottom: 30px;
}

.section-subheading {
    font-size: 1.2rem;
    font-weight: 600;
    margin-bottom: 15px;
    color: var(--text-color);
}

/* Section commentaires */
.product-comments-section {
    background-color: var(--card-bg);
    border-radius: var(--border-radius);
    box-shadow: var(--shadow);
    padding: 30px;
}

.section-heading {
    font-size: 1.5rem;
    font-weight: 700;
    margin-bottom: 25px;
    display: flex;
    align-items: center;
}

.comments-count {
    background-color: var(--primary-color);
    color: white;
    font-size: 0.9rem;
    padding: 5px 10px;
    border-radius: 20px;
    margin-left: 10px;
}

.comment-form-container {
    margin-bottom: 30px;
}

.comment-textarea {
    border: 1px solid var(--border-color);
    border-radius: 8px;
    padding: 15px;
    width: 100%;
    font-family: inherit;
    transition: var(--transition);
    resize: none;
}

.comment-textarea:focus {
    border-color: var(--primary-color);
    box-shadow: 0 0 0 2px rgba(52, 152, 219, 0.25);
    outline: none;
}

.text-right {
    text-align: right;
}

.btn-comment {
    background-color: var(--primary-color);
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 8px;
    font-weight: 600;
    cursor: pointer;
    transition: var(--transition);
}

.btn-comment:hover {
    background-color: var(--primary-hover);
    transform: translateY(-2px);
}

.comments-container {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.comment-item {
    display: flex;
    gap: 15px;
    padding-bottom: 20px;
    border-bottom: 1px solid var(--border-color);
}

.comment-item:last-child {
    border-bottom: none;
    padding-bottom: 0;
}

.comment-avatar {
    font-size: 2.5rem;
    color: var(--text-light);
    width: 50px;
    height: 50px;
    flex-shrink: 0;
}

.comment-content {
    flex: 1;
}

.comment-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 10px;
}

.comment-author {
    font-size: 1.1rem;
    font-weight: 600;
    margin: 0;
}

.comment-date {
    font-size: 0.9rem;
    color: var(--text-light);
}

.comment-text {
    margin: 0;
    line-height: 1.6;
}

.empty-comments {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 40px 0;
    color: var(--text-light);
    text-align: center;
}

.empty-comments i {
    font-size: 3rem;
    margin-bottom: 15px;
}

/* Nouvelles styles pour modification/suppression de commentaires */
.comment-actions {
    display: flex;
    gap: 10px;
    margin-top: 10px;
    opacity: 0;
    transition: opacity 0.2s ease-in-out;
}

.comment-item:hover .comment-actions {
    opacity: 1;
}

.btn-edit, .btn-delete {
    background: none;
    border: none;
    font-size: 0.85rem;
    color: var(--text-light);
    cursor: pointer;
    padding: 5px 10px;
    border-radius: 4px;
    transition: all 0.2s ease;
    display: flex;
    align-items: center;
    gap: 5px;
}

.btn-edit:hover {
    color: var(--primary-color);
    background-color: rgba(52, 152, 219, 0.1);
}

.btn-delete:hover {
    color: var(--danger-color);
    background-color: rgba(231, 76, 60, 0.1);
}

.btn-edit i, .btn-delete i {
    font-size: 0.9rem;
}

.comment-edit-area {
    margin-top: 10px;
}

.edit-textarea {
    margin-bottom: 10px;
}

.edit-actions {
    display: flex;
    justify-content: flex-end;
    gap: 10px;
}

.btn-cancel, .btn-save {
    border: none;
    padding: 6px 12px;
    border-radius: 4px;
    font-size: 0.9rem;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s ease;
}

.btn-cancel {
    background-color: #e9ecef;
    color: var(--text-color);
}

.btn-cancel:hover {
    background-color: #dee2e6;
}

.btn-save {
    background-color: var(--primary-color);
    color: white;
}

.btn-save:hover {
    background-color: var(--primary-hover);
}

/* Animation pour le feedback d'action */
@keyframes fadeInOut {
    0% { opacity: 0; }
    10% { opacity: 1; }
    90% { opacity: 1; }
    100% { opacity: 0; }
}

.action-feedback {
    position: fixed;
    bottom: 20px;
    right: 20px;
    padding: 12px 20px;
    border-radius: 4px;
    color: white;
    font-weight: 500;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    z-index: 1000;
    animation: fadeInOut 3s forwards;
}

.feedback-success {
    background-color: var(--success-color);
}

.feedback-error {
    background-color: var(--danger-color);
}

/* Responsive */
@media (max-width: 992px) {
    .product-main {
        grid-template-columns: 1fr;
    }
    
    .product-image-container, .product-image-placeholder {
        height: 350px;
    }
}

@media (max-width: 768px) {
    .btn-primary, .btn-secondary {
        width: 100%;
        justify-content: center;
    }
    
    .edit-actions {
        flex-direction: column;
    }
    
    .btn-cancel, .btn-save {
        width: 100%;
    }
}

@media (max-width: 576px) {
    .comment-actions {
        flex-direction: column;
        align-items: flex-start;
    }
}
</style>
@endsection