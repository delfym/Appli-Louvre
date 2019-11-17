<?php

namespace Louvre\BookingBundle\Form;

//use Doctrine\DBAL\Types\DateType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;

class VisitorType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', TextType::class)
                ->add('firstName', TextType::class)
                ->add('birthDate', BirthdayType::class, array(
                            'format'=> 'dd-MM-yyyy',
                            'years' => range(date('Y'), date('Y')-100),
                            'required' => true))
                ->add('email', EmailType::class, array(
                                'required' => true))
                ->add('country', CountryType::class, array(
                                'preferred_choices' => array('FR')
                    ));
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Louvre\BookingBundle\Entity\Visitor'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'louvre_bookingbundle_visitor';
    }


}
