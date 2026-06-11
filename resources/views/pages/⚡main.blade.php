<?php

use Livewire\Component;

new class extends Component {
    public function render()
    {
        return $this->view()->title('Livewire Contacts');
    }
};
?>

<div>
    <div class="px-4 mx-auto max-w-7xl py-12">
        <div class="mb-8 flex justify-center w-full">
            <livewire:logo />
        </div>

        <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
            <div class="md:col-span-1">
                <livewire:form-contact />
            </div>
            <div class="md:col-span-2">
                <livewire:contacts />
            </div>
        </div>

    </div>
</div>
