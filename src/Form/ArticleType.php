<?php

namespace App\Form;

use App\Entity\Article;
use App\Repository\UserRepository;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichFileType;

class ArticleType extends AppType
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * ArticleType constructor.
     *
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {

        $this->userRepository = $userRepository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'title',
                TextType::class,
                $this->getConfiguration('Titre', 'Entrez un titre...', ['required' => false])
            )
            ->add(
                'content',
                TextareaType::class,
                $this->getConfiguration('Content', 'Entrez un contenu...', ['required' => false])
            )
            ->add(
                'imageFile',
                VichFileType::class,
                [
                    'required'      => false,
                    'allow_delete'  => true,
                    'download_link' => true,
                ]
            )
            ->add(
                'publishedAt',
                null,
                [
                    'widget' => 'single_text',
                ]
            )
            ->add(
                'user',
                UserSelectTextType::class
            )
//            ->add(
//                'user',
//                EntityType::class,
//                [
//                    'class'        => User::class,
//                    'choice_label' => function (User $user) {
//                        return sprintf('(%d) %s', $user->getId(), $user->getEmail());
//                    },
//                    'placeholder' => 'Choose an author',
//                    'choices' => $this->userRepository->findAllEmailAlphabetical(),
//                ]
//            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => Article::class,
            ]
        );
    }
}
