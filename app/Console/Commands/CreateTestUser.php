<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateTestUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:create-test {email?} {password?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Créer un utilisateur de test pour l\'application';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email') ?? 'admin@banque.fr';
        $password = $this->argument('password') ?? 'password';

        // Vérifier les utilisateurs existants
        $this->info('=== Utilisateurs existants ===');
        $users = User::all(['name', 'email', 'role']);
        
        if ($users->isEmpty()) {
            $this->warn('Aucun utilisateur trouvé dans la base de données.');
        } else {
            foreach ($users as $user) {
                $this->line("• {$user->name} - {$user->email} ({$user->role})");
            }
        }

        $this->newLine();

        // Vérifier si l'utilisateur existe déjà
        $existingUser = User::where('email', $email)->first();
        
        if ($existingUser) {
            $this->warn("L'utilisateur {$email} existe déjà.");
            $this->info("Nom: {$existingUser->name}");
            $this->info("Rôle: {$existingUser->role}");
            
            if ($this->confirm('Voulez-vous mettre à jour le mot de passe ?')) {
                $existingUser->update([
                    'password' => Hash::make($password)
                ]);
                $this->info("Mot de passe mis à jour pour {$email}");
            }
        } else {
            // Créer un nouvel utilisateur
            $user = User::create([
                'name' => 'Admin Principal',
                'email' => $email,
                'password' => Hash::make($password),
                'role' => 'admin',
                'department' => 'IT Management',
                'phone' => '+33 1 23 45 67 89',
                'is_active' => true,
            ]);

            $this->info("Utilisateur créé avec succès:");
            $this->line("• Email: {$user->email}");
            $this->line("• Mot de passe: {$password}");
            $this->line("• Rôle: {$user->role}");
        }

        $this->newLine();
        $this->info('=== Informations de connexion ===');
        $this->line("URL: http://127.0.0.1:8000");
        $this->line("Email: {$email}");
        $this->line("Mot de passe: {$password}");
    }
}
