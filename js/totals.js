
var totalin = 0;
var transout = 0;
var totalexpense = 0;
var overheadtotal = 0;
function updateTinTotal() {
    var myTin = document.getElementsByName('amountInputsTIN[]');
    var tintotal = 0;
    for (var i = 0; i < myTin.length; i++) {
        if (parseFloat(myTin[i].value))
            tintotal += parseFloat(myTin[i].value);
    }

    totalin = +(Math.round(totalin + "e+2") + "e-2");
    totalin = tintotal
    tintotal = tintotal.toFixed(2);
    var tinstring = "Total: $" + tintotal;
    var otherstring = "$" + tintotal;

    document.getElementById('totalTIN').innerHTML = tinstring;
    document.getElementById('TINResAmt').innerHTML = otherstring;

    calcNet();
}
function updateToutTotal(){
    var myTout = document.getElementsByName('amountInputsTOUT[]');
    var toutotal = 0;

    for (var i = 0; i < myTout.length; i++) {
        if(parseFloat(myTout[i].value))
            toutotal += parseFloat(myTout[i].value);
    }

    toutotal = +(Math.round(toutotal + "e+2") + "e-2");
    transout = toutotal;
    toutotal = toutotal.toFixed(2);
    var toutstring = "Total: $" + toutotal;
    var otherstring = "$" + toutotal;

    document.getElementById('totalTOUT').innerHTML = toutstring;
    document.getElementById('TOUTResAmt').innerHTML = otherstring;

    calcOverhead();
}
function calcOverhead(){
    var x = totalexpense + transout;
    x = x * 0.028;
    x = +(Math.round(x + "e+2") + "e-2");
    overheadtotal = x;
    x = x.toFixed(2);
    totalstring = "$" + x;
    document.getElementById('OverheadResAmt').innerHTML = totalstring;

    calcNet();
}
function updateExpenseTotal() {
    var arr = document.getElementsByName('amountInputsOTHER[]');
    var equip = document.getElementById('equipment');
    var improv = document.getElementById('improvements');
    var cont = document.getElementById('contingencies');

    var total = 0;

    if (parseFloat(equip.value))
        total += parseFloat(equip.value);
    if (parseFloat(improv.value))
        total += parseFloat(improv.value);
    if (parseFloat(cont.value))
        total += parseFloat(cont.value);

    for (var i = 0; i < arr.length; i++) {
        if (parseFloat(arr[i].value))
            total += parseFloat(arr[i].value);
    }

    total = +(Math.round(total + "e+2") + "e-2");
    totalexpense = total;

    total = total.toFixed(2);
    var totalstring = "Total: $" + total;
    var otherstring = "$" + total;

    document.getElementById('expenseTotal').innerHTML = totalstring;
    document.getElementById('ExpensesResAmt').innerHTML = otherstring;

    calcOverhead();
}
function calcNet() {
    var netin = totalin;
    var netout = totalexpense + transout + overheadtotal;
    netout = +(Math.round(netout + "e+2") + "e-2");

    var net = netin - netout;
    net = +(Math.round(net + "e+2") + "e-2");

    net = net.toFixed(2);
    netout = netout.toFixed(2);

    var expense = "$" + netout;


    document.getElementById('netres').innerHTML = net;
    document.getElementById('totalExpenseResAmt').innerHTML = expense;
}