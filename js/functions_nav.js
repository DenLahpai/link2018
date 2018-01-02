//function to expend the menu
function expand_menu() {
    if (document.getElementById('menu-items').style.display == 'block') {
        document.getElementById('menu-items').style.display = 'none';
        document.getElementById('menu-switch').innerHTML = 'Menu';
    }
    else {
        document.getElementById('menu-items').style.display = 'block';
        document.getElementById('menu-switch').innerHTML = 'Close';
    }
};
