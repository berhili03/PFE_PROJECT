<div id="registerModal" class="modal">
  <div class="modal-content">
    <button onclick="closeRegister()" class="close-btn">&times;</button>
    <h2 class="modal-title">S'inscrire</h2>
    
    @if ($errors->any())
    <div class="error-box">
      <ul>
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
    @endif
    
    <form method="POST" action="{{ route('register') }}" class="form">
      @csrf
      
      <div class="form-row">
        <div class="form-group">
          <input type="text" id="name" name="name" value="{{ old('name') }}" 
                 class="form-input" required autofocus placeholder="Nom complet">
        </div>
        <div class="form-group">
        <input type="email" id="email" name="email" value="{{ old('email') }}" 
               class="form-input" required placeholder="Email">
      </div>
        
      </div>
      
      <div class="form-row">
        <div class="form-group">
          <select id="sexe" name="sexe" class="form-input" required>
            <option value="" disabled selected>Genre</option>
            <option value="Homme" {{ old('sexe') == 'Homme' ? 'selected' : '' }}>Homme</option>
            <option value="Femme" {{ old('sexe') == 'Femme' ? 'selected' : '' }}>Femme</option>
          </select>
        </div>
        <div class="form-group">
          <select id="role" name="role" class="form-input" required>
            <option value="" disabled selected>Type de compte</option>
            <option value="Commercant" {{ old('role') == 'Commercant' ? 'selected' : '' }}>Commerçant</option>
            <option value="Consommateur" {{ old('role') == 'Consommateur' ? 'selected' : '' }}>Consommateur</option>
          </select>
        </div>
      </div>
      
      <div class="form-row">
        <div class="form-group">
          <input type="tel" id="tel" name="tel" value="{{ old('tel') }}" 
                 class="form-input" required placeholder="Téléphone">
        </div>
        <div id="merchantFields" class="form-group hidden">
          <input type="text" id="store_name" name="store_name" 
                 class="form-input" placeholder="Nom de la boutique">
        </div>
      </div>
      
      <div class="form-group">
        <textarea id="adresse" name="adresse" class="form-input" 
                  required placeholder="Adresse">{{ old('adresse') }}</textarea>
      </div>
      
     
      
      <div class="form-row">
        <div class="form-group">
          <input type="password" id="password" name="password" 
                 class="form-input" required placeholder="Mot de passe">
        </div>
        <div class="form-group">
          <input type="password" id="password_confirmation" name="password_confirmation" 
                 class="form-input" required placeholder="Confirmation">
        </div>
      </div>
      
      <button type="submit" class="submit-btn">S'inscrire</button>
      
      <p class="login-link">Déjà membre? <a href="{{ route('login') }}">Se connecter</a></p>
    </form>
  </div>
</div>

<style>
.modal {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: rgba(0,0,0,0.6);
  backdrop-filter: blur(5px);
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 100;
}

.modal-content {
  background: white;
  border-radius: 15px;
  width: 90%;
  max-width: 460px;
  padding: 25px;
  position: relative;
  box-shadow: 0 10px 25px rgba(0,0,0,0.1);
  animation: fadeIn 0.3s ease;
}

@keyframes fadeIn {
  from { opacity: 0; transform: translateY(-10px); }
  to { opacity: 1; transform: translateY(0); }
}

.close-btn {
  position: absolute;
  top: 15px;
  right: 15px;
  font-size: 22px;
  background: #f8f9fa;
  color: #4a5568;
  border: none;
  border-radius: 50%;
  width: 30px;
  height: 30px;
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  transition: all 0.2s;
}

.close-btn:hover {
  background: #e2e8f0;
  transform: rotate(90deg);
}

.modal-title {
  text-align: center;
  margin-bottom: 20px;
  color: #2d3748;
  font-weight: 600;
  position: relative;
  padding-bottom: 10px;
}

.modal-title:after {
  content: '';
  position: absolute;
  bottom: 0;
  left: 50%;
  transform: translateX(-50%);
  width: 50px;
  height: 3px;
  background: linear-gradient(to right, #38b2ac, #4299e1);
}

.error-box {
  background: #fff5f5;
  color: #c53030;
  padding: 10px 15px;
  border-radius: 8px;
  margin-bottom: 15px;
  font-size: 14px;
  border-left: 4px solid #fc8181;
}

.form-row {
  display: flex;
  gap: 15px;
  margin-bottom: 10px;
}

.form-group {
  flex: 1;
  position: relative;
  margin-bottom: 10px;
}

.form-input {
  width: 100%;
  padding: 10px 12px;
  border: 1px solid #e2e8f0;
  border-radius: 8px;
  font-size: 14px;
  transition: all 0.2s;
  background-color: #f8fafc;
}

.form-input:focus {
  border-color: #4299e1;
  box-shadow: 0 0 0 2px rgba(66, 153, 225, 0.2);
  outline: none;
  background-color: #fff;
}

textarea.form-input {
  min-height: 60px;
  resize: none;
}

select.form-input {
  appearance: none;
  background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e");
  background-repeat: no-repeat;
  background-position: right 10px center;
  background-size: 16px;
}

.submit-btn {
  width: 100%;
  padding: 12px;
  background: linear-gradient(135deg, #38b2ac, #4299e1);
  color: white;
  border: none;
  border-radius: 8px;
  cursor: pointer;
  font-weight: 500;
  margin-top: 10px;
  transition: transform 0.2s, box-shadow 0.2s;
}

.submit-btn:hover {
  transform: translateY(-2px);
  box-shadow: 0 4px 12px rgba(66, 153, 225, 0.3);
}

.submit-btn:active {
  transform: translateY(0);
}

.login-link {
  text-align: center;
  margin-top: 15px;
  font-size: 14px;
  color: #718096;
}

.login-link a {
  color: #4299e1;
  text-decoration: none;
  font-weight: 500;
  transition: color 0.2s;
}

.login-link a:hover {
  color: #2b6cb0;
  text-decoration: underline;
}

.hidden {
  display: none;
}
</style>

<script>
function closeRegister() {
  const modal = document.getElementById('registerModal');
  modal.style.opacity = '0';
  modal.style.transform = 'translateY(-10px)';
  setTimeout(() => {
    modal.style.display = 'none';
    modal.style.opacity = '1';
    modal.style.transform = 'translateY(0)';
  }, 300);
}

document.getElementById('role').addEventListener('change', function() {
  const merchantFields = document.getElementById('merchantFields');
  if (this.value === 'Commercant') {
    merchantFields.classList.remove('hidden');
  } else {
    merchantFields.classList.add('hidden');
  }
});

// Initialiser les champs au chargement si nécessaire
window.addEventListener('DOMContentLoaded', function() {
  const roleSelect = document.getElementById('role');
  if (roleSelect.value === 'Commercant') {
    document.getElementById('merchantFields').classList.remove('hidden');
  }
});
</script>