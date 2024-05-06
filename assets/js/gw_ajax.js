//==============================================================================
const show = (element, visible) =>
{
    if (visible)
    {
        element.classList.remove('hidden');
    }   
    else
    {
        element.classList.add('hidden');
    }
}
//==============================================================================
const hideById = (id) =>
{
    show(document.getElementById(id), false);
}
//==============================================================================
const showById = (id) =>
{
    show(document.getElementById(id), true);
}
//==============================================================================
const populateSelect = (targetselect, items) =>
{
    targetselect.options.length = 0;
    for (let i = 0; i < items.length; i++) 
    {
        let opt = document.createElement('option');
        opt.value= items[i].val;
        opt.innerHTML = items[i].txt;
        targetselect.appendChild(opt);
    }        
}
//==============================================================================
const ajaxBusy =  () =>
{
    
}
//==============================================================================
const ajaxReady =  () =>
{
    
}
//==============================================================================
const showMsg = (html, error) =>
{
    const usermsg = document.getElementById((error?'error':'user')+'-msg');
    usermsg.innerHTML = html;
    show(usermsg,true);
}
//==============================================================================
const showErrorMsg = (msg) =>
{
    hideById('user-msg');
    showMsg(msg, true);
}
//==============================================================================
const showUserMsg = (msg) => 
{
    showMsg(msg, false);
}
//==============================================================================
async function ajaxGet(url, responsetype, callback_succes, callback_fail)
{
    let response = await fetch(
        url, 
        {
            method: 'GET',
        }
    );
    if (response.ok) // if HTTP-status is 200-299
    { 
        let result = '';   
        switch (responsetype)
        {
            case 'json' :    
                result = await response.json();
                break;
            case 'xml' :    
                data = await response.text();
                const parser = new DOMParser();
                result = parser.parseFromString(data, "application/xml");
                break;
            default:
                result = await response.text();
        }
        callback_succes(result);
    } 
    else
    {
        let error = await response.text();
        callback_fail(error);
    }    
}
//==============================================================================
async function ajaxPost(url, responsetype, data, callback_succes, callback_fail)
{
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
        switch (responsetype)
        {
            case 'json' :    
                result = await response.json();
                break;
            case 'xml' :    
                data = await response.text();
                const parser = new DOMParser();
                result = parser.parseFromString(data, "application/xml");
                break;
            default:
                result = await response.text();
        }        
        callback_succes(result);
    } 
    else
    {
        callback_fail(response.statusText);
    }    
}

const updateElement = (element_info) =>
{
    const target_element = document.querySelector(element_info.target);
    if (target_element)
    {
        target_element.innerHTML = element_info.content;
        if ("undefined" !== typeof element_info.addclass && element_info.addclass !== '')
        {
            target_element.classList.add(element_info.addclass);
        }
        else
        {    
            show(target_element, true);
        }    
    }   
    else
    {
        console.log(element_info.target + ' not found');
    }    
};


