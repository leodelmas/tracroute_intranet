<?php
namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class AppExtension extends AbstractExtension
{
    public function getFilters()
    {
        return [
            new TwigFilter('displayRoles', [$this, 'displayRoles']),
        ];
    }

    public function displayRoles($roles)
    {
        $roleNames = [];
        foreach ($roles as $role) {
            // Ajoutez ici la logique pour traduire les rôles en noms conviviaux
            switch ($role) {
                case 'ROLE_USER':
                    $roleNames[] = 'Utilisateur';
                    break;
                case 'ROLE_ADMIN':
                    $roleNames[] = 'Administrateur';
                    break;
                default:
                    // Si le rôle n'a pas de nom convivial défini, utilisez le nom de rôle lui-même
                    $roleNames[] = $role;
            }
        }

        return implode(', ', $roleNames);
    }
}