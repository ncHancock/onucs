var primary;

function onLoad()
{
  getPrimary(false);
  //$(".newValue").hide();
}

function ajaxInsertPrimary(method, DmgID, Name, Slash, Puncture, Impact, Trigger, FireRate, Critical, Status)
{
  return $.ajax({
    url: 'ShadyAPI.php',
    type: 'POST',
    data: {method: method,
      DmgID: DmgID,
      Name: Name,
      Slash: Slash,
      Puncture: Puncture,
      Impact: Impact,
      Trigger: Trigger,
	  FireRate: FireRate,
	  Critical: Critical,
	  Status: Status
    }
  });
}

function insertPrimary()
{
  var DmgID, Name, Slash, Puncture, Impact, Trigger, FireRate, Critical, Status;
  DmgID = JSON.stringify($('#Dmg option:selected').val());
  Name = JSON.stringify($('#Name').val());
  Slash = JSON.stringify($('#Slash').val());
  Puncture = JSON.stringify($('#Puncture').val());
  Impact = JSON.stringify($('#Impact').val());
  Trigger = JSON.stringify($('#Trigger').val());
  FireRate = JSON.stringify($('#FireRate').val());
  Critical = JSON.stringify($('#Critical').val());
  Status = JSON.stringify($('#Status').val());
  ajax = ajaxInsertprimary("insertprimary", DmgID, Name, Slash, Puncture, Impact, Trigger, FireRate, Critical, Status);
  ajax.done(insertPrimaryCallback);
  ajax.fail(function () {
    alert("Failure1");
  });
  getPrimary();
}

function insertPrimaryCallback(response_in)
{
  response = JSON.parse(response_in);
  if (!response['success'])
  {
    $("#results").html("");
    alert("Insert failed on query:" + '\n' + response['querystring']);
  } else
  {
    $("#results").html(response['credentials'] + '<br>' +
            response['querystring'] + '<br>' +
            response['success'] + '<br>');
    getPrimary();

  }
}

function showPrimary(primary)
{
  var primaryList = "";

  $.each(primary, function (key, value)
  {
    var itemString = "";
    $.each(value, function (key, item)
    {
      itemString += item + "&nbsp &nbsp &nbsp";
    });
    primaryList += itemString + '<br>';
  });

  $("#results").html(primaryList);
}

function getPrimary(async)
{
  ajax = ajaxgetPrimary("getPrimary", async);
  ajax.done(getPrimaryCallback);
  ajax.fail(function () {
    alert("Failure2");
  });
}

function ajaxgetPrimary(method, async)
{
  return $.ajax({
    url: 'ShadyAPI.php',
    type: 'POST',
	async: async,
    data: {method: method
    }
  });
}

function getPrimaryCallback(response_in)
{
	alert("failure")
  var response = JSON.parse(response_in);
  primary = response["primary"];
  if (!response['success'])
  {
    $("#results").html("getPrimary failed");
  } else
  {
    $('#Dmg').find('option').remove();
    showprimary($primary);
    $.each($primary,
            function (key, primary)
                    /* 
                     * - key is the zero based position in the array
                     * - value is the entire row in the table
                     * - we want the value returned from selecting to be the
                     *   primary id -- position 0 in the row
                     * - we want the value that is displayed in the select
                     *   control to be the name of the primary -- zero based
                     *   position 2 in the row  Therefore:
                     */
                    {
                      $("#Dmg")
                              .append($('<option>',
                                      {
                                        value: primary[0].toString(),
                                        text: primary[2].toString()
                                      }));

                    }
            )
                    ;
          }
}


function updateprimary()
{
  var Dmg, Name, Slash, Puncture, Impact, Trigger,
      newDmg, newName, newSlash, newPuncture, newImpact, newTrigger;
  Dmg = JSON.stringify($('#Dmg option:selected').val());
  Name = JSON.stringify($('#Name').val());
  Slash = JSON.stringify($('#Slash').val());
  Puncture = JSON.stringify($('#Puncture').val());
  Impact = JSON.stringify($('#Impact').val());
  Trigger = JSON.stringify($('#Trigger').val());
  FireRate = JSON.stringify($('#FireRate').val());
  Critical = JSON.stringify($('#Critical').val());
  Status = JSON.stringify($('#Status').val());
  newDmg = JSON.stringify($('#newDmg option:selected').val());
  newName = JSON.stringify($('#newName').val());
  newSlash = JSON.stringify($('#newSlash').val());
  newPuncture = JSON.stringify($('#newPuncture').val());
  newImpact = JSON.stringify($('#newImpact').val());
  newTrigger = JSON.stringify($('#newTrigger').val());
  newFireRate = JSON.stringify($('#newFireRate').val());
  newCritical = JSON.stringify($('#newCritical').val());
  newStatus = JSON.stringify($('#newStatus').val());
  
  ajax = ajaxupdateprimary("updateprimary", newDmg, newName, newSlash, 
                                           newPuncture, newImpact, newTrigger, newFireRate, newCritical, newStatus);
  ajax.done(updateprimaryCallback);
  ajax.fail(function () {
    alert("Failure3");
  });
}

function ajaxupdateprimary(method)
{

  return $.ajax({
    url: 'ShadyAPI.php',
    type: 'POST',
    data: {method: method
    }
  });
}

function updateprimaryCallback(response_in)
{
  response = JSON.parse(response_in);
  $primary = response["primary"];
  if (!response['success'])
  {
    $("#results").html("updateprimary failed");
  } else
  {
    $("#results").html(response['querystring']);
    $primary = getPrimary();
    showprimary($primary);
  }
}
