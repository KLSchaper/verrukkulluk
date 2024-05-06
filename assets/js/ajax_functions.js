/* FAVORITE */
const changeFavoriteStatus = () => {
    const heart = document.getElementById('favorite-heart');
    const url = heart.getAttribute('data-vrklk-fav-url');

    if (heart.classList.contains('fa-regular')) {
        heart.setAttribute('data-vrklk-fav-url', url.replace('add', 'remove'));
    } else {
        heart.setAttribute('data-vrklk-fav-url', url.replace('remove', 'add'));
    }

    let xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState == 4) {
            switch (xmlhttp.status) {
                case 200:
                    gwprompt.show(toggle_favorite_options(xmlhttp.responseText));
                    heart.classList.toggle('fa-regular');
                    heart.classList.toggle('fa-solid');
                    break;
                case 401:
                    gwprompt.show(not_logged_options(xmlhttp.responseText));
                    break;
                case 500:
                    gwprompt.show(action_failed_options(xmlhttp.responseText));
                    break;
                default:
                    gwprompt.show(action_failed_options(xmlhttp.status));
            }
        } 
    };
    xmlhttp.open("GET", url);
    xmlhttp.send();
}

/* ADD TO LIST */
const addToShoppingList = () => {
    const add_button = document.getElementById('add-to-list');
    const url = add_button.getAttribute('data-vrklk-add-list-url');
    
    let xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4) {
            switch (xmlhttp.status) {
                case 200:
                    gwprompt.show(add_to_list_options(xmlhttp.responseText));
                    break;
                case 500:
                    gwprompt.show(action_failed_options(xmlhttp.responseText));
                    break;
                default:
                    gwprompt.show(action_failed_options(xmlhttp.statusText));
            }
        } 
    };
    xmlhttp.open("GET", url);
    xmlhttp.send();
}

/* INIT */
const initAJAXPage = () => {
    console.log('initAJAXPage');
    document.getElementById('favorite-heart').addEventListener('click', changeFavoriteStatus);
    document.getElementById('add-to-list').addEventListener('click', addToShoppingList);
}

(function (fn) {
    if (document.readyState === "complete" || document.readyState === "interactive") {
        // call on next available tick
        setTimeout(fn, 1);
    }
    else {
        document.addEventListener("DOMContentLoaded", fn);
    }
}(initAJAXPage));