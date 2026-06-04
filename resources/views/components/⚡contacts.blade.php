<?php

use Livewire\Component;
use App\Models\Contact;

new class extends Component {
    public $contacts;

    public function mount()
    {
        $this->contacts = Contact::all();
    }
};
?>

<div>
    <div class="p-6 bg-white rounded-lg border border-gray-200 shadow-sm">
        <p class="text-lg font-semibold text-gray-900 mb-4">Contacts</p>

        @if ($contacts->isEmpty())
            <p class="text-sm text-gray-500 py-4 text-center">No contacts found.</p>
        @else
            <div class="divide-y divide-gray-100 border-t border-gray-100">
                @foreach ($contacts as $contact)
                    <div class="py-3.5 flex justify-between items-center">
                        <div>
                            <p class="text-sm font-medium text-gray-900">{{ $contact->name }}</p>
                            <p class="text-xs text-gray-500">{{ $contact->email }}</p>
                        </div>
                        <div>
                            <span
                                class="inline-flex items-center rounded-md bg-gray-50 px-2 py-1 text-xs font-medium text-gray-600 ring-1 ring-inset ring-gray-500/10">
                                {{ $contact->phone }}
                            </span>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
