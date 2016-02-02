<?php
namespace AppBundle\Form;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use AppBundle\Entity\Producto;


class ProfesorType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombre',  TextType::class)
            ->add('primerapellido', TextType::class)
            ->add('segundoapellido', TextType::class)
            ->add('edad',      NumberType::class)
            ->add('asignatura', TextType::class);

    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => 'AppBundle\Entity\Profesor',
            ]
        );
    }
    public function getName()
    {
        return 'app_bundle_profesor_type';
    }
}