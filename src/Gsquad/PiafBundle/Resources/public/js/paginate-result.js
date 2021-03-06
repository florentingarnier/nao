$(document).ready(function(){

    $('#form_search').on('click', function() { // When click on an element in the list
        $('#loading').css("display", "block");
    });

    $('#pagination-container').pagination({
        dataSource: datas,
        pageSize: 9,
        className: 'paginationjs-theme paginationjs-small',
        callback: function(data, pagination) {
            var html = simpleTemplating(data);
            $('#data-container').html(html);
        }
    });

    function simpleTemplating(data) {
        var html = '<hr/>';
        html += '<div id="fiches-area">';

        $.each(data, function(index, item){
            html += '<div class="col-sm-6 col-md-4 text-center fiche">';
            html += '<div class="cover">';
            html += '<img class="img-observation" src="' + data[index][0] + '" />';
            html += '</div>';
            html += '<p>Ordre : ' + data[index][1] +'</p>';
            html += '<p>Famille : ' + data[index][2] +'</p>';
            html += '<p>Nom vulgaire : ' + data[index][3] +'</p>';
            html += '<p>Nom vulgaire anglais : ' + data[index][4] +'</p>';
            html += '<p>Nom scientifique : ' + data[index][5] +'</p>';
            html += '<p>Habitat : ' + data[index][6] +'</p>';
            if(data[index][7] > 0) {
                html += '<p>' + data[index][7] +' résultat(s)</p>';
            }
            html += '<p><a class="button" href="' + data[index][8] + '">Voir les observations</a></p>';
            html += '</div>';
        });

        html += '</div>';
        return html;
    }


});