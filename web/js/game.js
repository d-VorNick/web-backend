const bodyElement = document.getElementById('wrapper');
const u1 = document.getElementById('unit1');
const u2 = document.getElementById('unit2');


//const unit = document.getElementById('unit1');

//const ws = new WebSocket('wss://web-server-sem2:8443');
const ws = new WebSocket('ws://localhost:8443');

$.fn.hasAttr = function(name) {
    return this.attr(name) !== undefined && this.attr(name) !== false;
};

$('.unit').click(function (e) {

    //$(this).css('background-color', 'red');
    //$(this).prop("disabled",true);
    $(this).addClass('move');

    let id;
    let ready;
    let prep = false;
    if ($(this).attr('id') === 'unit1') {
        id = 'first_choice';
        ready = 'cactus';
        if (!$('#unit2').hasAttr('disabled')) {
            $('#unit2').prop("disabled", true);
        } else {
            prep = true;

        }
    } else {
        if (!$('#unit1').hasAttr('disabled')) {
            $('#unit1').prop("disabled", true);
        } else {
            prep = true;

        }
        id = 'second_choice';
        ready = 'cactus2';
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
        location: location.pathname.split('/')[2],
        ready: ready,
    };

    ws.send(JSON.stringify(data));
    if (prep) {
        prepareSrv();
    }
});



document.addEventListener('keyup', event => {
    let unit = $('.move');
    unit.css('top', unit.css('top') ? unit.css('top') : 0);
    unit.css('left', unit.css('left') ? unit.css('left') : 0);
    let top = unit.css('top');
    let left = unit.css('left');
    const step = 5;


    /* Для кружков
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
    };*/

    if (event.code === 'ArrowUp') {
        jump(unit);
        let positionData = {
            side: unit.attr('id'),
            location: location.pathname.split('/')[2]
        };
        ws.send(JSON.stringify(positionData));
    }

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

function sleep(ms) {
    /*const date = Date.now();
    let curDate = null;
    do {
        curDate = Date.now();
    } while (curDate - date < ms);*/
    return new Promise(resolve => setTimeout(resolve, ms));
}

function prepare() {
    let h = $('#mid-h1');
    h.text('3');
    sleep(1000)
        .then(() => { h.text('2'); })
        .then(() => {
            sleep(1000)
                .then(() => { h.text('1'); })
                .then(() => {
                    sleep(1000)
                        .then(() => { h.text('Игра!'); })
                })
        })
    /*sleep(1000);
    h.text('2');
    sleep(1000);
    h.text('1');
    sleep(1000);
    h.text('Игра!');
    sleep(1000);*/
}

function prepareSrv() {
    let h = $('#mid-h1');
    h.text('3');
    sleep(1000)
        .then(() => { h.text('2'); })
        .then(() => {
            sleep(1000)
                .then(() => { h.text('1'); })
                .then(() => {
                    sleep(1000)
                        .then(() => { h.text('Игра!');
                            $('#cactus').css('animation', 'cactusMov 1s infinite linear');
                            $('#cactus2').css('animation', 'cactusMov 1s infinite linear');
                        })
                })
        })
}

ws.onmessage = response => {
    let positionData = JSON.parse(response.data);

    if ('ready' in positionData && positionData.location === location.pathname.split('/')[2]) {
        console.log(positionData);
        let unit = {};
        if (positionData.ready === 'cactus') {
            unit = $('#unit1');
            if (unit.hasAttr('disabled')) {
                prepareSrv();

            } else {
                unit.prop("disabled", true);
            }
        } else {
            unit = $('#unit2');
            if (unit.hasAttr('disabled')) {
                prepareSrv();

            } else {
                unit.prop("disabled", true);
            }
        }
    }

    if ('finished' in positionData && positionData.finished === location.pathname.split('/')[2]) {
        $('#unit1').css('top', 142);
        $('#unit2').css('top', 142);
        $('#cactus').css('left', 100);
        $('#cactus2').css('left', 100);
        $('#cactus').css('animation', 'none');
        $('#cactus2').css('animation', 'none');
        alert(positionData.msg);
        window.location.pathname = '/contact';
    }

    if ('disconnect' in positionData && positionData.disconnect === location.pathname.split('/')[2]) {
        console.log(positionData);
        alert('Противник вышел!');
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
        let opponent = $('#' + positionData.side)
        /* Для кружков
        opponent.css('top', positionData.top);
        opponent.css('left', positionData.left);*/
        jump(opponent);
    }
}

function jump (dino) {
    if (!dino.hasClass('jump')) {
        dino.addClass('jump');
    }
    setTimeout( function () {
        dino.removeClass('jump');
    }, 300)
}

let isAlive = setInterval( function () {
    let dino1Top = parseInt($('#unit1').css('top'));
    let dino2Top = parseInt($('#unit2').css('top'));
    let cactusLeft = parseInt($('#cactus').css('left'));

    if (cactusLeft < 50 && cactusLeft > 0 && dino1Top >= 144 && dino2Top >= 144) {

        let data = {
            finished: location.pathname.split('/')[2],
            msg: 'Ничья!'
        }
        ws.send(JSON.stringify(data));
        //alert("Ничья!");
        //window.location.pathname = '/contact';
    } else {

        if (cactusLeft < 50 && cactusLeft > 0 && dino1Top >= 144) {
            let data = {
                finished: location.pathname.split('/')[2],
                msg: 'Победил нижний игрок!'
            }
            ws.send(JSON.stringify(data));
            //alert("Победил нижний игрок!");
            //window.location.pathname = '/contact';
        }
        if (cactusLeft < 50 && cactusLeft > 0 && dino2Top >= 144) {
            let data = {
                finished: location.pathname.split('/')[2],
                msg: 'Победил верхний игрок!'
            }

            ws.send(JSON.stringify(data));
            //alert("Победил верхний игрок!");
            //window.location.pathname = '/contact';
        }
    }

}, 10)

ws.onclose = () => {

}