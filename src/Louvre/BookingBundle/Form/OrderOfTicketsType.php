<?php

namespace Louvre\BookingBundle\Form;

use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class OrderOfTicketsType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('purchaseDate',    DateTimeType::class)
                ->add('ticketsQuantity', ChoiceType::class,  array(
                    'choices' => array(
                                    1 => 1,
                                    2 => 2,
                                    3 => 3,
                                    4 => 4,
                                    5 => 5,
                                    6 => 6,
                                    7 => 7,
                                    8 => 8,
                                    9 => 9,
                                    10 => 10)
                ))
                ->add('ticketDate', DateType::class, array(
                    'widget'=> 'single_text',
                    'html5' => false,
                    'format' => 'd-m-Y',
                    'attr' => ['class' => 'datepicker']))
                ->add('ticketType', ChoiceType::class, array(
                    'choices' => array(
                        'journée' => 0,
                        'demi-journée'=> 1)
                ))
                ->add('visitor',         VisitorType::class)
                ->add('tickets',         CollectionType::class, array(
                    'entry_type'    => TicketType::class,
                    'label'         => false,
                    'allow_add'     => true,
                    'allow_delete'  => true,
                    'by_reference'  => false))
                ->add('amount', MoneyType::class, array(
                    'currency' => false,
                    'disabled' => true
                ))
                ->add('save', SubmitType::class, [
                    'label' => 'Régler ma commande']
                );
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Louvre\BookingBundle\Entity\OrderOfTickets'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'louvre_bookingbundle_orderoftickets';
    }
}
