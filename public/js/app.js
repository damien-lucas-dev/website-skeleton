$(document).on('change', '#sortie_ville', function () {
    console.log('Entrée dans la fonction');
    let $field = $(this);
    let $form = $field.closest('form');
    console.log($form);
    let $target = '#' + $field.attr('id').replace('ville', 'lieu');
    console.log($target);

    // Les données à envoyer en Ajax
    let ville = {'ville': $field.val()};

    console.log(ville);

    // On soumet les données

   /* $.post('getplaces', ville, function (data) {
        /!*!// On récupère le nouveau <select>
        let $input = $(data).find($target);
        // On remplace notre <select> actuel
        $($target).replaceWith($input);*!/
        console.log(data);
    });*/

    $.post({
        url: 'http://localhost/website-skeleton/public/sortie/dams/getplaces',
        data: ville,
        dataType: "json",

        success: function (data)
        {
            console.log(data);

            // initialise une variable sHtml
            // dans laquelle on va construire le HTML �  afficher
            // dans notre cas les '<option></option>' de la liste déroulante 'departements'
            let sHtml = "<option value=''>-- Sélectionnez un lieu --</option>\n";

            // on boucle sur le JSON : chaque itération = une <option> du 'select' avec un département
            $.each(data, function(key, val) {
                sHtml += "<option value='"+val.id+"'>"+val.nom+"</option>\n";
            });

            // après la boucle, on a une chaîne qui contient du code HTML
            // Il ne reste plus qu'�  injecter ce HTML dans le formulaire
            $("#sortie_lieu").html(sHtml);
        }
    });

});