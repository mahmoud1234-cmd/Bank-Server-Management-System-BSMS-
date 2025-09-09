<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\File;
use Inertia\Inertia;
use Inertia\Response;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request)
    {
        return view('profile.edit', [
            'user' => $request->user(),
            'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
            'status' => session('status'),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        try {
            \Log::info('Début de la mise à jour du profil', ['user_id' => $request->user()->id]);
            $validated = $request->validated();
            \Log::debug('Données validées', $validated);
            
            // Handle photo upload
            if ($request->hasFile('photo')) {
                try {
                    \Log::info('Téléchargement d\'une nouvelle photo de profil');
                    // Delete old photo if exists
                    if ($request->user()->photo && Storage::disk('public')->exists($request->user()->photo)) {
                        \Log::info('Suppression de l\'ancienne photo', ['photo_path' => $request->user()->photo]);
                        Storage::disk('public')->delete($request->user()->photo);
                    }
                    
                    // Store new photo
                    $photoPath = $request->file('photo')->store('profile-photos', 'public');
                    $validated['photo'] = $photoPath;
                    \Log::info('Nouvelle photo enregistrée', ['photo_path' => $photoPath]);
                } catch (\Exception $e) {
                    \Log::error('Erreur lors du téléchargement de la photo de profil: ' . $e->getMessage());
                    return back()->with('error', 'Une erreur est survenue lors du téléchargement de la photo de profil.');
                }
            }
            
            $request->user()->fill($validated);

            if ($request->user()->isDirty('email')) {
                $request->user()->email_verified_at = null;
            }

            $request->user()->save();
            \Log::info('Profil mis à jour avec succès', ['user_id' => $request->user()->id]);

            return Redirect::route('profile.edit')
                ->with('success', 'Votre profil a été mis à jour avec succès.')
                ->with('status', 'profile-updated');
                
        } catch (\Exception $e) {
            \Log::error('Erreur lors de la mise à jour du profil: ' . $e->getMessage());
            \Log::error($e);
            return back()->with('error', 'Une erreur est survenue lors de la mise à jour de votre profil. Veuillez réessayer.');
        }
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
