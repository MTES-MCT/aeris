<?php

namespace App\Security;

class SecurityHelper
{
    private $authChecker;

    private $tokenStorage;

    public function __construct($authChecker, $tokenStorage){
        $this->authChecker = $authChecker;
        $this->tokenStorage = $tokenStorage;
    }

    public function canAccessIncinerateur($incinerateur){
        if ($this->authChecker->isGranted('ROLE_INSPECTEUR')) {
            return true;
        }
        if($this->authChecker->isGranted('ROLE_PROPRIETAIRE')) {
            $mainIncinerateur = $this->getMainIncinerateur();
            return $mainIncinerateur->getId() == $incinerateur->getId();
        }
        return false;
    }

    public function getMainIncinerateur(){
        $user = $this->tokenStorage->getToken()->getUser();
        $incinerateurs = $user->getIncinerateurs();
        if(!empty($incinerateurs)) {
            return $incinerateurs[0];
        }
        return null;
    }

    public function isInspecteur(){
        return $this->authChecker->isGranted('ROLE_INSPECTEUR');
    }

    public function isOwner(){
        return $this->authChecker->isGranted('ROLE_PROPRIETAIRE');
    }
}