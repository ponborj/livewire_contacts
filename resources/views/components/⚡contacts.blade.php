<?php

use Livewire\Component;
use App\Models\Contact;
use Livewire\Attributes\On;
use Livewire\WithPagination;

new class extends Component {
    use WithPagination;

    public string $search = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    #[On('refreshContacts')]
    public function refreshContactsList()
    {
        $this->resetPage();
    }

    public function render()
    {
        // Filtra os contatos pelo nome ou e-mail digitado antes de paginar
        $contacts = Contact::query()
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')->orWhere('email', 'like', '%' . $this->search . '%');
            })
            ->paginate(5);

        // $this->view()
        return $this->view()->with([
            'contacts' => $contacts,
        ]);
    }
};
?>

<div>
    <div class="p-6 bg-white rounded-lg border border-gray-200 shadow-sm space-y-4">
        <div class="flex justify-between items-center flex-wrap gap-4">
            <p class="text-lg font-semibold text-gray-900">Contatos</p>

            <div class="w-full sm:w-64">
                <input type="text" wire:model.live.debounce.300ms="search" placeholder="Buscar contato..."
                    class="block w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 text-sm p-2 border">
            </div>
        </div>

        @if ($contacts->isEmpty())
            <p class="text-sm text-gray-500 py-4 text-center">Nenhum contato encontrado!</p>
        @else
            <div class="divide-y divide-gray-100 border-t border-gray-100">
                @foreach ($contacts as $contact)
                    <div class="py-3.5 flex justify-between items-center">
                        <div>
                            <p class="text-sm font-medium text-gray-900">{{ $contact->name }}</p>
                            <p class="text-xs text-gray-500">{{ $contact->email }}</p>
                        </div>
                        <div class="flex items-center space-x-4">
                            <span
                                class="inline-flex items-center rounded-md bg-gray-50 px-2 py-1 text-xs font-medium text-gray-600 ring-1 ring-inset ring-gray-500/10">
                                {{ $contact->phone }}
                            </span>

                            <a href="{{ route('contacts.edit', ['id' => $contact->id]) }}"
                                class="text-xs text-indigo-600 hover:text-indigo-900 font-medium">
                                Editar
                            </a>

                            <a href="{{ route('contacts.delete', ['id' => $contact->id]) }}"
                                class="text-xs text-red-600 hover:text-red-900 font-medium">
                                Deletar
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="pt-4">
                {{ $contacts->links() }}
            </div>
        @endif
    </div>
</div>
