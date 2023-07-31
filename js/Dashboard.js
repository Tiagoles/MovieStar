document.addEventListener("DOMContentLoaded", function () {
    const LinkNewMovie = document.getElementById("LinkNewMovie");
    function ShowTextLink(obj) {
        let link = obj;
        link.innerText = "Adicionar filme";
        link.classList.remove("fas", "fa-plus")
    };
    function HiddenTextLink(obj) {
        let link = obj;
        link.innerText = "";
        link.classList.add("fas", "fa-plus");
    };

    LinkNewMovie.addEventListener("mouseover", function () {
        ShowTextLink(LinkNewMovie);
    });
    LinkNewMovie.addEventListener("mouseout", function () {

        HiddenTextLink(LinkNewMovie);
    });
    function ShowModal(obj){
        obj.removeAttribute("hidden");
    };
     



});