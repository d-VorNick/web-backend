const ws = new WebSocket('ws://localhost:8443');

$(document).ready(function() {
    $('.btn-player').click(function(e) {
        e.preventDefault();
        $(this).text('Занято');
        $(this).css('background-color', 'gray');
        let $places = $(this).parents().parents().children().eq(1).text().split(' ')[2];
        $places = $places - 1;
        let emptyPlaces = 'Свободных мест ' + $places;
        $(this).parents().parents().children().eq(1).text(emptyPlaces);
        //$('#submitButton').removeAttr('disabled');
        let id = $(this).attr('id');
        let room;
        $.ajax({
            method: 'GET',
            url: '/room/take-place',
            data: {
                'id': id
            },
            dataType: 'json'
        }).done(function(response) {
        });
        $(this).addClass('disabled');
        let data = {
            id: id,
            places: emptyPlaces,
            location: 'rooms'
        };
        let resp;
        ws.send(JSON.stringify(data));
        if (id == 1 || id == 2) {
            room = 1;
            location.pathname = '/room/' + room;
        }
        if (id == 3 || id == 4) {
            room = 2;
            location.pathname = '/room/' + room;
        }
        if (id == 5 || id == 6) {
            room = 3;
            location.pathname = '/room/' + room;
        }
    });
});

ws.onmessage = response => {
    let data = JSON.parse(response.data);
    if (data.location === 'rooms') {
        console.log(data);
        $('#' + data.id).parents().parents().children().eq(1).text(data.places);
        $('#' + data.id).addClass('disabled');
        $('#' + data.id).text('Занято');
    }
    if ('disconnect' in data) {
        let id1;
        let id2;
        switch (data.disconnect) {
            case '1':
                id1 = $('#1');
                id2 = $('#2');
                activateBtn(id1, id2);
                break;

            case '2':
                id1 = $('#3');
                id2 = $('#4');
                activateBtn(id1, id2);
                break;

            case '3':
                id1 = $('#5');
                id2 = $('#6');
                activateBtn(id1, id2);
                break;
        }
    }
}

function activateBtn(id1, id2) {
    id1.text('Игрок 1');
    id1.removeClass('disabled');
    id2.text('Игрок 2');
    id2.removeClass('disabled');
    id2.parents().parents().children().eq(1).text('Свободных мест: 2');
}

