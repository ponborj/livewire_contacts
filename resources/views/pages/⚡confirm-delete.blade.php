<?php

use Livewire\Component;
use App\Models\Contact;

new class extends Component {
    public Contact $contact;

    public function mount($id)
    {
        $this->contact = Contact::findOrFail($id);
    }

    public function cancel()
    {
        return redirect()->route('home');
    }

    public function delete()
    {
        $this->contact->delete();
        return redirect()->route('home');
    }

    public function render()
    {
        return $this->view()->title('Livewire Contacts - Deletar');
    }
};
?>

<div>
    <div class="px-4 mx-auto max-w-7xl flex flex-col items-center justify-center min-h-[60vh] py-12">
        <div class="mb-6 flex justify-center w-full">
            <livewire:logo />
        </div>

        <div class="w-[450px] text-center p-6 bg-white rounded-lg border border-gray-200 shadow-sm">
            <p class="text-lg font-semibold text-red-600 mb-3">Deseja deletar esse contato?</p>

            <div class="text-sm text-gray-700 text-left bg-gray-50 p-4 rounded-md space-y-1">
                <p><strong>Nome:</strong> {{ $contact->name }}</p>
                <p><strong>Email:</strong> {{ $contact->email }}</p>
                <p><strong>Telefone:</strong> {{ $contact->phone }}</p>
            </div>

            <div class="mt-4 space-x-2 pt-2">
                <button wire:click="delete" type="button"
                    class="px-4 py-2 bg-red-600 text-white rounded-md text-sm hover:bg-red-700 transition-colors">
                    Confirmar
                </button>
                <button wire:click="cancel" type="button"
                    class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md text-sm hover:bg-gray-300 transition-colors">
                    Cancelar
                </button>
            </div>
        </div>
    </div>
</div>
