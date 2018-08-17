
var cancelButtonColor = "#F0D530";
var confirmButtonColor = "#3d4d86";

function error(title, message){
	  sweetAlert({
        title: title,
        text: message,
        type:"error",
        confirmButtonColor: confirmButtonColor,
        cancelButtonColor: cancelButtonColor,
        cancelButtonText: "Cancelar",
     });
}

function success(title, message){
	  sweetAlert({
        title: title,
        text: message,
        type:"success",
        confirmButtonColor: confirmButtonColor,
       
     });
}
