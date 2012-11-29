Buttonset
==========

The buttonset is styled as toggle buttons. The label element associated with the button is used for the button text. 
It could be multiple or single choice.
See [demo](http://jqueryui.com/button/#radio)

### Usage:

**Note:** You can replace *choice* with *entity* etc.

``` php
<?php
// ...
public function buildForm(FormBuilderInterface $builder, array $options)
{
    $builder
        // .....
        ->add('name', 'neutron_buttonset_choice', array(
	        'label' => 'Buttonset', 
	        'multiple' => false,
	        'choices' => array('value1' => 'label1', 'value2' => 'label2', 'value3' => 'label3'),
        ))
		// .....
    ;
}
```

in the twig template add following code:

``` jinja
{% block stylesheets %}
            
    {% stylesheets
       'jquery/css/smoothness/jquery-ui.css' 
       'bundles/neutronform/css/form_widgets.css'
         filter='cssrewrite'
   %}
        <link rel="stylesheet" href="{{ asset_url }}" />
    {% endstylesheets %}

{% endblock %}

{% block javascripts %}

    {% javascripts
        'jquery/js/jquery.js'
        'jquery/js/jquery-ui.js'
        'jquery/i18n/jquery-ui-i18n.js'
        'bundles/neutronform/js/buttonset.js'
   
    %}
        <script src="{{ asset_url }}"></script>
	{% endjavascripts %}

{% endblock %}

{% form_theme form with ['NeutronFormBundle:Form:fields.html.twig'] %}

``

**Note:** You must install jQueryUI.

That's it.

