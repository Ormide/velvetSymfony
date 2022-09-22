<?php
namespace App\Security;

use App\Entity\Comments;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class CommentVoter extends Voter
{
    const EDIT = 'edit';

    protected function supports(string $attribute, mixed $subject): bool
    {
        // l'attribut n'est pas dans la liste.
        if (!in_array($attribute, [self::EDIT])) {
            return false;
        }
        // si $comment n'est pas un instance de Comment
        if (!$subject instanceof Comments) {
            return false;
        }
        // Si retourne true, appel de VoteOnAttrobute()
        return true;
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();

        if (!$user instanceof User) {
            // l'utilisateur doit êter coonecté, sinon accès refusé
            return false;
        }

        $comment = $subject;

        switch ($attribute) {
            case self::EDIT:
                return $user === $comment->getUser();
        }

        throw new \LogicException('This code should not be reached');
    }
}