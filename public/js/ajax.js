/** -------------------------------------------------------
 * app.js
 * --------------------------------------------------------- */

// Initialise jQuery
$(document).ready(function()
{
    // Quand changement sur le 1er select 'regions'
    $("#regions").change(function()
    {
        // Régions sélectionnées (attribut 'value' de l'option cliquée dans le select #regions)
        const reg_id_selected = $("#regions").val();

        // console.log(reg_id_selected);

        $.post({
            // Envoie la requête Ajax vers un fichier PHP de traitement
            url: "post_departements.php",

            // Valeurs �  transmettre au fichier PHP
            // Attention : cette propriété 'data' ici n'a rien �  voir avec l'argument 'data' du 'success' ligne 24 ci-après
            // Syntaxe : liste des paramètres : nom:valeur
            // Les noms ('reg_id' dans notre cas) envoyés ici sont ceux récupérés avec $_POST dans le fichier PHP
            data: { 'reg_id_envoye' : reg_id_selected },
            // Exemple pour la syntaxe pour plusieurs paramètres :
            // data: { 'param_1' : 'value_1', 'param_2' : uneVariableJs, 'param_3' : 789 },

            // Spécifie que le PHP doit retourner du JSON (produira une erreur si ce n'est pas le cas)
            dataType: "json",

            // Succès de la requête Ajax
            // le paramètre 'data' (nom libre) contient le 'echo' retourné par le PHP
            success: function(data)
            {
                // console.log(data);

                // initialise une variable sHtml
                // dans laquelle on va construire le HTML �  afficher
                // dans notre cas les '<option></option>' de la liste déroulante 'departements'
                let sHtml = "<option value=''>-- Sélectionnez un département --</option>\n";

                // on boucle sur le JSON : chaque itération = une <option> du 'select' avec un département
                $.each(data, function(key, val) {
                    sHtml += "<option value='"+val.dep_id+"'>"+val.dep_id+" - "+val.dep_nom+"</option>\n";
                });

                // après la boucle, on a une chaîne qui contient du code HTML
                // Il ne reste plus qu'�  injecter ce HTML dans le formulaire
                $("#departements").html(sHtml);
            }
        });
    });
});