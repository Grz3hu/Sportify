const dislikeButtons = document.querySelectorAll(".fa-minus-square");
function Dislike(){
    const dislikes = this;
    const container = dislikes.parentElement.parentElement.parentElement;
    const id = container.getAttribute("id");

    fetch(`/dislike/${id}`)
        .then( function (){
            container.remove();
        })
}
dislikeButtons.forEach(button => button.addEventListener("click", Dislike));