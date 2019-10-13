<?php


namespace App\Form;


use App\DataTransformer\EmailToUserTransformer;
use App\Repository\UserRepository;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserSelectTextType extends AppType
{

    /**
     * @var UserRepository
     */
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addModelTransformer(
            new EmailToUserTransformer(
                $this->userRepository,
                $options['finder_callback']
            )
        );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        return $resolver->setDefaults(
            [
                'invalid_message' => ' Hmmm..., user not found!!',
                'finder_callback' => static function (UserRepository $userRepository, string $email) {
                    return $userRepository->findOneBy(['email' => $email]);
                },
                'attr'            => [
                    'class' => 'js-user-autocomplete',
                ],
            ]
        );
    }


    public function getParent()
    {
        return TextType::class;
    }

}