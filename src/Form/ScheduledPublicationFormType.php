<?php


    namespace Ever\ScheduledPublication\Form;

use PrestaShop\PrestaShop\Adapter\SymfonyContainer;
use PrestaShopBundle\Form\Admin\Type\CommonAbstractType;
use PrestaShopBundle\Form\Admin\Type\DatePickerType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Translation\TranslatorInterface;

class ScheduledPublicationFormType extends CommonAbstractType
{
    private TranslatorInterface $translator;
    private array $locales;

    public function __construct()
    {
        $this->translator = SymfonyContainer::getInstance()->get('translator');
        $this->locales = [SymfonyContainer::getInstance()->get('prestashop.adapter.legacy.context')->getContext()->language->id];
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('id', HiddenType::class)
            ->add('object', TextType::class, [
                'required' => true,
                'attr' => ['value' => 'Product', 'readonly' => 'readonly'],
                'label' => $this->trans('Object', \everpsscheduledpublication::getTranslationDomain()),
            ])
            ->add('idObject', IntegerType::class, [
                'required' => true,
                'label' => $this->trans('Id de l\'objet', \everpsscheduledpublication::getTranslationDomain()),
            ])
            ->add('dueDate', DatePickerType::class, [
                'required' => true,
                'label' => $this->trans('Date de publication', \everpsscheduledpublication::getTranslationDomain()),
                'date_format' => 'DD-MM-YYYY HH:mm:ss',
            ]);
    }

    /**
     * Get the translated chain from key.
     *
     * @param string $key the key to be translated
     * @param string $domain the domain to be selected
     * @param array $parameters Optional, pass parameters if needed (uncommon)
     *
     * @returns string
     */
    protected function trans($key, $domain, $parameters = [])
    {
        return $this->translator->trans($key, $parameters, $domain);
    }

    /**
     * @return TranslatorInterface
     */
    protected function getTranslator(): TranslatorInterface
    {
        return $this->translator;
    }

    /**
     * Get locales to be used in form type.
     *
     * @return array
     */
    protected function getLocaleChoices()
    {
        $locales = [];

        foreach ($this->locales as $locale) {
            $locales[$locale['name']] = $locale['iso_code'];
        }

        return $locales;
    }
}
