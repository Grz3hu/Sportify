const search = document.querySelector('input[id="searchbar"]');
const searchMobile = document.querySelector('input[id="searchbar-mobile"]');
const eventsContainer = document.querySelector(".events");

search.addEventListener("keyup", searchFunction);
searchMobile.addEventListener("keyup", searchFunction);
function searchFunction(event){
    if(event.key === "Enter") {
        event.preventDefault();

        const data = {search: this.value};

        fetch("/search",{
            method: "POST",
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        }).then(function (response){
            return response.json();
        }).then(function (events){
            eventsContainer.innerHTML="";
            loadEvents(events);
        })
    }
}

function loadEvents(events) {
    events.forEach(event => {
        console.log(event);
        createEvent(event);
    })
}

function createEvent(event){
    const template = document.querySelector("#event-template");
    const clone = template.content.cloneNode(true);

    const image = clone.querySelector("img");
    image.src = `/public/uploads/${event.picture}`;

    const category = clone.querySelector("h2");
    category.innerHTML = event.category;

    const date = clone.querySelector("#date");
    date.innerHTML = event.date;

    const location = clone.querySelector("p");
    location.innerHTML = event.location;

    eventsContainer.appendChild(clone)
}