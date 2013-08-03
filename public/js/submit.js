// JavaScript Document

function testSubmit()
{
  if(document.forms["bravoform"]["nome"].value =="")
  {
    alert('Favor informar o nome!');
    return false;
  }
  if(document.forms["bravoform"]["email"].value =="")
  {
    alert('Favor informar o e-mail!');
    return false;
  }
  if(document.forms["bravoform"]["mensagem"].value =="")
  {
    alert('Favor escrever uma mensagem!');
    return false;
  }
  return true;
}
function formSubmit()
{
  if(testSubmit())
  {
    document.forms["bravoform"].submit(); //first submit
    setTimeout(function(){document.forms["bravoform"].reset();},3000); //and then reset the form values
  }
}