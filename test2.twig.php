<html>
    <body>
        <h1> {{ title }} </h1>

        {% if user.is_admin %}
            <div>
                Validation du commentaire
            </div>
        {% endif %}
        {% for figure in figures %}
        <div>
            {{ figure.name }}
        </div>
        {% endfor %}
    </body>

    {% include('template1') %}
</html>


<?php $figures = [ 
    [
        "name" => "Figure1"
    ],
    [
        "name" => "Figure2"
    ]
] ?> 


TEMPLATE 1
<h2>Ceci est mon template</h2>


Utilisation des namespace
Comment utiliser twig