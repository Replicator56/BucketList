<?php
// src/Form/EventSearchType.php
namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class EventSearchType extends AbstractType
{
public function buildForm(FormBuilderInterface $builder, array $options): void
{
$builder
->add('city', TextType::class, [
'label' => 'Ville',
'required' => true,
])
->add('date', DateType::class, [
'label' => 'Date',
'widget' => 'single_text',
'required' => true,
]);
}
}
