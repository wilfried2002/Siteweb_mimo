<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddToCartRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'product_id' => ['required', 'integer', 'exists:products,id'],
            'quantity'   => ['required', 'integer', 'min:1'],
            'type'       => ['required', 'in:detail,gros'],
        ];
    }

    public function messages(): array
    {
        return [
            'product_id.required' => 'Produit invalide.',
            'product_id.exists'   => 'Ce produit n\'existe pas.',
            'quantity.required'   => 'Veuillez indiquer une quantité.',
            'quantity.min'        => 'La quantité doit être au moins 1.',
            'type.required'       => 'Veuillez choisir le type de commande.',
            'type.in'             => 'Type de commande invalide.',
        ];
    }
}
