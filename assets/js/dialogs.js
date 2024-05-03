//CREATE DIALOG:
var gwprompt = new GWDialog();

//==============================================================================
async function ajaxPost(url, responsetype, data, callback_succes, callback_fail) {
    let response = await fetch(
        url,
        {
            method: 'POST',
            body: data
        }
    );
    if (response.ok) // if HTTP-status is 200-299
    {
        let result = '';
        switch (responsetype) {
            case 'json':
                result = await response.json();
                break;
            case 'xml':
                data = await response.text();
                const parser = new DOMParser();
                result = parser.parseFromString(data, "application/xml");
                break;
            default:
                result = await response.text();
        }
        callback_succes(result);
    }
    else {
        callback_fail(response.statusText);
    }
}


/* SOME DIALOG OPTIONS */
const ok_msg_options = (msg) => {
    return {
        title: 'Ok',
        ok_txt: 'Ok',
        body: '<div class="alert">' + msg + '</div>',
        cancel_func: 'NOP',
        width: 400
    };
};

const error_msg_options = (msg) => {
    return {
        title: 'Error',
        ok_txt: 'Ok',
        body: '<div class="alert alert-danger">' + msg + '</div>',
        cancel_func: 'NOP',
        width: 400
    };
};

const edit_name_options = (title, name) => {
    return {
        title: title,
        ok_txt: 'Geef een naam',
        ok_func: 'saveName',
        cancel_txt: 'Cancel',
        cancel_func: '',
        body: '<input type="text" class="gw-dialog-value form-control" name="newname" value="' + name + '"/>'
            + '<input type="hidden" class="gw-dialog-value form-control" name="name" value="' + name + '" />'
    };
};

const add_to_list_options = (recipe) => {
    return {
        title: recipe + ' toegevoegd aan boodschappenlijst',
        cancel_func: 'NOP',
        body: '<div class="alert alert-succes">'
            + '<p>Je kunt je boodschappenlijst terugvinden via het menu bovenaan de pagina.</p>'
            + '<p>(maar je boodschappen staan er nog niet op want nog geen AJAX toegevoegd)</p>'
            + '</div>',
    };
};

const toggle_favorite_options = (response_text) => {
    return {
        title: response_text,
        cancel_func: 'NOP',
        body: '<div class="alert alert-succes">'
            + '<p>Je kunt je favorieten terugvinden via het menu bovenaan de pagina.</p>'
            + '</div>',
    };
};

const not_logged_favorite_options = () => {
    return {
        title: 'Log in om iets aan je favorieten toe te voegen',
        cancel_func: 'NOP',
        body: '<div class="alert alert-succes">'
            + '<p>Je vindt het inlog formulier aan de linkerkant, onder de Agenda.</p>'
            + '</div>',
    };
};

/* OK CALLBACK */
function saveName(data) {
    if (data.newname == null || data.newname == "") {
        console.log("User cancelled.");
        return;
    }
    formData = new FormData();
    for (const property in data) {
        formData.append(property, data[property]);
    }
    ajaxPost(
        'dialogs.php?ajax=1',
        'html',
        formData,
        function (response_data) {
            gwprompt.show(ok_msg_options(response_data));
        },

        function (error) {
            gwprompt.show(error_msg_options(error));

        }
    );
}

/* SHOW DIALOG */
function editName() {
    const name = 'Mag geen naam hebben';
    gwprompt.show(edit_name_options('Edit', name));
}

function addToList() {
    const recipe = document.getElementById('recipe-title').innerHTML;
    gwprompt.show(add_to_list_options(recipe));
}


/* INIT */
const initPage = () => {
    console.log('initPage');
    // document.getElementById('show-dlg').addEventListener('click', editName);
    document.getElementById('add-to-list').addEventListener('click', addToList);
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

