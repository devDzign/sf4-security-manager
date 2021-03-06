<?php


namespace App\Form;


use App\DataTransformer\EmailToUserTransformer;
use App\Repository\UserRepository;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Routing\RouterInterface;

class UserSelectTextType extends AppType
{

    /**
     * @var UserRepository
     */
    private $userRepository;
    /**
     * @var RouterInterface
     */
    private $router;

    /**
     * UserSelectTextType constructor.
     *
     * @param UserRepository  $userRepository
     * @param RouterInterface $router
     */
    public function __construct(UserRepository $userRepository, RouterInterface $router)
    {
        $this->userRepository = $userRepository;

        $this->router = $router;
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
                    'class'                 => 'js-user-autocomplete',
                    'data-autocomplete-url' => $this->router->generate('admin_utility_users'),
                ],
            ]
        );
    }


    public function getParent()
    {
        return TextType::class;
    }

}