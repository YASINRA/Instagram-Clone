<?php

use App\Http\Controllers\ProfileController;
use App\Livewire\Chat\Chat;
use App\Livewire\Chat\Index;
use App\Livewire\Chat\Main;
use App\Livewire\Explore;
use App\Livewire\Home;
use App\Livewire\Post\View\Page;
use App\Livewire\Profile\Home as ProfileHome;
use App\Livewire\Profile\Reels;
use App\Livewire\Profile\Saved;
use App\Livewire\Reels as LivewireReels;
use Illuminate\Support\Facades\Route;

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

Route::middleware('auth')->group(function () {
    //Home
    Route::get('/', Home::class)->name('home');
    Route::get('/explore', Explore::class)->name('explore');
    Route::get('/reels', LivewireReels::class)->name('reels');

    Route::get('/post/{post}', Page::class)->name('post');
    Route::get('/chat', Index::class)->name('chat');
    Route::get('/chat/{chat}', Main::class)->name('chat.main');

    //Profile
    Route::get('/profile/{user}', ProfileHome::class)->name('profile.home');
    Route::get('/profile/{user}/reels', Reels::class)->name('profile.reels');
    Route::get('/profile/{user}/saved', Saved::class)->name('profile.saved');
});

require __DIR__ . '/auth.php';
