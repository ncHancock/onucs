var DmgID;
var Primary;




function onLoad() {
    //alert("In onLoad()");

    getDmgCategories(false);
    getPrimary(false);

}






function insertPrimary() {
    var DmgID,
        Name,
        Slash;
        Puncture;
		Impact;
    DmgID = JSON.stringify($('#Dmg option:selected').val());
    Name = JSON.stringify($('#Name').val());
    Slash = JSON.stringify($('#Slash').val());
    Puncture = JSON.stringify($('#Puncture').val());
	Impact = JSON.stringify($('#Impact').val());
    ajax = ajaxinsertPrimary("insertPrimary", DmgID, Name, Slash, Puncture, Impact);
    ajax.done(insertPrimaryCallback);
    ajax.fail(function() {
        alert("Failure");
    });
}

function ajaxinsertPrimary(method, DmgID, Name, Slash, Puncture, Impact) {
    return $.ajax({
        url : 'databaseoperations.php',
        type : 'POST',
        data : {
            method : method,
            DmgID : DmgID,
            Name : Name,
            Slash : Slash,
			Puncture Puncture,
            Impact: Impact
        }
    });
}

function insertPrimaryCallback(response_in) {
    response = JSON.parse(response_in);

    if (!response['success']) {
        $("#results").html("");
        alert("Insert failed on query:" + '\n' + response['querystring']);
        getPrimary(false);
        getDmgCategories(false);
    } else {
        $("results").html(response['querystring'] + '<br>' + response['success'] + '<br>');
        getPrimary(false);
        getDmgCategories(false);
    }
}

function showPrimary(Primary) {
    //alert("In showSeries()");
    //alert(Series);
    var PrimaryList = "";
    $.each(Primary, function(key, value) {
        var itemString = "";
        $.each(value, function(key, item) {
            itemString += item + "\t \t";
        });
        PrimaryList += itemString + '<br>';
    });
    $("#results").html(PrimaryList);
}

function getPrimary() {
    //alert("In getSeries()");
    ajax = ajaxgetPrimary("getPrimary");
    ajax.done(getPrimaryCallback);
    ajax.fail(function() {
        alert("Failure");
    });
}

function ajaxgetPrimary(method) {
    //alert("In ajaxgetSeries()");
    return $.ajax({
        url : 'databaseoperations.php',
        type : 'POST',
        data : {
            method : method
        }
    });
}

function getPrimaryCallback(response_in) {
    //alert(response_in);
    var response = JSON.parse(response_in);
    Primary = response["Primary"];
    if (!response['success']) {
        $("#results").html("getPrimary() failed");
    } else {
        showPrimary(Primary);
    }
}

function getDmgCategories() {
    //alert("In getPublishers()");
    ajax = ajaxgetDmgCategories("getDmgCategories");
    ajax.done(getDmgCategoriesCallback);
    ajax.fail(function() {
        alert("Failure");
    });
}

function ajaxgetDmgCategories(method) {
    //alert("In ajaxgetPublishers()");
    return $.ajax({
        url : 'databaseoperations.php',
        type : 'POST',
        data : {
            method : method
        }
    });
}

function getDmgCategoriesCallback(response_in) {
    //alert("In getPublishersCallback()");
    //alert(response_in);
    response = JSON.parse(response_in);
    $DmgID = response["DmgID"];
    //alert($Publisher);
    if (!response['success']) {
        alert('Failed in getDmgCategoriesCallback');
        $("#results").html("getDmgCategories failed");
    } else {
        $('#DmgID').find('option').remove();
        //alert($Publisher);
        $.each($DmgID, function(key, columns) {
            $("#DmgID").append($('<option>', {
                //value : columns[0].toString(),
                text : columns[1].toString()
            }));
        });
    }
}
