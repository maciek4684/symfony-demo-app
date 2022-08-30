<?php

namespace App\Security\Voter;

use App\Entity\AppUser;
use App\Entity\Task;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

final class TaskVoter extends Voter
{
    const VIEW = 'view';
    const EDIT = 'edit';
    const DELETE = 'delete';

    /**
     * @inheritDoc
     */
    protected function supports($attribute, $subject): bool
    {
        // if the attribute isn't one we support, return false
        if (!in_array($attribute, [self::VIEW, self::EDIT, self::DELETE])) {
            return false;
        }

        if (!$subject instanceof Task) {
            return false;
        }

        return true;
    }

    /**
     * @inheritDoc
     */
    protected function voteOnAttribute($attribute, $subject, TokenInterface $token): bool
    {

        $user = $token->getUser();

        if (!$user instanceof AppUser) {
            return false;
        }

        /**
         * @var Task $task
         */
        $task = $subject;

        switch ($attribute) {
            case self::VIEW:
                return $this->canView($task, $user);
            case self::EDIT:
                return $this->canEdit($task, $user);
            case self::DELETE:
                return $this->canDelete($task, $user);
        }

        throw new \LogicException('This code should not be reached!');
    }
    private function canView(Task $task, AppUser $user) : bool
    {
        if (in_array("ROLE_USER", $user->getRoles()))
        {
            return true;
        }

        return false;
    }

    private function canDelete(Task $task, UserInterface $user) : bool
    {

        if (in_array("ROLE_ADMIN", $user->getRoles()))
        {
            return true;
        }

        return false;
    }

    private function canEdit(Task $task, AppUser $user) :bool
    {
        if (in_array("ROLE_ADMIN", $user->getRoles()))
        {
            return true;
        }

        return false;
    }
}
