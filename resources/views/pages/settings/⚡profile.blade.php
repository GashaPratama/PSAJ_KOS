<?php

use App\Concerns\ProfileValidationRules;
use App\Models\User;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithFileUploads;

new class extends Component {
    use ProfileValidationRules, WithFileUploads;

    public string $nama_lengkap = '';

    public string $email = '';

    public $foto_profil;

    /**
     * Mount the component.
     */
    public function mount(): void
    {
        $this->nama_lengkap = Auth::user()->nama_lengkap ?? '';
        $this->email = Auth::user()->email ?? '';
    }

    /**
     * Update the profile photo.
     */
    public function updateProfilePhoto(): void
    {
        $this->validate([
            'foto_profil' => ['required', 'image', 'max:2048'],
        ]);

        $user = Auth::user();

        if ($user->foto_profil) {
            Storage::disk('public')->delete($user->foto_profil);
        }

        $path = $this->foto_profil->store('profile-photos', 'public');
        $user->update(['foto_profil' => $path]);
        $user->refresh();

        $this->foto_profil = null;
        $this->dispatch('profile-updated');
    }

    /**
     * Remove the profile photo.
     */
    public function removeProfilePhoto(): void
    {
        $user = Auth::user();

        if ($user->foto_profil) {
            Storage::disk('public')->delete($user->foto_profil);
            $user->update(['foto_profil' => null]);
            $user->refresh();
        }

        $this->dispatch('profile-updated');
    }

    /**
     * Update the profile information for the currently authenticated user.
     * Hanya nama_lengkap yang dapat diubah; email harus hubungi administrator.
     */
    public function updateProfileInformation(): void
    {
        $this->validate([
            'nama_lengkap' => ['required', 'string', 'max:255'],
        ]);

        Auth::user()->update(['nama_lengkap' => $this->nama_lengkap]);

        $this->dispatch('profile-updated', name: $this->nama_lengkap);
    }

    /**
     * Send an email verification notification to the current user.
     */
    public function resendVerificationNotification(): void
    {
        $user = Auth::user();

        if (! $user instanceof MustVerifyEmail || $user->hasVerifiedEmail()) {
            $this->redirectIntended(default: route('home', absolute: false));

            return;
        }

        $user->sendEmailVerificationNotification();

        Session::flash('status', 'verification-link-sent');
    }

    #[Computed]
    public function hasUnverifiedEmail(): bool
    {
        $user = Auth::user();

        return $user instanceof MustVerifyEmail && ! $user->hasVerifiedEmail();
    }

    #[Computed]
    public function showDeleteUser(): bool
    {
        return false; // Penghapusan akun dinonaktifkan; hubungi administrator.
    }
}; ?>

<section class="w-full">
    @include('partials.settings-heading')

    <flux:heading class="sr-only">{{ __('Profile Settings') }}</flux:heading>

    <x-pages::settings.layout :heading="__('Profile')" :subheading="__('Data profil Anda. Untuk mengubah email, hubungi administrator.')">
        <div class="my-6 w-full space-y-6">
            {{-- Foto Profil --}}
            <div class="flex flex-col items-center gap-4 rounded-xl border border-zinc-200 bg-zinc-50/50 p-6 dark:border-zinc-800 dark:bg-zinc-900/50">
                <div class="relative">
                    <img
                        src="{{ auth()->user()->avatarUrl() }}"
                        alt="{{ __('Foto profil') }}"
                        class="h-28 w-28 rounded-full object-cover ring-2 ring-zinc-200 dark:ring-zinc-700"
                        wire:key="avatar-{{ auth()->user()->foto_profil ?? 'default' }}"
                    />
                </div>
                <form wire:submit="updateProfilePhoto" class="flex flex-col items-center gap-3">
                    <label class="cursor-pointer">
                        <input type="file" wire:model="foto_profil" accept="image/jpeg,image/png,image/gif" class="sr-only" />
                        <span class="inline-flex items-center justify-center rounded-lg border border-zinc-300 bg-white px-4 py-2 text-sm font-medium text-zinc-700 shadow-sm transition-colors hover:bg-zinc-50 dark:border-zinc-600 dark:bg-zinc-800 dark:text-zinc-300 dark:hover:bg-zinc-700">
                            {{ __('Pilih Foto') }}
                        </span>
                    </label>
                    <div class="flex items-center gap-3">
                        <flux:button type="submit" variant="primary" size="sm" wire:loading.attr="disabled">
                            <span wire:loading.remove wire:target="foto_profil">{{ __('Simpan Foto') }}</span>
                            <span wire:loading wire:target="foto_profil">{{ __('Mengunggah...') }}</span>
                        </flux:button>
                        @if (auth()->user()->foto_profil)
                            <button type="button" wire:click="removeProfilePhoto" wire:loading.attr="disabled" class="text-sm text-zinc-500 hover:text-red-600 dark:text-zinc-400 dark:hover:text-red-400">
                                {{ __('Hapus') }}
                            </button>
                        @endif
                    </div>
                    <flux:text class="text-xs text-zinc-500">{{ __('JPG, PNG, GIF. Maks. 2MB') }}</flux:text>
                    @error('foto_profil')
                        <flux:text class="text-sm text-red-600">{{ $message }}</flux:text>
                    @enderror
                </form>
            </div>

            <flux:callout variant="neutral" icon="information-circle" class="mb-6">
                {{ __('Untuk mengubah email atau menghapus akun, hubungi administrator.') }}
            </flux:callout>

            <form wire:submit="updateProfileInformation" class="space-y-6">
                <flux:field>
                    <flux:label>{{ __('Nama lengkap') }}</flux:label>
                    <flux:input wire:model="nama_lengkap" type="text" required autocomplete="name" />
                </flux:field>

                <flux:field>
                    <flux:label>{{ __('Email') }}</flux:label>
                    <flux:input :value="$email" type="email" disabled />
                </flux:field>

                <div class="flex items-center gap-4">
                    <flux:button variant="primary" type="submit" wire:loading.attr="disabled">
                        <span wire:loading.remove wire:target="updateProfileInformation">{{ __('Simpan') }}</span>
                        <span wire:loading wire:target="updateProfileInformation">{{ __('Menyimpan...') }}</span>
                    </flux:button>
                    <x-action-message class="me-3" on="profile-updated">
                        {{ __('Tersimpan.') }}
                    </x-action-message>
                </div>
            </form>
        </div>
    </x-pages::settings.layout>
</section>
