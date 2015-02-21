$(document).ready(function(){
    $(".postcode-form").submit(function(event){
        event.preventDefault();
        postcodeSearch();        
    });
});

function postcodeSearch(){
  $.ajax
  ({
    url: wpBaseURL.siteurl + "/constituency.json",
    dataType: "json",
    success: function(data)
    {
      var constituencies = data;
      var userPostcode = document.forms["postcodeSearchForm"]["userpostcode"].value.toUpperCase();
      for(var i = 0; i < constituencies.length; i++)
      {
        if(constituencies[i].postcode == userPostcode)
        {
          var constituency = constituencies[i].constituency;
          displayConstituency(constituency);
        }
      }
      if(! constituency){
        $('.constituency').html("Postcode not found. Your postcode may be formatted incorrectly or you might have entered a postcode outside the eligible area.");
      }else{
        constituency = undefined;
      }
    },
    error: function(){
    }
  });
}

function displayConstituency(constituencyinput){
  if(constituencyinput == "central"){
    constituencyFull = "East Central";
    constituencyURI = "candidates-east-central";
  }else if(constituencyinput == "north"){
    constituencyFull = "North";
    constituencyURI = "candidates-north";
  }else if(constituencyinput == "south"){
    constituencyFull = "South";
    constituencyURI = "candidates-south";
  }
  $('.constituency').html('Your constituency is Bristol ' + constituencyFull + '. <a href="' + wpBaseURL.siteurl + '/' + constituencyURI + '">View candidates standing in your area</a>');
}