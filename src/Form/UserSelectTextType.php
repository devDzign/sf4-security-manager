<?php


namespace App\Form;


use Symfony\Component\Form\Extension\Core\Type\TextType;

class UserSelectTextType extends AppType
{
    public function getParent()
    {
        return TextType::class;
    }

}