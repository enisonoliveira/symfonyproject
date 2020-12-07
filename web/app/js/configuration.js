
//Pusher.log = function (msg) {
//    console.log(msg);
//};

// SCROLL TO TOP
$(function () {
    $(window).scroll(function () {
        if ($(this).scrollTop() > 150) {
            $('#toTop').addClass('show');
        } else {
            $('#toTop').removeClass('show');
        }
    });
});

function mascara(o, f) {
    v_obj = o;
    v_fun = f;
    setTimeout("execmascara()", 1);
}
function execmascara() {
    v_obj.value = v_fun(v_obj.value);
}
function vlMoney(v) {
    v = v.replace(/\D/g, "");
    v = v.replace(/[0-9]{15}/, "invÃ¡lido");
    v = v.replace(/(\d{1})(\d{11})$/, "$1.$2"); // coloca ponto antes dos
    v = v.replace(/(\d{1})(\d{8})$/, "$1.$2"); // coloca ponto antes dos
    v = v.replace(/(\d{1})(\d{5})$/, "$1.$2"); // coloca ponto antes dos
    v = v.replace(/(\d{1})(\d{1,2})$/, "$1,$2"); // coloca virgula antes dos
    return v;
}


document.onclick = function (e) {

    var elem, evt = e ? e : event;
    if (evt.srcElement)
        elem = evt.srcElement;
    else if (evt.target)
        elem = evt.target;
//    alert(elem.id);
    if (elem.id == 'menuAnchor') {
        $('#closeMenu').toggleClass('open');
//        $('#closeMenu').toggleClass('opacity');
        $('#closeMenu').toggleClass('opacity');
        $('#menuAnchor').toggleClass('open');
        $('body').removeClass('searchOpen');
        $('body').removeClass('userOpen');
        $('body').removeClass('alertOpen');
//        $('.alertClose').hide();
        $('body').toggleClass('menuOpen');
        $('nav#menu > ul > li.has-children').removeClass('open');

    } else
    if (elem.id == 'closeMenu') {
        $('body').removeClass('alertOpen');
        $('body').removeClass('userOpen');
        $('#menuAnchor').removeClass('open');
        $('body').removeClass('searchOpen');
        $('body').removeClass('alertOpen');
        $('body').removeClass('menuOpen');
        $('#menuAnchor').removeClass('open');
        $('#closeMenu').removeClass('opacity');
        $('#closeMenu').removeClass('open');
        $('nav#menu > ul > li.has-children').removeClass('open');

    } else
    if (elem.id == 'alertsAnchor') {
        $('body').toggleClass('alertOpen');
        $('body').removeClass('userOpen');
        $('#menuAnchor').removeClass('open');
        $('body').removeClass('open');
        $('body').removeClass('menuOpen');
        $('#menuAnchor').removeClass('open');
        $('nav#menu > ul > li.has-children').removeClass('open');
        $('body').removeClass('searchOpen');
        setTimeout(function () {
            $('#closeMenu').removeClass('opacity');
            $('#closeMenu').removeClass('open');
        }, 15);
    } else
    if (elem.id == 'togle') {
    } else
    if (elem.id == 'accountAnchor') {
        $('body').toggleClass('userOpen');

        $('#menuAnchor').removeClass('open');
        $('body').removeClass('alertOpen');
        $('body').removeClass('open');
//        $('.alertClose').hide();
        $('body').removeClass('menuOpen');
        $('#menuAnchor').removeClass('open');
        $('nav#menu > ul > li.has-children').removeClass('open');
        $('body').removeClass('searchOpen');
        setTimeout(function () {
            $('#closeMenu').removeClass('opacity');
            $('#closeMenu').removeClass('open');
        }, 15);
    } else
    if (elem.id == 'imagemuser') {
        $('body').toggleClass('userOpen');

        $('#menuAnchor').removeClass('open');
        $('body').removeClass('alertOpen');
        $('body').removeClass('open');
//        $('.alertClose').hide();
        $('body').removeClass('menuOpen');
        $('#menuAnchor').removeClass('open');
        $('nav#menu > ul > li.has-children').removeClass('open');
        $('body').removeClass('searchOpen');
        setTimeout(function () {
            $('#closeMenu').removeClass('opacity');
            $('#closeMenu').removeClass('open');
        }, 15);
    } else
    if (elem.id == 'searchAnchor') {
        $('body').toggleClass('searchOpen');

        $('#menuAnchor').removeClass('open');
        $('body').removeClass('userOpen');
        $('body').removeClass('alertOpen');
        $('body').removeClass('open');
        $('body').removeClass('menuOpen');
        $('#menuAnchor').removeClass('open');
        $('nav#menu > ul > li.has-children').removeClass('open');

        setTimeout(function () {
            $('#closeMenu').removeClass('opacity');
            $('#closeMenu').removeClass('open');
        }, 15);
    } else
    if (elem.id == 'autocomplete') {
        $('body').removeClass('searchOpen');
        $('#menuAnchor').removeClass('open');
        $('body').removeClass('userOpen');
        $('body').removeClass('alertOpen');
        $('body').removeClass('open');
        $('body').removeClass('menuOpen');
        $('body').removeClass('searchOpen');
        $('#menuAnchor').removeClass('open');
        $('nav#menu > ul > li.has-children').removeClass('open');

        setTimeout(function () {
            $('#closeMenu').removeClass('opacity');
            $('#closeMenu').removeClass('open');
        }, 15);
    } else
    if (elem.id == 'toTop') {

        var $doc = $('html, body');
        $doc.animate({
            scrollTop: $("body").offset().top
        }, 500);
        return false;

    } else if (elem.id == 'alertClose_alerts') {
        $('#menuAnchor').removeClass('open');
        $('body').removeClass('userOpen');
        $('body').removeClass('alertOpen');

    } else if (elem.id == 'userBoxClose_user') {
        $('body').removeClass('userOpen');
        $('body').removeClass('userOpen');
        $('body').removeClass('alertOpen');

    } else {

    }

}
;

function scrollPrevent(e) {
    $('.owl-carousel').bind('touchmove', function (e) {
        var touch = e.originalEvent.touches[0] || e.originalEvent.changedTouches[0];
        window.addEventListener('touchmove', function () {})
    });
}
function scrollBack(e) {
    $('.owl-carousel').unbind('touchmove');
}
window.addEventListener('touchmove', function () {})
