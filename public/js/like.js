const likeButtons = document.querySelectorAll(".fa-heart");
function Like(){
    const likes = this;
    const container = likes.parentElement.parentElement.parentElement;
    const id = container.getAttribute("id");

    fetch(`/like/${id}`)
        .then( function (){
            container.remove();
        })
}
likeButtons.forEach(button => button.addEventListener("click", Like));