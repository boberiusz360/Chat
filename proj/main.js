function pigo()
{
    var w = window.innerWidth;
    if(w < 1000)
    {
        document.getElementById("pigo").innerHTML = "<img src=\"src/ASPC.png\" id=\"pig\" style=\"width:250px;height:250px;\" />";
    }
}

function reload()
{
    $.ajax
    (
        {
            url: '/logged.php',
            type: 'PUT',
            data: "reload=yes",
        }
    );
}