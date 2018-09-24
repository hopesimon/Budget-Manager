var counterTIN = 1;
function addAnotherTIN(){
    counterTIN++;
    var inputName = "<h5>Name: &nbsp;&nbsp;<input type = 'text' id = 'TIN name " + counterTIN + "' name = 'nameInputsTIN[]' maxlength='30' placeholder='Enter Name' /></h5>";
    var inputAmount = "<h5>Amount: &nbsp;&nbsp;<input type = 'number' id = 'TIN amount " + counterTIN + "' name = 'amountInputsTIN[]' placeholder='0.00' min='0' step='0.01' onchange='updateTinTotal();' /></h5>";
    var newel = document.createElement('div');
    newel.className = "col-lg-6";
    newel.innerHTML = inputName;
    var otherel = document.createElement('div');
    otherel.className = "col-lg-6";
    otherel.innerHTML = inputAmount;
    document.getElementById('TINRes').appendChild(newel);
    document.getElementById('TINRes').appendChild(otherel);
}

var counterTOUT = 1;
function addAnotherTOUT(){
    counterTOUT++;
    var inputName = "<h5>Name: &nbsp;&nbsp;<input type = 'text' id = 'TOUT name " + counterTOUT + "' name = 'nameInputsTOUT[]' maxlength='30' placeholder='Enter Name'></h5>";
    var inputAmount = "<h5>Amount: &nbsp;&nbsp;<input type = 'number' id = 'TOUT amount " + counterTOUT + "' name = 'amountInputsTOUT[]' min='0' placeholder='0.00' step='0.01' onchange='updateToutTotal();'></h5>";
    var newel = document.createElement('div');
    newel.className = "col-lg-6";
    newel.innerHTML = inputName;
    var otherel = document.createElement('div');
    otherel.className = "col-lg-6";
    otherel.innerHTML = inputAmount;
    document.getElementById('TOUTRes').appendChild(newel);
    document.getElementById('TOUTRes').appendChild(otherel);
}

var counterOTHER = 1;
function addAnotherOTHER(){
    counterOTHER++;
    var inputName = "<h5>Name: &nbsp;&nbsp;<input type = 'text' id = 'OTHER name " + counterOTHER + "' name = 'nameInputsOTHER[]' maxlength='30' placeholder='Enter Name'></h5>";
    var inputAmount = "<h5>Amount: &nbsp;&nbsp;<input type = 'number' id = 'OTHER amount " + counterOTHER + "' name = 'amountInputsOTHER[]' min='0' placeholder='0.00' step='0.01' onchange='updateExpenseTotal();'></h5>";
    var newel = document.createElement('div');
    newel.className = "col-lg-6";
    newel.innerHTML = inputName;
    var otherel = document.createElement('div');
    otherel.className = "col-lg-6";
    otherel.innerHTML = inputAmount;
    document.getElementById('otherRes').appendChild(newel);
    document.getElementById('otherRes').appendChild(otherel);
}