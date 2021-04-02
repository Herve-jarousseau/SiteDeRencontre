

// event clic heart !
var likedElement = document.querySelector(".likePerson");
likedElement.addEventListener("click", sendLike);



function sendLike( event ) {
    let clickedElt = event.currentTarget;
    let userIdLiked = clickedElt.dataset.userId;

    axios.post('http://localhost/SiteDeRencontre/siteRencontre/public/reaction', {
        "id": userIdLiked
    })
        .then(function (response) {
            console.log(response);
        })
        .catch(function (error) {
            console.log(error);
        });

}

