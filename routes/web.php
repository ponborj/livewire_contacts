<?php

use Illuminate\Support\Facades\Route;
use App\Livewire;

Route::livewire('/', 'pages::main')->name('home');
Route::livewire('/contacts/{id}/delete', 'pages::confirm-delete')->name('contacts.delete');
Route::livewire('/contacts/{id}/edit', 'pages::edit-contact')->name('contacts.edit');