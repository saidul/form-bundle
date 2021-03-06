ColorPicker
===========

The colorpicker is a jQuery widget.

See [demo](http://www.eyecon.ro/colorpicker/#about)

**Important:** download source from [here](http://www.eyecon.ro/colorpicker/#download)

### Usage:

``` php
<?php
// ...
public function buildForm(FormBuilderInterface $builder, array $options)
{
    $builder
        // .....
        ->add('name', 'neutron_colorpicker', array(
            'label' => 'Colorpicker',
            'configs' => array(),
        ))
		// .....
    ;
}
```
**Note:** All configs are passed as json object to the widget.

In the twig template add following code:

``` jinja
{% block stylesheets %}
            
    {% stylesheets
    	'bundles/neutronform/css/form_widgets.css'
        'jquery/plugins/colorpicker/css/colorpicker.css'
        filter='cssrewrite'
    %}
        <link rel="stylesheet" href="{{ asset_url }}" />
    {% endstylesheets %}

{% endblock %}

{% block javascripts %}

    {% javascripts
        'jquery/js/jquery.js'
        'jquery/plugins/colorpicker/js/colorpicker.js'
        'bundles/neutronform/js/colorpicker.js'
    %}
        <script src="{{ asset_url }}"></script>
	{% endjavascripts %}

{% endblock %}

{% form_theme form with ['NeutronFormBundle:Form:fields.html.twig'] %}

```

Run the following command:

``` bash
$ php app/console assetic:dump
```

[jQuery API documentation](http://www.eyecon.ro/colorpicker/#implement)

That's it.

[back to index](index.md#list)
