<?php

namespace App\Form;

use App\Entity\Choix;
use App\Repository\ChoixRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\UX\Autocomplete\Form\AsEntityAutocompleteField;
use Symfony\UX\Autocomplete\Form\ParentEntityAutocompleteType;

#[AsEntityAutocompleteField]
class SimpleChoixAutocompleteField extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'class' => Choix::class,
            'placeholder' => 'Choissisez un nom dans la liste',
            'choice_label' => 'nom',

            'query_builder' => function(ChoixRepository $choixRepository) {
                return $choixRepository->createQueryBuilder('choix');
            },
            //'security' => 'ROLE_SOMETHING',
        ]);
    }

    public function getParent(): string
    {
        return ParentEntityAutocompleteType::class;
    }
}
