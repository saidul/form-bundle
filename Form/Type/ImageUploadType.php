<?php
/*
 * This file is part of NeutronFormBundle
 *
 * (c) Nikolay Georgiev <azazen09@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */
namespace Neutron\FormBundle\Form\Type;

use Neutron\FormBundle\Model\ImageInterface;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\FormView;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Symfony\Component\OptionsResolver\Options;

use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\HttpFoundation\Session\Session;

use Symfony\Bundle\FrameworkBundle\Routing\Router;

use Symfony\Component\Form\FormInterface;

use Symfony\Component\Form\AbstractType;

/**
 * This class creates jquery image upload element
 *
 * @author Nikolay Georgiev <azazen09@gmail.com>
 * @since 1.0
 */
class ImageUploadType extends AbstractType
{    
    /**
     * @var \Symfony\Component\HttpFoundation\Session\Session
     */
    protected $session;

    /**
     * @var \Symfony\Bundle\FrameworkBundle\Routing\Router
     */
    protected $router;
    
    /**
     * @var \Symfony\Component\EventDispatcher\EventSubscriberInterface
     */
    protected $subscriber;

    /**
     * @var array
     */
    protected $options;


    /**
     * Construct 
     * 
     * @param Session $session
     * @param Router $router
     * @param EventSubscriberInterface $isubscriber
     * @param array $options
     */
    public function __construct(Session $session, Router $router, EventSubscriberInterface $subscriber, array $options)
    {
        $this->session = $session;
        $this->router = $router;
        $this->subscriber = $subscriber;
        $this->options = $options;
    }

    /**
     * (non-PHPdoc)
     * @see Symfony\Component\Form.AbstractType::buildForm()
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', 'hidden');
        $builder->add('title', 'hidden');
        $builder->add('caption', 'hidden');
        $builder->add('description', 'hidden');
        $builder->add('hash', 'hidden');
        $builder->add('enabled', 'hidden');
        $builder->add('currentVersion', 'hidden');
        $builder->add('scheduledForDeletion', 'hidden', array('data' => false));
        $builder->addEventSubscriber($this->subscriber);
    }
    
    /**
     * (non-PHPdoc)
     * @see \Symfony\Component\Form\AbstractType::finishView()
     */
    public function finishView(FormView $view, FormInterface $form, array $options)
    {
        $configs = array_merge($options['configs'], array(
            'id' => $view->vars['id'],        
            'name_id' => $view->getChild('name')->vars['id'],        
            'title_id' => $view->getChild('title')->vars['id'],        
            'caption_id' => $view->getChild('caption')->vars['id'],        
            'description_id' => $view->getChild('description')->vars['id'],        
            'hash_id' => $view->getChild('hash')->vars['id'],        
            'enabled_id' => $view->getChild('enabled')->vars['id'],   
            'scheduled_for_deletion_id' => $view->getChild('scheduledForDeletion')->vars['id'],   
            'enabled_value' => false,     
        ));
       
        $image = $form->getData();
        
        if ($image instanceof ImageInterface && null !== $image->getId()){            
            $configs['enabled_value'] = $image->isEnabled();
        }
        
        $this->session->set($view->vars['id'], $configs);
        $view->vars['configs'] = $configs;
    }
    
    /**
     * (non-PHPdoc)
     * @see Symfony\Component\Form.AbstractType::setDefaultOptions()
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $defaultOptions = $this->options; 
        
        $defaultConfigs = array(
            'maxSize' => $this->options['max_upload_size']        
        );
        
        $router = $this->router;
        
        $resolver->setDefaults(array(
            'error_bubbling' => false,
            'translation_domain' => 'NeutronFormBundle',
            'configs' => $defaultConfigs,
        ));
    
        $resolver->setNormalizers(array(
            'configs' => function (Options $options, $value) use ($defaultOptions, $defaultConfigs, $router){
                $configs = array_replace_recursive($defaultOptions, $defaultConfigs, $value);
                
                $requiredConfigs = array('minWidth', 'minHeight', 'maxSize', 'extensions');
            
                if (count(array_diff($requiredConfigs, array_keys($configs))) > 0){
                    throw new \InvalidArgumentException(sprintf('Some of the configs "%s" are missing', json_encode($requiredConfigs)));
                }
                
                $configs['upload_url'] = $router->generate('neutron_form_media_image_upload');
                $configs['crop_url'] = $router->generate('neutron_form_media_image_crop');
                $configs['rotate_url'] = $router->generate('neutron_form_media_image_rotate');
                $configs['reset_url'] = $router->generate('neutron_form_media_image_reset');
                $configs['dir'] = $defaultOptions['temporary_dir'] . '/';
                
                return $configs;
            }
        ));
    }
    
    /**
     * (non-PHPdoc)
     * @see Symfony\Component\Form.FormTypeInterface::getName()
     */
    public function getName()
    {
        return 'neutron_image_upload';
    }
}