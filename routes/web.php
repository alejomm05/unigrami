<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\StoryController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\NotificationController;

// Página de bienvenida
Route::view('/', 'welcome')->name('welcome');

// Autenticación (Laravel Breeze)
require __DIR__.'/auth.php';

// Rutas protegidas: autenticado y correo verificado
Route::middleware(['auth', 'verified'])->group(function () {

    // Dashboard principal: feed de publicaciones, historias, sugerencias
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    // Perfil del usuario autenticado (editar)
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    // Ver perfil de cualquier usuario por username
    Route::get('/profile/{user:username}', [ProfileController::class, 'show'])
        ->name('profile.show');

    // Búsqueda de usuarios (aproximada)
    Route::get('/search', [SearchController::class, 'search'])
        ->name('search');

    // Seguir / Dejar de seguir
    Route::post('/follow/{user}', [FollowController::class, 'follow'])
        ->name('follow');
    Route::delete('/unfollow/{user}', [FollowController::class, 'unfollow'])
        ->name('unfollow');

    // Publicaciones
    Route::prefix('posts')->group(function () {
        // Crear nueva publicación
        Route::get('/create', function () {
            return view('posts.create');
        })->name('posts.create');

        // Almacenar publicación
        Route::post('/', [PostController::class, 'store'])->name('posts.store');

        // Ver publicación
        Route::get('/{post}', [PostController::class, 'show'])->name('posts.show');

        // Eliminar publicación
        Route::delete('/{post}', [PostController::class, 'destroy'])->name('posts.destroy');
    });

    // Comentarios
    Route::post('/comments', [CommentController::class, 'store'])
        ->name('comments.store');

    // Historias
    Route::prefix('stories')->group(function () {
        // Crear historia
        Route::get('/create', [StoryController::class, 'create'])->name('stories.create');
        Route::post('/store', [StoryController::class, 'store'])->name('stories.store');

        // Ver historia (registro de vista)
        Route::get('/{story}/view', [StoryController::class, 'view'])->name('stories.view');

        // Reaccionar con emoji
        Route::post('/{story}/react', [StoryController::class, 'react'])->name('stories.react');
    });

    // Mensajes directos
    Route::prefix('messages')->group(function () {
        Route::get('/', [MessageController::class, 'index'])->name('messages.index');
        Route::get('/conversation/{username}', [MessageController::class, 'conversation'])->name('messages.conversation');
        Route::post('/send', [MessageController::class, 'send'])->name('messages.send');
        Route::post('/forward/{message}', [MessageController::class, 'forward'])->name('messages.forward');
    });

    // Notificaciones
    Route::get('/notifications', [NotificationController::class, 'index'])
        ->name('notifications.index');

    Route::post('/notifications/mark-as-read', [NotificationController::class, 'markAsRead'])
        ->name('notifications.markAsRead');

    // Menciones
    Route::get('/mentions', [NotificationController::class, 'mentions'])
        ->name('mentions.index');
});