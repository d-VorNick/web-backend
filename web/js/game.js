const bodyElement = document.getElementById('wrapper');
const u1 = document.getElementById('unit1');
const u2 = document.getElementById('unit2');


//const unit = document.getElementById('unit1');

//const ws = new WebSocket('wss://web-server-sem2:8443');
const ws = new WebSocket('ws://localhost:8443');

$('.unit').click(function (e) {
    $(this).css('background-color', 'red');
    $(this).prop("disabled",true);
    $(this).addClass('move');
    $(this).siblings().prop("disabled",true);
    let id;
    if ($(this).attr('id') === 'unit1') {
        id = 'first_choice';
    } else {
        id = 'second_choice';
    }
    $.ajax({
        method: 'GET',
        url: '/room/make-choice',
        data: {
            'id': id,
            'room': location.pathname.split('/')[2]
        },
        dataType: 'json'
    }).done(function(response) {
    });

    let data = {
        id: $(this).attr('id'),
        top: $(this).css('top'),
        left: $(this).css('left'),
        location: location.pathname.split('/')[2]
    };

    ws.send(JSON.stringify(data));
});



document.addEventListener('keyup', event => {
    let unit = $('.move');
    unit.css('top', unit.css('top') ? unit.css('top') : 0);
    unit.css('left', unit.css('left') ? unit.css('left') : 0);
    let top = unit.css('top');
    let left = unit.css('left');
    const step = 5;

    if (event.code === 'ArrowUp') {
        unit.css('top', parseInt(top) - step + 'px');
    } else if (event.code === 'ArrowDown') {
        unit.css('top', parseInt(top) + step + 'px');
    } else if (event.code === 'ArrowLeft') {
        unit.css('left', parseInt(left) - step + 'px');
    } else if (event.code === 'ArrowRight') {
        unit.css('left', parseInt(left) + step + 'px');
    }

    let positionData = {
        top: unit.css('top'),
        left: unit.css('left'),
        side: unit.attr('id'),
        location: location.pathname.split('/')[2]
    };

    ws.send(JSON.stringify(positionData));
});

$(window).on('unload', function () {
    ws.send(JSON.stringify({disconnect: location.pathname.split('/')[2]}));
});


$(window).on('beforeunload', function () {
    $.ajax({
        method: 'GET',
        url: '/room/clear-room',
        data: {
            'room': location.pathname.split('/')[2]
        },
        dataType: 'json'
    }).done(function(response) {
    });
});


ws.onmessage = response => {
    let positionData = JSON.parse(response.data);

    if ('disconnect' in positionData && positionData.disconnect === location.pathname.split('/')[2]) {
        alert('Противник вышел, вы победили');
        window.location.pathname = '/contact';
        /*$.ajax({
            method: 'GET',
            url: '/room/clear-room',
            data: {
                'room': location.pathname.split('/')[2]
            },
            dataType: 'json'
        }).done(function(response) {
            alert('Противник вышел, вы победили');
            window.location.pathname = '/contact';
        });*/
    }
    console.log(positionData);
    if (positionData.location !== 'rooms' && positionData.location === location.pathname.split('/')[2]) {
        console.log(positionData);
        let unit = {};
        let opponent = $('#' + positionData.side)
        if (positionData.side === 'unit1') {
            unit = $('#unit2');
        } else {
            unit = $('#unit1');
        }
        opponent.css('top', positionData.top);
        opponent.css('left', positionData.left);
        unit.prop("disabled", true);
    }
}

ws.onclose = () => {

}