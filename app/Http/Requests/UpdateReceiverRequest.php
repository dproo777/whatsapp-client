<?php

namespace App\Http\Requests;

use App\Models\Receiver;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateReceiverRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'type'        => [
                'required',
                Rule::in(Receiver::getTypes()),
            ],
            'name'        => 'required|string|max:255',
            'whatsapp_id' => [
                'required',
                'string',
                'max:255',
                Rule::unique(Receiver::class, 'whatsapp_id')
                    ->where('sender_id', $this->sender->id)
                    ->ignoreModel($this->receiver),
            ],
        ];
    }
}
