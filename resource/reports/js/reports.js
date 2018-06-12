
$.ajax({
    url: "/private/ajaxRequests/fotoRequestHandler.php",
    method: "GET",
    success: function(data,status,request) {
       console.log(data);
       console.log(status);
       console.log(request);
    }
});

					