<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\Follow;
use Illuminate\Support\Facades\Auth;

class FollowButton extends Component
{
    public User $user; // Declarar la propiedad pública $user
    public bool $isFollowing = false;

    protected $listeners = ['refreshFollowStatus'];

    public function mount(User $user)
    {
        $this->user = $user; // Asignar el usuario recibido al componente
      
 $this->isFollowing = Auth::check() &&
        Follow::where('follower_id', Auth::id())
            ->where('followed_id', $user->id)
            ->exists();    }

    public function follow()
    {
        if (!Auth::check() || Auth::id() === $this->user->id) {
            return;
        }

        Follow::create([
            'follower_id' => Auth::id(),
            'followed_id' => $this->user->id,
        ]);

        // Emitir evento para actualizar estado
        $this->dispatchBrowserEvent('refreshFollowStatus');
    }

    public function unfollow()
    {
        Follow::where('follower_id', Auth::id())
            ->where('followed_id', $this->user->id)
            ->delete();

        $this->isFollowing = false;
        $this->dispatchBrowserEvent('unfollowed');
    }

    public function toggleFollow()
    {
        if ($this->isFollowing) {
            $this->unfollow();
        } else {
            $this->follow();
        }
    }

    public function render()
    {
        return view('livewire.follow-button'); // Renderizar la vista con $user definido
    }
}