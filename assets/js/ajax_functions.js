
function changeFavoriteStatus() {
    
}

/* INIT */
const initPage = () => {
    console.log('initAJAXPage');
    document.getElementById('favorite_heart').addEventListener('click', changeFavoriteStatus);
}

(function (fn) {
    if (document.readyState === "complete" || document.readyState === "interactive") {
        // call on next available tick
        setTimeout(fn, 1);
    }
    else {
        document.addEventListener("DOMContentLoaded", fn);
    }
}(initPage));