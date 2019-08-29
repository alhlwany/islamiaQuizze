//DATA TABLE FILTER...............>
$('table.data').DataTable(
        {
            "aaSorting": [],
            "stateSave": true
        }
);
//Menu Clik Slider..................>
(function()
{
        var navTopPadding=parseInt($('nav.main_navigation').css('padding-top'),10);
        var navBottomPadding=parseInt($('nav.main_navigation').css('padding-bottom'),10);
        var navHeightToExclude=navTopPadding+navBottomPadding;
        $('nav.main_navigation').height($(window).height()-$('header.main').height()-navHeightToExclude-1);
        
        var contentTopPadding=parseInt($('div.action_view').css('padding-top'),10);
        var contentBottomPadding=parseInt($('div.action_view').css('padding-top'),10);
        var contentHeightToExclude=contentTopPadding+contentBottomPadding;
        $('div.action_view').height($(window).height()-$('header.main').height()-contentHeightToExclude-1);       
        if (getCookie('menu_opened')=="true") {
            $('a.menu_switch').attr('data-menu-status','true');
            $('a.menu_switch').addClass('opened');
            $('nav.main_navigation').addClass('opened');
            $('div.action_view').addClass('collapsed');
        }
        })();
$('a.menu_switch').click(function(evt)
{
    evt.preventDefault();
    if ($(this).attr('data-menu_status')=='false') {
     $(this).attr('data-menu_status','true');
     $(this).addClass('opened');
     $('nav.main_navigation').addClass('opened');
     $('div.action_view').addClass('collapsed');
     if (getCookie('menu_opened')==""){
         setCookie('menu_opened',true,180,'http://inventory.eg:8080')
     }
}else {
    $(this).attr('data-menu_status','false');
    $(this).removeClass('opened');
    $('nav.main_navigation').removeClass('opened');
    $('div.action_view').removeClass('collapsed');
    deleteCookie('menu_opened','http://inventory.eg:8080');
    }
});
//Float Label .....................................................>
$('form.appForm input:not(.no_float)').on('focus', function ()
{
    $(this).parent().find('label').addClass('floated');
}).on('blur', function ()
{
    if ($(this).val() == '') {
        $(this).parent().find('label').removeClass('floated');
    } else {

    }
});

///////////////////////////////////////////////////////

$('div.radio_button, div.checkbox_button, label.radio span, label.checkbox span, a.language_switch.user').click(function (evt)
{
    evt.stopPropagation();
});

// setTimeout(function()
// {
//     $('p.message').fadeOut();
// }, 5000);

(function ()
{
    var closeMessageButtons = document.querySelectorAll('p.message a.closeBtn');
    for (var i = 0, ii = closeMessageButtons.length; i < ii; i++) {
        closeMessageButtons[i].addEventListener('click', function (evt) {
            evt.preventDefault();
            this.parentNode.parentNode.removeChild(this.parentNode);
        }, false);
    }
})();

$(document).click(function ()
{
    $('ul.user_menu').hide();
})

$('a.language_switch.user').click(function (evt)
{
    evt.preventDefault();
    $('ul.user_menu').toggle();
})

$('li.submenu > a').click(function ()
{
    $('li.submenu > ul').not($(this).next()).slideUp();
    $('li.submenu').not($(this).parent()).removeClass('selected')
    $(this).next().slideToggle();
    if ($(this).parent().hasClass('selected')) {
        $(this).parent().removeClass('selected')
    } else {
        $(this).parent().addClass('selected')
    }
});

(function ()
{
    var userNameField = document.querySelector('input[name=Username]');
    if (null !== userNameField) {
        userNameField.addEventListener('blur', function ()
        {
            var req = new XMLHttpRequest();
            req.open('POST', 'http://inventory.eg:8080/users/checkuserexistsajax');
            req.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

            req.onreadystatechange = function ()
            {
                var iElem = document.createElement('i');
                if (req.readyState == req.DONE && req.status == 200) {
                    if (req.response == 1) {
                        iElem.className = 'fa fa-times error';
                    } else if (req.response == 2) {
                        iElem.className = 'fa fa-check success';
                    }
                    var iElems = userNameField.parentNode.childNodes;
                    for (var i = 0, ii = iElems.length; i < ii; i++)
                    {
                        if (iElems[i].nodeName.toLowerCase() == 'i') {
                            iElems[i].parentNode.removeChild(iElems[i]);
                        }
                    }
                    userNameField.parentNode.appendChild(iElem);
                }
            }

            req.send("Username=" + this.value);
        }, false);
    }
})();
    