<?php

use Livewire\Component;
use Livewire\Attributes\Validate;
use App\Models\Contact;
use Masmerise\Toaster\Toaster;

new class extends Component {
    public Contact $contact;

    // Os atributos de validação herdam as regras do seu formulário de criação
    #[Validate('required|min:3|max:50')]
    public $name;

    #[Validate('required|email|min:5|max:50')]
    public $email;

    #[Validate('required|min:5|max:20')]
    public $phone;

    public function mount($id)
    {
        // Busca o contato ou falha se não existir
        $this->contact = Contact::findOrFail($id);

        // Preenche as propriedades do formulário com os dados atuais do banco
        $this->name = $this->contact->name;
        $this->email = $this->contact->email;
        $this->phone = $this->contact->phone;
    }

    public function updateContact()
    {
        $this->validate();

        // Verifica se email já está cadastrado
        if (Contact::where('email', $this->email)->where('id', '!=', $this->contact->id)->exists()) {
            Toaster::error('Este e-mail já está cadastrado em outro contato!');
            return;
        }

        // Verifica se phone já está cadastrado
        if (Contact::where('phone', $this->phone)->where('id', '!=', $this->contact->id)->exists()) {
            Toaster::error('Este telefone já está cadastrado em outro contato!');
            return;
        }

        $this->contact->update([
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
        ]);

        Toaster::success('Contato atualizado com sucesso!');

        return redirect()->route('home');
    }
    public function cancel()
    {
        return redirect()->route('home');
    }

    public function render()
    {
        return $this->view()->title('Livewire Contacts - Editar');
    }
};
?>

<div>
    <div class="px-4 mx-auto max-w-7xl flex flex-col items-center justify-center min-h-[60vh] py-12">
        <div class="mb-6 flex justify-center w-full">
            <livewire:logo />
        </div>

        <div class="w-[450px] p-6 bg-white rounded-lg border border-gray-200 shadow-sm">
            <p class="text-lg font-semibold text-gray-900 mb-4 text-center">Editar Contato</p>

            <form wire:submit="updateContact" class="space-y-4">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                    <input type="text" id="name" wire:model="name"
                        class="block mt-1 w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                    @error('name')
                        <span class="text-xs text-red-600 mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" id="email" wire:model="email"
                        class="block mt-1 w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                    @error('email')
                        <span class="text-xs text-red-600 mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700">Phone</label>
                    <input type="text" id="phone" wire:model="phone"
                        class="block mt-1 w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                    @error('phone')
                        <span class="text-xs text-red-600 mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                <div class="flex justify-end space-x-2 pt-2">
                    <button type="button" wire:click="cancel"
                        class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md text-sm hover:bg-gray-300 transition-colors">
                        Cancelar
                    </button>
                    <button type="submit"
                        class="px-4 py-2 bg-indigo-600 text-white rounded-md text-sm hover:bg-indigo-700 shadow-sm transition-colors">
                        Salvar Alterações
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
