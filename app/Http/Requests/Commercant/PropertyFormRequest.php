<?php

namespace App\Http\Requests\Commercant;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Category;

class PropertyFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $imageRule = $this->isMethod('post') 
        ? 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048' 
        : 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048';
    
        return [
            'nomProduit' => ['required', 'min:3'],
            'description' => ['required', 'min:6'],
            'prix' => ['required'],
            'marque' => ['required'],
            'image' => $imageRule,
            'new_categorie' => ['nullable', 'string', 'min:2'],
            'categorie' => [
                'required',
                function ($attribute, $value, $fail) {
                    // Vérifier si la catégorie est "Autre"
                    if ($value === 'Autre') {
                        return; // Si "Autre", rien à vérifier
                    }
        
                    // Vérifier si la catégorie existe en utilisant le `name`
                    if (!Category::where('name', $value)->exists()) {
                        $fail('La catégorie sélectionnée est invalide.');
                    }
                }
            ],
        'new_categorie' => ['nullable', 'string', 'min:2', 'max:255'],
        ];
        
    }
}

