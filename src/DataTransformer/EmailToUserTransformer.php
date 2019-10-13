<?php

namespace App\DataTransformer;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;


class EmailToUserTransformer implements DataTransformerInterface
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * EmailToUserTransformer constructor.
     *
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {

        $this->userRepository = $userRepository;
    }

    /**
     * Le rendu de formulaire
     *
     * @param mixed $value
     *
     * @return mixed|string|null
     */
    public function transform($value)
    {
        if ( null === $value ) {
            return '';
        }
        if ( !$value instanceof User ) {
            throw new \LogicException('The UserSelectTextType can only be used with User objects');
        }

        return $value->getEmail();
    }


    /**
     * Enregistrer le formulaire
     *
     * @param mixed $value
     *
     * @return User|mixed|null
     */
    public function reverseTransform($value)
    {

        if ( !$value ) {
            return;
        }

        $user = $this->userRepository->findOneBy(['email' => $value]);
        if ( !$user ) {
            throw new TransformationFailedException(sprintf('No user found with email "%s"', $value));
        }

        return $user;
    }
}