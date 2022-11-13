<?php

namespace App\Form;

use App\Entity\Etalage;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Repository\LivreRepository;

class EtalageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
                //dump($options);
                $etalage = $options['data'] ?? null;
                $amateur = $etalage->getAmateur();
        $builder
            ->add('description')
            ->add('publie')
            ->add('livres')
            ->add('amateur', null, [
                'disabled'   => true,])

                         ->add('livres', null, [
                'query_builder' => function (LivreRepository $er) use ($amateur) {
                        return $er->createQueryBuilder('g')
                        ->leftJoin('g.librairie', 'i')
                        ->andWhere('i.amateur = :amateur')
                        ->setParameter('amateur', $amateur)
                        ;
                    }
                ])  
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Etalage::class,
        ]);
    }
}
