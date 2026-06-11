<?php

use Livewire\Component;
use Livewire\Attributes\Validate;
use App\Models\Contact;
use Masmerise\Toaster\Toaster;

new class extends Component {
    #[Validate('required|min:3|max:50')]
    public $name;

    #[Validate('required|email|min:5|max:50')]
    public $email;

    #[Validate('required|min:5|max:20')]
    public $phone;

    public $error = '';
    public $success = '';

    public function newContact()
    {
        $this->error = '';
        $this->success = '';

        // $this->validate([
        //     'name' => 'required|min:3|max:50',
        //     'email' => 'required|email|min:5|max:50',
        //     'phone' => 'required|min:5|max:20',
        // ]);

        $this->validate();

        // save contact to database
        $result = Contact::firstOrCreate(
            [
                'email' => $this->email,
            ],
            [
                'name' => $this->name,
                'phone' => $this->phone,
            ],
        );

        // clear form 1
        // $this->name = '';
        // $this->email = '';
        // $this->phone = '';

        // clear form 2
        // $this->reset();
        // $this->reset(['name', 'email', 'phone']);

        // check if contact was created or error
        if ($result->wasRecentlyCreated) {
            Toaster::success($this->success = 'Contato criado com sucesso!');
            $this->reset(['name', 'email', 'phone']);

            // event
            $this->dispatch('refreshContacts');
        } else {
            Toaster::error($this->error = 'Contato já existe!');
        }
    }
};
?>

<div>
    <div class="p-6 bg-white rounded-lg border border-gray-200 shadow-sm">
        <p class="text-lg font-semibold text-gray-900 mb-4">Criar Contato</p>

        <form wire:submit="newContact" class="space-y-4 divide-y divide-gray-100 border-t border-gray-100">

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

            <div class="text-right">
                <button type="submit"
                    class="inline-flex justify-center px-6 py-2 text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 rounded-md shadow-sm transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Salvar
                </button>
            </div>

        </form>
    </div>
</div>
